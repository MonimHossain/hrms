<?php

namespace App;

use App\Traits\HasUserStamps;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasUserStamps;
    protected $fillable = [
        'employee_id',
        'level_of_education_id',
        'institute_id',
        'exam_degree_title',
        'major',
        'result',
        'passing_year',
    ];

    public function employee(){
        return $this->belongsTo('App\Employee');
    }

    public function institute(){
        return $this->hasOne('App\Institute', 'id', 'institute_id');
    }

    public function levelOfEducation(){
        return $this->hasOne('App\LevelOfEducation', 'id', 'level_of_education_id');
    }


}
