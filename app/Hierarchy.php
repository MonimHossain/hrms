<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Employee;

class Hierarchy extends Model
{

    protected $guarded =[];

    public function treeGenerateByEmployee()
    {
       return DB::select( DB::raw("SELECT
        h.id AS id,
        h.parent_id AS parent_id,
        h.employee_id AS employee_id,
        CONCAT( e.first_name, ' ', e.last_name ) AS emp_name
    FROM
        hierarchies h
        LEFT JOIN employees e ON h.employee_id = e.id"));
    }


    public function treeGenerateByDesignation()
    {
       return DB::select( DB::raw("SELECT
        h.id AS id,
        h.parent_id AS parent_id,
        h.employee_id AS employee_id,
        CONCAT( e.first_name, ' ', e.last_name ) AS emp_name
    FROM
        hierarchies h
        LEFT JOIN employees e ON h.employee_id = e.id"));

    }

    public function employee()
    {
        return $this->hasOne('App\Employee', 'id', 'employee_id');
    }

}
