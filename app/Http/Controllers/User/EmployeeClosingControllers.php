<?php

namespace App\Http\Controllers\User;

use App\ClearanceChecklist;
use App\ClosingApplication;
use App\ClosingClearanceSetting;
use App\ClosingClearanceStatus;
use App\Employee;
use App\EmployeeClosing;
use App\Utils\EmployeeClosing as EmpClosing;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmployeeClosingControllers extends Controller
{
    /**
     * show clearance request for Admin.
     *
     * @param $request Object from Request Class
     *
     * @return @blade @View
     */

    public function admin(Request $request)
    {
        $active = 'request-to-admin';

        $emoloyees = Employee::all();

        $requestCheck = $request->all();
        if (!$requestCheck) {
            $hrApproval = EmployeeClosing::where('checklist_id', \App\Utils\EmployeeClosing::ApprovedFrom['status']['hr'])
                ->where('approval_status', \App\Utils\EmployeeClosing::ApprovedFrom['approval']['approved'])
                ->get();
            $adminApproval = EmployeeClosing::where('checklist_id', \App\Utils\EmployeeClosing::ApprovedFrom['status']['hr'])->get();
            $employeeClosing = $hrApproval->merge($adminApproval);
            return view('admin.emploeeClosing.admin', compact('active',  'emoloyees', 'employeeClosing'));
        }

        $query = EmployeeClosing::query();
        if ($request->has('employee_id')){
            $query->where('employee_id', $request->employee_id);
            $query->where('checklist_id', \App\Utils\EmployeeClosing::ApprovedFrom['status']['admin']);
        }

        $employeeClosing = $query->get();
        return view('admin.emploeeClosing.admin', compact('active',  'emoloyees', 'employeeClosing'));

    }

    public function adminShow($id)
    {
        $checklist = ClearanceChecklist::where('name', 'admin')->first(); // get from interface
        return view('admin.emploeeClosing.admin-show', compact('checklist', 'id'));
    }

    public function adminApproved(Request $request, $id)
    {
        $employeeClosing = new EmployeeClosing;
        $employeeClosing->employee_id = EmployeeClosing::find($id)->employee_id;
        $employeeClosing->checklist_id = \App\Utils\EmployeeClosing::ApprovedFrom['status']['admin']; // get from interface
        $employeeClosing->approved_by = auth()->user()->employee_id;
        $employeeClosing->approval_status = $request->approval_status;
        $employeeClosing->remarks = $request->remarks;
        $employeeClosing->save();

        toastr()->success('Successful');

        return redirect()->route('request.clearance.admin');
    }


    /**
     * show clearance request for IT.
     *
     * @param $request Object from Request Class
     *
     * @return @blade @View
     */

    public function it(Request $request)
    {
        $active = 'request-to-it';

        $checklist_id = ClearanceChecklist::where('name', 'hr')->first()->id ?? 0; // get from interface

        $emoloyees = Employee::all();

        $requestCheck = $request->all();
        if (!$requestCheck) {
            $hrApproval = EmployeeClosing::where('checklist_id', \App\Utils\EmployeeClosing::ApprovedFrom['status']['hr'])
                ->where('approval_status', \App\Utils\EmployeeClosing::ApprovedFrom['approval']['approved'])
                ->get();
            $itApproval = EmployeeClosing::where('checklist_id', \App\Utils\EmployeeClosing::ApprovedFrom['status']['it'])->get();
            $employeeClosing = $hrApproval->merge($itApproval);
            return view('admin.employeeClosing.it', compact('active',  'emoloyees', 'employeeClosing'));
        }

        $query = EmployeeClosing::query();
        if ($request->employee_id){
            $query->where('employee_id', $request->employee_id);
            $query->where('checklist_id', \App\Utils\EmployeeClosing::ApprovedFrom['status']['it']);
        }

        $employeeClosing = $query->get();
        return view('admin.employeeClosing.it', compact('active',  'emoloyees', 'employeeClosing'));
    }

    public function itShow($id)
    {
        $checklist = ClearanceChecklist::where('name', 'it')->first(); // get from interface
        return view('admin.emploeeClosing.it-show', compact('checklist', 'id'));
    }

    public function itApproved(Request $request, $id)
    {
        $employeeClosing = new EmployeeClosing;
        $employeeClosing->employee_id = EmployeeClosing::find($id)->employee_id;
        $employeeClosing->checklist_id = \App\Utils\EmployeeClosing::ApprovedFrom['status']['it']; // get from interface
        $employeeClosing->approved_by = auth()->user()->employee_id;
        $employeeClosing->approval_status = $request->approval_status;
        $employeeClosing->remarks = $request->remarks;
        $employeeClosing->save();

        toastr()->success('Successful');

        return redirect()->route('request.clearance.it');
    }


    /**
     * show clearance request for accounts.
     *
     * @param $request Object from Request Class
     *
     * @return @blade @View
     */

    public function account(Request $request)
    {
        $active = 'request-to-account';

        $emoloyees = Employee::all();

        $requestCheck = $request->all();
        if (!$requestCheck) {
            $employeeClosing = ClosingClearanceStatus::where('accounts_status', EmpClosing::ApprovedFrom['approval']['pending'])->get();
            return view('admin.employeeClosing.accounts', compact('active',  'emoloyees', 'employeeClosing'));
        }

        $query = ClosingClearanceStatus::query();
        if ($request->has('employee_id')){
            $query->whereHas('employeeByApplication', function ($q) use ($request){
                $q->where('employee_id', $request->employee_id);
            });
            $query->whereIn('accounts_status', [EmpClosing::ApprovedFrom['approval']['approved'], EmpClosing::ApprovedFrom['approval']['rejected'], EmpClosing::ApprovedFrom['approval']['pending']]);
        }

        $employeeClosing = $query->get();

        return view('admin.employeeClosing.accounts', compact('active',  'emoloyees', 'employeeClosing'));
    }

    public function accountShow($id, $appId)
    {
        $application = ClosingApplication::find($appId);
        $setting = ClosingClearanceSetting::find(1);
        $userType = $this->selectUserInChargeOrHod();

        return view('admin.employeeClosing.accounts-show', compact('id', 'appId', 'application', 'setting', 'userType'));
    }

    public function accountApproved(Request $request, $id)
    {
        $userSelect = $this->selectUserInChargeOrHod();

        $data = [];

        if($userSelect[1] === 'hod'){
            $data = [
                $userSelect[0].'_'.$userSelect[1].'_by' => auth()->user()->employee_id,
                $userSelect[0].'_status' => ($request->approval_status == EmpClosing::ApprovedFrom['approval']['approved']) ?
                    EmpClosing::ApprovedFrom['approval']['approved'] : EmpClosing::ApprovedFrom['approval']['rejected']
            ];
        }


        if($userSelect[1] === 'in'){
           $data = [
                $userSelect[0].'_'.$userSelect[1].'_charge_by' => auth()->user()->employee_id,
                $userSelect[0].'_clearance' => $request->remarks
            ];
        }


        ClosingClearanceStatus::where('id', $id)->update($data);

        toastr()->success('Successfully Updated');

        return redirect()->route('request.clearance.account');
    }




    /**
     * show clearance request for accounts.
     *
     * @param $request Object from Request Class
     *
     * @return @blade @View
     */

    public function hr(Request $request)
    {
        $active = 'request-to-hr';

        $emoloyees = Employee::all();


        $requestCheck = $request->all();
        if (!$requestCheck) {
            $pendingList = EmployeeClosing::where('approval_status', \App\Utils\EmployeeClosing::ApprovedFrom['approval']['pending'])->get();
            $itApproval = EmployeeClosing::where('checklist_id', \App\Utils\EmployeeClosing::ApprovedFrom['status']['hr'])->get();
            $employeeClosing = $pendingList->merge($itApproval);
            return view('admin.emploeeClosing.hr', compact('active',  'emoloyees', 'employeeClosing'));
        }

        $query = EmployeeClosing::query();
        if ($request->has('employee_id')){
            $query->where('employee_id', $request->employee_id);
            $query->where('checklist_id', null);
        }

        $employeeClosing = $query->get();
        return view('admin.emploeeClosing.hr', compact('active',  'emoloyees', 'employeeClosing'));

    }


    public function hrShow($id)
    {
        $checklist = ClearanceChecklist::where('name', 'HR')->first(); // get from interface
        return view('admin.emploeeClosing.hr-show', compact('checklist', 'id'));
    }

    public function hrApproved(Request $request,  $id)
    {
        $employeeClosing = new EmployeeClosing;
        $employeeClosing->employee_id = EmployeeClosing::find($id)->employee_id;
        $employeeClosing->checklist_id = \App\Utils\EmployeeClosing::ApprovedFrom['status']['hr']; // get from interface
        $employeeClosing->approved_by = auth()->user()->employee_id;
        $employeeClosing->approval_status = $request->approval_status;
        $employeeClosing->remarks = $request->remarks;
        $employeeClosing->save();

        toastr()->success('Successful');

        return redirect()->route('request.clearance.hr');
    }


    /* ... closing approval from HR ... */
    public function userRequestToHr(Request $request)
    {
        $active = 'user-request-to-hr';

        $emoloyees = Employee::all();

        $requestCheck = $request->all();
        if (!$requestCheck) {
            $employeeClosing = ClosingApplication::where('status', EmpClosing::ApprovedFrom['teamLeadSupervisor']['team_lead_approved'])->get();
            return view('admin.employeeClosing.hr-approval', compact('active',  'emoloyees', 'employeeClosing'));
        }

        $query = ClosingApplication::query();
        if ($request->has('employee_id')){
            $query->where('employee_id', $request->employee_id);
            $query->where('status', EmpClosing::ApprovedFrom['teamLeadSupervisor']['team_lead_approved']);
        }

        $employeeClosing = $query->get();
        return view('admin.employeeClosing.hr-approval', compact('active',  'emoloyees', 'employeeClosing'));
    }

    public function userRequestToHrShow($id)
    {
        $closingApplication = ClosingApplication::find($id);
        return view('admin.employeeClosing.hr-approval-show', compact('closingApplication', 'id'));
    }

    public function userRequestToHrChangeStatus(Request $request,$id)
    {
        $status = ($request->approval_status == EmpClosing::ApprovedFrom['approval']['approved']) ?
            [
                'status' => EmpClosing::ApprovedFrom['teamLeadSupervisor']['hr_approved'],
                'hr_by' => auth()->user()->employee_id
            ] :  [
                'status' => EmpClosing::ApprovedFrom['teamLeadSupervisor']['rejected'],
                'rejected_by' => auth()->user()->employee_id
            ];

        ClosingApplication::where('id', $id)->update($status);

        if($request->approval_status == EmpClosing::ApprovedFrom['approval']['approved']){
            $this->addUserApplicationForClearance($id);
        }

        return redirect()->route('user.request.clearance.hr');
    }

    private function addUserApplicationForClearance($id)
    {
        $data = [
            'closing_applications_id' => $id
        ];

        ClosingClearanceStatus::insert($data);
        return redirect()->route('user.request.clearance.hr');
    }

    private function selectUserInChargeOrHod()
    {
        $user = auth()->user()->employee_id;

        $allUser = ClosingClearanceSetting::select('hr_hod_id', 'hr_in_charge_id', 'it_hod_id', 'it_in_charge_id', 'admin_hod_id', 'admin_in_charge_id', 'accounts_hod_id', 'accounts_in_charge_id')
            ->first()
            ->toArray();

        $selectUser = array_search($user, $allUser);
        if($selectUser){
            $arr = explode("_",$selectUser);
            foreach ($arr as $key=> $value){
                if($key <= 1){
                    $stringName[] = $value;
                }
            }
        }

        return $stringName ?? false;

    }
}
