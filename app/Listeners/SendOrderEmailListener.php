<?php

// app/Listeners/SendOrderEmailListener.php
namespace App\Listeners;

use App\Events\OrderPlaced;
use App\Mail\OrderPlacedEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendOrderEmailListener implements ShouldQueue
{
    public function handle(OrderPlaced $event)
    {
        try {
            // Send to user
            Mail::to($event->order->user->email)
                ->queue(new OrderPlacedEmail($event->order, false));
            
            // Send to admin
            Mail::to('admin@freshkart.com')
                ->queue(new OrderPlacedEmail($event->order, true));
            
            Log::info('Order emails queued for order: ' . $event->order->id);
        } catch (\Exception $e) {
            Log::error('Failed to send order emails: ' . $e->getMessage());
        }
    }
}