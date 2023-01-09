<?php

namespace App\Imports;

use App\Attendance;
use App\Employee;
use App\Leave;
use App\Utils\LeaveStatus;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AttendanceImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    private $request, $checkAttendances, $checkLeaves, $employees;

    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return ($row);
        //return new Attendance([
        //    //
        //]);
    }

    public function headingRow(): int
    {
        return 1;
    }

    public function batchSize(): int
    {
        return 50;
    }

    public function chunkSize(): int
    {
        return 50;
    }
}
