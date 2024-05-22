<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BookingEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $booking;
    public $cartTotals;
    public $email_type;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Booking $booking,$cartTotals,$email_type="user")
    {
        $this->booking=$booking;
        $this->cartTotals=$cartTotals;
        $this->cartTotals=$cartTotals;
        $this->email_type=$email_type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(){
        return $this->subject("Booking")
                ->view('emails.bookingEmail');
    }
}
