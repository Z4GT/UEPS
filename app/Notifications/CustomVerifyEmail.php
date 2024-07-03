<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Auth\Notifications\VerifyEmail as VerifyEmailNotification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomVerifyEmail extends VerifyEmailNotification
{
    protected function verificationUrl($notifiable)
    {
        return url(route('verification.verify', [
            'id' => $notifiable->getKey(),
            'hash' => sha1($notifiable->getEmailForVerification()),
        ], false));
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Verifica tu Dirección de Correo Electrónico')
            ->greeting('¡Hola!')
            ->line('Gracias por registrarte en nuestra aplicación. Por favor, haz clic en el botón de abajo para verificar tu dirección de correo electrónico.')
            ->action('Verificar Correo Electrónico', $this->verificationUrl($notifiable))
            ->line('Si no creaste una cuenta, no es necesario realizar ninguna acción adicional.')
            ->line('Gracias por usar nuestra aplicación!')
            ->salutation('Saludos, UEPS');
    }
}
