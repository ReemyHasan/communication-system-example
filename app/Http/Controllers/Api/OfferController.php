<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Responses;
use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\PhoneNumber;
use App\Models\PhoneOffer;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OfferController extends Controller
{
    use Responses;

    public function show($service, $offer)
    {
        $service = Service::where('name', $service)->first();
        if (!$service)
            return $this->indexOrShowResponse('message', 'error, this service not exist');
        $offer = $service->offers->where('offer_number', $offer)->first();
        if (!$offer) {
            return $this->indexOrShowResponse('message', 'error, this offer does not exist');
        }
        $offerData = [
            'offer_number' => $offer->offer_number,
            'name' => $offer->name,
            'description' => $offer->description,
            'price' => $offer->price,
            'duration' => $offer->duration
        ];

        return $this->indexOrShowResponse('offer', $offerData);
    }
    public function activateOffer($service, $offer, Request $request)
    {
        return DB::transaction(function () use ($service, $offer, $request) {
            $phone_number = PhoneNumber::where('phone_number', $request['phone_number'])->first();
            $service = Service::where('name', $service)->first();
            if (!$service)
                return $this->indexOrShowResponse('message', 'error, this service not exist');
            $offer = $service->offers->where('offer_number', $offer)->first();
            if (!$offer) {
                return $this->indexOrShowResponse('message', 'error, this offer does not exist');
            }
            if ($phone_number->balance < $offer->price) {
                return $this->indexOrShowResponse('message', 'sorry, your balance less than the offer price');

            }
            $phoneOffers = $phone_number->phoneOffers;

            $checkOffer = $phoneOffers->where('offer_id', $offer->id)->first();
            lad($phoneOffers->count());
            if (($checkOffer != null && $checkOffer->expiration_date > now())) {
                return $this->indexOrShowResponse('message', 'sorry, you already activate the offer');

            }
            if($phoneOffers->count()>=5){
                return $this->indexOrShowResponse('message', 'you reached your limits, you already activate 5 offers');

            }
            $phoneOffer = new PhoneOffer();
            $phoneOffer->forceCreate(
                [
                    'phone_number_id' => $phone_number->id,
                    'offer_id' => $offer->id,
                    'offer_full_amount' => 100,
                    'offer_used_amount' => 0,
                    'expiration_date' => now()->addHours($offer->duration_in_hours)
                ]
            );
            $new_balance = $phone_number->balance - $offer->price;
            $new_bonus_points = $phone_number->bonus_points + $offer->bonus_points;
            $phone_number->forceFill(['balance' => $new_balance, 'bonus_points' => $new_bonus_points]);
            $phone_number->update();
            return $this->indexOrShowResponse(
                'message',
                ['message' => 'Offer activated successfully']
            );
        });
    }

    public function deactivateOffer($service, $offer, Request $request)
    {
        $phone_number = PhoneNumber::where('phone_number', $request['phone_number'])->first();
        $service = Service::where('name', $service)->first();
        if (!$service)
            return $this->indexOrShowResponse('message', 'error, this service not exist');
        $offer = $service->offers->where('offer_number', $offer)->first();
        if (!$offer) {
            return $this->indexOrShowResponse('message', 'error, this offer does not exist');
        }
        $phoneOffer = $phone_number->phoneOffers->where('offer_id', $offer->id)->first();
        if($phoneOffer == null)
        return $this->indexOrShowResponse('message', 'error, you do not activate this offer');

        $phoneOffer->delete();
        // lad($phoneOffer);
        return $this->sudResponse('offer deleted successfully');
    }

    public function deactivateAllOffers(Request $request)
    {
        $phone_number = PhoneNumber::where('phone_number', $request['phone_number'])->first();
        $phone_number->phoneOffers()->delete();
        return $this->sudResponse('all your offers deleted successfully');

    }


}
