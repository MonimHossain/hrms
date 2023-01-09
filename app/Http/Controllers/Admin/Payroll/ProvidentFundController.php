<?php

namespace App\Http\Controllers\Admin\Payroll;

use App\Clearance;
use App\Employee;
use App\IndividualSalary;
use App\Kpi;
use App\ProcessSegment;
use App\ProvidentFundSetting;
use App\ProvidentHistory;
use App\Statements\PfStatement;
use App\Statements\StatementController;
use App\TaxHistory;
use App\Utils\EmploymentTypeStatus;
use App\Utils\Payroll;
use App\Utils\TeamMemberType;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Cassandra\Collection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Imports\PfHistoryImport;
use DB;


class
ProvidentFundController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $active = 'payroll.provident.fund.index';

        $pfActive = [];
        $pfInactive = [];
        $requestCheck = $request->all();
        if (!$requestCheck) {
            $history = ProvidentHistory::with('employee', 'employee.individualSalary')->select('employee_id', DB::raw('SUM(amount) as amount'))->groupBy('employee_id')->get();


            foreach ($history as $value)
            {
                if(isset($value->employee->individualSalary->pf_status)){
                    if($value->employee->individualSalary->pf_status == Payroll::SALARYSTATUS['active']){
                        $pfActive[] = [
                            'id'=>$value->id,
                            'emp_id'=>$value->employee_id,
                            'employee_id'=> $value->employee->employer_id ?? '',
                            'name'=> $value->employee->FullName ?? '',
                            'gross'=> $value->employee->individualSalary->gross_salary ?? 0,
                            'cumulative'=> $value->amount ?? 0,
                            'payable'=> $value->employee->individualSalary->pf ?? 0
                        ];
                    }else{
                        $pfInactive[] = [
                            'id'=>$value->id,
                            'emp_id'=>$value->employee_id,
                            'employee_id'=> $value->employee->employer_id ?? '',
                            'name'=> $value->employee->FullName ?? '',
                            'gross'=> $value->employee->individualSalary->gross_salary ?? 0,
                            'cumulative'=> $value->amount ?? 0,
                            'payable'=> $value->employee->individualSalary->pf ?? 0
                        ];
                    }
                }

            }

            $totalEmployeePfActive = ProvidentHistory::whereHas('employee.individualSalary', function($q){
                 $q->where('pf_status', Payroll::SALARYSTATUS['active']);
            })->get();

            $totalEmployeePfInactive = ProvidentHistory::whereHas('employee.individualSalary', function($q){
                 $q->where('pf_status', Payroll::SALARYSTATUS['inactive']);
            })->get();

            return view('admin.payroll.providentFund.index', compact('active', 'pfActive', 'totalEmployeePfActive', 'pfInactive', 'totalEmployeePfInactive'));
        }


        $query = ProvidentHistory::with('employee', 'employee.individualSalary')->select('employee_id', DB::raw('SUM(amount) as amount'))->groupBy('employee_id');


        if ($request->employee_id){
            $query->whereHas('employee',function($i) use($request){
                $i->where('id', $request->employee_id);
            });
        }

        if ($request->date_from || $request->date_to){
            $fromDate = $request->date_from;
            // $toDate = $request->date_to;
            $query->where('month', $fromDate);
        }

        $history = $query->get();


        foreach ($history as $value)
            {
                if(isset($value->employee->individualSalary->pf_status)){
                    if($value->employee->individualSalary->pf_status == Payroll::SALARYSTATUS['active']){
                        $pfActive[] = [
                            'id'=>$value->id,
                            'emp_id'=>$value->employee_id,
                            'employee_id'=> $value->employee->employer_id ?? '',
                            'name'=> $value->employee->FullName ?? '',
                            'gross'=> $value->employee->individualSalary->gross_salary ?? 0,
                            'cumulative'=> $value->amount ?? 0,
                            'payable'=> $value->employee->individualSalary->pf ?? 0
                        ];
                    }else{
                        $pfInactive[] = [
                            'id'=>$value->id,
                            'emp_id'=>$value->employee_id,
                            'employee_id'=> $value->employee->employer_id ?? '',
                            'name'=> $value->employee->FullName ?? '',
                            'gross'=> $value->employee->individualSalary->gross_salary ?? 0,
                            'cumulative'=> $value->amount ?? 0,
                            'payable'=> $value->employee->individualSalary->pf ?? 0
                        ];
                    }
                }

            }

        $filterEmployeePfActive = ProvidentHistory::whereHas('employee.individualSalary', function($q){
                $q->where('pf_status', Payroll::SALARYSTATUS['active']);
        });

        $filterEmployeePfInactive = ProvidentHistory::whereHas('employee.individualSalary', function($q){
            $q->where('pf_status', Payroll::SALARYSTATUS['inactive']);
        });

        if ($request->employee_id){
            $filterEmployeePfActive->whereHas('employee',function($i) use($request){
                $i->where('employer_id', $request->employee_id);
            });
        }

        if ($request->date_from || $request->date_to){
            $fromDate = $request->date_from;
            // $toDate = $request->date_to;
            $filterEmployeePfActive->where('month', $fromDate);
        }

        if ($request->employee_id){
            $filterEmployeePfInactive->whereHas('employee',function($i) use($request){
                $i->where('employer_id', $request->employee_id);
            });
        }

        if ($request->date_from || $request->date_to){
            $fromDate = $request->date_from;
            // $toDate = $request->date_to;
            $filterEmployeePfInactive->where('month', $fromDate);
        }



        $totalEmployeePfActive = $filterEmployeePfActive->get();
        $totalEmployeePfInactive = $filterEmployeePfInactive->get();

        return view('admin.payroll.providentFund.index', compact('active', 'pfActive', 'totalEmployeePfActive', 'pfInactive', 'totalEmployeePfInactive'));
    }

    public function details($id)
    {
        $historys = ProvidentHistory::with('employee', 'employee.individualSalary')->where('employee_id', $id)->get();
        $cumulative = 0;
        foreach ($historys as $value)
            {
                $cumulative += $value->amount;
                $history[] = [
                    'month'=> $value->month ?? '',
                    'gross'=> $value->employee->individualSalary->gross_salary ?? 0,
                    'cumulative'=> $cumulative ?? 0,
                    'payable'=> $value->employee->individualSalary->pf ?? 0
                ];

            }
        return view('admin.payroll.providentFund.view-details', compact('history'));
    }

    public function downloadTax($year, $month)
    {
        $query = ProvidentHistory::with('employee', 'employee.individualSalary');

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
                    'payable'=> $value->employee->individualSalary->pf ?? 0
                ];

            }

        return (new FastExcel($pfActive))->download('file.xlsx');
    }

    public function pfUpload()
    {
        return view('admin.payroll.providentFund.pf-upload');
    }

    public function storePfUpload_old(Request $request)
    {
         if ($request->hasFile('excel_file')) {
            $file = $request->file('excel_file');
            $validator = Validator::make([
                'file' => $file,
                'extension' => strtolower($file->getClientOriginalExtension()),
            ],
                [
                    'excel_file' => 'required',
                    'extension' => 'required|in:csv',
                ]);
        } else {
            toastr()->error('Please select correct file.');
            return redirect()->back();
        }

        $new_file_name = md5(uniqid()) . '.' . $request->file('excel_file')->getClientOriginalExtension();
        $destinationPath = storage_path('app/import-temp/');
        $path = $request->file('excel_file')->move($destinationPath, $new_file_name);
        Excel::import(new PfHistoryImport($request), $path);
        unlink($destinationPath.$new_file_name);

        // $pfArray = Payroll::PF;
        // (new FastExcel)->sheet(1)->import($request->file('excel_file', function($line) use($pfArray){
        //     return ProvidentHistory::create([
        //         'employee_id' => Employee::where('employer_id', $line['employee_id'])->first()->id,
        //         'month' => $line['month'],
        //         'remarks' => 'Previous amount',
        //         'amount' => $line['amount'],
        //         'status' => (array_key_exists($line['status'],$pfArray)) ? $pfArray[$line['status']] : 0
        //     ]);
        // }));

       toastr()->success('Successfully Uploaded!');
       return redirect()->back();
    }

    public function storePfUpload(Request $request){
        set_time_limit(500);

        request()->validate([
            'excel_file' => 'required|mimes:csv,txt'
        ]);

        $active = 'missing-report-employee-attendance-csv';
        
        $path = request()->file('excel_file')->getRealPath();
        $file = file($path);
        $data = array_slice($file, 1);
        
        
        foreach($data as $key => $row){
            $row = explode(",", $row);
                $temp = array(
                    'employee_id' => $row[1],
                    'month' => Carbon::parse($row[0])->format('Y-m-d'),
                    'remarks' => 'Previous amount',
                    'amount' => $row[2],
                    'status' => Payroll::PF['Generated']
                );
                ProvidentHistory::where('employer_id', $row[1])->where('month', Carbon::parse($row[0])->format('Y-m-d'))->delete();
                ProvidentHistory::insert($temp);
        }
        
        toastr()->success('Done importing');
        return redirect()->back();
    }

    public function add()
    {
        $active = 'payroll.provident.fund.add';
        $flag = 'add';
        $rows = null;
        return view('admin.payroll.providentFund.add', compact('active', 'flag', 'rows'));
    }

    public function edit($id)
    {
        $active = 'payroll.provident.fund.index';
        $flag = 'edit';
        $rows = ProvidentHistory::find($id);
        return view('admin.payroll.providentFund.add', compact('active', 'flag', 'id', 'rows'));
    }

    public function delete($id){
        ProvidentHistory::find($id)->delete();
        toastr()->success('Successfully Deleted !');
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'month' => 'required',
            'amount' => 'required|numeric',
            'remarks' => '',
        ]);
        $employeeId = Employee::where('employer_id', $request->employee_id)->first()->id??0;

        if($employeeId){
            $validatedData['employee_id'] = $employeeId;
            $providentHistory = ProvidentHistory::find($id);
            $providentHistory->update($validatedData);
            toastr()->success('successfully Updated');
            return redirect()->route('payroll.provident.fund.index');
        }
        toastr()->success('Employee is not exist!');
        return redirect()->route('payroll.provident.fund.index');
    }

    public function setting()
    {
        $active = 'payroll.provident.fund.setting';
        $query = ProvidentFundSetting::find(1);
        $settings = optional($query)->first();
        return view('admin.payroll.providentFund.setting', compact('active', 'settings'));
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
        // $employeeId = Employee::where('employer_id', $request->employee_id)->first()->id??0;
        $employeeId = $request->employee_id;

        if($employeeId){
            $validatedData['employee_id'] = $employeeId;
            $validatedData['created_by'] = auth()->user()->employee_id ?? 0;
            $validatedData['updated_by'] = auth()->user()->employee_id ?? 0;
            $existUserList = ProvidentHistory::where('month', $request->month)->get()->pluck('employee_id')->toArray();
            if(in_array($employeeId, $existUserList)){
                toastr()->success('This data already inserted');
                return redirect()->route('payroll.provident.fund.index');
            }
            ProvidentHistory::create($validatedData);
            toastr()->success('successfully Created');
            return redirect()->route('payroll.provident.fund.index');
        }
        toastr()->success('Employee is not exist!');
        return redirect()->route('payroll.provident.fund.index');

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
        $validatedData = Validator::make($request->all(), [
                'amount' => 'required|numeric',
                'pf_year' => 'required|numeric',
                'gratuity_year' => 'required|numeric',
        ]);
        if ($validatedData->fails()) {
            return redirect()
                ->route('payroll.provident.fund.setting');
        }

        ProvidentFundSetting::updateOrCreate(
            ['id' => $id],
            [
                'amount' => $request->amount,
                'pf_year' => $request->pf_year,
                'gratuity_year' => $request->gratuity_year
            ]
        );

        toastr()->success('successfully Updated');
        return redirect()->route('payroll.provident.fund.setting');
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
        $active = 'payroll.provident.fund.statement';
        $requestCheck = $request->all();
        if(!$requestCheck){
            $history = collect();
            $year = Carbon::now()->format('Y');
            $month = Carbon::now()->format('m');
            return view('admin.payroll.providentFund.statement', compact('active', 'month', 'year', 'history'));
        }
        $month = $request->input('month');
        $year = $request->input('year');
        $button = $request->button;

        if($button === 'View') {
            $history = ProvidentHistory::where('month', $year . '-' . $month)->get();
            return view('admin.payroll.providentFund.statement', compact('active', 'month', 'year', 'history'));
        }

        if($button === 'Generate') {

            /*PF generate start*/
            $existData = ProvidentHistory::where('month', $year . '-' . $month)->get();
            if ($existData->isNotEmpty()) {
                toastr()->info('Already PF Generated');
                $history = ProvidentHistory::where('month', $year . '-' . $month)->get();
                return view('admin.payroll.providentFund.statement', compact('active', 'month', 'year', 'history'));
            }
            $Statement = new StatementController(new PfStatement($month, $year));
            ProvidentHistory::insert($Statement->statement());
            /*PF generate end*/

            toastr()->success('PF Successfully Generated!');
            $history = ProvidentHistory::where('month', $year . '-' . $month)->get();
            return view('admin.payroll.providentFund.statement', compact('active', 'month', 'year', 'history'));
        }

        if($button === 'Regenerate')
        {
            /*PF Re-generate start*/
            //Delete data by selected month and year
            ProvidentHistory::where('month', $year . '-' . $month)->delete();

            $Statement = new StatementController(new PfStatement($month, $year));
            ProvidentHistory::insert($Statement->statement());
            /*PF Re-generate end*/

            toastr()->success('PF Successfully Re-generated!');
            $history = ProvidentHistory::where('month', $year . '-' . $month)->get();
            return view('admin.payroll.providentFund.statement', compact('active', 'month', 'year', 'history'));
        }
    }


    /*public function statementGenerate(Request $request, $month, $year)
    {
        dd($month);
        $month = $request->input('month') ?? $month;
        $year = $request->input('year') ?? $year;
        $button = $request->button;

        if($button === 'Generate'){
            toastr()->success('PF Successfully Generated!');
            $Statement = new StatementController(new PfStatement($month, $year));
            ProvidentHistory::insert($Statement->statement());
        }elseif($button === 'Regenerate'){
            toastr()->success('PF Successfully Re-generated!');
            ProvidentHistory::where('month', $year.'-'.$month)->delete();
            $Statement = new StatementController(new PfStatement($month, $year));
            ProvidentHistory::insert($Statement->statement());
        }

        return redirect()->route('payroll.provident.fund.statement',['month'=>$month, 'year'=>$year, 'button'=>'View']);
    }*/


    public function buttonEnabledDisabled(Request $request)
    {
        $month = !is_null($request->input('month')) ? $request->input('month') : Carbon::parse(Carbon::now())->format('m');
        $year = !is_null($request->input('year')) ? $request->input('year') : Carbon::parse(Carbon::now())->format('Y');
        $clearance = Clearance::where('module', 'pf')->where('month', $year.'-'.$month)->first();
        $pf = ProvidentHistory::where('month', $year.'-'.$month)->first();
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

    public function statementRegenerate()
    {
        ProvidentHistory::where('month', Carbon::parse(Carbon::now())->format('Y-m'))->delete();
        $Statement = new StatementController(new PfStatement);
        ProvidentHistory::insert($Statement->statement());
        return redirect()->route('payroll.provident.fund.statement');
    }

    public function viewClearance(Request $request,  $month, $year)
    {
        $year = $year ?? Carbon::parse(Carbon::now())->format('Y');
        $month = $month ?? Carbon::parse(Carbon::now())->format('m');


        $total = ProvidentHistory::where('month', $year.'-'.$month)->get();
        $generated = ProvidentHistory::where('month', $year.'-'.$month)->where('status', Payroll::PF['Generated'])->get();
        $hold = ProvidentHistory::where('month', $year.'-'.$month)->where('status', Payroll::PF['Hold'])->get();
        $disable = IndividualSalary::where('type', Payroll::STATEMENT['status']['Active'])
            ->where('salary_status', Payroll::SALARYSTATUS['active'])
            ->where('pf_status', Payroll::SALARYSTATUS['inactive'])
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

        return view('admin.payroll.providentFund.view-clearance', compact('result'));
    }

    public function statementClearance($year, $month)
    {
        $data = [
            'module' => 'pf',
            'month' => $year.'-'.$month,
            'created_at' => Carbon::parse(Carbon::now())->format('Y-m-d'),
            'created_by' => auth()->user()->employee_id
        ];
        Clearance::insert($data);

        return redirect()->route('payroll.provident.fund.statement',['month'=>$month, 'year'=>$year, 'button'=>'View']);
    }
}
