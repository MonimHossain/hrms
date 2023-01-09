<?php

namespace App;

use App\Scopes\DivisionCenterScope;
use App\Scopes\ActiveEmployeeScope;
use App\Traits\AddOwnershipToModel;
use App\Traits\HasUserStamps;
use App\Traits\CasecadeSoftDelete;
use App\Utils\TeamMemberType;
use Illuminate\Database\Eloquent\Model;
use App\Team;
use App\EmployeeTeam;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Traits\LogsActivity;

class Employee extends Model
{

    use  SoftDeletes, HasUserStamps, AddOwnershipToModel, LogsActivity;

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'blood_group_id',
        'login_id',
        'employer_id',
        'first_name',
        'last_name',
        'email',
        'personal_email',
        //'center_id',
        'nearby_location_id',
        'gender',
        'date_of_birth',
        'religion',
        'ssc_reg_num',
        'father_name',
        'mother_name',
        'present_address',
        'permanent_address',
        'contact_number',
        'alt_contact_number',
        'pool_phone_number',
        'emergency_contact_person',
        'emergency_contact_person_number',
        'relation_with_employee',
        //'bank_name',
        //'bank_branch',
        //'bank_account',
        //'bank_routing',
        'nid',
        'passport',
        'marital_status',
        'spouse_name',
        'spouse_dob',
        'child1_name',
        'child1_dob',
        'child2_name',
        'child2_dob',
        'child3_name',
        'child3_dob'
    ];

    //protected $casts = [
    //    'employer_id' => 'integer'
    //];

    // activity logging
    protected static $logName = 'Employee';
    protected static $logAttributes = [
        'login_id',
        'employer_id',
        'first_name',
        'last_name',
        'email'
    ];
    protected static $logOnlyDirty = true;
    public function getDescriptionForEvent(string $eventName): string
    {
        return "This model/data has been {$eventName}";
    }


    // Dip
    // eloquent model relations

    public function userDetails()
    {
        return $this->hasOne('App\User', 'employee_id', 'id');
    }

    public function bloodGroup()
    {
        return $this->hasOne(BloodGroup::class, 'id', 'blood_group_id');
    }

    //public function center(){
    //    return $this->hasOne('App\Center', 'id', 'center_id');
    //}

    public function divisionCenters()
    {
        return $this->hasMany('App\EmployeeDivisionCenter', 'employee_id', 'id');
    }

    public function nearbyLocation()
    {
        return $this->hasOne('App\NearbyLocation', 'id', 'nearby_location_id');
    }

    public function educations()
    {
        return $this->hasMany('App\Education', 'employee_id', 'id');
    }

    public function trainings()
    {
        return $this->hasMany('App\Training', 'employee_id', 'id');
    }

    public function employeeJourney()
    {
        return $this->hasOne('App\EmployeeJourney', 'employee_id', 'id');
    }

    public function employeeJourneyArchive()
    {
        return $this->hasMany('App\EmployeeJourneyArchive', 'employee_id', 'id');
    }

    public function departmentProcess()
    {
        return $this->hasMany('App\EmployeeDepartmentProcess', 'employee_id', 'id');
    }

    //public function supervisor1(){
    //    return $this->belongsTo('App\EmployeeJourney', 'sup1');
    //}
    //public function supervisor2(){
    //    return $this->belongsTo('App\EmployeeJourney', 'sup2');
    //}
    //public function headOfDepartment(){
    //    return $this->belongsTo('App\EmployeeJourney', 'hod');
    //}


    // public function userDetails(){
    //     return $this->belongsTo('App\User', 'id');
    // }

    public function leaves()
    {
        return $this->hasMany('App\Leave', 'employee_id', 'id');
    }

    public function leaveBalances()
    {
        return $this->hasMany('App\LeaveBalance', 'employee_id', 'id');
    }

    public function earnLeaves()
    {
        return $this->hasMany('App\EarnLeave', 'employee_id', 'id');
    }

    public function attendances()
    {
        return $this->hasMany('App\Attendance', 'employee_id', 'id');
    }

    public function attendanceChangeRequests()
    {
        return $this->hasMany('App\AttendanceChangeRequest', 'employee_id', 'id');
    }

    public function rosterRequests()
    {
        return $this->hasMany('App\RosterRequest', 'employee_id', 'id');
    }

    public function rosterChangeRequests()
    {
        return $this->hasMany('App\RosterChangeRequest', 'employee_id', 'id');
    }


    public function team()
    {
        return $this->belongsToMany('App\Team', 'team_workflow', 'id', 'team_id');
    }



    public function teams()
    {
        return $this->belongsToMany(Team::class);
    }




    public function teamMember()
    {
        return $this->belongsToMany(Team::class)->withPivot('member_type', 'created_by', 'updated_by')->withTimestamps();
    }

    public function teamLeadCheck()
    {
        return $this->hasMany('App\Team', 'team_lead_id', 'id');
    }

    public function processOrdering()
    {
        return $this->hasMany('App\ProcessOrdering', 'emp_id');
    }

    public function processOrderingDemo()
    {
        return $this->belongsTo('App\ProcessOrdering', 'emp_id');
    }

    public function toApprovalProcess()
    {
        return $this->hasMany('App\ApprovalProcess', 'to_id', 'id');
    }

    public function fromApprovalProcess()
    {
        return $this->hasMany('App\ApprovalProcess', 'from_id', 'id');
    }

    public function employeeTeam()
    {
        return $this->hasMany('App\EmployeeTeam', 'employee_id', 'id');
    }

    public function teamCheck()
    {
        return $this->hasOne('App\Team', 'team_lead_id', 'id');
    }

    public function employeeDepartmentProcess()
    {
        return $this->hasMany('App\EmployeeDepartmentProcess', 'employee_id', 'id');
    }

    public function fixedOfficeTime()
    {
        return $this->hasMany('App\EmployeeFixedOfficeTime', 'employee_id', 'id');
    }


    // salary

    public function individualSalaryBreakdown()
    {
        return $this->hasMany('App\IndividualSalaryBreakdown', 'employee_id', 'id');
    }

    public function kpi()
    {
        return $this->hasOne('App\Kpi', 'employee_id', 'id');
    }

    public function adjustment()
    {
        return $this->hasMany('App\Adjustment', 'employee_id', 'id');
    }

    public function otherAllowances()
    {
        return $this->hasMany('App\IndividualOtherAllowance', 'employee_id', 'id');
    }

    public function employeeHour()
    {
        return $this->hasMany('App\EmployeeHours', 'employee_id', 'id');
    }

    public function attendanceSummary()
    {
        return $this->hasMany('App\EmployeeAttendanceSummary', 'employee_id', 'id');
    }

    public function individualSalary()
    {
        return $this->hasOne('App\IndividualSalary', 'employee_id', 'id');
    }
    public function individualSalaryIncrement()
    {
        return $this->hasMany('App\IndividualSalaryIncrement', 'employee_id', 'id');
    }

    public function individualOtherAllowances()
    {
        return $this->hasMany('App\IndividualOtherAllowance', 'employee_id', 'id');
    }

    // employee closing
    public function closingApplication()
    {
        return $this->hasMany('App\ClosingApplication', 'employee_id', 'id');
    }

    public function providentFund()
    {
        return $this->hasMany('App\ProvidentHistory', 'employee_id', 'id');
    }

    public function tax()
    {
        return $this->hasMany('App\TaxHistory', 'employee_id', 'id');
    }

    public function evaluationListMst()
    {
        return $this->belongsTo('App\EmployeeEvaluationListMst', 'employee_id', 'id');
    }

    public function evaluationList()
    {
        return $this->belongsTo('App\EmployeeEvaluationListMst', 'id', 'employee_id');
    }

    public function yearlyAppraisalList()
    {
        return $this->hasMany('App\YearlyAppraisalMst', 'employee_id', 'id');
    }

    public function employeeEvaluationListMst()
    {
        return $this->hasOne('App\EmployeeEvaluationListMst', 'employee_id', 'id');
    }



    // accessors
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }


    /**
     * Scope a query to only include male users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeMale($query)
    {
        return $query->where('gender', 'Male');
    }

    /**
     * Scope a query to only include female users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFemale($query)
    {
        return $query->where('gender', 'Female');
    }


    /**
     * Scope a query to only include active users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->whereHas('employeeJourney', function ($q) {
            $q->where('employee_status_id', 1);
        });
    }

    /**
     * Scope a query to only include inactive users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInactive($query)
    {
        return $query->whereHas('employeeJourney', function ($q) {
            $q->where('employee_status_id', 2);
        });
    }

    /**
     * Scope a query to only include suspended users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSuspended($query)
    {
        return $query->whereHas('employeeJourney', function ($q) {
            $q->where('employee_status_id', 3);
        });
    }

    /**
     * Scope a query to only without inactive and suspended users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithoutInactiveSuspended($query)
    {
        return $query->withoutGlobalScope(ActiveEmployeeScope::class)->whereHas('employeeJourney', function ($q) {
            $q->where('employee_status_id', '!=', 2)->where('employee_status_id', '!=', 3);
        });
    }

    /**
     * Scope a query to only inactive and suspended users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInactiveSuspended($query)
    {
        return $query->withoutGlobalScope(ActiveEmployeeScope::class)->whereHas('employeeJourney', function ($q) {
            $q->where('employee_status_id', '!=', 1);
        });
    }

    /**
     * Scope a query to department employee.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDepartment($query, $department_id = null, $process_id = null, $processSegment_id = null)
    {
        return $query->withoutGlobalScope(DivisionCenterScope::class)->whereHas('departmentProcess', function ($q) use($department_id, $process_id, $processSegment_id) {
            $q->when($department_id, function($q) use($department_id) {
                $q->where('department_id', $department_id);
            })->when($process_id, function($q) use($process_id) {
                $q->where('process_id', $process_id);
            })->when($processSegment_id, function($q) use($processSegment_id) {
                $q->where('process_segment_id', $processSegment_id);
            });
        });
    }

    /**
     * Scope a query to division center employee.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDivisionCenter($query, $division_id, $center_id)
    {
        return $query->withoutGlobalScope(DivisionCenterScope::class)->whereHas('divisionCenters', function ($q) use($division_id, $center_id) {
            return $q->where('is_main', 1)->where('division_id', $division_id)->where('center_id', $center_id);
        });
    }

    /**
     * Scope a query to only without inactive and Dhaka center users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDhakaCenter($query)
    {
        return $query->withoutGlobalScope(DivisionCenterScope::class)->whereHas('divisionCenters', function ($q) {
            return $q->where('is_main', 1)->whereHas('center', function ($q2) {
                return $q2->where('center', 'Dhaka');
            });
        });
    }

    /**
     * Scope a query to only without inactive and Dhaka center users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCtgCenter($query)
    {
        return $query->withoutGlobalScope(DivisionCenterScope::class)->whereHas('divisionCenters', function ($q) {
            return $q->where('is_main', 1)->whereHas('center', function ($q2) {
                return $q2->where('center', 'Chattagram');
            });
        });
    }


    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        //if (session()->get('division'))
        static::addGlobalScope(new DivisionCenterScope(session()->get('division'), session()->get('center')));
        static::addGlobalScope(new ActiveEmployeeScope());

        //soft delete
        static::deleting(function($users) {
            //delete employee Journey
            foreach ($users->employeeJourney()->get() as $employeeJourney) {
               $employeeJourney->delete();
            }

            // delete Employee Journey Archive
            /* foreach ($users->employeeJourneyArchive()->get() as $employeeJourney) {
                $employeeJourney->delete();
             } */
         });
    }
}
