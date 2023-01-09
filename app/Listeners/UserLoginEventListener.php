<?php

namespace App\Listeners;

use App\EmployeeJourney;
use App\Events\UserLoginEvent;
use App\Mail\WelcomeMail;
use App\User;
use Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserLoginEventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserLoginEvent  $event
     * @return void
     */
    public function handle(UserLoginEvent $event)
    {
        $user = new User();
        $user->employee_id = $event->employee_id;
        $user->email = $event->email;
        $user->employer_id = $event->employer_id;
        $user->password = bcrypt('Genex@123');
        $user->status = EmployeeJourney::where('employee_id', $event->employee_id)->first()->employee_status_id;
        //$user->save();

        if ($user->save()) {
            //User::find($user->id)->assignRole($request->input('role'));
            $user->assignRole('User');

            // send welcome mail to new employee
            //$mailData['name'] = $user->employeeDetails->FullName;
            //$mailData['employer_id'] = $event->employee_id;
            //$mailData['email'] = $event->email;
            //$mailData['password'] = 'Genex@123';
            //if($event->email){
            //    Mail::to($event->email)->send(new WelcomeMail($mailData));
            //}

            toastr()->success('User credentials successfully created');
        } else {
            toastr()->error('An error has occurred. Please try with correct information.');
        }
    }
}
