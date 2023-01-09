<?php

namespace App\Http\Controllers\Admin\Employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Hierarchy;
use App\Employee;

class HierarchyController extends Controller
{


    /**
    *  @method name :
    *  @param :
    *  @return void
    *
    */

    public function employeeWiseHierarchy(){
        $allEmployee = Hierarchy::all();

        // $data = [];
        // foreach($allEmployee as $v){
        //     $data['id'][] = $v->id;
        //     $data['parent_id'][] = $v->parent_id;
        //     $data['name'][] = $v->employee->FullName;
        // }

        // dd($data);
        // dd($allEmployee);
        // $ff = [];
        $data = $allEmployee->map(function($obj){
            $obj->designation = $obj->employee->employeeJourney->designation->name;
            return $obj;
        });

        // dd($data);
        $resultData = $this->generateWorkFlowTreeData($allEmployee);
        //dd($resultData);
        $active = 'employeeHirerchy';
        return view('admin/employee/employee-wise-hierarchy', compact('active', 'resultData'));
    }


    public function generateWorkFlowTreeData($resultData) {
        $data=[];
        foreach($resultData as $row){
            $sub_data['id'] = $row->id;
            $sub_data['parent_id'] =  $row->parent_id;
            $sub_data['text'] =  $row->employee->FullName;
            $sub_data['designation'] =  $row->employee->employeeJourney->designation->name;
            $data[] = $sub_data;

            if(isset($data)){
                foreach($data as $key => &$value) {
                    $output[$value["id"]] = &$value;
                }

                foreach($data as $key => & $value) {
                    if ($value["parent_id"] && isset($output[$value["parent_id"]])) {
                        $output[$value["parent_id"]]["nodes"][] = &$value;
                    }
                }

                foreach($data as $key => & $value) {
                    if ($value["parent_id"] && isset($output[$value["parent_id"]])) {
                        unset($data[$key]);
                    }
                }

            }

        }

        return $data;
    }




    /**
    *  @method name :
    *  @param :
    *  @return void
    *
    */
    public function designationWiseHierarchy(){
        $data = new Hierarchy;
        $resultData = $data->treeGenerateByDesignation();
        $active = 'designationHirerchy';
        return view('admin/employee/designation-wise-hierarchy', compact('active', 'resultData'));
    }





    /**
    *  @method:
    *  @param :
    *  @return void
    *
    */
    public function employeeHierarchyAdd ($id)
    {
        $employees = Employee::all();
        return view('admin/employee/hierarchy/add', compact('id', 'employees'));
    }



    /**
    *  @method:
    *  @param :
    *  @return void
    *
    */
    public function employeeHierarchySave (Request $request)
    {
        $data = $request->validate([
            'employee_id' => 'required',
            'parent_id' => '',
        ]);


        if(Hierarchy::create($data)){
            toastr()->success('New Hierarchy successfully created');
        }

        return redirect()->back();
    }


}
