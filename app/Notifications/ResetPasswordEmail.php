<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordEmail extends Notification
{
    use Queueable;
    public $name;
    public $email;
    public $otp;

    /**
     * Create a new notification instance.
     */
    public function __construct($name, $email, $otp)
    {
        $this->name = $name;
        $this->email = $email;
        $this->otp = $otp;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                ->subject(trans('msg.email.reset-password.subject'))
                ->greeting(trans('msg.email.reset-password.greeting', ['name' => $this->name]))
                ->line(trans('msg.email.reset-password.message'))
                ->line(trans('msg.email.reset-password.otp', ['otp' => $this->otp]))
                ->line(trans('msg.email.reset-password.keep_secure'))
                ->action(trans('msg.email.reset-password.login'), route('/'))
                ->line(trans('msg.email.reset-password.thank_you'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
