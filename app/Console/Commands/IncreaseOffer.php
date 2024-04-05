<?php

namespace App\Console\Commands;

use App\Models\PhoneOffer;
use Illuminate\Console\Command;

class IncreaseOffer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:increase-offer';

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
        $phoneOffers = PhoneOffer::get();

        foreach ($phoneOffers as $phoneOffer) {
            $phoneOffer->forceFill(['offer_used_amount' => $phoneOffer->offer_used_amount += 10]);
            $phoneOffer->save();
        }
    }
}
