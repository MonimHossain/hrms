<?php

namespace App\Http\Controllers\Admin\Appraisal\Setting;

use App\Employee;
use App\AppraisalQstChd;
use App\AppraisalQstMst;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class AppraisalSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $active = 'admin-employee-appraisal-question-setting';

        $emoloyees = Employee::all();

        $requestCheck = $request->all();
        if (!$requestCheck) {
            $questionsList = AppraisalQstMst::all();
            return view('admin.appraisal.setting.index', compact('active',  'questionsList'));
        }

        $query = (object) [];
        if ($request->has('employee_id')){
        }

        $employeeClosing = $query;
        return view('admin.appraisal.setting.index', compact('active',  'emoloyees', 'employeeClosing'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $active = 'admin-employee-interview';
        return view('admin.appraisal.setting.create', compact('active'));
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
                ->route('admin.employee.appraisal.question.setting');
        }

        $data = [
            'name' => $request->has('name') ? $request->name : " ",
            'type_id' => $request->has('type_id') ? $request->type_id : " ",
            'marks' => $request->has('mark') ? $request->mark : " ",
            'created_by' => auth()->user()->employee_id ?? 1
        ];

        AppraisalQstMst::create($data);
        toastr()->success('Successfully Saved!');
        return redirect()->route('admin.employee.appraisal.question.setting');

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
        $row = AppraisalQstMst::find($id);
        return view('admin.appraisal.setting.edit', compact('active', 'row', 'id'));
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
            'type_id' => $request->has('type_id') ? $request->type_id : " ",
        ];

        AppraisalQstMst::where('id', $id)->update($data);
        toastr()->success('Successfully update!');
        return redirect()->route('admin.employee.appraisal.question.setting');
    }


    public function answer(Request $request)
    {

        $active = 'admin-employee-appraisal-answer-setting';

        $questions = AppraisalQstMst::all();
        $requestCheck = $request->all();
        if (!$requestCheck) {
            $questionsList = AppraisalQstChd::all();
            return view('admin.appraisal.setting.answer', compact('active',  'questionsList', 'questions'));
        }

        $query = AppraisalQstChd::query();

        if ($request->has('question_id')){
            $query = $query->where('mst_id', $request->question_id);
        }

        if($request->get('question_type')){
            $query = $query->whereHas('question', function ($q) use ($request){
                $q->where('type_id', $request->question_type);
            });
        }

        $questionsList = $query->get();
        return view('admin.appraisal.setting.answer', compact('active',  'questionsList', 'questions'));
    }

    public function answerCreate()
    {
        $active = 'admin-employee-interview-answer';
        $questions = AppraisalQstMst::all();
        return view('admin.appraisal.setting.answer-create', compact('active', 'questions'));
    }

    public function filterAppraisalQuestionList(Request $request)
    {
        $id = $request->has('id') ? $request->id : '';

        return $data = AppraisalQstMst::where('type_id', $id)->get()->toArray();

        /*$option = [];
        foreach ($data as $val)
        {
            $option[$val['id']] = $val['name'];
        }

        return $option;*/
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
                ->route('admin.employee.appraisal.answer.setting');
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


        AppraisalQstChd::insert($data);
        toastr()->success('Successfully Saved!');
        return redirect()->route('admin.employee.appraisal.answer.setting');

    }

    public function answerEdit($id)
    {
        $active = 'admin-employee-interview-answer';
        $row = AppraisalQstChd::find($id);
        $questions = AppraisalQstMst::all();
        return view('admin.appraisal.setting.answer-edit', compact('active', 'row', 'id', 'questions'));

    }

    public function answerUpdate(Request $request, $id)
    {
        $data = [
            'mst_id' => $request->has('question') ? $request->question : " ",
            'label' => $request->has('label') ? $request->label : " ",
            'value' => $request->has('value') ? $request->value : " ",
            'type' => $request->has('fieldType') ? $request->fieldType : " ",
        ];

        AppraisalQstChd::where('id', $id)->update($data);
        toastr()->success('Successfully update!');
        return redirect()->route('admin.employee.appraisal.answer.setting');
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
