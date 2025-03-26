<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Mail\WelcomeEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendWelcomeEmailListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        
    }

    /**
     * Handle the event.
     */
    public function handle(UserRegistered $event): void
    {
        try {
            Mail::to($event->user->email)->queue(new WelcomeEmail($event->user));
            Log::info('Welcome email queued for user: ' . $event->user->email);
        } catch (\Exception $e) {
            Log::error('Failed to send welcome email: ' . $e->getMessage());
        }
    }
}
