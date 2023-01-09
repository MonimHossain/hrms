<?php

namespace App\Jobs;

use DB;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CsvAttendenceUploadJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $updateData;
    public $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($updateData, $data)
    {
        $this->updateData = $updateData;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        DB::table('attendances')
        ->where('employee_id', $this->data['ac_no'])
        ->where('date', date("Y-m-d", strtotime($this->data['date'])))
        ->where('status', '!=', 4)
        ->update($this->updateData);
    }
}
