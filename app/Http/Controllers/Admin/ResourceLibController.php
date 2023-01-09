<?php

namespace App\Http\Controllers\Admin;
use App\Adjustment;
use App\AdjustmentType;
use App\AdjustmentDefaults;
use App\Department;
use App\Division;
use App\Employee;
use App\Clearance;
use App\Process;
use App\ResourceLib;
use App\ResourceLibFilter;
use Carbon\Carbon;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ResourceLibController extends Controller
{
    public function library(Request $request){
        $active = 'resource-lib-list';
        $employees = Employee::all();
        $departments = Department::all();
        $processes = Process::all();
        $paginate = 10;

        $requestCheck = $request->all();
        if (!$requestCheck) {
            $query = ResourceLib::query();
            //$resources = $query->where('status', 1)->orderBy('created_at', 'desc')->paginate($paginate);
            $resources = [];
            return view('admin.resourceLib.library', compact('active', 'resources', 'employees', 'departments', 'processes'));
        }

        $query = ResourceLib::query();
        if ($request->employee_id){
            $query->where('employee_id', $request->employee_id);
        }

        if ($request->department){
            $query->whereHas('employeeDepartmentProcess', function ($q) use($request){
                $q->where('department_id', $request->department);
            });
        }

        if ($request->process){
            $query->whereHas('employeeDepartmentProcess', function ($q) use($request){
                $q->where('process_id', $request->process);
            });
        }

        if ($request->date_from){
            $query->whereYear('created_at', \Carbon\Carbon::parse($request->date_from)->format('Y'));
            $query->whereMonth('created_at', \Carbon\Carbon::parse($request->date_from)->format('m'));
        }
        $resources = $query->where('status', 1)->orderBy('created_at', 'desc')->paginate($paginate);
        return view('admin.resourceLib.library', compact('active', 'resources', 'employees', 'departments', 'processes'));
    }

    public function insertLibrary(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'note' => '',
            'file' => 'required|max:5000',
        ]);

        if ($validator->fails()) {
            toastr()->success('Field is required !');
            return redirect()->back();
        }
        $data = new ResourceLib;
        $data->name = $request->name;
        $data->created_at = Carbon::now();
        $data->file = $request->name.'-'.time().'.'.$request->file->extension();
        $request->file('file')->storeAs('uploads/resources', $data->file,'public');
        $data->employee_id = auth()->user()->employee_id ?? 1;
        $data->download_status = ($request->has('is_download') == "on")? 1:0;
        $data->status = 1;
        $data->save();

        if($request->targetEmployee === '2'){
            foreach ($request->dps as $row){
                $resourceLibFilter = new ResourceLibFilter;
                $resourceLibFilter->division_id  = $row['division'] ?? 0;
                $resourceLibFilter->center_id  = $row['center'] ?? 0;
                $resourceLibFilter->department_id  = $row['department'] ?? 0;
                $resourceLibFilter->process_id   = $row['process'] ?? 0;
                $resourceLibFilter->process_segment_id   = $row['processSegment'] ?? 0;
                $resourceLibFilter->resource_lib_id    = $data->id;
                $resourceLibFilter->save();
            }
        }
        toastr()->success('Successfully Uploaded');
        return redirect()->route('resource.list');
    }

    public function updateLibrary(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'id' => 'required',
            'note' => '',
        ]);

        if ($validator->fails()) {
            toastr()->success('Field is required !');
            return redirect()->back();
        }
        $data = collect($request->all());
        $data['updated_at'] = Carbon::now();
        $data['status'] = 1;
        $data['download_status'] = ($request->has('is_download') == "on")? 1:0;

        ResourceLib::where('id', $request->id)->update($data->except(['_token', 'file', 'is_download'])->toArray());
        toastr()->success('Successfully Updated');
        return redirect()->back();
    }

    public function myFiles(Request $request){
        $active = 'resource-lib-list';
        $adjustmentType = AdjustmentType::all();
        $emoloyees = Employee::all();

        /** show hide button*/
        $confirmation = (!empty(Clearance::where('module', 'adjustment')->whereYear('created_at', Carbon::parse(Carbon::now())->format('Y'))->whereMonth('created_at', Carbon::parse(Carbon::now())->format('m'))->first())) ? false : true;
        /** show hide button*/

        $requestCheck = $request->all();
        if (!$requestCheck) {
            $query = ResourceLib::query();
            $default = AdjustmentDefaults::where('module_name', 'mobile_bill')->first();
            if($default){
                $adjustments = $query->where('adjustment_type', $default->type_id)->get();
            } else {
                $adjustments = [];
            }
            return view('admin.resourceLib.library', compact('active', 'confirmation', 'adjustments', 'adjustmentType', 'emoloyees'));
        }

        $query = ResourceLib::query();
        if ($request->employee_id){
            $query->where('employee_id', $request->employee_id);
        }

        if ($request->adjustment_type){
            $query->where('adjustment_type', $request->adjustment_type);
        }

        if ($request->date_from){
            $query->whereYear('created_at', \Carbon\Carbon::parse($request->date_from)->format('Y'));
            $query->whereMonth('created_at', \Carbon\Carbon::parse($request->date_from)->format('m'));
        }
        $default = AdjustmentDefaults::where('module_name', 'mobile_bill')->first();
        if($default){
            $adjustments = $query->where('adjustment_type', $default->type_id)->get();
        } else {
            $adjustments = [];
        }
        return view('admin.resourceLib.library', compact('active', 'confirmation', 'adjustments', 'adjustmentType', 'emoloyees'));
    }

    public function addLibrary(Request $request){
        $active = 'resource-lib-list';
        $divisions = Division::all();
        return view('admin.resourceLib.add', compact('active', 'divisions'));
    }

    public function editLibrary(Request $request, $id){
        $active = 'resource-lib-list';
        $file = ResourceLib::find($id);
        return view('admin.resourceLib.edit', compact('active', 'file'));
    }

    public function trash(Request $request){
        $active = 'resource-lib-trash';
        $adjustmentType = AdjustmentType::all();
        $emoloyees = Employee::all();
        $paginate = 15;

        /** show hide button*/
        $confirmation = (!empty(Clearance::where('module', 'adjustment')->whereYear('created_at', Carbon::parse(Carbon::now())->format('Y'))->whereMonth('created_at', Carbon::parse(Carbon::now())->format('m'))->first())) ? false : true;
        /** show hide button*/

        $requestCheck = $request->all();
        if (!$requestCheck) {
            $query = ResourceLib::query();
            $adjustments = $query->where('status', 0)->paginate($paginate);
            return view('admin.resourceLib.trash', compact('active', 'confirmation', 'adjustments', 'adjustmentType', 'emoloyees'));
        }

        $query = ResourceLib::query();
        if ($request->employee_id){
            $query->where('employee_id', $request->employee_id);
        }

        if ($request->date_from){
            $query->whereYear('created_at', \Carbon\Carbon::parse($request->date_from)->format('Y'));
            $query->whereMonth('created_at', \Carbon\Carbon::parse($request->date_from)->format('m'));
        }
        $adjustments = $query->where('status', 0)->paginate($paginate);
        return view('admin.resourceLib.trash', compact('active', 'confirmation', 'adjustments', 'adjustmentType', 'emoloyees'));
    }

    public function trashLibrary(Request $request, $id){
        $active = 'resource-lib-trash';
        $var = array(
            'status' => 0
        );
        ResourceLib::where('id', $id)->update($var);
        toastr()->success('Successfully Moved into trash');
        return redirect()->back();
    }

    public function restoreLibrary(Request $request, $id){
        $active = 'resource-lib-list';
        $var = array(
            'status' => 1
        );
        ResourceLib::where('id', $id)->update($var);
        toastr()->success('Successfully restored');
        return redirect()->back();
    }

    public function deleteLibrary(Request $request, $id){
        $fileInfo = ResourceLib::find($id);
        $path = public_path()."/storage/uploads/resources/". $fileInfo->file;
        if(file_exists($path)){
            unlink($path);
        }
        ResourceLib::where('id', $id)->delete();
        toastr()->success('Successfully Deleted');
        return redirect()->back();
    }
}
