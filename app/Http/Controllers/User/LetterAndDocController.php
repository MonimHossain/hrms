<?php

namespace App\Http\Controllers\User;

use App\Attendance;
use App\Department;
use App\DocSetup;
use App\Document;
use App\DocumentReqHistory;
use App\DocumentReqTemplate;
use App\LeaveBalanceSetting;
use App\LeaveDocument;
use App\LeaveRule;
use App\Notifications\DocumentNotification;
use App\Notifications\LeaveApply;
use App\Process;
use App\Team;
use App\TeamLeaveStatus;
use App\Utils\AttendanceStatus;
use App\Utils\DocumentAndLetter;
use App\Utils\EmploymentTypeStatus;
use App\Utils\Permissions;
use App\Utils\TeamMemberType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Leave;
use App\User;
use DB;
use PDF;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Validator;
use App\Workflow;
use App\Employee;
use App\ApprovalProcess;
use App\EmployeeJourney;
use App\EmployeeTeam;
use App\LeaveBalance;
use App\ProcessOrdering;
use App\SetLeave;
use App\TeamWorkflow;
use App\Utils\LeaveStatus;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use App\LetterAndDocument;
use App\Utils\ReferenceNumber;
use App\Utils\DocumentRequestHistoryStatus;
use App\DocumentHeaderTemplate;


class LetterAndDocController extends Controller
{
    /**
     * @method:
     * @param :
     * @return void
     *
     */

    public function userRequestDocAndLetter()
    {
        $active = 'user-document-create';
        $docTypes = DocSetup::where('permission', 1)->get();
        $employees = Employee::all();
        return view('admin.letterAndDocs.user.create_doc', compact('active', 'docTypes', 'employees'));
    }

    public function getDocumentSetupTemplate(Request $request)
    {
        $docTemplate = DocumentReqTemplate::where('type_id', $request->id)->first();
        if(!empty($docTemplate)){
            $result = $docTemplate->content ?? '';
        }else{
            $result = '';
        }
        return $result;
    }

    public function saveDocAndLetter(Request $request)
    {
        $employee = Employee::find(auth()->user()->employee_id);


        $userList = User::permission(_permission(Permissions::ADMIN_LETTER_AND_DOCUMENTS_VIEW))->get();

        //$toEmployee = Employee::find($userList); // Hard Code for select hr admin.

        $docRequest = new DocumentReqHistory;
        $docRequest->type_id = $request->input('type_id');
        $docRequest->ref_id = $this->generateRefNumber();
        $docRequest->content = $request->input('editor1');
        $docRequest->employee_id = auth()->user()->employee_id;
        $docRequest->processed_by = $request->input('processed_by');
        $docRequest->remarks = $request->input('request');
        $docRequest->save();

        Notification::send($userList, new DocumentNotification($employee->FullName, 'Request for Document', 'admin.document.request.history'));


        return redirect()->route('employee.request.history');
    }

    public function userRequestHistory(Request $request)
    {
        $userId = auth()->user()->employee_id;
        $active = 'user-request-history';
        $docTypes = DocSetup::all();
        $employees = Employee::all();

        $requestCheck = $request->all();
        if (!$requestCheck) {
            $userReqHistory = DocumentReqHistory::where('employee_id', $userId)->get();
            return view('admin.letterAndDocs.user.request_history', compact('active', 'docTypes', 'employees', 'userReqHistory'));
        }

        $query = DocumentReqHistory::query();
        if ($request->status != null) {
            $query->where('status', $request->status);
        }

        if ($request->doc_type){
            $query->where('type_id', $request->doc_type);
        }

        if ($request->start_date || $request->end_date){
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        $userReqHistory = $query->where('employee_id', $userId)->get();

        return view('admin.letterAndDocs.user.request_history', compact('active', 'docTypes', 'employees', 'userReqHistory'));
    }

    public function userDocumentHistory()
    {
        $userId = auth()->user()->employee_id;
        $active = 'user-document-history';
        $docTypes = DocSetup::all();
        $docHistory = Document::where('status', '=', 1)->where('employee_id', $userId)->paginate(15);
        return view('admin.letterAndDocs.user.doc_history', compact('active', 'docTypes', 'docHistory'));
    }

    public function generateRefNumber(){
        $countDocAndDocument = DocumentReqHistory::select('id')->max('id') + 1;
        return ReferenceNumber::AppointmentLetter.date("ymd").str_pad($countDocAndDocument, 6, "0", STR_PAD_LEFT);
    }

    public function documentAndLetterWithPdf($id)
    {
        $type = 'yes';
        $pdfData = Document::where('id',$id)->first();
        $data = ['data' => $pdfData, 'type'=> $type];
        $pdf = PDF::loadView('admin.letterAndDocs.pdf', $data);
        $file = $this->fileNameGenerate('documents');
        return $pdf->download($file.'.pdf');
    }

    public function fileNameGenerate($table)
    {
        $countDocAndDocument = DB::table($table)->where('year', Date('Y'))->select('id')->max('id') + 1;
        return date("ymd").str_pad($countDocAndDocument, 6, "0", STR_PAD_LEFT).rand(100,1000);
    }

}
