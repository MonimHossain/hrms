<?php

namespace App\Http\Controllers\Admin\Asset;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Division;
use App\AssetType;
use App\ProvidentHistory;
use App\Employee;
use App\Asset;
use App\AssetAllocation;
use App\AssetRequisition;

class AssetController extends Controller
{
    /**
     ** @Function name : index function
     *  @Param :
     *  @return void list of all look up
     *
     */

    public function types ()
    {
        $active = 'add.new.type';
        $assets = AssetType::all();
        return view('admin.asset.type', compact('active','assets'));
    }


    /**
     ** @Function name :
     *  @Param :
     *  @return void
     *
     */

    public function typeCreate(Request $request){
        $assets = $request->validate([
            'name' => 'required',
            'details' => 'required',
            'status' => 'required',
        ]);


        if(AssetType::create($assets)){
            toastr()->success('New type successfully created');
        }

        return redirect()->back();
    }


    /**
     ** @Function name :
     *  @Param :
     *  @return void
     *
     */

    public function typeEdit (Request $request, $id)
    {
        if(empty($request->input('fld_id'))){
            $active = 'add.new.type';
            $assets = AssetType::all();
            $asset = AssetType::findOrFail($id);
            return view('admin.asset.type-edit', compact('active', 'assets', 'asset'));
        }else{
            $division = AssetType::find($id);
            $division->name = $request->input('name');
            $division->details = $request->input('details');
            if($division->save()){
                toastr()->success('Type successfully updated');
            }

            return redirect()->route('add.new.type');
        }

    }


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
            $history = $query->where('employee_id', auth()->user()->id)->get();
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

        $history = $query->where('employee_id', auth()->user()->id)->get();
        return view('admin.asset.myIndex', compact('active', 'history', 'asset_types', 'status'));
    }

    public function index(Request $request)
    {
        $active = 'asset.index';
        $requestCheck = $request->all();
        $asset_types = AssetType::all();
        $status = array(
            2 => 'Allocated',
            1 => 'Active',
            0 => 'Inactive',
        );
        if (!$requestCheck) {
            $query = Asset::query();
            $history = $query->get();
            return view('admin.asset.index', compact('active', 'history', 'asset_types', 'status'));
        }

        $query = Asset::query();
        if ($request->asset_type){
            $query->where('type_id', $request->asset_type);
        }

        if ($request->asset_id){
            $query->where('asset_id', $request->asset_id);
        }

        $history = $query->get();
        return view('admin.asset.index', compact('active', 'history', 'asset_types', 'status'));
    }

    public function add()
    {
        $active = 'asset.index';
        $asset_types = AssetType::all();
        $flag = 'add';
        $rows = null;
        return view('admin.asset.add', compact('active', 'flag', 'rows', 'asset_types'));
    }

    public function edit($id)
    {
        $active = 'asset.index';
        $flag = 'edit';
        $rows = Asset::find($id);
        $asset_types = AssetType::all();
        return view('admin.asset.add', compact('active', 'flag', 'id', 'rows', 'asset_types'));
    }

    public function view($id)
    {
        $active = 'asset.index';
        $status = array(
            2 => 'Allocated',
            1 => 'Active',
            0 => 'Inactive',
        );
        $flag = 'view';
        $rows = Asset::find($id);
        $asset_types = AssetType::all();
        return view('admin.asset.add', compact('active', 'flag', 'id', 'rows', 'asset_types', 'status'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'asset_id' => 'required',
            'details' => 'required',
            'type_id' => 'required',
            'price' => 'required|numeric',
            'status' => 'required|numeric',
        ]);

        $asset = Asset::find($id);
        $asset->update($validatedData);
        toastr()->success('successfully Updated');
        return redirect()->route('asset.index');
    }

    public function setting()
    {
        $active = 'payroll.provident.fund.setting';
        $query = ProvidentFundSetting::find(1);
        $settings = optional($query)->first();
        return view('admin.asset.setting', compact('active', 'settings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'asset_id' => 'required',
            'details' => 'required',
            'type_id' => 'required',
            'price' => 'required|numeric',
            'status' => 'required|numeric',
        ]);
        Asset::create($validatedData);
        toastr()->success('successfully Created');
        return redirect()->route('asset.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function settingUpdate(Request $request, $id)
    {
        $validatedData = Validator::make($request->all(), [
                'amount' => 'required|numeric',
        ]);
        if ($validatedData->fails()) {
            return redirect()
                ->route('payroll.provident.fund.setting');
        }

        ProvidentFundSetting::updateOrCreate(
            ['id' => $id],
            ['amount' => $request->amount]
        );

        toastr()->success('successfully Updated');
        return redirect()->route('payroll.provident.fund.setting');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function allocaiton(Request $request){
        $active = 'asset.allocaiton';
        $requestCheck = $request->all();
        $asset_types = AssetType::all();
        $status = array(
            2 => 'Allocated',
            1 => 'Active',
            0 => 'Inactive',
        );
        if (!$requestCheck) {
            $query = AssetAllocation::query();
            $history = $query->get();
            return view('admin.asset.allocation', compact('active', 'history', 'asset_types', 'status'));
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

        $history = $query->get();
        return view('admin.asset.allocation', compact('active', 'history', 'asset_types', 'status'));
    }

    public function allocation_add()
    {
        $active = 'asset.allocaiton';
        $asset_types = AssetType::all();
        $flag = 'add';
        $rows = null;
        return view('admin.asset.addAllocation', compact('active', 'flag', 'rows', 'asset_types'));
    }

    public function allocation_edit($id)
    {
        $active = 'asset.allocaiton';
        $flag = 'edit';
        $rows = AssetAllocation::find($id);
        $asset_types = AssetType::all();
        return view('admin.asset.addAllocation', compact('active', 'flag', 'id', 'rows', 'asset_types'));
    }

    public function allocation_view($id)
    {
        $active = 'asset.allocaiton';
        $status = array(
            2 => 'Allocated',
            1 => 'Active',
            0 => 'Inactive',
        );
        $flag = 'view';
        $rows = AssetAllocation::find($id);
        $asset_types = AssetType::all();
        return view('admin.asset.addAllocation', compact('active', 'flag', 'id', 'rows', 'asset_types', 'status'));
    }

    public function allocation_update(Request $request, $id)
    {
        $validatedData = $request->validate([
            "allocation_note" => '',
            "return_date" => '',
            "return_note" => '',
            "is_damaged" => 'required',
            "damage_amount" => '',
        ]);

        $asset = AssetAllocation::find($id);
        $asset->update($validatedData);
        toastr()->success('successfully Updated');
        return redirect()->route('asset.allocaiton');
    }

    public function allocation_store(Request $request)
    {
        $validatedData = $request->validate([
            "asset_id" => 'required',
            "employee_id" => 'required',
            "allocaiton_date" => 'required',
            "allocation_note" => '',
            "return_date" => '',
            "return_note" => '',
            "is_damaged" => 'required',
            "damage_amount" => '',
        ]);

        $employeeId = Employee::where('employer_id', $request->employee_id)->first()->id??0;
        $assetId = Asset::where('asset_id', $request->asset_id)->where('status', '1')->first()->id??0;

        if($employeeId && $assetId){
            $validatedData['employee_id'] = $employeeId;
            $validatedData['asset_id'] = $assetId;
            $validatedData['allocated_by'] = auth()->user()->id;
            AssetAllocation::create($validatedData);
            Asset::where('asset_id', $request->asset_id)->update(['status'=>2]);
            toastr()->success('successfully Created');
            return redirect()->route('asset.allocaiton');
        }
        if(!$employeeId){
            toastr()->success('Employee not exist!');
        } else if($assetId){
            toastr()->success('Asset not exist!');
        } else {
            toastr()->success('Asset and Employee not exist!');
        }
        return redirect()->route('asset.allocaiton');
    }

    public function requisition(Request $request){
        $active = 'asset.requisition';
        $requestCheck = $request->all();
        $asset_types = AssetType::all();
        $status = array(
            2 => 'Rejected',
            1 => 'Accepted',
            0 => 'New',
        );
        if (!$requestCheck) {
            $query = AssetRequisition::query();
            $history = $query->get();
            return view('admin.asset.requisition', compact('active', 'history', 'asset_types', 'status'));
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

        $history = $query->get();
        return view('admin.asset.requisition', compact('active', 'history', 'asset_types', 'status'));
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
            $history = $query->where('employee_id', auth()->user()->id)->get();
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

        $history = $query->where('employee_id', auth()->user()->id)->get();
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
        return view('admin.asset.addRequisition', compact('active', 'flag', 'rows', 'asset_types'));
    }

    public function requisition_edit($id)
    {
        $active = 'asset.requisition';
        $flag = 'edit';
        $rows = AssetRequisition::find($id);
        $asset_types = AssetType::all();
        return view('admin.asset.addRequisition', compact('active', 'flag', 'id', 'rows', 'asset_types'));
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
        return view('admin.asset.addRequisition', compact('active', 'flag', 'id', 'rows', 'asset_types', 'status'));
    }

    public function requisition_update(Request $request, $id)
    {
        $validatedData = $request->validate([
            "status" => 'required',
        ]);

        $asset = AssetRequisition::find($id);
        $asset->update($validatedData);
        toastr()->success('successfully Updated');
        return redirect()->route('asset.requisition');
    }

    public function requisition_store(Request $request)
    {
        $validatedData = $request->validate([
            "asset_type_id" => 'required',
            "due_date" => 'required',
            "specification" => 'required'
        ]);

        if($validatedData){
            $validatedData['employee_id'] = auth()->user()->id;
            $validatedData['status'] = 0;
            AssetRequisition::create($validatedData);
            toastr()->success('successfully Created');
            return redirect()->route('asset.my.requisition');
        }
        return redirect()->route('asset.my.requisition');
    }
}
