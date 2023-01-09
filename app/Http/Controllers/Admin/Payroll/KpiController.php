<?php

namespace App\Http\Controllers\Admin\Payroll;

use App\DocumentReqHistory;
use App\Employee;
use App\Kpi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;
use Rap2hpoutre\FastExcel\FastExcel;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\KpiImport;
use App\Helpers\Helper;

class KpiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $active = 'payroll-setting-index';

        // if(empty($request->year) || empty($request->month)){
        //     // return redirect()->route('kpi.setting.index');
        // }

        $requestCheck = $request->all();
        if (!$requestCheck) {
            $kpis = Kpi::all();
            return view('admin.payroll.setting.index', compact('active', 'kpis'));
        }

        $query = Kpi::query();
        if ($request->employee_id){
            $query->where('employee_id', Employee::where('id', $request->employee_id)->first()->id ?? 0);
        }

        if ($request->year && $request->month){
            $query->whereYear('monthly_date', $request->year)->whereMonth('monthly_date', $request->month);
        }

        $kpis = $query->get();
        return view('admin.payroll.setting.index', compact('active', 'kpis'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $active = 'payroll-setting-create';
        return view('admin.payroll.setting.create', compact('active'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        $active = 'payroll-setting-add';
        $flag = "add";
        $rows = '';
        return view('admin.payroll.setting.add', compact('active', 'flag', 'rows'));
    }

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'employee_id' => 'required|numeric',
            'monthly_date' => 'required',
            'grade' => 'required',
            'amount' => 'required|numeric',
            'r_and_r' => 'required',
            'reward' => '',
            'others' => ''
        ]);

//        dd($validatedData);

        $employeeId = $request->employee_id;

        if($employeeId){
            $validatedData['employee_id'] = $employeeId;
            $existUserList = Kpi::whereMonth('monthly_date', Carbon::parse($request->month)->format('m'))
                ->whereYear('monthly_date', Carbon::parse($request->month)->format('Y'))
                ->get()->pluck('employee_id')->toArray();
            if(in_array($employeeId, $existUserList)){
                toastr()->success('This data already inserted');
                return redirect()->route('kpi.setting.index');
            }
            $validatedData['monthly_date'] = Carbon::parse($request->monthly_date)->format('Y-m-d');
            $validatedData['created_by'] = auth()->user()->employee_id ?? 1;
//            dd($validatedData);
            Kpi::create($validatedData);
            toastr()->success('successfully Created');
            return redirect()->route('kpi.setting.index');
        }
        toastr()->success('Employee is not exist!');
        return redirect()->route('kpi.setting.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store_old(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $validator = Validator::make(
                [
                    'file' => $file,
                    'extension' => strtolower($file->getClientOriginalExtension()),
                ],
                [
                    'file' => 'required',
                    'extension' => 'required|in:csv',
                ]
            );
        } else {
            toastr()->error('Please select correct file.');
            return redirect()->back();
        }

        if ($validator->fails()) {
            $errors = $validator->errors();
            foreach ($errors->all() as $message) {
                toastr()->error($message);
            }
            return redirect()->back();
        }


        $new_file_name = md5(uniqid()) . '.' . $request->file('file')->getClientOriginalExtension();

        $destinationPath = storage_path('app/import-temp/');
        $path = $request->file('file')->move($destinationPath, $new_file_name);

        $msg = "Required Valid data";

        $kpis = (new FastExcel)->sheet(1)->import($path, function ($pointer) use ($request){
                $existUserList = Kpi::whereYear('monthly_date', Carbon::parse($pointer['month'])->format('Y'))->whereMonth('monthly_date', Carbon::parse($pointer['month'])->format('m'))->get()->pluck('employee_id')->toArray();
                $employee_id = Employee::where('employer_id', $pointer['employee_id'])->first()->id ?? 0;
                if(!$employee_id){
                    return false;
                }

                if(in_array($employee_id, $existUserList)){
                    return false;
                }

                $arr['monthly_date'] = Carbon::parse($pointer['month'])->format('Y-m-d');

                if(!preg_match("/^[1-9][0-9]*$/", $pointer['employee_id'])){
                     $arr['employee_id'] = "-";
                }else{
                     $arr['employee_id'] = $employee_id;
                }

                if(!preg_match("/^[1-9][0-9]*$/", $pointer['amount'])){
                    $arr['employee_id'] = null;
                }else{
                    $arr['amount'] = $pointer['amount'];
                }

                if(!preg_match("/[ABCD][+-]$/", $pointer['grade'])){
                    $arr['grade'] = null;
                }else{
                    $arr['grade'] = $pointer['grade'];
                }

                $arr['r_and_r'] = (strtolower($pointer['r_and_r']) == 'yes')?1:2;
                $arr['reward'] = '';

                $arr['created_by'] = auth()->user()->employee_id ?? 1;


                return $arr;

            })->toArray();

            $smg = 'KPI successfully Uploaded';

            Kpi::insert($kpis);

            unlink($destinationPath.$new_file_name);

            toastr()->success($smg);

        return redirect()->route('kpi.setting.index');

    }


    public function store_old_2(Request $request){

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
                    'employee_id'  => $row[1],
                    'monthly_date' => Carbon::parse($row[0])->format('Y-m-d'),
                    'amount'       => $row[2],
                    'grade'        => $row[3],
                    'r_and_r'      => $row[4],
                    'created_by'   => auth()->user()->employee_id ?? null,
                    'created_at'   => Carbon::parse(Carbon::now())->format('Y-m-d H:i:s')
                );
                Kpi::where('employer_id', $row[1])->where('monthly_date', Carbon::parse($row[0])->format('Y-m-d'))->delete();
                Kpi::insert($temp);

        }

        toastr()->success('Done importing');
        return redirect()->back();
    }

    public function store(Request $request)
    {
        /***validation***/
        // CSV file extention start
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $validator = Validator::make(
                [
                    'file' => $file,
                    'extension' => strtolower($file->getClientOriginalExtension()),
                ],
                [
                    'file' => 'required',
                    'extension' => 'required|in:csv',
                ]
            );
        } else {
            toastr()->error('Please select correct file.');
            return redirect()->back();
        }

        if ($validator->fails()) {
            $errors = $validator->errors();
            foreach ($errors->all() as $message) {
                toastr()->error($message);
            }
            return redirect()->back();
        }
        // CSV file check end


        // Column validation start here..
        $requiredHeaderCoulumnArray = ['empid', 'amount', 'grade', 'r_n_r']; // Required header column
        $csvHeaderColumnArray = Helper::fetchCSVHeader($file);
        $validateHeader = Helper::validateHeaderRow($csvHeaderColumnArray, $requiredHeaderCoulumnArray); // Filter it through our validation
        if(!$validateHeader){
            return redirect()->back();
        }
        // Column validation start end..


        // Data validation start here ..
        $requiredDataValidationArray = [
            0   => 'required|numeric',
            1   => 'required|numeric'
        ];
        $validationMessage = [
            '0.required'    => 'EmpID columnt\'s should not be empty!',
            '0.numeric'     => 'EmpID column\'s data must be number!',
            '1.required'    => 'Amount column\'s should not be empty',
            '1.numeric'     => 'Amount column\'s data must be number!'
        ];
        $csvDataColumnsArray = Helper::fetchCSVData($file);
        $validateData       = Helper::validateDataRow($csvDataColumnsArray, $requiredDataValidationArray, $validationMessage);
        if(!$validateData){
            return redirect()->back();
        }
        // Data validation end here ..
        /***validatoin***/

        $new_file_name = md5(uniqid()) . '.' . $request->file('file')->getClientOriginalExtension();
        $destinationPath = storage_path('app/import-temp/');
        $path = $request->file('file')->move($destinationPath, $new_file_name);

        Excel::import(new KpiImport($request), $path);
        unlink($destinationPath.$new_file_name);

        toastr()->success('Successfully Uploaded !');
        return redirect()->back();
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
        $active = 'payroll-setting-index';
        $flag = "edit";
        $rows = Kpi::find($id);
        return view('admin.payroll.setting.add', compact('active', 'flag', 'id', 'rows'));
    }


    public function update(Request $request, $id)
    {

       /* $validatedData = $request->validate([
            'employee_id' => 'required',
            'monthly_date' => 'required',
            'grade' => 'required',
            'amount' => 'required',
            'r_and_r' => 'required',
            'reward' => '',
            'others' => '',
        ]);*/

       $validatedData = [
            'employer_id' => $request->employee_id,
            'monthly_date' => $request->monthly_date,
            'grade' => $request->grade,
            'amount' => $request->amount,
            'r_and_r' => $request->r_and_r,
            'reward' => $request->reward,
            'updated_by' => auth()->user()->employee_id ?? 1,
       ];

        $employeeId = Employee::where('employer_id', $request->employee_id)->first()->id??0;

        if($employeeId){
            $validatedData['employee_id'] = $employeeId;
            $validatedData['others']= ($validatedData['reward'] == '-1')?$request->others:null;
            $providentHistory = Kpi::find($id);
            $providentHistory->update($validatedData);
            toastr()->success('successfully Updated');
            return redirect()->route('kpi.setting.index');
        }
        toastr()->success('Employee is not exist!');
        return redirect()->route('kpi.setting.index');
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
}
