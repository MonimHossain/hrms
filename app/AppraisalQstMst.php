<?php

namespace App;

use App\Traits\HasUserStamps;
use Illuminate\Database\Eloquent\Model;

class AppraisalQstMst extends Model
{
    use HasUserStamps;
    protected $guarded = [];

    public function labels()
    {
        return $this->hasMany('App\AppraisalQstChd', 'mst_id', 'id');
    }
}
