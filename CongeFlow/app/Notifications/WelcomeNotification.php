<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected string $password;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $password)
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
            ->subject('Bienvenue chez CongeFlow')
            ->greeting('Bonjour ' . $notifiable->prenom . ' ' . $notifiable->nom . ' !')
            ->line('Votre compte a été créé avec succès dans notre système de gestion.')
            ->line('Voici vos informations de connexion:')
            ->line('Email: ' . $notifiable->email)
            ->line('Mot de passe: ' . $this->password)
            ->action('Se connecter', url('/login'))
            ->line('Pour des raisons de sécurité, nous vous recommandons de changer votre mot de passe après votre première connexion.')
            ->line('Merci de faire partie de notre équipe !');
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