<?php

namespace App\Http\Controllers\Admin\Loan;


use App\Clearance;
use App\Employee;
use App\Http\Forms\Loan\LoanTypeObj;
use App\Loan\DueLoan;
use App\Loan\EmiLoan;
use App\Loan\LoanController;
use App\LoanApplication;
use App\LoanEmi;
use App\LoanGeneralApplication;
use App\LoanInterested;
use App\Utils\Payroll;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\LoanType;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;


class LoanApplicationController extends Controller
{


    /**
     * Api for loan
     * http://hrms.test/loan/show/api/emi/54 return from
     */
    public function showLoanApi($flag = null, $id = null)
    {
        $class = DueLoan::class;

        if ($flag === 'emi') {
            $class = EmiLoan::class;
        }
        $loanController = new LoanController(new $class, $id);

        $loanController->show();
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function applicationHistory(Request $request)
    {
        $active = 'admin-application-history';


        $requestCheck = $request->all();

        if (!$requestCheck) {
            $applicationList = LoanApplication::all();
            return view('admin.loan.application-history', compact('active', 'applicationList'));
        }

        $query = LoanApplication::query();
        if ($request->reference_id) {
            $query->where('reference_id', $request->reference_id);
        }

        if ($request->employee_id) {
            $query->where('employee_id', Employee::where('employer_id', $request->employee_id)->first()->id ?? 0);
        }

        if ($request->date_from || $request->date_to) {
            $query->whereBetween('active_month', [$request->date_from, $request->date_to]);
        }

        $applicationList = $query->simplePaginate(10);
        return view('admin.loan.application-history', compact('active', 'applicationList'));
    }


    public function applicationHistoryUpdate($id)
    {
        $findApplication = LoanApplication::find($id);
        return view('admin.loan.application-history-status-change', compact('findApplication', 'id'));
    }

    public function applicationHistoryChangeUpdate(Request $request, $id)
    {
        $findAppHistory = LoanApplication::find($id);
        $findAppHistory->status = $request->status;
        $findAppHistory->approved_by = auth()->user()->employee_id;
        $findAppHistory->save();
        toastr()->success('Successfully updated.');

        return redirect()->route('admin.loan.application.history');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function loanStatusHistory(Request $request)
    {
        $active = 'admin-loan-history-status';

        $requestCheck = $request->all();

        if (!$requestCheck) {
            $loanApplication = LoanApplication::where('status', Payroll::LOAN['SHOWSTATUS']['APPROVED'])->simplePaginate(10);
            return view('admin.loan.loan-status-history', compact('active', 'loanApplication'));
        }

        $query = LoanApplication::query();
        if ($request->reference_id) {
            $query->where('reference_id', $request->reference_id);
        }

        if ($request->employee_id) {
            $query->where('employee_id', Employee::where('employer_id', $request->employee_id)->first()->id ?? 0);
        }

        if ($request->date_from || $request->date_to) {
            $query->whereBetween('active_month', [$request->date_from, $request->date_to]);
        }

        $loanApplication = $query->where('status', Loan::SHOWSTATUS['APPROVED'])->simplePaginate(10);
        return view('admin.loan.loan-status-history', compact('active', 'loanApplication'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function loanStatementUpdate()
    {
        $active = 'admin-loan-statement-update';
        $confirmation = (!empty(Clearance::where('module', 'loan')->whereYear('created_at', Carbon::parse(Carbon::now())->format('Y'))->whereMonth('created_at', Carbon::parse(Carbon::now())->format('m'))->first())) ? false : true;
        $generate = (!empty(LoanEmi::whereYear('emi_date', Carbon::parse(Carbon::now())->format('Y'))->whereMonth('emi_date', Carbon::parse(Carbon::now())->format('m'))->first())) ? false : true;

        $confirmation = ($generate) ? false : ($confirmation) ? true : false; //Re initialize confirmation button for show hide


        $loanApplication = LoanEmi::whereYear('emi_date', Carbon::now()->format('Y'))->whereMonth('emi_date', Carbon::now()->format('m'))->get();
        return view('admin.loan.loan-statement-update', compact('active', 'loanApplication', 'generate', 'confirmation'));
    }


    public function loanStatementEmiChange($id)
    {
        $findAppHistory = LoanEmi::find($id);
        return view('admin.loan.loan-statement-update-emi-change', compact('findAppHistory', 'id'));
    }

    public function loanStatementUpdateEmiChange(Request $request, $id)
    {
        $loanEmiFind = LoanEmi::find($id);
        $dueAmount = ($loanEmiFind->amount - $request->emi_amount) + $loanEmiFind->amount_due;
        LoanEmi::where(['id' => $id])->first()->update(['amount' => $request->emi_amount, 'amount_due' => $dueAmount, 'remarks' => $request->remarks]);
        LoanApplication::where(['id' => $loanEmiFind->loan_id])->first()->update(['due_amount' => $dueAmount]);
        return redirect()->route('admin.loan.statement.update');
    }


    public function loanStatementUpdateEmiGenerate()
    {
        $loanApplication = LoanApplication::where('status', Payroll::LOAN['SHOWSTATUS']['APPROVED'])->where('due_amount', '>', 0)->get();
        if (count($loanApplication)) {
            foreach ($loanApplication as $key => $row) {
                $emi = $row->due_amount / $row->due_interval;
                $data = [
                    'loan_id' => $row->id,
                    'amount' => $emi,
                    'amount_due' => $row->due_amount - $emi,
                    'emi_date' => Carbon::now()->format('Y-m-d'),
                    'remarks' => '',
                    'status' => Payroll::LOAN['SHOWPROCESS']['DUE'],
                    'approved_by' => auth()->user()->employee_id ?? 1
                ];
                $loanEmi = LoanEmi::updateOrCreate($data);
                LoanApplication::where(['id' => $loanEmi->loan_id])->first()->update(['due_interval' => $row->due_interval - 1, 'due_amount' => ($row->due_amount - $emi)]);
            }
            toastr()->success('Successfully Generated.');
        } else {
            toastr()->success('No application due amount');
        }
        return redirect()->route('admin.loan.statement.update');
    }


    public function loanStatementUpdateEmiClearance()
    {
        $data = [
            'module' => 'loan',
            'created_at' => Carbon::parse(Carbon::now())->format('Y-m-d'),
            'created_by' => auth()->user()->employee_id
        ];
        Clearance::insert($data);
        return redirect()->route('admin.loan.statement.update');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function loanStatementHistory()
    {
        $active = 'admin-loan-statement-history';
        $loanApplication = LoanEmi::whereYear('emi_date', Carbon::now()->format('Y'))->whereMonth('emi_date', Carbon::now()->format('m'))->get();
        return view('admin.loan.loan-statement-history', compact('active', 'loanApplication'));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function emiApplicationHistory()
    {
        $active = 'admin-emi-application-history';
        $emiAppList = LoanGeneralApplication::all();
        return view('admin.loan.emi-application-history', compact('active', 'emiAppList'));
    }

    public function emiApplicationHistoryEdit($id)
    {
        $findApplication = LoanGeneralApplication::find($id);
        return view('admin.loan.emi-application-history-edit', compact('findApplication', 'id'));
    }

    public function emiApplicationHistoryUpdate(Request $request, $id)
    {
        $findLoanGeneralForm = LoanGeneralApplication::find($id);
        $findLoanGeneralForm->status = $request->status;
        $findLoanGeneralForm->save();
        toastr()->success('Successfully updated.');
        return redirect()->route('admin.loan.emi.application.history');
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function settingLoanType()
    {
        $active = 'admin-setting-loan-type';
        $loanTypes = LoanType::all();
        return view('admin.loan.setting-loan-type', compact('active', 'loanTypes'));
    }


    public function settingLoanTypeCreate()
    {
        return view('admin.loan.setting-loan-type-create');
    }


    public function settingLoanTypeSave(LoanTypeObj $obj)
    {
        $obj->save();
        toastr()->success('Successfully created.');
        return redirect()->route('admin.loan.setting.loan.type');
    }


    public function settingLoanTypeEdit($id)
    {
        $loanTypes = LoanType::find($id);
        return view('admin.loan.setting-loan-type-edit', compact('loanTypes', 'id'));
    }

    public function settingLoanTypeUpdate(Request $request, $id)
    {

        $loanType = LoanType::find($id);
        $loanType->loan_type = $request->loan_type;
        $loanType->content = $request->terms_and_condition;
        $loanType->max_amount = $request->max_amount;
        $loanType->interval = $request->interval;
        $loanType->save();

        toastr()->success('Successfully updated.');
        return redirect()->route('admin.loan.setting.loan.type');
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function settingLoanInterested($id)
    {
        $active = 'admin-setting-loan-interested';
        $query = LoanInterested::find($id);
        $interested = optional($query)->first();
        return view('admin.loan.setting-loan-interested', compact('active', 'interested', 'id'));
    }


    public function settingLoanInterestedUpdate(Request $request, $id)
    {
        $validatedData = Validator::make($request->all(), [
            'interested' => 'required|numeric',
        ]);
        if ($validatedData->fails()) {
            return redirect()
                ->route('payroll.provident.fund.setting');
        }

        LoanInterested::updateOrCreate(
            ['id' => $id],
            ['interested' => $request->interested]
        );


        toastr()->success('Successfully updated.');
        return redirect()->route('admin.loan.setting.loan.interested', ['id' => $id]);
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
        //
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
