<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeNotification extends Notification implements ShouldQueue
{
    use Queueable;
    
    protected $password;

    /**
     * Create a new notification instance.
     */
    public function __construct($password)
    {
        $this->password = $password;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Bienvenue sur CongeFlow - Vos identifiants de connexion')
                    ->greeting('Bonjour ' . $notifiable->prenom . ' ' . $notifiable->nom . ',')
                    ->line('Bienvenue sur CongeFlow, votre nouvel outil de gestion des congés.')
                    ->line('Un compte a été créé pour vous. Voici vos identifiants de connexion:')
                    ->line('Email: ' . $notifiable->email)
                    ->line('Mot de passe: ' . $this->password)
                    ->action('Se connecter', url('/login'))
                    ->line('Nous vous recommandons de changer votre mot de passe lors de votre première connexion.')
                    ->line('Merci d\'utiliser notre application !');
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
            'message' => 'Bienvenue sur CongeFlow !',
        ];
    }
} 