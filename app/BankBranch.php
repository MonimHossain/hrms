<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankBranch extends Model
{

    protected $fillable = ['bank_id', 'bank_branch_name', 'bank_routing'];

    public function bankInfo()
    {
        return $this->belongsTo('App\BankInfo');
    }
}
