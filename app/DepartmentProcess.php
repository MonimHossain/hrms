<?php

namespace App;

use App\Traits\HasUserStamps;
use Illuminate\Database\Eloquent\Model;

class DepartmentProcess extends Model
{
    use HasUserStamps;
    protected $guarded = [];

    protected $table = 'department_process';
}
