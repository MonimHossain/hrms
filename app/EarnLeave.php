<?php

namespace App;

use App\Traits\HasUserStamps;
use Illuminate\Database\Eloquent\Model;

class EarnLeave extends Model
{
    use HasUserStamps;
    protected $fillable = ['employee_id', 'eligible_date', 'year', 'earn_balance', 'forwarded_balance', 'total_balance', 'is_usable'];

    public function employee()
    {
        return $this->belongsTo('App\Employee');
    }
}
