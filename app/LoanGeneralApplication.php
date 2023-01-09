<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoanGeneralApplication extends Model
{
    protected $guarded = [];

    public function referenceId()
    {
        return $this->hasOne('App\LoanApplication', 'id', 'loan_id');
    }

}
