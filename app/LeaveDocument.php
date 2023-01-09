<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeaveDocument extends Model
{
    protected $fillable = ['leave_id', 'file_name'];

    public function leave(){
        return $this->belongsTo('App\Leave', 'id', 'leave_id');
    }
}
