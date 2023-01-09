<?php

namespace App\Imports;

use App\ProvidentHistory;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Employee;
use App\Utils\Payroll;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PfHistoryImport implements ToModel , WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ProvidentHistory([
                'employee_id' => Employee::where('employer_id', $row['employee_id'])->first()->id,
                'month' => $row['month'],
                'remarks' => 'Previous amount',
                'amount' => $row['amount'],
                'status' => Payroll::PF['Generated']
        ]);
    }
}
