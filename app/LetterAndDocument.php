<?php

namespace App;

use App\Events\LetterAndDocument\SendNotifyToEmployeeEvent;
use App\Traits\AddOwnershipToModel;
use Illuminate\Database\Eloquent\Model;

class LetterAndDocument extends Model
{
    use AddOwnershipToModel;




}
