<?php

namespace App\Notifications;

use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CardRechargeRequestedNotification extends Notification
{
    use Queueable;

    protected Transaction $transaction;

    /**
     * Create a new notification instance.
     */
    public function __construct($transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $url = env('APP_URL') . '/#recharge-card';

        return (new MailMessage)
            ->greeting('Hello!')
            ->line('A user has requested a credit card recharge!')
            ->action('View Recharge', $url)
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'amount' => $this->transaction->amount,
            'beneficiary' => $this->transaction->beneficiary,
            'date' => $this->transaction->date,
            'description' => $this->transaction->description,
            'type' => $this->transaction->type
        ];
    }
}
