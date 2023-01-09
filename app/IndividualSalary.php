<?php

namespace App;

use App\Traits\Encryptable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class IndividualSalary extends Model
{

    // use Encryptable;

    protected $fillable = [
        'employee_id',
        'payment_type_id',
        'pay_cycle_id',
        'bank_info_id',
        'bank_branch_id',
        'bank_account',
        'bank_account_type',
        'type',
        'applicable_from',
        'applicable_to',
        'hourly_rate',
        'gross_salary',
        'pf',
        'pf_status',
        'tax',
        'tax_status',
        'total_deduction',
        'payable',
        'salary_status',
        'kpi_status',
        'kpi_rate',
    ];

    // protected $encryptable = [
    //     'gross_salary'
    // ];

    // protected $with = ['individualSalaryBreakdowns', 'individualOtherAllowances'];

    public function employee()
    {
        return $this->belongsTo('App\Employee');
    }

    public function bankInfo()
    {
        return $this->hasOne('App\BankInfo', 'id', 'bank_info_id');
    }

    public function bankBranch()
    {
        return $this->hasOne('App\BankBranch', 'id', 'bank_branch_id');
    }

    public function paymentType()
    {
        return $this->hasOne('App\PaymentType', 'id', 'payment_type_id');
    }

    public function payCycle()
    {
        return $this->hasOne('App\PayCycle', 'id', 'pay_cycle_id');
    }

    // public function individualSalaryBreakdowns(){
    //     return $this->belongsToMany('App\IndividualSalaryBreakdown', 'individual_salary_breakdown_pivot', 'salary_id', 'breakdown_id')->withTimestamps();
    // }

    // public function individualOtherAllowances(){
    //     return $this->belongsToMany('App\IndividualOtherAllowance', 'individual_salary_other_allowance_pivot', 'salary_id', 'allowance_id')->withTimestamps();
    // }

    public function incrementSalaryActive()
    {
        return $this->hasMany('App\IndividualSalaryIncrement', 'individual_salary_id', 'id')->where('salary_status', 1);
    }
    public function incrementSalary()
    {
        return $this->hasMany('App\IndividualSalaryIncrement', 'individual_salary_id', 'id');
    }

    public function individualSalaryBreakdowns()
    {
        return $this->hasMany('App\IndividualSalaryBreakdown', 'individual_salary_id', 'id');
    }

    public function individualOtherAllowances()
    {
        return $this->hasMany('App\IndividualOtherAllowance', 'individual_salary_id', 'id');
    }

    public function getIndividualSalaryWithIncrement()
    {
        $incrementSalary = $this->incrementSalaryActive->first();
        if ($incrementSalary) {
            $this->type = $incrementSalary->type;
            $this->applicable_from = $incrementSalary->applicable_from;
            $this->applicable_to = $incrementSalary->applicable_to;
            $this->hourly_rate = $incrementSalary->current_hourly_rate;
            $this->gross_salary = $incrementSalary->current_gross_salary;
            $this->pf = $incrementSalary->pf;
            $this->pf_status = $incrementSalary->pf_status;
            $this->tax = $incrementSalary->tax;
            $this->tax_status = $incrementSalary->tax_status;
            $this->total_deduction = $incrementSalary->total_deduction;
            $this->payable = $incrementSalary->payable;
            $this->salary_status = $incrementSalary->salary_status;
            return $this;
        }

        return $this;
    }


    public static function boot()
    {
        parent::boot();

        // static::retrieved(function ($model) {
        //     return $model->getIndividualSalaryWithIncrement();
        // });

        // static::addGlobalScope('with_increment', function (Builder $builder, Model $model) {
        //     // $builder->where('age', '>', 200);
        //     $model->getIndividualSalaryWithIncrement();
        // });
    }
}
