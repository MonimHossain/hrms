<?php

namespace App\Http\Controllers\User;

use App\Employee;
use App\ExitInterviewEvaluation;
use App\Helpers\Helper;
use App\InterviewQstMst;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExitInterviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $active = 'employee-evaluation';

        $emoloyees = Employee::all();

        $requestCheck = $request->all();
        if (!$requestCheck) {
            return view('user.exitInterview.index', compact('active',  'emoloyees', 'employeeClosing'));
        }

        $query = (object) [];
            if ($request->has('employee_id')){
        }

        $employeeClosing = $query;
        return view('user.exitInterview.index', compact('active',  'emoloyees', 'employeeClosing'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $active = 'employee-evaluation';
        $questions = InterviewQstMst::all();
        return view('user.exitInterview.create', compact('id','active',  'questions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $numberQst = InterviewQstMst::count();
        $data = [];
        for($key = 0; $key < $numberQst; $key++){


            $data[] = [
                'employee_id' => auth()->user()->employee_id,
                'application_id' => $id,
                'lead_id' => Helper::getCurrentTeamLead()->id ?? 1,
                'qst_no' => $request->has('qstNo'.$key) ? $request->{'qstNo'.$key} : '',
                'qst_name' => $request->has('qstName'.$key) ? $request->{'qstName'.$key} : '',
                'ans_label' => $request->has('ansLabel'.$key) ? $request->{'ansLabel'.$key} : '',

                'ans_value' => (int) (in_array($request->{'qstType'.$key}, ['radio', 'check'])) ? $request->{'ansValue'.$key} : '',
                'ans_text' => (in_array($request->{'qstType'.$key}, ['textarea', 'input'])) ? $request->{'ansText'.$key} : '',
                'created_at' => Carbon::now()
            ];
        }


        ExitInterviewEvaluation::insert($data);
        toastr()->success('Saved Successfully !');

        return redirect()->route('user.closing.list');
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
        //
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
        //
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
