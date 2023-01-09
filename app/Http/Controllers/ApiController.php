<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Department;
use App\Employee;
use App\HiringRecruitment;

class ApiController extends Controller
{
    public function departments(Request $request){
        dd(Department::all());
    }

    public function employees(Request $request){
        $employees = [];
        $data = Employee::withoutGlobalScopes()->whereHas('employeeJourney', function($q){
            $q->where('employee_status_id', 1);
        })->get();
        foreach($data as $row){

            $centerDivision =   '';
            $departments    =   '';
            $process        =   '';
            $teams        =   '';

            foreach($row->departmentProcess->unique('department_id') as $item){
                // {{ $item->department->name ?? null }}@if(!$loop->last) , @endif
                $departments = $item->department->name . "; ";
            }

            foreach($row->departmentProcess->unique('process_id') as $item) {
                if($item->process) {
                    $process .= $item->process->name .' - '. $item->processSegment->name . "; ";
                }
            }

            foreach($row->divisionCenters as $item) {
                $centerDivision .= $item->division->name .',  '.$item->center->center;
                if( !next( $row->divisionCenters ) ) {
                    $centerDivision .= '; ';
                }
            }

            // if($row->teams){
            //     foreach($row->teams as $team){
            //         $teams .= $team->name;
            //         if( !next( $row->teams ) ) {
            //             $teams .= '; ';
            //         }
            //     }
            // }

            $temp = array(
                'employee_id' => $row->employer_id,
                'name' => $row->first_name . ' ' . $row->last_name,
                'phone' => $row->pool_phone_number,
                'contact' => $row->contact_number,
                'email' => $row->email,
                'centerDivision' => $centerDivision,
                'departments' => $departments,
                'process' => $process,
                'employee_hrms_id' => $row->id,
            );
            array_push($employees, $temp);
        }
        return response()->json($employees);
    }


    public function hiringRequisition()
    {
        $data = HiringRecruitment::where('status', 1)->get();
        return response()->json($data);
    }

    public function hiringRequestViews($id)
    {
        $data = HiringRecruitment::find($id);
        return response()->json($data);
    }


}
