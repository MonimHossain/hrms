<?php

namespace App\Http\Controllers\Admin\SalaryHold;

use App\Clearance;
use App\Employee;
use App\SalaryHoldList;
use App\Utils\EmploymentTypeStatus;
use App\Utils\Payroll;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Rap2hpoutre\FastExcel\FastExcel;

class SalaryHoldController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $active = 'admin-salary-hold-list';

        $emoloyees = Employee::all();

        if(! $request->all()){
            $salaryHolds = SalaryHoldList::all();
            return view('admin.payroll.salaryHold.index', compact('active', 'salaryHolds', 'emoloyees'));
        }

        $query = SalaryHoldList::query();
        if ($request->employee_id){
            $query->where('employee_id', $request->employee_id);
        }

        if ($request->month){
            $query->whereYear('month', \Carbon\Carbon::parse($request->month)->format('Y'));
            $query->whereMonth('month', \Carbon\Carbon::parse($request->month)->format('m'));
        }

        $salaryHolds = $query->get();
        return view('admin.payroll.salaryHold.index', compact('active', 'salaryHolds', 'emoloyees'));
    }

    public function downloadTax($year, $month)
    {
        $query = SalaryHoldList::with('employee', 'employee.individualSalary');
        
        $query->whereYear('month', $year)->whereMonth('month', $month);
        
        $history = $query->get();
        
        $pfActive = []; 
        $department = [];
        $div = [];    
        foreach ($history as $value)
            {
                foreach($value->employee->divisionCenters as $item){
                    $div = $item->division->name.'-'.$item->center->center; 
                }
                foreach($value->employee->departmentProcess->unique('department_id') as $item){
                      $department = $item->department->name;
                }
                                        
          
                $pfActive[] = [    
                    'employee_id'=> $value->employee->employer_id ?? '',
                    'name'=> $value->employee->FullName ?? '',
                    'division_center'=> $div,
                    'department' => $department,
                    'employee_type' => $value->employee->employeeJourney->employmentType->type,
                    'status' => _lang('payroll.salaryhold.status', $value->status),
                    'month' => Carbon::parse($value->month)->format('M Y'),
                    'created_by' => $value->createdBy->FullName,
                    'remarks' => str_limit($value->remarks, 20, '...')
                ];
                
            }
        
        return (new FastExcel($pfActive))->download('file.xlsx');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $active = 'payroll-salary-hold-create';
        $emoloyees = Employee::all();
        return view('admin.payroll.salaryHold.create', compact('active', 'emoloyees'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employee_id' => 'required',
            'month' => 'required',
            'hold_reason' => 'required',
            'remarks' => 'required',
        ]);

        if ($validator->fails()) {
            toastr()->success('Field is required !');
            return redirect()
                ->route('payroll.salary.hold.index');
        }

        /*get year month string*/
        $monthArray = explode('-', $request->month);
        $year = $monthArray[0];
        $month = $monthArray[1];

        $data = collect($request->all());
        $data['month'] = Carbon::parse($request->month)->format('Y-m-d');
        $data['created_by'] = auth()->user()->employee_id ?? 1;
        $data['updated_by'] = auth()->user()->employee_id ?? 1;
        $data['created_at'] = Carbon::now();
        $data['status'] = Payroll::SALARYHOLD['status']['Hold'];

        SalaryHoldList::insert($data->except(['_token'])->toArray());

        toastr()->success('Salary Hold successfully Uploaded');

        return redirect()->route('payroll.salary.hold.statement', ['month'=>$month, 'year'=>$year, 'button'=>'View']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $active = 'payroll-salary-hold-create';
        $emoloyees = Employee::all();
        $rows = SalaryHoldList::find($id);
        return view('admin.payroll.salaryHold.edit', compact('active', 'rows', 'emoloyees', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        /*get year month string*/
        $monthArray = explode('-', $request->month);
        $year = $monthArray[0];
        $month = $monthArray[1];

        $data = collect($request->all());
        $data['month'] = Carbon::parse($year.'-'.$month)->format('Y-m-d');
        $data['updated_by'] = auth()->user()->employee_id ?? 1;
        $data['updated_at'] = Carbon::now();

        SalaryHoldList::where('id', $id)->update($data->except(['_token','_method'])->toArray());

        toastr()->success('Salary Hold successfully Updated');

        return redirect()->route('payroll.salary.hold.statement', ['month'=>$month, 'year'=>$year, 'button'=>'View']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function history(Request $request)
    {
        $active = 'admin-salary-hold-history';

        $emoloyees = Employee::all();

        if(! $request->all()){
            $salaryHolds = SalaryHoldList::all();
            return view('admin.payroll.salaryHold.history', compact('active', 'salaryHolds', 'emoloyees'));
        }

        $query = SalaryHoldList::query();
        if ($request->employee_id){
            $query->where('employee_id', $request->employee_id);
        }

        if ($request->month){
            $query->whereYear('month', \Carbon\Carbon::parse($request->month)->format('Y'));
            $query->whereMonth('month', \Carbon\Carbon::parse($request->month)->format('m'));
        }

        $salaryHolds = $query->get();
        return view('admin.payroll.salaryHold.history', compact('active', 'salaryHolds', 'emoloyees'));
    }


    public function statement(Request $request)
    {

        $active = 'admin-salary-hold-statement';

        /** show hide button*/
        //$confirmation = (!empty(Clearance::where('module', 'salary-hold')->whereYear('month', Carbon::parse(Carbon::now())->format('Y'))->whereMonth('month', Carbon::parse(Carbon::now())->format('m'))->first())) ? false : true;
        /** show hide button*/

        /*$employees = Employee::all();

        if(! $request->all()){
            $salaryHolds = SalaryHoldList::whereYear('month', Carbon::parse(Carbon::now())->format('Y'))
                ->whereMonth('month', Carbon::parse(Carbon::now())->format('m'))->get();
            return view('admin.payroll.salaryHold.statement', compact('active', 'salaryHolds', 'employees', 'confirmation'));
        }

        $query = SalaryHoldList::query()
        ->whereYear('month', Carbon::parse(Carbon::now())->format('Y'))
        ->whereMonth('month', Carbon::parse(Carbon::now())->format('m'));

        if ($request->employee_id){
            $query->where('employee_id', $request->employee_id);
        }

        $salaryHolds = $query->get();
        return view('admin.payroll.salaryHold.statement', compact('active', 'salaryHolds', 'employees', 'confirmation'));*/

        $requestCheck = $request->all();
        if(!$requestCheck){
            $salaryHolds = collect();
            $year = Carbon::now()->format('Y');
            $month = Carbon::now()->format('m');
            return view('admin.payroll.salaryHold.statement', compact('active', 'month', 'year', 'salaryHolds'));
        }
        $month = $request->input('month');
        $year = $request->input('year');
        $button = $request->button;

        if($button === 'View') {
            $salaryHolds = SalaryHoldList::whereYear('month', $year)->whereMonth('month', $month)->get();
            return view('admin.payroll.salaryHold.statement', compact('active', 'month', 'year', 'salaryHolds'));
        }
    }

    public function buttonEnabledDisabled(Request $request)
    {
        $month = !is_null($request->input('month')) ? $request->input('month') : Carbon::parse(Carbon::now())->format('m');
        $year = !is_null($request->input('year')) ? $request->input('year') : Carbon::parse(Carbon::now())->format('Y');
        $clearance = Clearance::where('module', 'salary-hold')->where('month', $year.'-'.$month)->first();
        $pf = SalaryHoldList::whereYear('month', $year)->whereMonth('month', $month)->first();
        $confirmation = (!empty($clearance)) ? false : true;
        $generate = (!empty($pf)) ? false : true;
        $confirmation = ($generate) ? false : ($confirmation) ? true : false; //Re initialize confirmation button for show hide

        return [
            'confirmation' => $confirmation
        ];
    }

    public function viewClearance(Request $request,  $month, $year)
    {
        $year = $year ?? Carbon::parse(Carbon::now())->format('Y');
        $month = $month ?? Carbon::parse(Carbon::now())->format('m');


        $permanet = SalaryHoldList::wherehas('employee.employeeJourney', function($p){
            $p->where('employment_type_id', EmploymentTypeStatus::PERMANENT);    
        })->whereYear('month', $year)->whereMonth('month', $month)->get();
        $contractual = SalaryHoldList::wherehas('employee.employeeJourney', function($p){
            $p->where('employment_type_id', EmploymentTypeStatus::CONTRACTUAL);    
        })->whereYear('month', $year)->whereMonth('month', $month)->get();
        $probation = SalaryHoldList::wherehas('employee.employeeJourney', function($p){
            $p->where('employment_type_id', EmploymentTypeStatus::PROBATION);    
        })->whereYear('month', $year)->whereMonth('month', $month)->get();
        $hourly = SalaryHoldList::wherehas('employee.employeeJourney', function($p){
            $p->where('employment_type_id', EmploymentTypeStatus::HOURLY);    
        })->whereYear('month', $year)->whereMonth('month', $month)->get();
       
        
        $result = [
            'permanet' => $permanet->count(),
            'contractual' => $contractual->count(),
            'probation' => $probation->count(),
            'hourly' => $hourly->count(),
            'month' => $month,
            'year' => $year
        ];
        // dd('dd');

        return view('admin.payroll.salaryHold.view-clearance', compact('result'));
    }

    public function statementClearance($year, $month)
    {
        $data = [
            'module' => 'salary-hold',
            'month' => $year.'-'.$month,
            'created_at' => Carbon::parse(Carbon::now())->format('Y-m-d'),
            'created_by' => auth()->user()->employee_id
        ];
        Clearance::insert($data);

        return redirect()->route('payroll.salary.hold.statement', ['month'=>$month, 'year'=>$year, 'button'=>'View']);
    }
}
