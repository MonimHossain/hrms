<?php

namespace App\Imports;

use App\Kpi;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class KpiImport implements ToModel, WithHeadingRow,  WithChunkReading, WithBatchInserts
{

    public $request;

    public function __construct($request){
        $this->request = $request;
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        Kpi::where('employer_id', $row['empid'])
                    ->where('monthly_date', $this->request->monthly_date)
                    ->delete();

        return new Kpi([
                'employer_id'  => $row['empid'],
                'monthly_date' => $this->request->monthly_date,
                'amount'       => (double) $row['amount'],
                'grade'        => $row['grade'],
                'r_and_r'      => $row['r_n_r'] ?? '-',
                'created_by'   => auth()->user()->employee_id ?? null,
                'created_at'   => Carbon::parse(Carbon::now())->format('Y-m-d H:i:s')
            ]);
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
