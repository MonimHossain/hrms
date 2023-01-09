<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use DB;

class CsvScheduleRosterUpdate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $data;
    public $date;
    public $employerId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($a, $b, $c)
    {
        $this->data = $a;
        $this->date = $b;
        $this->employerId = $c;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        DB::table('attendances')->where('date', $this->date)->where('employee_id', $this->employerId)->update($this->data);
    }
}
