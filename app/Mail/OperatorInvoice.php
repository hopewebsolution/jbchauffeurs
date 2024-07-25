<?php

namespace App\Mail;

use App\User;
use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OperatorInvoice extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $cartTotals;
    public $contact_data;
    public $setting;
    public $pdf;

    /**
     * Create a new message instance.
     *
     * @param \App\Models\Booking $booking
     * @param $cartTotals
     * @param $contact_data
     * @param $pdf
     */
    public function __construct(Booking $booking, $cartTotals, $contact_data, $setting, $pdf)
    {
        $this->booking = $booking;
        $this->cartTotals = $cartTotals;
        $this->contact_data = $contact_data;
        $this->pdf = $pdf; // Ensure $pdf is assigned here
        $this->setting = $setting;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Operator Invoice Generated')
            ->view('emails.OperatorInvoice')
            ->attachData($this->pdf->output(), 'operator_invoice.pdf', [
                'mime' => 'application/pdf',
            ]);
    }
}
