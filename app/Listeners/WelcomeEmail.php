<?php

namespace App\Listeners;

use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;

class WelcomeEmail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        // Mail::to($event->user)
        //   ->send(new WelcomeMail($event->user));
        dump("email has been sent");
    }
}
