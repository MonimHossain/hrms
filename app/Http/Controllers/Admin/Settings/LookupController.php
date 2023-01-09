<?php

namespace App\Http\Controllers\Admin\Settings;

use App\CenterDepartment;
use App\DepartmentProcess;
use App\Division;
use App\Employee;
use Etc\ManagePermission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Department;
use App\Designation;
use App\Process;
use App\ProcessSegment;
use App\EmployeeStatus;
use App\Center;
use App\Roster;
use App\SetLeave;
use App\DocSetup;
use App\Institute;
use App\Holiday;
use App\LeaveReason;
use App\NearbyLocation;

class LookupController extends Controller
{

    /**
    ** @Function name : Constructor Function
    *  @Param :
    *  @return void
    *
    */

    public function __constructor ()
    {
        $this->middleware('auth');
    }

    /**
     ** @Function name : index function
     *  @Param :
     *  @return void list of all look up
     *
     */

    public function division ()
    {
        $active = 'look-up-division';
        $divisions = Division::all();
        return view('admin.settings.lookup.division', compact('active','divisions'));
    }


    /**
     ** @Function name :
     *  @Param :
     *  @return void
     *
     */

    public function divisionCreate(Request $request){
        $divisions = $request->validate([
            'name' => 'required',
            'full_name' => 'required',
        ]);


        if(Division::create($divisions)){
            toastr()->success('New Division successfully created');
        }

        return redirect()->back();
    }


    /**
     ** @Function name :
     *  @Param :
     *  @return void
     *
     */

    public function divisionEdit (Request $request, $id)
    {
        if(empty($request->input('fld_id'))){
            $active = 'look-up-division';
            $divisions = Division::all();
            $division = Division::findOrFail($id);
            return view('admin.settings.lookup.division-edit', compact('active', 'division', 'divisions'));
        }else{
            $division = Division::find($id);
            $division->name = $request->input('name');
            $division->full_name = $request->input('full_name');
            if($division->save()){
                toastr()->success('Division successfully updated');
            }

            return redirect()->route('settings.manage.division');

        }

    }



    /**
    ** @Function name : index function
    *  @Param :
    *  @return void list of all look up
    *
    */

    public function department ()
    {
        $active = 'look-up-department';
        $departments = Department::all();
        $employees = Employee::all();
        return view('admin.settings.lookup.department', compact('active','departments', 'employees'));
    }


    /**
    ** @Function name :
    *  @Param :
    *  @return void
    *
    */

    public function departmentCreate(Request $request){
        $departments = $request->validate([
            'name' => 'required',
            'own_hod_id' => 'required',
            'own_in_charge_id' => 'required',
        ]);


        if(Department::create($departments)){
            toastr()->success('New Department successfully created');
        }

        return redirect()->back();
    }


    /**
    ** @Function name :
    *  @Param :
    *  @return void
    *
    */

    public function departmentEdit (Request $request, $id)
    {
        if(empty($request->input('fld_id'))){
            $active = 'look-up-department';
            $departments = Department::all();
            $department = Department::findOrFail($id);
            $employees = Employee::all();
            return view('admin.settings.lookup.department-edit', compact('active', 'department', 'departments', 'employees'));
        }else{
            $department = Department::find($id);
            $department->name = $request->input('name');
            $department->own_hod_id = $request->input('own_hod_id');
            $department->own_in_charge_id = $request->input('own_in_charge_id');
            if($department->save()){
                toastr()->success('Department successfully updated');
            }

            return redirect()->route('settings.manage.department');

        }

    }


    /**
    ** @Function name :
    *  @Param :
    *  @return void
    *
    */

    public function designation ()
    {
        $active = 'look-up-designation';
        $designations = Designation::all();
        return view('admin/settings/lookup/designation', compact('active','designations'));
    }



    /**
    ** @Function name :
    *  @Param :
    *  @return void
    *
    */

    public function designationCreate(Request $request){
        $designations = $request->validate([
            'name' => 'required',
        ]);


        if(Designation::create($designations)){
            toastr()->success('New Dasignation successfully created');
        }

        return redirect()->back();
    }





    /**
    ** @Function name :
    *  @Param :
    *  @return void
    *
    */

    public function designationEdit (Request $request, $id)
    {
        if(empty($request->input('fld_id'))){
            $active = 'look-up-setup';
            $designations = Designation::all();
            $designation = Designation::findOrFail($id);
            return view('admin/settings/lookup/designation-edit', compact('active', 'designation', 'designations'));
        }else{
            $designation = Designation::find($id);
            $designation->name = $request->input('name');
            if($designation->save()){
                toastr()->success('Designation successfully updated');
            }

            return redirect()->route('settings.manage.designation');

        }

    }





    /**
    ** @Function name :
    *  @Param :
    *  @return void
    *
    */

    public function process()
    {
        $active = 'look-up-process';
        $departments = Department::all();
        $processes = Process::all();
        return view('admin.settings.lookup.process', compact('active','processes', 'departments'));
    }




    /**
    ** @Function name :
    *  @Param :
    *  @return void
    *
    */

    public function processCreate(Request $request){
        $processes = $request->validate([
            'name' => 'required',
        ]);


        if(Process::create($processes)){
            toastr()->success('New Process successfully created');
        }

        return redirect()->back();
    }



    /**
    ** @Function name :
    *  @Param :
    *  @return void
    *
    */

    public function processEdit (Request $request, $id)
    {
        if(empty($request->input('fld_id'))){
            $active = 'look-up-process';
            $departments = Department::all();
            $processes = Process::all();
            $process = Process::findOrFail($id);
            return view('admin/settings/lookup/process-edit', compact('active', 'process', 'processes', 'departments'));
        }else{
            $processes = $request->validate([
                'name' => 'required',
            ]);
            $process = Process::find($id);
            $process->name = $request->input('name');
            if($process->save()){
                toastr()->success('Process successfully updated');
            }
            return redirect()->route('settings.manage.process');

        }

    }




    /**
    ** @Function name :
    *  @Param :
    *  @return void
    *
    */

    public function processSegment()
    {

        $active = 'look-up-process-segment';
        $processSegments = ProcessSegment::all();
        $processes = Process::all();
        return view('admin/settings/lookup/process-segment', compact('active','processSegments', 'processes'));
    }




    /**
    ** @Function name :
    *  @Param :
    *  @return void
    *
    */

    public function processSegmentCreate(Request $request){
        $data = $request->validate([
            'process_id' => 'required',
            'name' => 'required',
        ]);


        if(ProcessSegment::create($data)){
            toastr()->success('New Process segment successfully created');
        }
        return redirect()->back();
    }





    /**
    ** @Function name :
    *  @Param :
    *  @return void
    *
    */

    public function processSegmentEdit (Request $request, $id)
    {
        if(empty($request->input('fld_id'))){
            $active = 'look-up-process-segment';
            $processSegments = ProcessSegment::all();
            $processesList = Process::all();
            $process = ProcessSegment::findOrFail($id);
            return view('admin.settings.lookup.process-segment-edit', compact('active', 'process', 'processesList', 'processSegments'));
        }else{
            $process = ProcessSegment::find($id);
            $process->process_id = $request->input('process_id');
            $process->name = $request->input('name');
            if($process->save()){
                toastr()->success('Process successfully updated');
            }

            return redirect()->route('settings.manage.process.segment');

        }

    }


    public function leaveReason()
    {
        $active = 'look-up-leave-reason';
        $leaveReasons = LeaveReason::all();
        return view('admin.settings.lookup.leave-reason', compact('active', 'leaveReasons'));
    }

    public function leaveReasonCreate(Request $request){
        $data = $request->validate([
            'leave_reason' => 'required',
        ]);


        if(LeaveReason::create($data)){
            toastr()->success('New leave reason successfully added.');
        }
        return redirect()->back();
    }

    public function leaveReasonEdit (Request $request, $id)
    {
        if(empty($request->input('fld_id'))){
            $active = 'look-up-leave-reason';
            $leaveReasons = LeaveReason::all();
            $leaveReason = LeaveReason::findOrFail($id);
            return view('admin.settings.lookup.leave-reason-edit', compact('active', 'leaveReasons', 'leaveReason'));
        }else{
            $leaveReason = LeaveReason::find($id);
            $leaveReason->leave_reason = $request->input('leave_reason');
            if($leaveReason->save()){
                toastr()->success('Leave reason successfully updated');
            }
            return redirect()->route('settings.manage.leave.reason');

        }

    }





    /**
    ** @Function name :
    *  @Param :
    *  @return void
    *
    */

    public function status()
    {
        $active = 'look-up-status';
        $employeeStatas = EmployeeStatus::all();
        return view('admin.settings.lookup.status', compact('active','employeeStatas'));
    }





    /**
    ** @Function name :
    *  @Param :
    *  @return void
    *
    */

    public function statusCreate(Request $request){
        $data = $request->validate([
            'status' => 'required',
        ]);


        if(EmployeeStatus::create($data)){
            toastr()->success('New Process segment successfully created');
        }

        return redirect()->back();
    }



    /**
    ** @Function name :
    *  @Param :
    *  @return void
    *
    */

    public function statusEdit (Request $request, $id)
    {
        if(empty($request->input('fld_id'))){
            $active = 'look-up-setup';
            $employeeStatases = EmployeeStatus::all();
            $employeeStatas = EmployeeStatus::findOrFail($id);
            return view('admin.settings.lookup.status-edit', compact('active', 'employeeStatases', 'employeeStatas'));
        }else{
            $employeeStatas = EmployeeStatus::find($id);
            $employeeStatas->status = $request->input('status');
            if($employeeStatas->save()){
                toastr()->success('Employee Status successfully updated');
            }

            return redirect()->route('settings.manage.employee.status');

        }

    }



    /**
    *  @method:
    *  @param :
    *  @return void
    *
    */

    public function center ()
    {
        $active = 'look-up-center';
        $centers = Center::all();
        $divisions = Division::all();
        return view('admin.settings.lookup.center', compact('active','centers', 'divisions'));
    }


    /**
    *  @method:
    *  @param :
    *  @return void
    *
    */
    public function centerCreate (Request $request)
    {
        $data = $request->validate([
            'division_id' => 'required',
            'center' => 'required',
            'name' => 'required',
        ]);

        $divisions = Division::all();

        $division = Division::find($request->input('division_id'));
        //$permission = new ManagePermission($division->name, $request->input('center'));
        //$permission->generatePermission();
        if(Center::create($data)){
            foreach ($divisions as $division){
                foreach ($division->centers as $center){
                    $permission = new ManagePermission($division->name, $center->center);
                    $permission->generatePermission();
                }
            }
            toastr()->success('New Center successfully created');
        }

        return redirect()->back();
    }

    /**
    *  @method:
    *  @param :
    *  @return void
    *
    */
    public function centerEdit (Request $request, $id)
    {

        if(empty($request->input('fld_id'))){
            $active = 'look-up-center';
            $divisions = Division::all();
            $centers = Center::all();
            $center = Center::findOrFail($id);
            return view('admin.settings.lookup.center-edit', compact('active', 'centers', 'center', 'divisions'));
        }else{
            $request->validate([
                'division_id' => 'required',
                'center' => 'required',
                'name' => 'required',
            ]);
            $center = Center::find($id);
            $center->division_id = $request->input('division_id');
            $center->center = $request->input('center');
            $center->name = $request->input('name');
            if($center->save()){
                toastr()->success('Center successfully updated');
            }
            return redirect()->route('settings.manage.center');
        }
    }


    public function addDepartmentToCenter($id)
    {
        $departments = Department::all();
        $selectDepartment = CenterDepartment::where('center_id', $id)->pluck('department_id')->toArray();
        return view('admin.settings.lookup.center-department', compact('departments', 'selectDepartment', 'id'));

    }

    public function updateDepartmentToCenter(Request $request, $id)
    {
        $center = Center::find($id);
        $center->departments()->sync($request->department);
        toastr()->success('Successfully updated');
        return redirect()->route('settings.manage.center');
    }

    public function addDepartmentToProcess($id)
    {
        $departments = Department::all();
        $selectDepartment = DepartmentProcess::where('process_id', $id)->pluck('department_id')->toArray();
        return view('admin.settings.lookup.department-process', compact('departments', 'selectDepartment', 'id'));

    }

    public function updateDepartmentToProcess(Request $request, $id)
    {
        $process = Process::find($id);
        $process->department()->sync($request->department);
        toastr()->success('Successfully center updated');
        return redirect()->route('settings.manage.process');
    }


    ///
    /**
     *  @method:
     *  @param :
     *  @return void
     *
     */

    public function setupDoc ()
    {
        $active = 'look-up-doc';
        $documents = DocSetup::all();
        return view('admin.settings.lookup.doc', compact('active','documents'));
    }


    /**
     *  @method:
     *  @param :
     *  @return void
     *
     */
    public function docCreate (Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'prefix' => '',
            'permission' => 'required',
        ]);


        if(DocSetup::create($data)){
            toastr()->success('New Document successfully created');
        }

        return redirect()->back();
    }

    /**
     *  @method:
     *  @param :
     *  @return void
     *
     */
    public function docEdit (Request $request, $id)
    {
        if(empty($request->input('fld_id'))){
            $active = 'look-up-doc';
            $documents = DocSetup::all();
            $document = DocSetup::findOrFail($id);
            return view('admin.settings.lookup.doc-edit', compact('active', 'documents', 'document'));
        }else{
            $document = DocSetup::find($id);
            $document->name = $request->input('name');
            $document->prefix = $request->input('prefix');
            $document->permission = $request->input('permission');
            if($document->save()){
                toastr()->success('Document successfully updated');
            }
            return redirect()->route('settings.manage.document');
        }
    }
    ///


    /**
    *  @method:
    *  @param :
    *  @return void
    *
    */

    public function roster ()
    {
        $active = 'look-up-roster';
        $rosters = Roster::all();
        return view('admin.settings.lookup.roster', compact('active','rosters'));
    }


    /**
    *  @method:
    *  @param :
    *  @return void
    *
    */
    public function rosterCreate (Request $request)
    {
        $data = [
           'title' => $request->input('title'),
           'roster_start' => $request->input('start_time'),
           'roster_end' => $request->input('end_time')
        ];



        if(Roster::create($data)){
            toastr()->success('New Roster successfully created');
        }

        return redirect()->back();
    }


    /**
    *  @method:
    *  @param :
    *  @return void
    *
    */
    public function rosterEdit (Request $request, $id)
    {
        if(empty($request->input('fld_id'))){
            $active = 'look-up-setup';
            $rosters = Roster::all();
            $roster = Roster::findOrFail($id);
            return view('admin.settings.lookup.roster-edit', compact('active', 'rosters', 'roster'));
        }else{
            $roster = Roster::find($id);
            $roster->title = $request->input('title');
            $roster->roster_start = $request->input('start_time');
            $roster->roster_end = $request->input('end_time');
            if($roster->save()){
                toastr()->success('Roster successfully updated');
            }
            return redirect()->route('settings.manage.roster');
        }
    }


    /**
    *  @method:
    *  @param :
    *  @return void
    *
    */
    public function leave ()
    {
        $active = 'look-up-leave';
        $leaves = SetLeave::all();
        return view('admin.settings.lookup.leave', compact('active','leaves'));
    }


    /**
    *  @method:
    *  @param :
    *  @return void
    *
    */
    public function leaveCreate (Request $request)
    {
        // dd($data);
        $setleave = new SetLeave;
        $setleave->name = $request->input('name');
        $setleave->hourly_quantity = $request->input('hourly_quantity');
        $setleave->contractual_quantity = $request->input('contractual_quantity');
        $setleave->parmanent_quantity = $request->input('parmanent_quantity');


        if($setleave->save()){
            toastr()->success('New Leave successfully created');
        }

        return redirect()->back();
    }


    /**
    *  @method:
    *  @param :
    *  @return void
    *
    */
    public function leaveEdit (Request $request, $id)
    {
        if(empty($request->input('fld_id'))){
            $active = 'look-up-leave';
            $leaves = SetLeave::all();
            $leave = SetLeave::findOrFail($id);
            return view('admin.settings.lookup.leave-edit', compact('active', 'leaves', 'leave'));
        }else{
            $leave = SetLeave::find($id);
            $leave->hourly_quantity = $request->input('hourly_quantity');
            $leave->contractual_quantity = $request->input('contractual_quantity');
            $leave->parmanent_quantity = $request->input('parmanent_quantity');
            $leave->probation_quantity = $request->input('probation_quantity');
            if($leave->save()){
                toastr()->success('Leave successfully updated');
            }
            return redirect()->route('settings.manage.set.leave');
        }
    }

    public function lookupSetupDelete($id, $model, $redirect, $getRouteId = null)
    {
        //if (!empty($getRouteId) ){
        //    $redirect = $redirect .','. ' ["id" =>'. $getRouteId.']';
        //}
        //dd($redirect);
        //$redirect = redirect()->back();
        if($model == 'Department'){
            $modelName = 'App\\EmployeeDepartmentProcess';
            $recordCount = $modelName::where('department_id', $id)->count();
            if($recordCount > 0){
                toastr()->error('Can not delete department, It has ' .$recordCount.' dependencies');
                return redirect()->route($redirect);
                //return redirect()->route('employee.profile');
            }
        } else if($model == 'Designation'){
            $modelName = 'App\\EmployeeJourney';
            $recordCount = $modelName::where('designation_id', $id)->count();
            if($recordCount > 0){
                toastr()->error('Can not delete desinnation, It has ' .$recordCount.' dependencies');
                return redirect()->route($redirect);
            }
        } else if($model == 'ProcessSegment'){
            $modelName = 'App\\EmployeeJourney';
            $recordCount = $modelName::where('process_segment_id', $id)->count();
            if($recordCount > 0){
                toastr()->error('Can not delete process segment, It has ' .$recordCount.' dependencies');
                return redirect()->route($redirect);
            }
        } else if($model == 'EmployeeStatus'){
            $modelName = 'App\\EmployeeJourney';
            $recordCount = $modelName::where('employee_status_id', $id)->count();
            if($recordCount > 0){
                toastr()->error('Can not delete employee status, It has ' .$recordCount.' dependencies');
                return redirect()->route($redirect);
            }
        } else if($model == 'Process'){
            $modelName = 'App\\EmployeeDepartmentProcess';
            $processSegment = 'App\\ProcessSegment';
            $recordCount = $modelName::where('process_id', $id)->count();
            $recordCountTwo = $processSegment::where('process_id', $id)->count();
            if($recordCount > 0){
                toastr()->error('Can not delete process, It has ' .$recordCount.' dependencies');
                return redirect()->route($redirect);
            } else if ( $recordCountTwo > 0 ) {
                toastr()->error('Can not delete process, It has ' .$recordCountTwo.' dependencies');
                return redirect()->route($redirect);
            }
        }
        $modelName = 'App\\'.$model;
        $modelName::find($id)->delete();
        toastr()->success('Entry successfully deleted');
        if (is_null($getRouteId)){
            return redirect()->route($redirect);
        }else{
            return redirect()->route($redirect, ['id' => $getRouteId]);
        }
    }

    /**
    *  @method:
    *  @param :
    *  @return void
    *
    */

    public function institute ()
    {
        $active = 'look-up-institute';
        $institutes = institute::all();
        return view('admin.settings.lookup.institute', compact('active','institutes'));
    }


    /**
    *  @method:
    *  @param :
    *  @return void
    *
    */
    public function instituteCreate (Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
        ]);

        if(institute::create($data)){
            toastr()->success('New institute successfully created');
        }

        return redirect()->back();
    }

    /**
    *  @method:
    *  @param :
    *  @return void
    *
    */
    public function instituteEdit (Request $request, $id)
    {
        if(empty($request->input('fld_id'))){
            $active = 'look-up-institute';
            $institutes = institute::all();
            $institute = institute::findOrFail($id);
            return view('admin.settings.lookup.institute-edit', compact('active', 'institutes', 'institute'));
        }else{
            $institute = institute::find($id);
            $institute->name = $request->input('name');
            if($institute->save()){
                toastr()->success('institute successfully updated');
            }
            return redirect()->route('settings.manage.institutes');
        }
    }

    /**
    *  @method:
    *  @param :
    *  @return void
    *
    */

    public function holiday ()
    {
        $active = 'look-up-holiday';
        $divisions = Division::with('centers')->get();
        $holidays = holiday::with(['centers' => function($q){
                        return $q->orderBy('division_id', 'asc');
                    }, 'centers.division'])->get();

        $religions = Employee::withoutGlobalScopes()->whereNotNull('religion')->groupBy('religion')->pluck('religion');

        // example fetch query
        //$test = Holiday::whereJsonContains('religion->religion', ['Islam', 'Hinduism'])->get()->dd();

        return view('admin.settings.lookup.holiday', compact('active','holidays', 'divisions', 'religions'));
    }

    public function holidayCenterChecked(Request $request){
        $data = $request->validate([
            'holiday_id' => 'required',
        ]);
        $holiday_id = $request->get('holiday_id');
        $divisions = Division::with('centers')->get();
        $activeHoliday = Holiday::whereId($request->get('holiday_id'))->with('centers')->first();

        return view('admin.settings.lookup.holiday-center-modal', compact('holiday_id', 'divisions', 'activeHoliday'));
    }


    /**
    *  @method:
    *  @param :
    *  @return void
    *
    */
    public function holidayCreate (Request $request)
    {
        //$data = $request->validate([
        //    'title' => 'required',
        //    'start_date' => 'required',
        //    'end_date' => 'required',
        //    'description' => '',
        //    'religion' => 'required',
        //]);
        $validator = \Validator::make( $request->all(),[
            'title' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'description' => '',
            'religion' => 'required',
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $message) {
                toastr()->error($message, '', ['extendedTimeOut' => 0, 'timeOut' => 0]);
            }
            return redirect()->back()->withInput();
        }
        $data = $request->all();
        $data['religion'] = json_encode(array(
            'religion' => $request->input('religion')
        ));

        if(holiday::create($data)){
            toastr()->success('New holiday successfully created');
        }

        return redirect()->back();
    }

    /**
    *  @method:
    *  @param :
    *  @return void
    *
    */
    public function holidayEdit (Request $request, $id)
    {
        if(empty($request->input('fld_id'))){
            $active = 'look-up-holiday';
            $holiday = Holiday::findOrFail($id);
            $divisions = Division::with('centers')->get();
            $holidays = holiday::with(['centers' => function ($q) {
                            return $q->orderBy('division_id', 'asc');
                        }, 'centers.division'])->get();
            $centers = Center::where('division_id', $holiday->division_id)->get();
            $religions = Employee::withoutGlobalScopes()->whereNotNull('religion')->groupBy('religion')->pluck('religion');

            return view('admin.settings.lookup.holiday-edit', compact('active', 'holidays', 'holiday', 'divisions', 'centers', 'religions'));
        }else{

            $validator = \Validator::make( $request->all(),[
                'title' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
                'description' => '',
                'religion' => 'required',
            ]);
            if ($validator->fails()) {
                foreach ($validator->errors()->all() as $message) {
                    toastr()->error($message, '', ['extendedTimeOut' => 0, 'timeOut' => 0]);
                }
                return redirect()->back()->withInput();
            }

            $holiday = Holiday::find($id);
            $holiday->title = $request->input('title');
            $holiday->start_date = $request->input('start_date');
            $holiday->end_date = $request->input('end_date');
            $holiday->description = $request->input('description');
            $holiday->religion = json_encode(array(
                'religion' => $request->input('religion')
            ));
            if($holiday->save()){
                toastr()->success('Holiday successfully updated');
            }
            return redirect()->route('settings.manage.holidays');
        }
    }

    public function holidayCenterCreate(Request $request){
        $holiday = Holiday::find($request->get('holiday_id'));
        $holiday->centers()->detach();
        if($request->has('center_id')){
            foreach($request->get('center_id') as $key => $item){
                $holiday->centers()->attach([$item => ['division_id' => $request->get('division_id')[$key]]]);
            }
        }
        toastr()->success('Holiday successfully assigned to the centers.');
        return redirect()->back();
    }

    /**
    *  @method:
    *  @param :
    *  @return void
    *
    */

    public function nearbyLocation ()
    {
        $active = 'look-up-nearbyLocation';
        $nearbyLocations = nearbyLocation::orderby('center_id', 'asc')->paginate(20);
        //dd($nearbyLocations);
        $centers = center::all();
        return view('admin.settings.lookup.nearbyLocation', compact('active','nearbyLocations', 'centers'));
    }


    /**
    *  @method:
    *  @param :
    *  @return void
    *
    */
    public function nearbyLocationCreate (Request $request)
    {
        // dd($request->all());
        $data = $request->validate([
            'center_id' => 'required',
            'nearby' => 'required'
        ]);

        if(nearbyLocation::create($data)){
            toastr()->success('New nearby location successfully created');
        }

        return redirect()->back();
    }

    /**
    *  @method:
    *  @param :
    *  @return void
    *
    */
    public function nearbyLocationEdit (Request $request, $id)
    {
        if(empty($request->input('fld_id'))){
            $active = 'look-up-nearbyLocation';
            $nearbyLocations = nearbyLocation::all();
            $nearbyLocation = nearbyLocation::findOrFail($id);
            $centers = center::all();
            return view('admin.settings.lookup.nearbyLocation-edit', compact('active', 'nearbyLocations', 'nearbyLocation', 'centers'));
        }else{
            $nearbyLocation = nearbyLocation::find($id);
            $nearbyLocation->center_id = $request->input('center_id');
            $nearbyLocation->nearby = $request->input('nearby');
            if($nearbyLocation->save()){
                toastr()->success('Nearby Location successfully updated');
            }
            return redirect()->route('settings.manage.nearbyLocations');
        }
    }


}
