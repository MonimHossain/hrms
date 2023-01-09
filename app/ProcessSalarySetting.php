<?php

namespace App;

use App\Traits\AddOwnershipToModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ProcessSalarySetting extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $guarded = [];


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

    public function employmentType()
    {
        return $this->hasOne('App\EmploymentType', 'id', 'employment_type_id');
    }
}
