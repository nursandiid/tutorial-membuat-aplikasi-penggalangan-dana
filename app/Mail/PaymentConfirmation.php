<?php

namespace App\Mail;

use App\Models\Bank;
use App\Models\Campaign;
use App\Models\Donation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $campaign;
    public $donation;
    public $bank;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(
        Campaign $campaign,
        Donation $donation,
        $bank
    )
    {
        $this->campaign = $campaign;
        $this->donation = $donation;
        $this->bank = $bank;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.payment_confirmation')
            ->with([
                'campaign' => $this->campaign,
                'donation' => $this->donation,
                'bank' => $this->bank
            ]);
    }
}
