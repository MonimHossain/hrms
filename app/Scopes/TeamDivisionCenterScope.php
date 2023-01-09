<?php

namespace App\Scopes;

use App\Center;
use App\Division;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class TeamDivisionCenterScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $division = Division::where('name', session()->get('division'))->with('centers')->first();
        $center = $division->centers->where('center', session()->get('center'))->first();
        if($center && $division && session()->get('center') && session()->get('division')){
            $builder->where('center_id', $center->id)->where('division_id', $division->id);
        }
    }
}
