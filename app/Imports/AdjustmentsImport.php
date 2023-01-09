<?php

namespace App\Imports;

use App\Adjustment;
use App\Employee;
use App\Utils\Payroll;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AdjustmentsImport implements ToModel, WithHeadingRow
{
    public $categoryType;
    public $type;
    public $month;
    public $employeeList = [];

    public function __construct($request)
    {
        $this->categoryType = $request->adjustment_type;
        $this->type = $request->type;
        $this->month = $request->month;
        $this->employeeList = Employee::all()->pluck('employer_id', 'id')->toArray();
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
       //$exitEmployee = in_array($row['empid'], $this->employeeList);
       $employeeId = $row['empid'];

       //if($exitEmployee){
        // $deleteStatus = Adjustment::where('employee_id', array_keys($this->employeeList, $row['employee_id'])[0])
        //             ->where('month', $this->month)
        //             ->delete();

        // if($deleteStatus){
        //     toastr()->success('Duplicate Data re-inserted');
        // }

        return new Adjustment([
            'employee_id' => null,
            'employer_id' =>  $employeeId,
            'adjustment_type' =>  $this->categoryType,
            'type' =>  $this->type,
            'amount' => (double)  $row['amount'],
            'remarks' =>  $row['remark'] ?? '',
            'adjustment_date' =>  Carbon::parse(Carbon::now())->format('Y-m-d'),
            'month' => $this->month,
            'created_by'=>auth()->user()->employee_id ?? 1,
            'updated_by'=>auth()->user()->employee_id ?? 1,
            'status' => Payroll::ADJUSTMENT['status']['Generated']
        ]);
    //    }else{
    //         toastr()->error('Unknown employer ID '.$row['empid'].'. Data is not inserted for this unknown ID');
    //    }

    }
}
