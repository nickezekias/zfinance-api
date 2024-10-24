<?php

namespace App\Notifications;

use App\Models\CreditCardRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CreditCardPurchaseRequestedNotification extends Notification
{
    use Queueable;

    protected $credit_card_request;

    /**
     * Create a new notification instance.
     */
    public function __construct(CreditCardRequest $credit_card_request)
    {
        $this->credit_card_request = $credit_card_request;
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
        $url = env('APP_URL') . '/#credit-card-request';

        if ($notifiable->is_admin()) {
            return (new MailMessage)
                ->greeting('Hello!')
                ->line('A user has requested a new credit card purchase!')
                ->action('View Card Purchase Request', $url)
                ->line('Thank you for using our application!');
        }

        return (new MailMessage)
            ->greeting("Hey $notifiable->first_name!")
            ->line('Your credit card purchase request is under review!')
            ->line('You will receive a confirmation email once we\'re done.')
            ->line('Meanwhile you can stay posted on your info validation status with the button below.')
            ->action('View Card Purchase Request', $url)
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
            'card_issuer' => $this->credit_card_request->card_issuer,
            'description' => 'features.cc.creditCardPurchaseRequestDescription',
            'holder' => $this->credit_card_request->holder,
            'title' => 'features.cc.creditCardPurchaseRequest',
            'validation_status' => $this->credit_card_request->validation_status
        ];
    }
}
