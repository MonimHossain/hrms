<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Division;
use App\AssetType;
use App\ProvidentHistory;
use App\Employee;
use App\Asset;
use App\AssetAllocation;
use App\AssetRequisition;

class UserAssetController extends Controller
{
    public function myAssets(Request $request)
    {
        $active = 'myAsset.index';
        $requestCheck = $request->all();
        $asset_types = AssetType::all();
        $status = array(
            2 => 'Allocated',
            1 => 'Active',
            0 => 'Inactive',
        );
        if (!$requestCheck) {
            $query = AssetAllocation::query();
            $history = $query->where('employee_id', auth()->user()->employee_id)->get();
            return view('admin.asset.myIndex', compact('active', 'history', 'asset_types', 'status'));
        }

        $query = AssetAllocation::query();
        if ($request->asset_type){
            $query->whereHas('Asset', function($query) use($request){
                return $query->where('type_id', $request->asset_type);
            });
        }

        if ($request->asset_id){
            $query->whereHas('Asset', function($query) use($request){
                return $query->where('asset_id', $request->asset_id);
            });
        }

        if ($request->date_from || $request->date_to){
            $query->where(function($query) use ($request){
                return $query->wherebetween('allocaiton_date', [$request->date_from,$request->date_to])
                      ->orwherebetween('return_date', [$request->date_from,$request->date_to]);
              });
        }

        $history = $query->where('employee_id', auth()->user()->employee_id)->get();
        return view('admin.asset.myIndex', compact('active', 'history', 'asset_types', 'status'));
    }

    public function myRequisition(Request $request){
        $active = 'asset.myRequisition';
        $requestCheck = $request->all();
        $asset_types = AssetType::all();
        $status = array(
            2 => 'Rejected',
            1 => 'Accepted',
            0 => 'New',
        );
        if (!$requestCheck) {
            $query = AssetRequisition::query();
            $history = $query->where('employee_id', auth()->user()->employee_id)->get();
            return view('admin.asset.myRequisition', compact('active', 'history', 'asset_types', 'status'));
        }

        $query = AssetRequisition::query();
        if ($request->asset_type){
            $query->where('asset_type_id', $request->asset_type);
        }

        if($request->employee_id){
            $employeeId = Employee::where('employer_id', $request->employee_id)->first()->id??0;
            $query->where('employee_id', $employeeId);
        }

        if ($request->date_from || $request->date_to){
            $query->where(function($query) use ($request){
                return $query->wherebetween('allocaiton_date', [$request->date_from,$request->date_to])
                      ->orwherebetween('return_date', [$request->date_from,$request->date_to]);
              });
        }

        $history = $query->where('employee_id', auth()->user()->employee_id)->get();
        return view('admin.asset.myRequisition', compact('active', 'history', 'asset_types', 'status'));
    }

    public function deleteMyRequisition(Request $request, $id){
        AssetRequisition::where('id', $request->id)->delete();
        toastr()->success('Successfully Deleted');
        return redirect()->back();
    }

    public function requisition_add()
    {
        $active = 'asset.requisition';
        $asset_types = AssetType::all();
        $flag = 'add';
        $rows = null;
        return view('admin.asset.addUserRequisition', compact('active', 'flag', 'rows', 'asset_types'));
    }

    public function requisition_edit($id)
    {
        $active = 'asset.requisition';
        $flag = 'edit';
        $rows = AssetRequisition::find($id);
        $asset_types = AssetType::all();
        return view('admin.asset.addUserRequisition', compact('active', 'flag', 'id', 'rows', 'asset_types'));
    }

    public function requisition_view($id)
    {
        $active = 'asset.requisition';
        $status = array(
            2 => 'Rejected',
            1 => 'Accepted',
            0 => 'New',
        );
        $flag = 'view';
        $rows = AssetRequisition::find($id);
        $asset_types = AssetType::all();
        return view('admin.asset.addUserRequisition', compact('active', 'flag', 'id', 'rows', 'asset_types', 'status'));
    }

    public function requisition_update(Request $request, $id)
    {
        $validatedData = $request->validate([
            "asset_type_id" => 'required',
            "due_date" => 'required',
            "specification" => 'required'
        ]);

        $asset = AssetRequisition::find($id);
        $asset->update($validatedData);
        toastr()->success('successfully Updated');
        return redirect()->route('asset.my.requisition');
    }

    public function requisition_store(Request $request)
    {
        $validatedData = $request->validate([
            "asset_type_id" => 'required',
            "due_date" => 'required',
            "specification" => 'required'
        ]);

        if($validatedData){
            $validatedData['employee_id'] = auth()->user()->employee_id;
            $validatedData['status'] = 0;
            AssetRequisition::create($validatedData);
            toastr()->success('successfully Created');
            return redirect()->route('asset.my.requisition');
        }
        return redirect()->route('asset.my.requisition');
    }
}
