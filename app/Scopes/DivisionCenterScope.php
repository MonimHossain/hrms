<?php

namespace App\Scopes;

use App\Center;
use App\Division;
use App\Employee;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class DivisionCenterScope implements Scope
{
    protected $division, $center;

    public function __construct($division, $center)
    {
        $this->division = $division;
        $this->center = $center;
    }
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        //if(session()->get('center') && session()->get('division')){
            $division = Division::where('name', ($this->division) ? $this->division : session()->get('division'))->with('centers')->first();
            $center = $division->centers->where('center', ($this->center) ? $this->center : session()->get('center'))->first();
            if($center && $division && session()->get('center') && session()->get('division')){
                $builder->whereHas('divisionCenters', function ($q) use ($center, $division) {
                    $q->where('center_id', $center->id)->where('division_id', $division->id);
                });
            }
        //}
    }
}
