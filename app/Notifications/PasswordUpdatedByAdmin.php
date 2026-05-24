<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordUpdatedByAdmin extends Notification
{
    use Queueable;

    public $password;

    public function __construct($password)
    {
        $this->password = $password;
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
             ->greeting('Hello ' . $notifiable->name . ',')
            ->line('The following are your new login credentials: ')
            ->line('Email: **' . $notifiable->email . '**')
            ->line('Temporary Password: **' . $this->password . '**')
            ->action('Login', url('/login'))
            ->line('Please change your password after logging in.')
            ->salutation(new \Illuminate\Support\HtmlString(
                        'Best regards,<br>Website Administrator'));
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
