<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\EventNoticeFilter;

class EventNotice extends Model
{
    protected $guarded = [];


    public function eventNoticeFilter()
    {
        return $this->hasMany('App\EventNoticeFilter', 'event_notice_id', 'id');
    }


}
