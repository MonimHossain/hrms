<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalaryBreakdownSetting extends Model
{
    protected $fillable = [
        'name',
        'percentage',
        'is_basic'
    ];
}
