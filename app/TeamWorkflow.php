<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamWorkflow extends Model
{
    protected $table = 'team_workflow';

    public $timestamps = false;

    protected $fillable = ['team_id', 'workflow_id'];

}

