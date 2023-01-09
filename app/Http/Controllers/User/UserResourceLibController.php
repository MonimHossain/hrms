<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Adjustment;
use App\AdjustmentType;
use App\AdjustmentDefaults;
use App\Employee;
use App\Clearance;
use App\ResourceLib;
use Carbon\Carbon;

class UserResourceLibController extends Controller
{
    public function library(Request $request){
        $active = 'resource-lib-list';
        $adjustmentType = AdjustmentType::all();
        $emoloyees = Employee::all();
        $paginate = 15;

        /** show hide button*/
        $confirmation = (!empty(Clearance::where('module', 'adjustment')->whereYear('created_at', Carbon::parse(Carbon::now())->format('Y'))->whereMonth('created_at', Carbon::parse(Carbon::now())->format('m'))->first())) ? false : true;
        /** show hide button*/

        $requestCheck = $request->all();
        if (!$requestCheck) {
            $query = ResourceLib::query();
            $adjustments = $query->where('status', 1)->paginate($paginate);
            return view('user.resourceLib.library', compact('active', 'confirmation', 'adjustments', 'adjustmentType', 'emoloyees'));
        }

        $query = ResourceLib::query();
        if ($request->employee_id){
            $query->where('employee_id', $request->employee_id);
        }

        if ($request->date_from){
            $query->whereYear('created_at', \Carbon\Carbon::parse($request->date_from)->format('Y'));
            $query->whereMonth('created_at', \Carbon\Carbon::parse($request->date_from)->format('m'));
        }
        $adjustments = $query->where('status', 1)->paginate($paginate);
        return view('user.resourceLib.library', compact('active', 'confirmation', 'adjustments', 'adjustmentType', 'emoloyees'));
    }
}
