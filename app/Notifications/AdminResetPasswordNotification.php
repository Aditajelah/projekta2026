<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminResetPasswordNotification extends Notification
{
    use Queueable;

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
            ->subject('Password Akun Anda Telah Direset Admin')
            ->greeting('Halo ' . $notifiable->username . ',')
            ->line('Password akun Anda telah direset oleh admin.')
            ->line('Jika Anda tidak meminta perubahan ini, segera hubungi admin.')
            ->line('Untuk keamanan, password baru tidak dicantumkan pada email ini.');
    }
}
