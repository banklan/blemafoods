<?php

namespace App\Mail;

use App\User;
use App\SpecialOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SpecialOrderCost extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $order;
    // public $cost;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, SpecialOrder $order)
    {
        $this->user = $user;
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('Blessing@blema.com')
        -> view('emails.order_cost');
    }
}
