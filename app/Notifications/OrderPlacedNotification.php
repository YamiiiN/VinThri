<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use Dompdf\Dompdf;
use Dompdf\Options;

class OrderPlacedNotification extends Notification
{
    use Queueable;
    protected $pdfContent;

    /**
     * Create a new notification instance.
     */
    public function __construct($pdfContent)
    {
        $this->pdfContent = $pdfContent;
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
         // Generate PDF
         $dompdf = new Dompdf();
         $dompdf->loadHtml($this->pdfContent);
         $dompdf->setPaper('A4', 'portrait');
         $dompdf->render();
         $pdfOutput = $dompdf->output();

         return (new MailMessage)
                     ->subject('Order Receipt')
                     ->line('Thank you for your order. Please find your receipt attached below.')
                     ->attachData($pdfOutput, 'receipt.pdf', [
                         'mime' => 'application/pdf',
                     ])
                     ->line('You can also download your receipt from the following link:')
                     ->action('Download Receipt', 'data:application/pdf;base64,' . base64_encode($pdfOutput));
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
