<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PayCycle extends Model
{
    protected $fillable = ['name', 'start_date', 'end_date'];
}
