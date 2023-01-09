<?php

namespace App;

use App\Traits\HasUserStamps;
use Illuminate\Database\Eloquent\Model;

class CenterDepartment extends Model
{
    use HasUserStamps;
    protected $guarded = [];

    protected $table = 'center_department';

    public function department()
    {
        return $this->belongsTo('App\Department', 'department_id', 'id');
    }



}
