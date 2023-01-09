<?php

namespace App\Http\Controllers\Admin\Closing;

use App\Employee;
use App\InterviewQstChd;
use App\InterviewQstMst;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class SettingExitInterviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $active = 'admin-employee-interview';

        $emoloyees = Employee::all();

        $requestCheck = $request->all();
        if (!$requestCheck) {
            $questionsList = InterviewQstMst::all();
            return view('admin.exitInterview.index', compact('active',  'questionsList'));
        }

        $query = (object) [];
        if ($request->has('employee_id')){
        }

        $employeeClosing = $query;
        return view('admin.exitInterview.index', compact('active',  'emoloyees', 'employeeClosing'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $active = 'admin-employee-interview';
        return view('admin.exitInterview.create', compact('active'));
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
            'name' => 'required',
            'type_id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('admin.employee.interview');
        }

        $data = [
            'name' => $request->has('name') ? $request->name : " ",
            'marks' => $request->has('marks') ? $request->marks : " ",
            'type_id' => $request->has('type_id') ? $request->type_id : " ",
            'created_by' => auth()->user()->employee_id ?? 1
        ];

        InterviewQstMst::create($data);
        toastr()->success('Successfully Saved!');
        return redirect()->route('admin.employee.interview');

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
        $active = 'admin-employee-interview';
        $row = InterviewQstMst::find($id);
        return view('admin.exitInterview.edit', compact('active', 'row', 'id'));
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

        $data = [
            'name' => $request->has('name') ? $request->name : " ",
            'marks' => $request->has('marks') ? $request->marks : " ",
            'type_id' => $request->has('type_id') ? $request->type_id : " ",
        ];

        InterviewQstMst::where('id', $id)->update($data);
        toastr()->success('Successfully update!');
        return redirect()->route('admin.employee.interview');
    }


    public function answer(Request $request)
    {
        $active = 'admin-employee-interview-answer';

        $requestCheck = $request->all();
        if (!$requestCheck) {
            $questionsList = InterviewQstChd::all();
            return view('admin.exitInterview.answer', compact('active',  'questionsList'));
        }

        $query = (object) [];
        if ($request->has('employee_id')){

        }

        $employeeClosing = $query;
        return view('admin.exitInterview.answer', compact('active', 'questionsList'));
    }

    public function answerCreate()
    {
        $active = 'admin-employee-interview-answer';
        $questions = InterviewQstMst::all();
        return view('admin.exitInterview.answer-create', compact('active', 'questions'));
    }

    public function answerStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'question' => 'required',
            'label' => 'required',
            'value' => 'required',
            'fieldType' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('admin.employee.interview.answer');
        }

        $data = [];
        foreach ($request->label as $key => $label){
            $data[] = [
                'mst_id' => $request->has('question') ? $request->question : " ",
                'label' => $request->has('label') ? $label : " ",
                'value' => $request->has('value') ? $request->value[$key] : " ",
                'type' => $request->has('fieldType') ? $request->fieldType : " ",
                'created_by' => auth()->user()->employee_id ?? 1
            ];
        }

        InterviewQstChd::insert($data);
        toastr()->success('Successfully Saved!');
        return redirect()->route('admin.employee.interview.answer');

    }

    public function answerEdit($id)
    {
        $active = 'admin-employee-interview-answer';
        $row = InterviewQstChd::find($id);
        $questions = InterviewQstMst::all();
        return view('admin.exitInterview.answer-edit', compact('active', 'row', 'id', 'questions'));

    }

    public function answerUpdate(Request $request, $id)
    {
        $data = [
            'mst_id' => $request->has('question') ? $request->question : " ",
            'label' => $request->has('label') ? $request->label : " ",
            'value' => $request->has('value') ? $request->value : " ",
            'type' => $request->has('fieldType') ? $request->fieldType : " ",
        ];

        InterviewQstChd::where('id', $id)->update($data);
        toastr()->success('Successfully update!');
        return redirect()->route('admin.employee.interview.answer');
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
