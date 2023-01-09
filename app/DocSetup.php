<?php

namespace App;

use App\Traits\AddOwnershipToModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocSetup extends Model
{
    use SoftDeletes, AddOwnershipToModel;
    protected $dates = ['deleted_at'];

    protected $guarded = [];
}
