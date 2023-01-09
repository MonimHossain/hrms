<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class YearlyLeaveUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'leaveBalanceUpdate:anual';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Annyally leave balance update';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
    }
}
