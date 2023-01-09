<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    protected $fillable = [
        'employee_id',
        'training_title',
        'country',
        'topics_covered',
        'training_year',
        'institute',
        'duration',
    ];

    public function employee(){
        return $this->belongsTo('App\Employee');
    }
}
