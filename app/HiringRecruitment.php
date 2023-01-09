<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HiringRecruitment extends Model
{
    protected $fillable = [
        'job_title',
        'min_salary',
        'max_salary',
        'number_of_vacancy',
        'job_requirement',
        'job_description',
        'approved_by',
        'status',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'expected_date'
    ];


    public function approvedBy(){
        return $this->hasOne('App\Employee', 'id', 'approved_by');
    }

    public function createdBy(){
        return $this->hasOne('App\Employee', 'id', 'created_by');
    }
}
