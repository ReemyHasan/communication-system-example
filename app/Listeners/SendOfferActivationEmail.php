<?php

namespace App\Listeners;

use App\Events\OfferActivated;
use App\Mail\OfferActivatedMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendOfferActivationEmail implements ShouldQueue
{
    use InteractsWithQueue, Queueable;
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
    public function handle(OfferActivated $event)
    {
        $phoneNumber = $event->phoneNumber;
        $user = $phoneNumber->user;
        Mail::to($user->email)->queue(new OfferActivatedMail($event->message));
    }
}
