<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApprovalProcess extends Model
{
    protected $fillable = [
        'from_id',
        'to_id',
        'processable_id',
        'processable_type',
        'remarks',
        'status',
    ];

    public function approvalable()
    {
        return $this->morphTo();
    }


    public function toEmployee()
    {
        return $this->belongsTo('App\Employee', 'to_id');
    }

    public function fromEmployee()
    {
        return $this->belongsTo('App\Employee', 'from_id');
    }


}
