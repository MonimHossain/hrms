<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportBroadcast extends Model
{
    

    public function employee()
    {
        return $this->hasOne('App\Employee', 'id', 'created_by');
    }
}
