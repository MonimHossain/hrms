<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Employee;


class ProcessOrdering extends Model
{
    protected $fillable = ['order_number'. 'emp_id', 'team_workflow_id'];
    public $timestamps = false;

    protected $table = 'process_ordering';
    protected $primaryKey = 'team_workflow_id';

    public function employee()
    {
        return $this->hasOne('App\Employee', 'id', 'emp_id');
    }

}
