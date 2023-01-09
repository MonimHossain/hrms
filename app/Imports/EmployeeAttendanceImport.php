<?php

namespace App\Imports;

use App\Employee;
use App\EmployeeAttendance;
use App\Traits\HasUserStamps;
use DB;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Events\ImportFailed;
use Maatwebsite\Excel\Validators\Failure;

class EmployeeAttendanceImport implements
    ToModel,
    WithHeadingRow,
    WithValidation,
    WithChunkReading,
    WithBatchInserts,
    ShouldQueue,
    WithEvents
{

    use Importable, RegistersEventListeners, HasUserStamps;


    // public $startDate;
    // public $endDate;
    public $employeeList = [];
    public $attendanceType = [];


    public $timeout = 0;
    public $user;



    public function __construct($user)
    {
        $this->user = $user;
        // $this->startDate = $request->startDate;
        // $this->endDate = $request->endDate;
        /*
         * $this->employeeList = collect(DB::select(DB::raw("SELECT e.id, e.employer_id FROM `employees` e")))->pluck('employer_id', 'id')->toArray();
        $this->attendanceType =  array(
            \App\Utils\AttendanceStatus::CASUAL_LEAVE => 'CL',
            \App\Utils\AttendanceStatus::SICK_LEAVE => 'SL',
            \App\Utils\AttendanceStatus::EARNED_LEAVE => 'EL',
            \App\Utils\AttendanceStatus::MATERNITY_LEAVE => 'ML',
            \App\Utils\AttendanceStatus::PATERNITY_LEAVE => 'PL',
            \App\Utils\AttendanceStatus::LEAVE_WITHOUT_PAY => 'LWP',
            \App\Utils\AttendanceStatus::PRESENT => 'P',
            \App\Utils\AttendanceStatus::WITHOUT_ROSTER => 'WR',
            \App\Utils\AttendanceStatus::HOLIDAY => 'HD',
            \App\Utils\AttendanceStatus::DAYOFF => 'DO',
            \App\Utils\AttendanceStatus::ADJUSTED_DAY_OFF => 'ADO',
            \App\Utils\AttendanceStatus::LATE => 'L',
            \App\Utils\AttendanceStatus::EARLY_LEAVE => 'EL',
            \App\Utils\AttendanceStatus::ANNUAL_LEAVE => 'AL',
            \App\Utils\AttendanceStatus::CASUAL_LEAVE_HALF => 'CLH',
            \App\Utils\AttendanceStatus::ANNUAL_LEAVE_HALF => 'ALH',
            \App\Utils\AttendanceStatus::OUT_OF_OFFICE => 'OOF',
            \App\Utils\AttendanceStatus::HALF_DAY => 'HD'
        );
        */
    }



    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $employeeId = preg_replace('/\s+/', '', $row['empid']);
        $status = preg_replace('/\s+/', '', $row['attendance_status']);
        //$exitEmployee = in_array($employeeId, $this->employeeList);

        //if($exitEmployee){
            /*$clearanceStatus = EmployeeAttendance::where('employer_id', $employeeId)
                ->whereDate('date', Carbon::parse($row['date'])->format('Y-m-d'))
                ->where('check_status', 1)->first();*/
            //if(!$clearanceStatus){

                $deleteStatus = EmployeeAttendance::where('employer_id', $employeeId)
                    ->whereDate('date', Carbon::parse($row['date'])->format('Y-m-d'))
                    ->delete();

                // if($deleteStatus){
                //     toastr()->success('Duplicate Data re-inserted');
                // }

                return new EmployeeAttendance([
                    'employer_id' =>  $employeeId,
                    'date' =>  Carbon::parse($row['date'])->format('Y-m-d'),
                    'status' =>  $status,
                    'created_by' => $this->user ?? null,
                    'created_at' => Carbon::parse(Carbon::now())->format('Y-m-d H:i:s')
                ]);
            //}
            // else{
            //     toastr()->error('Clearance Data !');
            // }
        // }else{
        //     toastr()->error('Unknown employer ID '.$employeeId.'. Data is not inserted for this unknown ID');
        // }
    }

    //public function sheets(): array
    //{
    //    return [
    //        0 => new FirstSheetImport()
    //    ];
    //}

    public function rules(): array
    {
        return [];
    }

    public function headingRow(): int
    {
        return 1;
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function batchSize(): int
    {
        return 1000;
    }
}
