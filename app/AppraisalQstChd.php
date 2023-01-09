<?php

namespace App;

use App\Traits\HasUserStamps;
use Illuminate\Database\Eloquent\Model;

class AppraisalQstChd extends Model
{
    use HasUserStamps;
    protected $guarded = [];

    public function question()
    {
        return $this->hasOne('App\AppraisalQstMst', 'id', 'mst_id');
    }
}
