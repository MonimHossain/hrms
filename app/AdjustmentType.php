<?php

namespace App;

use App\Traits\HasUserStamps;
use Illuminate\Database\Eloquent\Model;

class AdjustmentType extends Model
{
    use HasUserStamps;
    protected $guarded = [];

    protected $hidden = ['created_at', 'updated_at'];
}
