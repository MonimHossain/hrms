<?php

namespace App\Http\Controllers\Admin\Payroll;

use App\Division;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ProcessSalarySetting;
use App\Center;
use App\Department;
use App\Process;
use App\ProcessSegment;
use App\EmploymentType;

class ProcessSalarySettingsController extends Controller
{
    public function index(Request $request)
    {
        $active = 'process-salary-setting-index';

        $requestCheck = $request->all();
        if (!$requestCheck) {
            $AllSettings = ProcessSalarySetting::all();
            return view('admin.payroll.processSalarySettings.index', compact('active', 'AllSettings'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $active = 'payroll-setting-create';
        return view('admin.payroll.processSalarySettings.create', compact('active'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        $active = 'payroll-salary-setting-add';
        $flag = "add";
        $rows = '';
        $division = Division::all();
        $centers = Center::all();
        $departments = Department::all();
        $all_process = Process::all();
        $employment_types = EmploymentType::all();
        $all_process_segments = [];
        $salary_types = array(
            '1' => 'Hourly',
            '2' => 'Fixed',
        );
//         dd($division);
        return view('admin.payroll.processSalarySettings.add', compact('active', 'flag', 'rows','salary_types','employment_types', 'centers', 'division', 'departments', 'all_process', 'all_process_segments'));
    }

    public function save(Request $request)
    {
//         dd($request->all());
        $validatedData = $request->validate([
            'division_id'                       => '',
            'center_id'                         => 'required',
            'department_id'                     => 'required',
            'process_id'                        => 'required',
            'process_segment_id'                => 'required',
            'amount'                            => 'required',
            'kpi_boundary'                      => 'required',
            'salary_type'                       => 'required',
            'employment_type_id'                => 'required'
        ]);

        ProcessSalarySetting::create($validatedData);
        toastr()->success('KPI successfully created');
        return redirect()->route('process.payment.setting.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $kpis = (new FastExcel)->sheet(6)->import($request->file('file'));
        Kpi::insert($kpis);
        toastr()->success('KPI successfully Uploaded');
        return redirect()->route('kpi.setting.index');
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
        $active = 'process-salary-setting-index';
        $flag = "edit";
        $centers = Center::all();
        $departments = Department::all();
        $all_process = Process::all();
        $employment_types = EmploymentType::all();
        $all_process_segments = ProcessSegment::all();
        $salary_types = array(
            '1' => 'Hourly',
            '2' => 'Fixed',
        );
        $rows = ProcessSalarySetting::find($id);
        return view('admin.payroll.processSalarySettings.add', compact('active', 'flag', 'rows','salary_types','employment_types', 'centers', 'departments', 'all_process', 'all_process_segments', 'id'));
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
        $validatedData = $request->validate([
            'division_id'                       => '',
            'center_id'                         => 'required',
            'department_id'                     => 'required',
            'process_id'                        => 'required',
            'process_segment_id'                => 'required',
            'amount'                            => 'required',
            'kpi_boundary'                      => 'required',
            'salary_type'                       => 'required',
            'employment_type_id'                => 'required'
        ]);

        ProcessSalarySetting::find($id)->update($validatedData);
        toastr()->success('Entry successfully Updated');
        return redirect()->route('process.payment.setting.index');
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
