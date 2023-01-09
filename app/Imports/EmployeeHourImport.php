<?php

namespace App\Imports;

use App\EmployeeHours;
use App\Notifications\EmployeeHourCsvImport;
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


class EmployeeHourImport implements
        ToModel,
        WithHeadingRow,
        WithValidation,
        WithChunkReading,
        WithBatchInserts,
        ShouldQueue,
        WithEvents
{
    use Importable, RegistersEventListeners, HasUserStamps;


    public $timeout = 0;
    public $user;



    public function __construct($user)
    {
        //$this->employeeList = collect(DB::select(DB::raw("SELECT e.id, e.employer_id FROM `employees` e")))->pluck('employer_id', 'id')->toArray();
         $this->user = $user;
    }


    public function registerEvents(): array
    {
        return [
            ImportFailed::class => function(ImportFailed $event) {
                $this->user->notify(new EmployeeHourCsvImport('Employee Hour CVS', ' failed upload', 'leave.request'));
            },
        ];
    }



    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        //$exitEmployee = in_array($row['agent_id'], $this->employeeList);
        //if($exitEmployee){
            $deleteStatus = EmployeeHours::where('employer_id', $row['agent_id'])
                ->whereDate('date', Carbon::parse($row['date'])->format('Y-m-d'))
                ->where('check_status', 0)
                ->where('hour_type', 0)
                ->delete();

            return new EmployeeHours([
                'hour_type' =>  0,
                'employer_id' => $row['agent_id'],
                'date' =>  Carbon::parse($row['date'])->format('Y-m-d'),
                'ready_hour' =>  Carbon::parse($row['ready_hour'])->format('H:i:s'),
                'lag_hour' =>  Carbon::parse($row['lag_hour'])->format('H:i:s') ?? Carbon::parse(Carbon::now())->format('H:i:s'),
                'remarks' =>  $row['remarks'],
                'check_status' =>  '0',
                'created_by' => $this->user,
                'created_at' => Carbon::parse(Carbon::now())->format('Y-m-d H:i:s')
            ]);
        //}
    }

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
        return 3000;
    }

    public function batchSize(): int
    {
        return 3000;
    }


}
