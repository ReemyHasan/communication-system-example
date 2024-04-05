<?php

namespace App\Listeners;

use App\Events\OfferUsedAmount;
use App\Mail\OfferUsedAmountMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendOfferUsedAmountEmail implements ShouldQueue
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
    public function handle(OfferUsedAmount $event): void
    {
        $phoneNumber = $event->phoneNumber;
        $user = $phoneNumber->user;
        Mail::to($user->email)->queue(new OfferUsedAmountMail($event->message));
    }
}
