<?php

namespace App\Http\Controllers\Admin\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Workflow;
use App\Employee;
use App\Team;
use DB;
use App\Employee as AppEmployee;
use App\ProcessOrdering;
use App\User;

class WorkflowController extends Controller
{
    /**
    * @author name:
    * @method name:
    * @param:
    * @return:
    */

    public function index()
    {
        $active = 'look-up-workflow';
        $data = $this->generateWorkFlowTreeData(Workflow::all());
        return view('admin.settings.workflow.index', compact('active', 'data'));
    }

    /**
    * @author name:
    * @method name:
    * @param:
    * @return:
    */
    public function getAllProcessByWorkflowId($id)
    {
        $workflows =  Workflow::findOrFail($id)->team()->get();
        return view('admin.settings.workflow.team-list', compact('workflows'));
    }

    /**
    * @author name:
    * @method name:
    * @param:
    * @return:
    */
    public function getAddProcessToWorkflow($id)
    {
        $teams = Team::all();
        return view('admin.settings.workflow.add-team', compact('id', 'teams'));
    }

    /**
    * @author name:
    * @method name:
    * @param:
    * @return:
    */
    public function saveProcessWorkflow(Request $request)
    {
        $data = $request->except('_token');
        DB::table('team_workflow')->insert($data);
        toastr()->success('New Team successfully created');
        return redirect()->back();
    }



    /**
    * @author name:
    * @method name:
    * @param:
    * @return:
    */
    public function approvalHierarchy($workflow_id, $team_id)
    {
        $team_workflow_id = DB::table('team_workflow')->where('team_id', $team_id)->where('workflow_id', $workflow_id)->first()->id;
        $employees = User::whereNotNull('employee_id')->get();
        $exitemp = DB::select("SELECT p.emp_id, p.team_workflow_id, p.order_number, CONCAT(e.first_name, ' ', e.last_name) FullName FROM process_ordering p left join employees e ON e.id = p.emp_id where p.team_workflow_id = $team_workflow_id");
        return view('admin.settings.workflow.approval-hierarchy', compact('team_workflow_id', 'employees', 'exitemp'));
    }


    /**
    *  @method:
    *  @param :
    *  @return void
    *
    */
    public function processOrderingSave(Request $request)
    {
        $team_workflow_id = $request->input('team_workflow_id');
            //$order_number = $request->input('order_number');
            DB::table("process_ordering")->where('team_workflow_id', $team_workflow_id)->delete();
            $data = [];
            $emps = $request->input('member');
            for($i = 0; $i < count($emps); $i++){
                $data[] = [
                    'team_workflow_id' => $team_workflow_id,
                    'emp_id' => $emps[$i],
                    // 'order_number' => $order_number[$i],
                    'order_number' => $i+1,
                ];
            }
        $status = DB::table('process_ordering')->insert($data);
        if($status){
            echo $status;
        }
    }



    public function generateWorkFlowTreeData($resultData) {
        $data=[];
        foreach($resultData as $row){
            $sub_data['id'] = $row->id;
            $sub_data['parent_id'] =  $row->parent_id;
            $sub_data['text'] =  $row->name;
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



}
