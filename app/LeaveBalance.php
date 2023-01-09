<?php

namespace App;

use App\Traits\HasUserStamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class LeaveBalance extends Model
{
    use HasUserStamps;
    protected $fillable = [
        'employee_id',
        'year',
        'probation_start_date',
        'permanent_doj',
        'employment_type_id',
        'leave_type_id',
        'total',
        'used',
        'remain',
        'is_usable'
    ];

    public function employee(){
        return $this->belongsTo('App\Employee');
    }

//    public function employmentType(){
//        return $this->belongsTo('App\EmployeeJourney');
//    }

    public function leaveType(){
        return $this->belongsTo('App\LeaveType');
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('leaveBalanceSort', function (Builder $builder) {
            $builder->orderBy('leave_type_id', 'asc');
        });
    }
}
