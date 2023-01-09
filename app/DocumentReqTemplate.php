<?php

namespace App;

use App\Traits\AddOwnershipToModel;
use Illuminate\Database\Eloquent\Model;
use App\Employee;
use App\DocSetup;

class DocumentReqTemplate extends Model
{
    use AddOwnershipToModel;

    protected $guarded = [];

    public function employee()
    {
        return $this->hasOne('App\Employee', 'employer_id', 'created_by');
    }

    public function document()
    {
        return $this->hasOne('App\DocSetup', 'id', 'type_id');
    }
}
