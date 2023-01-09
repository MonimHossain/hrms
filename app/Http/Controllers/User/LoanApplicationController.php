<?php

namespace App\Http\Controllers\User;

use App\Http\Forms\Loan\LoanApplicationObj;
use App\LoanApplication;
use App\LoanEmi;
use App\LoanGeneralApplication;
use App\LoanType;
use App\Utils\Loan;
use App\Utils\Payroll;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class LoanApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $active = 'user-apply-status';
        $loanApplication = LoanApplication::where('employee_id', auth()->user()->employee_id)->get();
        return view('user.loan.application-status', compact('active', 'loanApplication'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $active = 'user-apply-loan';
        $loanTypes = LoanType::all();
        return view('user.loan.create-application', compact('active', 'loanTypes'));
    }


    public function termAndCondition(Request $request)
    {
        $id = $request->id;

        $message = LoanType::find($id);
        echo $message;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function allEmiHistory()
    {
        $active = 'user-loan-emi-history';
        $loanApplication = LoanEmi::whereHas('loan', function($query){
            $query->where('employee_id',auth()->user()->employee_id);
        })->get();
//        dd($loanApplication);
//        $loanApplication = LoanEmi::where('employee_id', auth()->user()->employee_id)->get();
        return view('user.loan.loan-emi-history', compact('active', 'loanApplication'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function emiAdjustment()
    {
        $active = 'user-loan-emi-adjustment';
        $emiList = LoanGeneralApplication::where('employee_id', auth()->user()->employee_id)->get();
        return view('user.loan.loan-emi-adjustment', compact('active', 'emiList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function emiReduceApplication()
    {
        $active = 'user-loan-emi-reduce-application';
        $ref = LoanApplication::query()
            ->where('status', Payroll::LOAN['SHOWSTATUS']['APPROVED'])
            ->where('employee_id', auth()->user()->employee_id)
            ->whereDoesntHave('loanGeneralApp', function ($q)
            {
                $q->where('status', Payroll::LOAN['SHOWSTATUS']['APPROVED']);
            })->get();

        return view('user.loan.loan-emi-reduce-application', compact('active', 'ref'));
    }


    public function emiReduceApplicationStore(Request $request)
    {

        $rules = [
            'reference_id' => 'required',
            'remarks' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()
                ->route('loam.emi.reduce.application')
                ->withErrors($validator)
                ->withInput();
        }
        $emiReduceApplication = new LoanGeneralApplication;

        $data = [
            'content' => $request->remarks,
            'employee_id' => auth()->user()->employee_id,
            'loan_id' => $request->reference_id, //use loan id
            'status' => Payroll::LOAN['SHOWSTATUS']['REQUEST'],
        ];

        $emiReduceApplication->create($data);
        toastr()->success('Successfully saved.');
        return redirect()->route('loam.emi.adjustment');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LoanApplicationObj $application)
    {
        $application->save();
        toastr()->success('Successfully saved.');
        return redirect()->route('loam.application.index');

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
        $loanTypes = LoanType::all();
        $rowField = LoanApplication::find($id);
        return view('user.loan.loan-application-edit', compact('id', 'loanTypes', 'rowField'));
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
        $loanApplication = LoanApplication::find($id);
        $loanApplication->loan_type = $request->loan_type;
        $loanApplication->interval = $request->interval;
        $loanApplication->due_interval = $request->interval;
        $loanApplication->amount = $request->amount;
        $loanApplication->due_amount = $request->amount;
        $loanApplication->remarks = $request->remarks;
        $loanApplication->reference_id = $request->reference_id;
        $loanApplication->status = Loan::SHOWSTATUS['REQUEST'];
        $loanApplication->save();

        toastr()->success('Successfully updated.');
        return redirect()->route('loam.application.index');
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
