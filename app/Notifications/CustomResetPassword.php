<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomResetPassword extends Notification
{
    use Queueable;

    public $token;
    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $subject = 'Notifikasi Reset Password';
        $token = $this->token;
        $email = $notifiable->getEmailForPasswordReset();
        $reset_url = url(config('app.frontend_url') . '/auth/reset-password/' . $token . '?email=' . urlencode($email), [], false);

        return (new MailMessage)
            ->view('mail.reset-password', [
                'subject' => $subject,
                'reset_url' => $reset_url
            ])
            ->subject($subject);
    }
}
