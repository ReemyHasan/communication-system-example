<?php

namespace App\Console\Commands;

use App\Events\OfferUsedAmount;
use App\Models\PhoneOffer;
use Illuminate\Console\Command;

class CheckOfferUsage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-offer-usage';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $phoneOffers = PhoneOffer::with('phone_number.user', 'offer')->get();

        foreach ($phoneOffers as $phoneOffer) {
            if (
                $phoneOffer->offer_used_amount == 100
                ||
                $phoneOffer->offer_used_amount == 50
                ||
                $phoneOffer->offer_used_amount == 70
            ) {
                event(new OfferUsedAmount($phoneOffer->phone_number, "You have used {$phoneOffer->offer_used_amount}% from offer {$phoneOffer->offer->name}."));
            }
        }
    }
}
