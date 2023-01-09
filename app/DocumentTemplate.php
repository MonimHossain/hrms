<?php

namespace App;

use App\Traits\AddOwnershipToModel;
use Illuminate\Database\Eloquent\Model;
use App\Employee;
use App\DocSetup;

class DocumentTemplate extends Model
{
    use AddOwnershipToModel;

    public function employee()
    {
        return $this->hasOne('App\Employee', 'employer_id', 'user_id');
    }

    public function document()
    {
        return $this->hasOne('App\DocSetup', 'id', 'type_id');
    }
}
