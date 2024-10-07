<?php

namespace App\Notifications;

use App\Models\Admin;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Transaction;

class MoneyTransferRequestedNotification extends Notification
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
        $url = env('APP_URL') . '/#money-transfer';

        if ($notifiable instanceof Admin) {
            return (new MailMessage)
            ->greeting('Hello!')
            ->line('A user has requested a money transfer operation!')
            ->action('View Money Transfer Request', $url)
            ->line('Thank you for using our application!');
        }

        return (new MailMessage)
            ->greeting("Hey  $notifiable->first_name!")
            ->line('Your money transfer operation is been treated.')
            ->line('You will receive a confirmation email once we\'re done.')
            ->line('Meanwhile you can stay posted on your request status with the button below.')
            ->action('View Money Transfer Request', $url)
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
            'title' => $this->transaction->title,
            'type' => $this->transaction->type
        ];
    }
}