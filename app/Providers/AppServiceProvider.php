<?php

namespace App\Providers;

use App\EarnLeave;
use App\Employee;
use App\Mail\NoticeEventMail;
use App\Observers\EarnLeaveObserver;
use App\Observers\EmployeeObserver;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use DB;
use Log;
use App\Jobs\NoticeEventMailSenderJob;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Support\Facades\Queue;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;
use Illuminate\Support\Facades\Log as FacadesLog;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        DB::listen(function($query) {
            Log::info(
                $query->sql,
                $query->bindings,
                $query->time
            );
        });

        // observer
        Employee::observe(EmployeeObserver::class);
        EarnLeave::observe(EarnLeaveObserver::class);

        /**
         * Log jobs
         *
         * Job failed
         */
        Queue::failing(function (JobFailed $event) {
            FacadesLog::error('Job failed: ' . $event->job->resolveName() . '(' . $event->exception->getMessage() . ')');
            // $logFile = 'laravel-queue-error.log';

            // FacadesLog::useDailyFiles(storage_path() . '/logs/' . $logFile);
        });
    }
}
