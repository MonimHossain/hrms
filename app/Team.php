<?php
namespace App;

use App\Scopes\TeamDivisionCenterScope;
use App\Traits\AddOwnershipToModel;
use App\Utils\TeamMemberType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Department;
use App\Process;

class Team extends Model
{
    use AddOwnershipToModel;
    use SoftDeletes;

    //protected $guarded = [];
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name',
        'team_lead_id',
        'division_id',
        'center_id',
        'department_id',
        'process_id',
        'process_segment_id',
        'parent_id',
        'is_functional',
    ];

    public function employees ()
    {
        return $this->belongsToMany('App\Employee')->withPivot('member_type', 'created_by', 'updated_by')->withTimestamps();
    }

    public function employeeMember ()
    {
        return $this->belongsToMany('App\Employee')->wherePivot('member_type', TeamMemberType::MEMBER);
    }

//    public function teamleadEmployee()
//    {
//        return $this->hasOne('App\Employee', 'id', 'team_lead_id');
//    }
//
   public function supOneEmployee()
   {
       return $this->hasOne('App\Employee', 'id', 'reporting_to_id_one');
   }
//
//    public function supTwoEmployee()
//    {
//        return $this->hasOne('App\Employee', 'id', 'reporting_to_id_two');
//    }
//
//    public function supThreeEmployee()
//    {
//        return $this->hasOne('App\Employee', 'id', 'reporting_to_id_three');
//    }
//
//    public function demaprtmentName()
//    {
//        return $this->hasOne('App\Department', 'id', 'demaprtment');
//    }
//
//    public function processName()
//    {
//        return $this->hasOne('App\Process', 'id', 'process');
//    }

    public function teamLead()
    {
        return $this->hasOne('App\Employee', 'id', 'team_lead_id');
    }

    public function division()
    {
        return $this->hasOne('App\Division', 'id', 'division_id');
    }
    public function center()
    {
        return $this->hasOne('App\Center', 'id', 'center_id');
    }
    public function department()
    {
        return $this->hasOne('App\Department', 'id', 'department_id');
    }

    public function process()
    {
        return $this->hasOne('App\Process', 'id', 'process_id');
    }

    public function processSegment()
    {
        return $this->hasOne('App\ProcessSegment', 'id', 'process_segment_id');
    }

    public function leaveRule()
    {
        return $this->hasOne('App\LeaveRule', 'team_id', 'id');
    }

    public function createdBy()
    {
        return $this->hasOne('App\Employee', 'id', 'created_by');
    }

    public function updatedBy()
    {
        return $this->hasOne('App\Employee', 'id', 'updated_by');
    }

    public function children(){
        return $this->hasMany( 'App\Team', 'parent_id', 'id' );
    }

    public function parent(){
        return $this->belongsTo( 'App\Team', 'parent_id', 'id' );
    }

    public function getRootParent()
    {
        if ($this->parent)
            return $this->parent->getRootParent();

        return $this;
    }

    public function leader()
    {
        return $this->belongsTo('App\Employee', 'team_lead_id', 'id');
    }



    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new TeamDivisionCenterScope());
    }

    public function evaluations()
    {
        return $this->hasMany( 'App\EmployeeEvaluationListMst', 'team_id', 'id' );
    }

    public function teamEvaluation()
    {
        return $this->hasMany( 'App\TeamEvaluationStatus', 'team_id', 'id' );
    }

}
