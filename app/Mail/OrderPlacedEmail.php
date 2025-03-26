<?php

// app/Mail/OrderPlacedEmail.php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderPlacedEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $isAdmin;

    public function __construct($order, $isAdmin = false)
    {
        $this->order = $order;
        $this->isAdmin = $isAdmin;
    }

    public function build()
    {
        $subject = $this->isAdmin ? "New Order Placed #{$this->order->id}" : "Your Order Confirmation #{$this->order->id}";
        
        return $this->subject($subject)
                    ->view('emails.order-placed')
                    ->with([
                        'order' => $this->order,
                        'isAdmin' => $this->isAdmin
                    ]);
    }
}