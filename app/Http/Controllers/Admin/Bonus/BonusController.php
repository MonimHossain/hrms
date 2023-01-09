<?php

namespace App\Http\Controllers\Admin\Bonus;

use App\Bonus;
use App\Employee;
use App\EmploymentType;
use App\Utils\Payroll;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class BonusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $active = 'admin-bonus-list';

        $emoloyees = Employee::all();        
        if(! $request->all()){
            $bonuses = Bonus::all();            
            return view('admin.payroll.bonus.index', compact('active', 'bonuses', 'emoloyees'));
        }

        $query = Bonus::query();
        if ($request->employee_id){
            $query->where('employee_id', $request->employee_id);
        }

        if ($request->month){
            $query->whereYear('month', \Carbon\Carbon::parse($request->month)->format('Y'));
            $query->whereMonth('month', \Carbon\Carbon::parse($request->month)->format('m'));
        }

        $bonuses = $query->get();
        return view('admin.payroll.bonus.index', compact('active', 'bonuses', 'emoloyees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $active = 'payroll-bonus-create';
        $emoloymentTypes = EmploymentType::all();
        return view('admin.payroll.bonus.create', compact('active', 'emoloymentTypes'));
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
            'employmentType' => 'required',
            'name' => 'required',
            'month' => 'required',
            'amount' => 'required',
            'type' => 'required',
            'remarks' => 'required',
        ]);

        if ($validator->fails()) {
            toastr()->success('Field is required !');
            return redirect()
                ->route('payroll.bonus.index');
        }

        $empType = $request->employmentType;


        $data = collect($request->all());
        $data['created_by'] = auth()->user()->employee_id ?? 1;
        $data['updated_by'] = auth()->user()->employee_id ?? 1;
        $data['status'] = Payroll::BONUS['status']['Active'];

        $commonField = $data->except(['_token', 'employmentType']);

        $employeeList = Employee::whereHas('employeeJourney', function ($query) use ($empType){
            $query->where('employee_journeys.employment_type_id', $empType);
        })->get();


        $employeeList->map(function ($employeeValue) use ($commonField) {
            $data = [];
            foreach ($commonField as $key=>$common){
                $data['employee_id'] = $employeeValue->id;
                $data['name'] = $commonField['name'];
                $data['month'] = Carbon::parse($commonField['month'])->format('Y-m-d');
                $data['amount'] = $commonField['amount'];
                $data['remarks'] = $commonField['remarks'];
                $data['status'] = 1;
                $data['created_by'] = auth()->user()->employee_id ?? 1;
                $data['updated_by'] = auth()->user()->employee_id ?? 1;
                $data['status'] = Payroll::BONUS['status']['Active'];
            }
            Bonus::updateOrCreate(['employee_id' => $employeeValue->id, 'month' => Carbon::parse($commonField['month'])->format('Y-m-d')], $data);
        });


        toastr()->success('Bonus successfully Uploaded');


        return redirect()->route('payroll.bonus.index');
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
        $emoloymentTypes = EmploymentType::all();
        $rows = Bonus::find($id);
        return view('admin.payroll.bonus.edit', compact('active', 'rows', 'emoloymentTypes', 'id'));
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
        $data = collect($request->all());
        $data['month'] = Carbon::parse($request->month)->format('Y-m-d');
        $data['updated_by'] = auth()->user()->employee_id ?? 1;
        $data['updated_at'] = Carbon::now();

        Bonus::where('id', $id)->update($data->except(['_token','_method'])->toArray());

        toastr()->success('Bonus successfully Updated');

        return redirect()->route('payroll.bonus.index');
    }

    /**
     * History List show data.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function history(Request $request)
    {
        $active = 'admin-bonus-history';

        $emoloyees = Employee::all();

        return view('admin.payroll.bonus.history', compact('active', 'emoloyees'));
    }
}
