<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class EmployeeEvaluationNotification extends Notification
{
    use Queueable;

    public $evaluation;
    public $title;
    public $body;
    public $route;
    public $time;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($evaluation, $title, $body, $route)
    {
        $this->evaluation = $evaluation;
        $this->title = $title;
        $this->body = $body;
        $this->route = $route;
        $this->time = Carbon::now();
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'evaluation' => $this->evaluation,
            'route' => route($this->route),
            'title' => $this->title,
            'body' => $this->body,
            'user' => auth()->user(),
            'time' => $this->time
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return BroadcastMessage
     */
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'evaluation' => $this->evaluation,
            'route' => route($this->route),
            'title' => $this->title,
            'body' => $this->body,
            'user' => auth()->user(),
            'time' => $this->time
        ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
