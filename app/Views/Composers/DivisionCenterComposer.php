<?php

namespace App\Views\Composers;

use App\Center;
use App\Division;
use Illuminate\View\View;

class DivisionCenterComposer
{
    public function compose(View $view)
    {
        $this->composeDivisionCenter($view);
    }

    public function composeDivisionCenter(View $view)
    {
        if(session()->exists('division') && session()->exists('center') && session()->get('validateRole') != 'User'){
            $divisions = Division::with('centers')->get();
            $activeDivision = $divisions->filter(function($item){
                return $item->name == session()->exists('division');
            })->first();
            $centers = ($activeDivision) ? $activeDivision->centers : null;
        }else{
            $divisions = [];
            $centers = [];
        }

        $view->with(compact('divisions', 'centers'));
    }


}
