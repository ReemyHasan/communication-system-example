<?php

namespace App\Notifications;

use App\Models\PhoneNumber;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\InteractsWithQueue;

class SendTwoFactorCode extends Notification implements ShouldQueue
{
    use InteractsWithQueue, Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public PhoneNumber $phone_number)
    {
        //
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
            ->line("Your two-factor code for the phone number {$this->phone_number->phone_number} is {$this->phone_number->two_factor_code}")
            ->action('Verify Here', 'http://127.0.0.1:8000/api/v1/verify')
            ->line('The code will expire in 10 minutes')
            ->line('If you didn\'t request this, please ignore.');
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
