<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use File;
use Carbon\Carbon;

class EmployeeHours extends Model
{
    protected $table = 'employee_hours';

    protected $fillable = [
        'employee_id',
        'employer_id',
        'hour_type',
        'date',
        'ready_hour',
        'lag_hour',
        'remarks',
        'check_status',
        'created_by',
        'updated_by'
    ];

    public function employee()
    {
        return $this->belongsTo('App\Employee');
    }

    public function employer()
    {
        return $this->belongsTo('App\Employee', 'employee_id', 'employer_id');
    }

    public function createdBy()
    {
        return $this->hasOne('App\Employee', 'id', 'created_by');
    }
    public function updatedBy()
    {
        return $this->hasOne('App\Employee', 'id', 'updated_by');
    }


    public static function importToDb()
    {
        $path = File::glob(public_path().'/pending-csv-files/*.*');
        foreach(array_slice($path, 0, 1) as $file)
        {
            $data = array_map('str_getcsv', file($file));
            foreach($data as $row)
            {
                self::updateOrCreate([
                    'date'        => Carbon::parse($row[0]),
                    'employee_id' => $row[1],
                    'ready_hour'  => $row[2],
                    'lag_hour'    => $row[3],
                    'hour_type'   => 0,
                    'check_status'=> 0, 
                    'created_by'  => auth()->user()->id
                ]);
            }
        }
    }


}
