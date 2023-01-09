<?php

namespace App\Http\Controllers\Admin\Adjustment;

use App\Adjustment;
use App\AdjustmentType;
use App\Clearance;
use App\Employee;
use App\AdjustmentDefaults;
use App\SalaryHoldList;
use App\Utils\EmploymentTypeStatus;
use App\Utils\Payroll;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Rap2hpoutre\FastExcel\FastExcel;
use DB;

use App\Imports\AdjustmentsImport;
use App\Helpers\Helper;


class AdjustmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $active = 'admin-adjustment-list';

        $adjustmentType = AdjustmentType::all();
        $emoloyees = Employee::all();
        /** show hide button*/
        $confirmation = (!empty(Clearance::where('module', 'adjustment')->whereYear('created_at', Carbon::parse(Carbon::now())->format('Y'))->whereMonth('created_at', Carbon::parse(Carbon::now())->format('m'))->first())) ? false : true;
        /** show hide button*/

        $requestCheck = $request->all();
        if (!$requestCheck) {
            $adjustments = Adjustment::all();
            return view('admin.payroll.adjustment.index', compact('active', 'confirmation', 'adjustments', 'adjustmentType', 'emoloyees'));
        }

        $query = Adjustment::query();
        if ($request->employee_id){
            $query->where('employee_id', $request->employee_id);
        }

        // if ($request->adjustment_type){
        //     //dd('ll');
        //     $query->where('adjustment_type', $request->adjustment_type);
        // }

        if ($request->date_from){
            $query->whereYear('created_at', \Carbon\Carbon::parse($request->date_from)->format('Y'));
            $query->whereMonth('created_at', \Carbon\Carbon::parse($request->date_from)->format('m'));
        }

        $adjustments = $query->get();
        return view('admin.payroll.adjustment.index', compact('active', 'confirmation', 'adjustments', 'adjustmentType', 'emoloyees'));
    }


    public function downloadTax($year, $month)
    {
        $query = Adjustment::with('employee', 'employee.individualSalary');

        $query->where('month', $year.'-'.$month);

        $history = $query->get();

        $pfActive = [];

        foreach ($history as $value)
            {

                $pfActive[] = [

                    'employee_id'=> $value->employee->employer_id ?? '',
                    'name'=> $value->employee->FullName ?? '',
                    'adjustment_type'=> $value->adjustmentType->name ?? 0,
                    'type'=> $value->type ?? 0,
                    'amount'=> $value->amount ?? 0,
                    'status'=> _lang('payroll.adjustment.status', $value->status) ?? 0,
                    'created_date'=>\Carbon\Carbon::parse($value->created_at)->format('d M Y'),
                    'created_by'=> $value->createdBy->FullName,
                    'remarks'=> str_limit($value->remarks, 20, '...')
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
        $active = 'payroll-setting-create';
        $adjustmentType = AdjustmentType::all();
        $emoloyees = Employee::all();
        return view('admin.payroll.adjustment.create', compact('active', 'emoloyees', 'adjustmentType'));
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
            'adjustment_type' => 'required',
            'type' => 'required',
            'amount' => 'required',
            'month' => 'required',
            'remarks' => 'required',
        ]);

        if ($validator->fails()) {
            toastr()->success('Field is required !');
            return redirect()
                ->route('payroll.adjustment.index');
        }

        /*get year month string*/
        $monthArray = explode('-', $request->month);
        $year = $monthArray[0];
        $month = $monthArray[1];

        /*Start check salary hold*/
         $salaryHoldStatus = SalaryHoldList::whereYear('month', $year)->whereMonth('month', $month)->get()->pluck('employee_id')->toArray();
        /*End check salary hold*/

        $data = collect($request->all());
        $data['adjustment_date'] = Carbon::now();
        $data['created_by'] = auth()->user()->employee_id ?? 1;
        $data['updated_by'] = auth()->user()->employee_id ?? 1;
        $data['status'] = in_array($request->employee_id, $salaryHoldStatus) ? 3 : Payroll::ADJUSTMENT['status']['Generated'];

        Adjustment::insert($data->except(['_token'])->toArray());

        toastr()->success('Adjustment successfully Uploaded');

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
        $rows = Adjustment::find($id);
        $adjustmentType = AdjustmentType::all();
        $emoloyees = Employee::all();
        return view('admin.payroll.adjustment.edit', compact('active', 'id', 'rows', 'adjustmentType', 'emoloyees'));
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
        $updateData = [
            'employee_id' => $request->employee_id,
            'adjustment_type' => $request->adjustment_type,
            'type' => $request->type,
            'amount' => $request->amount,
            'remarks' => $request->remarks,
            'adjustment_date' => Carbon::now(),
            'updated_by'=>auth()->user()->employee_id ?? 1
        ];

        Adjustment::where('id', $id)->update($updateData);
        toastr()->success('Adjustment successfully Updated');
        return redirect()->back();
    }


    public function statement(Request $request)
    {
        $active = 'admin-adjustment-statement';

        /** show hide button*/
        //$confirmation = (!empty(Clearance::where('module', 'adjustment')->whereYear('created_at', Carbon::parse(Carbon::now())->format('Y'))->whereMonth('created_at', Carbon::parse(Carbon::now())->format('m'))->first())) ? false : true;
        /** show hide button*/

        /*$adjustmentType = AdjustmentType::all();
        $emoloyees = Employee::all();

        $requestCheck = $request->all();
        if (!$requestCheck) {
            $adjustments = Adjustment::whereYear('adjustment_date', Carbon::parse(Carbon::now())->format('Y'))
                ->whereMonth('adjustment_date', Carbon::parse(Carbon::now())->format('m'))->get();
            return view('admin.payroll.adjustment.statement', compact('active', 'adjustments', 'adjustmentType', 'emoloyees', 'confirmation'));
        }

        $query = Adjustment::query()
            ->whereYear('adjustment_date', Carbon::parse(Carbon::now())->format('Y'))
            ->whereMonth('adjustment_date', Carbon::parse(Carbon::now())->format('m'));
        if ($request->employee_id){
            $query->where('employee_id', $request->employee_id);
        }

        if ($request->adjustment_type){
            $query->where('adjustment_type', $request->adjustment_type);
        }

        $adjustments = $query->get();
        return view('admin.payroll.adjustment.statement', compact('active', 'adjustments', 'adjustmentType', 'emoloyees', 'confirmation'));*/

        $requestCheck = $request->all();
        if(!$requestCheck){
            $adjustments = collect();
            $year = Carbon::now()->format('Y');
            $month = Carbon::now()->format('m');
            return view('admin.payroll.adjustment.statement', compact('active', 'month', 'year', 'adjustments'));
        }
        $month = $request->input('month');
        $year = $request->input('year');
        $button = $request->button;

        if($button === 'View') {
            $adjustments = Adjustment::where('month', $year . '-' . $month)->get();
            return view('admin.payroll.adjustment.statement', compact('active', 'month', 'year', 'adjustments'));
        }
    }

    public function buttonEnabledDisabled(Request $request)
    {
        $month = !is_null($request->input('month')) ? $request->input('month') : Carbon::parse(Carbon::now())->format('m');
        $year = !is_null($request->input('year')) ? $request->input('year') : Carbon::parse(Carbon::now())->format('Y');
        $clearance = Clearance::where('module', 'adjustment')->where('month', $year.'-'.$month)->first();
        $pf = Adjustment::where('month', $year.'-'.$month)->first();
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

        $totalEmployee = Employee::whereHas('employeeJourney', function ($p){
            $p->where('employment_type_id', EmploymentTypeStatus::PERMANENT);
        })->count();

        //$total = Adjustment::where('month', $year.'-'.$month)->groupBy('adjustment_type')->select(['adjustment_type', 'amount'])->get();
        $total = Adjustment::with('adjustmentType')->select('adjustment_type', DB::raw('sum(amount) as total'))
        ->groupBy('adjustment_type')
        ->get();

        $adjustmentGenerateData = [];
        foreach($total as $row){
            $adjustmentGenerateData['result'][] = [
                    'adjustment' => $row->adjustmentType->name,
                    'amount' => $row->total
                ];
        }

        $adjustmentGenerateData['month'] = $month;
        $adjustmentGenerateData['year'] = $year;

        return view('admin.payroll.adjustment.view-clearance', compact('adjustmentGenerateData'));
    }

    public function statementClearance($year, $month)
    {
        $data = [
            'module' => 'adjustment',
            'month' => $year.'-'.$month,
            'created_at' => Carbon::parse(Carbon::now())->format('Y-m-d'),
            'created_by' => auth()->user()->employee_id
        ];
        Clearance::insert($data);

        return redirect()->route('payroll.adjustment.statement', ['month'=>$month, 'year'=>$year, 'button'=>'View']);
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function typeIndex()
    {
        $active = 'admin-adjustment-type-list';

        $adjustments = AdjustmentType::all();
        return view('admin.payroll.adjustment.index-type', compact('active', 'adjustments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function typeCreate()
    {
        $active = 'payroll-setting-create';
        return view('admin.payroll.adjustment.create-type', compact('active'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function typeStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:adjustment_types',
        ]);

        if ($validator->fails()) {
            toastr()->success('Field is required !');
            return redirect()
                ->route('payroll.adjustment.type.index');
        }

        $data = collect($request->all());
        $data['created_by'] = auth()->user()->id;
        $data['updated_by'] = auth()->user()->id;

        AdjustmentType::insert($data->except(['_token'])->toArray());

        toastr()->success('Adjustment successfully Uploaded');

        return redirect()->route('payroll.adjustment.type.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function typeEdit($id)
    {
        $active = 'admin-adjustment-type-edit';
        $rows = AdjustmentType::find($id);
        return view('admin.payroll.adjustment.edit-type', compact('active', 'id', 'rows'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function typeUpdate(Request $request, $id)
    {
        AdjustmentType::where('id', $id)->update(['name' => $request->name, 'updated_by'=>auth()->user()->id]);
        toastr()->success('Adjustment type successfully Updated');
        return redirect()->back();
    }

    public function uploadBills(Request $request){
        $active = 'admin-adjustment-bill-list';
        $adjustmentType = AdjustmentType::all();
        $emoloyees = Employee::all();

        /** show hide button*/
        $confirmation = (!empty(Clearance::where('module', 'adjustment')->whereYear('created_at', Carbon::parse(Carbon::now())->format('Y'))->whereMonth('created_at', Carbon::parse(Carbon::now())->format('m'))->first())) ? false : true;
        /** show hide button*/

        $requestCheck = $request->all();
        if (!$requestCheck) {
            $query = Adjustment::query();
            $default = AdjustmentDefaults::where('module_name', 'mobile_bill')->first();
            if($default){
                $adjustments = $query->where('adjustment_type', $default->type_id)->get();
            } else {
                $adjustments = [];
            }
            return view('admin.payroll.adjustment.uploadbill', compact('active', 'confirmation', 'adjustments', 'adjustmentType', 'emoloyees'));
        }

        $query = Adjustment::query();
        if ($request->employee_id){
            $query->where('employee_id', $request->employee_id);
        }

        if ($request->adjustment_type){
            $query->where('adjustment_type', $request->adjustment_type);
        }

        if ($request->date_from){
            $query->whereYear('created_at', \Carbon\Carbon::parse($request->date_from)->format('Y'));
            $query->whereMonth('created_at', \Carbon\Carbon::parse($request->date_from)->format('m'));
        }
        $default = AdjustmentDefaults::where('module_name', 'mobile_bill')->first();
        if($default){
            $adjustments = $query->where('adjustment_type', $default->type_id)->get();
        } else {
            $adjustments = [];
        }
        return view('admin.payroll.adjustment.uploadbill', compact('active', 'confirmation', 'adjustments', 'adjustmentType', 'emoloyees'));
    }

    public function insertUploadBillsView(Request $request){
        $active = 'admin-adjustment-bill-list';
        $adjustmentType = AdjustmentType::all();
        $emoloyees = Employee::all();
        return view('admin.payroll.adjustment.create-bill', compact('active', 'emoloyees', 'adjustmentType'));
    }

    function csvToArray($filename = '', $delimiter = ',')
    {
        if (!file_exists($filename) || !is_readable($filename))
            return false;

        $header = [];
        $data = array();
        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                if (!$header)
                    $header = $row;
                else
                    $data[] = array_combine($header, $row);
                $emp_id[] = array_combine($header, $row);
            }
            fclose($handle);
        }
        // $headerArr = ['ac_no', 'Date', 'Clock_In', 'Clock_Out'];
        // foreach($header as $h){

        // }
        return $data;
    }

    public function insertUploadBills(Request $request){
        /***validation***/
        // CSV file extention start
        if ($request->hasFile('excel_file')) {
            $file = $request->file('excel_file');
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
        $requiredHeaderCoulumnArray = ['empid', 'amount', 'remark']; // Required header column
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


        $new_file_name = md5(uniqid()) . '.' . $request->file('excel_file')->getClientOriginalExtension();
        $destinationPath = storage_path('app/import-temp/');
        $path = $request->file('excel_file')->move($destinationPath, $new_file_name);
        Excel::import(new AdjustmentsImport($request), $path);
        unlink($destinationPath.$new_file_name);
        toastr()->success('SuccessFully Data inserted');
        return back();
    }

    // public function insertUploadBills(Request $request){
    //     //dd($request->file('excel_file'));
    //     if ($request->hasFile('excel_file')) {
    //         $file = $request->file('excel_file');
    //         $validator = Validator::make([
    //             'file' => $file,
    //             'extension' => strtolower($file->getClientOriginalExtension()),
    //         ],
    //         [
    //             'file' => 'required',
    //             'extension' => 'required|in:csv',
    //         ]);
    //     } else {
    //         toastr()->error('Please select correct file.');
    //         return redirect()->back();
    //     }

    //     if ($validator->fails()) {
    //         $errors = $validator->errors();
    //         foreach ($errors->all() as $message) {
    //             toastr()->error($message);
    //         }
    //         return redirect()->back();
    //     }

    //     $hoursArrs = $this->csvToArray($file);
    //     $data = [];
    //     $default = AdjustmentDefaults::where('module_name', 'mobile_bill')->first();

    //     if(!$default){
    //         toastr()->success('Please set default type for mobile bill');
    //         return redirect()->back();
    //     }

    //     foreach ($hoursArrs as $hourArr) {
    //         $employee = Employee::where('employer_id', $hourArr['SID'])->first();
    //         $unknownEmployerId = [];

    //         if($employee){
    //             $row_data = [
    //                 'employee_id' => $employee->id,
    //                 'adjustment_type' => $default->type_id,
    //                 'type' => 'deduction',
    //                 'amount' => $hourArr['Deduct from Salary'],
    //                 'remarks' => json_encode($hourArr),
    //                 'adjustment_date' => Carbon::now(),
    //                 'created_by'=>auth()->user()->employee_id ?? 1,
    //                 'updated_by'=>auth()->user()->employee_id ?? 1,
    //                 'status' => Payroll::ADJUSTMENT['status']['pending']
    //             ];
    //             array_push($data, $row_data);
    //         }else{
    //             array_push($unknownEmployerId, $hourArr['SID']);
    //         }
    //     }
    //     if ($data) {
    //         DB::transaction(function () use ($data) {
    //             DB::table('adjustments')->insert($data);
    //         });
    //     }
    //     foreach ($unknownEmployerId  as $item){
    //         toastr()->error('Unknown employer ID '.$item.'. Data is not inserted for this unknown ID');
    //     }
    //     toastr()->success('Successfully Uploaded !');
    //     return redirect()->back();
    // }

    public function uploadBillSettings(Request $request){
        $active = 'admin-adjustment-bill-list';
        $adjustmentType = AdjustmentType::all();
        $default = AdjustmentDefaults::where('module_name', 'mobile_bill')->first();
        return view('admin.payroll.adjustment.bill-settings', compact('active', 'emoloyees', 'adjustmentType', 'default'));
    }

    public function UpdateUploadBillSettings(Request $request){
        $val = array(
            'module_name' => 'mobile_bill',
            'type_id' => $request->adjustment_type,
        );
        $isValid = AdjustmentDefaults::where('module_name', 'mobile_bill')->first();
        if($isValid){
            AdjustmentDefaults::where('module_name', 'mobile_bill')->update($val);
            toastr()->success('Settings successfully Updated');
        }
        else {
            AdjustmentDefaults::insert($val);
            toastr()->success('Settings successfully Inserted');
        }
        return redirect()->back();
    }
}
