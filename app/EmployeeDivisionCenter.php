<?php

namespace App;

use App\Traits\AddOwnershipToModel;
use App\Traits\HasUserStamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeDivisionCenter extends Model
{

    use SoftDeletes, HasUserStamps, AddOwnershipToModel;

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'employee_id',
        'division_id',
        'center_id',
        'is_main'
    ];

    public function employee(){
        return $this->belongsTo('App\Employee');
    }

    public function division()
    {
        return $this->hasOne('App\Division', 'id', 'division_id');
    }

    public function center()
    {
        return $this->hasOne('App\Center', 'id', 'center_id');
    }
}
