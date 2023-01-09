<?php

namespace App;

use App\Traits\HasUserStamps;
use Illuminate\Database\Eloquent\Model;

class AppraisalKpiPercentage extends Model
{
    use HasUserStamps;
    protected $guarded = [];
}
