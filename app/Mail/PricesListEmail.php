<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PricesListEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $prices_data;
    public $user_name;
    public $current_date;

    /**
     * Create a new message instance.
     */
    public function __construct($prices_data, $user_name, $current_date)
    {
        $this->prices_data = $prices_data;
        $this->user_name = $user_name;
        $this->current_date = $current_date;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.prices_email')
            ->with([
                'prices_data' => $this->prices_data,
                'user_name' => $this->user_name,
                'current_date' => $this->current_date,
            ])
            ->subject('Latest Currency prices for ' . $this->user_name);
    }
}
