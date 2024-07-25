<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OperatorNotification extends Mailable
{
    use Queueable, SerializesModels;
    public $booking;
    public $cartTotals;
    public $contact_data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct ($booking, $cartTotals, $contact_data)
    {
        $this->booking = $booking;
        $this->cartTotals = $cartTotals;
        $this->contact_data = $contact_data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(){
        return $this->subject("New Booking Operator")
                ->view('emails.operatornotification')
                    ->with([
                        'booking' => $this->booking,
                        'cartTotals' => $this->cartTotals,
                        'contact_data' => $this->contact_data,
                    ]);

    }
}
