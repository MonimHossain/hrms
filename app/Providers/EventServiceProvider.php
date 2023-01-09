<?php

namespace App\Providers;

use App\Events\LetterAndDocument\SendNotifyToEmployeeEvent;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
//        Registered::class => [
//            SendEmailVerificationNotification::class,
//        ],

        'App\Events\LeaveApplyEvent' => [
            'App\Listeners\LeaveApplyEventListener',
        ],
        'App\Events\UserLoginEvent' => [
            'App\Listeners\UserLoginEventListener',
        ],
        'App\Events\EmployeeFixedOfficeTimeEvent' => [
            'App\Listeners\EmployeeFixedOfficeTimeEventListener',
        ],
        'App\Events\LetterAndDocument\SendNotifyToEmployeeEvent' => [
            'App\Listeners\LetterAndDocument\DocumentCreateListener',
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
