<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class PendingOrder extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Order ID
     *
     * @var int
     */
    protected $o_id;

    /**
     * Create a new message instance.
     *
     * @param int $o_id
     * @return void
     */
    public function __construct($o_id)
    {
        $this->o_id = $o_id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $o_id = $this->o_id;

        return $this->subject(translate('Pending_Order')) // Custom translation key for pending order
                    ->view('email-templates.pendding-order', ['id' => $o_id]);
    }
}
