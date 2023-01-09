<?php

namespace App\Http\Controllers\Admin\Payroll;

use App\Clearance;
use App\Employee;
use App\IndividualSalary;
use App\Kpi;
use App\ProcessSegment;
use App\ProvidentFundSetting;
use App\ProvidentHistory;
use App\Statements\StatementController;
use App\Statements\TaxStatement;
use App\TaxHistory;
use App\TaxSetting;
use App\Utils\EmploymentTypeStatus;
use App\Utils\Payroll;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Rap2hpoutre\FastExcel\FastExcel;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\TaxHistoryImport;
use Illuminate\Support\Facades\Validator;
use DB;

class TaxController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $active = 'payroll.tax.index';
        $pfActive = [];
        $pfInactive = [];
        $requestCheck = $request->all();
        if (!$requestCheck) {
            $history = TaxHistory::with('employee', 'employee.individualSalary')->select('employee_id', DB::raw('SUM(amount) as amount'))->groupBy('employee_id')->get();
            //dd($history);

            foreach ($history as $value)
            {
                if(isset($value->employee->individualSalary->tax_status)){
                    if($value->employee->individualSalary->tax_status == Payroll::SALARYSTATUS['active']){

                        $pfActive[] = [
                            'id'=>$value->id,
                            'emp_id'=>$value->employee_id,
                            'employee_id'=> $value->employee->employer_id ?? '',
                            'name'=> $value->employee->FullName ?? '',
                            'gross'=> $value->employee->individualSalary->gross_salary ?? 0,
                            'cumulative'=> $value->amount ?? 0,
                            'payable'=> $value->employee->individualSalary->tax ?? 0
                        ];
                    }else{
                        $pfInactive[] = [
                            'id'=>$value->id,
                            'emp_id'=>$value->employee_id,
                            'employee_id'=> $value->employee->employer_id ?? '',
                            'name'=> $value->employee->FullName ?? '',
                            'gross'=> $value->employee->individualSalary->gross_salary ?? 0,
                            'cumulative'=> $value->amount ?? 0,
                            'payable'=> $value->employee->individualSalary->tax ?? 0
                        ];
                    }
                }

            }

            $totalEmployeePfActive = TaxHistory::whereHas('employee.individualSalary', function($q){
                 $q->where('tax_status', Payroll::SALARYSTATUS['active']);
            })->get();

            $totalEmployeePfInactive = TaxHistory::whereHas('employee.individualSalary', function($q){
                 $q->where('tax_status', Payroll::SALARYSTATUS['inactive']);
            })->get();

            return view('admin.payroll.tax.index', compact('active', 'pfActive', 'totalEmployeePfActive', 'pfInactive', 'totalEmployeePfInactive'));
        }


        $query = TaxHistory::with('employee', 'employee.individualSalary')->select('employee_id', DB::raw('SUM(amount) as amount'))->groupBy('employee_id');


        if ($request->employee_id){
            $query->whereHas('employee',function($i) use($request){
                $i->where('employer_id', $request->employee_id);
            });
        }

        if ($request->date_from || $request->date_to){
            $fromDate = $request->date_from;
            $toDate = $request->date_to;
            $query->whereBetween('month', [$fromDate, $toDate]);
        }

        $history = $query->get();


        foreach ($history as $value)
            {
                if(isset($value->employee->individualSalary->tax_status)){
                    if($value->employee->individualSalary->tax_status == Payroll::SALARYSTATUS['active']){
                        $pfActive[] = [
                            'id'=>$value->id,
                            'emp_id'=>$value->employee_id,
                            'employee_id'=> $value->employee->employer_id ?? '',
                            'name'=> $value->employee->FullName ?? '',
                            'gross'=> $value->employee->individualSalary->gross_salary ?? 0,
                            'cumulative'=> $value->amount ?? 0,
                            'payable'=> $value->employee->individualSalary->tax ?? 0
                        ];
                    }else{
                        $pfInactive[] = [
                            'id'=>$value->id,
                            'emp_id'=>$value->employee_id,
                            'employee_id'=> $value->employee->employer_id ?? '',
                            'name'=> $value->employee->FullName ?? '',
                            'gross'=> $value->employee->individualSalary->gross_salary ?? 0,
                            'cumulative'=> $value->amount ?? 0,
                            'payable'=> $value->employee->individualSalary->tax ?? 0
                        ];
                    }
                }

            }

        $filterEmployeePfActive = TaxHistory::whereHas('employee.individualSalary', function($q){
                $q->where('tax_status', Payroll::SALARYSTATUS['active']);
        });

        $filterEmployeePfInactive = TaxHistory::whereHas('employee.individualSalary', function($q){
            $q->where('tax_status', Payroll::SALARYSTATUS['inactive']);
        });

        if ($request->employee_id){
            $filterEmployeePfActive->whereHas('employee',function($i) use($request){
                $i->where('employer_id', $request->employee_id);
            });
        }

        if ($request->date_from || $request->date_to){
            $fromDate = $request->date_from;
            $toDate = $request->date_to;
            $filterEmployeePfActive->whereBetween('month', [$fromDate, $toDate]);
        }

        if ($request->employee_id){
            $filterEmployeePfInactive->whereHas('employee',function($i) use($request){
                $i->where('employer_id', $request->employee_id);
            });
        }

        if ($request->date_from || $request->date_to){
            $fromDate = $request->date_from;
            $toDate = $request->date_to;
            $filterEmployeePfInactive->whereBetween('month', [$fromDate, $toDate]);
        }



        $totalEmployeePfActive = $filterEmployeePfActive->get();
        $totalEmployeePfInactive = $filterEmployeePfInactive->get();

        return view('admin.payroll.tax.index', compact('active', 'pfActive', 'totalEmployeePfActive', 'pfInactive', 'totalEmployeePfInactive'));
    }

    public function details($id)
    {
        $historys = TaxHistory::with('employee', 'employee.individualSalary')->where('employee_id', $id)->get();
        $cumulative = 0;
        foreach ($historys as $value)
            {
                $cumulative += $value->amount;
                $history[] = [
                    'month'=> $value->month ?? '',
                    'gross'=> $value->employee->individualSalary->gross_salary ?? 0,
                    'cumulative'=> $cumulative ?? 0,
                    'payable'=> $value->employee->individualSalary->tax ?? 0
                ];

            }
        return view('admin.payroll.tax.view-details', compact('history'));
    }

    public function downloadTax($year, $month)
    {
        $query = TaxHistory::with('employee', 'employee.individualSalary');

        $query->where('month', $year.'-'.$month);

        $history = $query->get();

        $pfActive = [];

        foreach ($history as $value)
            {

                $pfActive[] = [
                    'employee_id'=> $value->employee->employer_id ?? '',
                    'name'=> $value->employee->FullName ?? '',
                    'month'=> $value->month ?? '',
                    'gross'=> $value->employee->individualSalary->gross_salary ?? 0,
                    'cumulative'=> $value->amount ?? 0,
                    'payable'=> $value->employee->individualSalary->tax ?? 0
                ];

            }

        return (new FastExcel($pfActive))->download('file.xlsx');
    }

    public function taxUpload()
    {
       return view('admin.payroll.tax.tax-upload');
    }

    public function taxStore_old(Request $request)
    {

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $validator = Validator::make([
                'file' => $file,
                'extension' => strtolower($file->getClientOriginalExtension()),
            ],
                [
                    'file' => 'required',
                    'extension' => 'required|in:csv',
                ]);
        } else {
            toastr()->error('Please select correct file.');
            return redirect()->back();
        }

        // $pfArray = Payroll::TAX;
        // (new FastExcel)->import($request->file('file'), function ($line) {
        //     return TaxHistory::create([
        //         'employee_id' => Employee::where('employer_id', $line['employee_id'])->first()->id,
        //         'month' => Carbon::parse(Carbon::now())->format('Y-m'),
        //         'remarks' => 'Previous amount',
        //         'amount' => $line['amount'],
        //         'status' => (array_key_exists($line['status'],$pfArray)) ? $pfArray[$line['status']] : 0
        //     ]);
        // });

        $new_file_name = md5(uniqid()) . '.' . $request->file('file')->getClientOriginalExtension();
        $destinationPath = storage_path('app/import-temp/');
        $path = $request->file('excel_file')->move($destinationPath, $new_file_name);
        Excel::import(new TaxHistoryImport, $path);
        unlink($destinationPath.$new_file_name);

        toastr()->success('Successfully Uploaded!');
        return redirect()->back();
    }


    public function taxStore(){
        set_time_limit(500);

        request()->validate([
            'file' => 'required|mimes:csv,txt'
        ]);

        $active = 'missing-report-employee-attendance-csv';
        
        $path = request()->file('file')->getRealPath();
        $file = file($path);
        $data = array_slice($file, 1);
        
        
        foreach($data as $key => $row){
            $row = explode(",", $row);
                $temp = array(
                    'employer_id' => $row[1],
                    'month' => Carbon::parse($row[0])->format('Y-m-d'),
                    'remarks' => 'Previous amount',
                    'amount' => $row[2],
                    'status' => Payroll::TAX['Generated']
                );
                TaxHistory::where('employer_id', $row[1])->where('month', Carbon::parse($row[0])->format('Y-m-d'))->delete();
                TaxHistory::insert($temp);
        }
        
        toastr()->success('Done importing');
        return redirect()->back();
    }

    public function add()
    {
        $active = 'payroll.tax.add';
        $flag = 'add';
        $rows = null;
        return view('admin.payroll.tax.add', compact('active', 'flag', 'rows'));
    }

    public function edit($id)
    {
        $active = 'payroll.tax.index';
        $flag = 'edit';
        $rows = TaxHistory::find($id);
        return view('admin.payroll.tax.add', compact('active', 'flag', 'id', 'rows'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'month' => 'required',
            'amount' => 'required|numeric',
            'remarks' => '',
        ]);
        // $employeeId = Employee::where('employer_id', $request->employee_id)->first()->id??0;
        // $employeeId = $request

        if($employeeId){
            //$validatedData['employee_id'] = $employeeId;
            $providentHistory = TaxHistory::find($id);
            $providentHistory->update($validatedData);
            toastr()->success('successfully Updated');
            return redirect()->route('payroll.tax.statement');
        }
        toastr()->success('Employee is not exist!');
        return redirect()->route('payroll.tax.statement');
    }

    public function setting()
    {
        $active = 'payroll.tax.setting';
        $taxs = TaxSetting::all();
        $flag = 'Index';
        return view('admin.payroll.tax.setting', compact('active', 'taxs', 'flag'));
    }

    public function settingAdd()
    {
        return view('admin.payroll.tax.setting-add');
    }

    public function settingSave(Request $request)
    {
        $validatedData = $request->validate([
            'amount' => 'required|numeric',
            'min' => 'required|numeric',
            'max' => 'required|numeric',
        ]);

//        dd($validatedData);

        TaxSetting::insert($validatedData);

        toastr()->success('successfully Updated');
        return redirect()->route('payroll.tax.setting');

    }


    public function settingEdit($id)
    {
        $settings = TaxSetting::find($id);
        return view('admin.payroll.tax.setting-edit', compact( 'settings', 'id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'month' => 'required',
            'amount' => 'required|numeric',
            'remarks' => '',
        ]);
        $employeeId = Employee::where('employer_id', $request->employee_id)->first()->id??0;

        if($employeeId){
            $validatedData['employee_id'] = $employeeId;
            $existUserList = TaxHistory::where('month', $request->month)->get()->pluck('employee_id')->toArray();
            if(in_array($employeeId, $existUserList)){
                toastr()->success('This data already inserted');
                return redirect()->route('payroll.tax.index');
            }
            TaxHistory::create($validatedData);
            toastr()->success('successfully Created');
            return redirect()->route('payroll.tax.index');
        }
        toastr()->success('Employee is not exist!');
        return redirect()->route('payroll.tax.index');

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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function settingUpdate(Request $request, $id)
    {
        $validatedData = $request->validate([
            'amount' => 'required|numeric',
            'min' => 'required|numeric',
            'max' => 'required|numeric',
        ]);
//        dd($validatedData);

        TaxSetting::find($id)->update($validatedData);

        toastr()->success('successfully Updated');
        return redirect()->route('payroll.tax.setting');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function statement(Request $request)
    {
        $active = 'payroll.tax.statement';
        /*$confirmation = (!empty(Clearance::where('module', 'tax')->whereYear('created_at', Carbon::parse(Carbon::now())->format('Y'))->whereMonth('created_at', Carbon::parse(Carbon::now())->format('m'))->first())) ? false : true;
        $generate = (!empty(TaxHistory::where('month', Carbon::parse(Carbon::now())->format('Y-m'))->first())) ? false : true;
        $regenerate = ($generate) ? false : ($confirmation) ? true : false;

        $confirmation = ($generate) ? false : ($confirmation) ? true : false; //Re initialize confirmation button for show hide


        $history = TaxHistory::where('month', Carbon::parse(Carbon::now())->format('Y-m'))->get();

        return view('admin.payroll.tax.statement', compact('active', 'history', 'generate', 'regenerate', 'confirmation', 'history'));*/

        $requestCheck = $request->all();
        if(!$requestCheck){
            $history = collect();
            $year = Carbon::now()->format('Y');
            $month = Carbon::now()->format('m');
            return view('admin.payroll.tax.statement', compact('active', 'month', 'year', 'history'));
        }
        $month = $request->input('month');
        $year = $request->input('year');
        $button = $request->button;

        if($button === 'View') {
            $history = TaxHistory::where('month', $year . '-' . $month)->get();
            return view('admin.payroll.tax.statement', compact('active', 'month', 'year', 'history'));
        }

        if($button === 'Generate') {

            /*PF generate start*/
            $existData = TaxHistory::where('month', $year . '-' . $month)->get();
            if ($existData->isNotEmpty()) {
                toastr()->info('Already Tax Generated');
                $history = TaxHistory::where('month', $year . '-' . $month)->get();
                return view('admin.payroll.tax.statement', compact('active', 'month', 'year', 'history'));
            }
            $Statement = new StatementController(new TaxStatement($month, $year));
            TaxHistory::insert($Statement->statement());
            /*PF generate end*/

            toastr()->success('Tax Successfully Generated!');
            $history = TaxHistory::where('month', $year . '-' . $month)->get();
            return view('admin.payroll.tax.statement', compact('active', 'month', 'year', 'history'));
        }

        if($button === 'Regenerate')
        {
            /*PF Re-generate start*/
            //Delete data by selected month and year
            TaxHistory::where('month', $year . '-' . $month)->delete();

            $Statement = new StatementController(new TaxStatement($month, $year));
            TaxHistory::insert($Statement->statement());
            /*PF Re-generate end*/

            toastr()->success('Tax Successfully Re-generated!');
            $history = TaxHistory::where('month', $year . '-' . $month)->get();
            return view('admin.payroll.tax.statement', compact('active', 'month', 'year', 'history'));
        }
    }


    public function statementGenerate()
    {
        $Statement = new StatementController(new TaxStatement);
        TaxHistory::insert($Statement->statement());
        return redirect()->route('payroll.tax.statement');
    }

    public function statementRegenerate()
    {
        TaxHistory::where('month', Carbon::parse(Carbon::now())->format('Y-m'))->delete();
        $Statement = new StatementController(new TaxStatement);
        TaxHistory::insert($Statement->statement());
        return redirect()->route('payroll.tax.statement');
    }


    public function viewClearance(Request $request,  $month, $year)
    {
        $year = $year ?? Carbon::parse(Carbon::now())->format('Y');
        $month = $month ?? Carbon::parse(Carbon::now())->format('m');

        $total = TaxHistory::where('month', $year.'-'.$month)->get();
        $generated = TaxHistory::where('month', $year.'-'.$month)->where('status', Payroll::PF['Generated'])->get();
        $hold = TaxHistory::where('month', $year.'-'.$month)->where('status', Payroll::PF['Hold'])->get();
        $disable = IndividualSalary::where('type', Payroll::STATEMENT['status']['Active'])
            ->where('salary_status', Payroll::SALARYSTATUS['active'])
            ->where('tax_status', Payroll::SALARYSTATUS['inactive'])
            ->get();
        $result = [
            'emp_count' => $total->count() + $hold->count(),
            'total_amount' => $total->sum('amount') + $hold->sum('amount'),
            'generated' => $generated->count(),
            'generated-amount' =>  $generated->sum('amount'),
            'disabled' => $disable->count(),
            'disabled-amount' => $disable->sum('pf'),
            'hold' => $hold->count(),
            'hold-amount' => $hold->sum('amount'),
            'month' => $month,
            'year' => $year
        ];

        return view('admin.payroll.tax.view-clearance', compact('result'));
    }

    public function buttonEnabledDisabled(Request $request)
    {
        $month = !is_null($request->input('month')) ? $request->input('month') : Carbon::parse(Carbon::now())->format('m');
        $year = !is_null($request->input('year')) ? $request->input('year') : Carbon::parse(Carbon::now())->format('Y');
        $clearance = Clearance::where('module', 'tax')->where('month', $year.'-'.$month)->first();
        $pf = TaxHistory::where('month', $year.'-'.$month)->first();
        $confirmation = (!empty($clearance)) ? false : true;
        $generate = (!empty($pf)) ? false : true;
        $regenerate = ($generate) ? false : ($confirmation) ? true : false;
        $confirmation = ($generate) ? false : ($confirmation) ? true : false; //Re initialize confirmation button for show hide

        return [
            'confirmation' => $confirmation,
            'generate' => $generate,
            'regenerate' => $regenerate
        ];
    }

    public function statementClearance($year, $month)
    {
        $data = [
            'module' => 'tax',
            'month' => $year.'-'.$month,
            'created_at' => Carbon::parse(Carbon::now())->format('Y-m-d'),
            'created_by' => auth()->user()->employee_id
        ];
        Clearance::insert($data);

        return redirect()->route('payroll.tax.statement', ['month'=>$month, 'year'=>$year, 'button'=>'View']);
    }


}
