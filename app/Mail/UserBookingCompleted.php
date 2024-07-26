<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserBookingCompleted extends Mailable
{
    use Queueable, SerializesModels;

    public $customer;
    public $booking;
    public $cartTotals;
    public $contact_data;
    public $setting;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($customer, $booking, $cartTotals, $contact_data, $setting)
    {
        //
        $this->customer = $customer;
        $this->booking = $booking;
        $this->cartTotals = $cartTotals;
        $this->contact_data = $contact_data;
        $this->setting = $setting;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Your Booking Completed")
            ->view('emails.user-booking-completed')
            ->with([
                'customer' => $this->customer,
                'booking' => $this->booking,
                'cartTotals' => $this->cartTotals,
                'contact_data' => $this->contact_data,
                'setting' => $this->setting
            ]);
    }
}
