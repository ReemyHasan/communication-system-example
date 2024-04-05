<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Responses;
use App\Events\OfferActivated;
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
        try {
            return DB::transaction(function () use ($service, $offer, $request) {
                $phone_number = PhoneNumber::where('phone_number', $request['phone_number'])->first();
                $service = Service::where('name', $service)->first();
                if (!$service) {
                    return $this->indexOrShowResponse(
                        'message',
                        'error, this service does not exist'
                    );
                }
                $offer = $service->offers->where('offer_number', $offer)->first();
                $error = $this->validateOfferActivation($offer, $phone_number);
                if ($error != null) {
                    event(new OfferActivated($phone_number, $error));
                    return $this->indexOrShowResponse('message', 'error, check your email to get details');
                }

                $phoneOffer = $this->createPhoneOffer($phone_number, $offer);
                $this->updatePhoneNumberBalance($phone_number, $offer);

                event(new OfferActivated($phone_number, 'Offer ' . $offer->name . ' activated successfully'));
                return $this->indexOrShowResponse(
                    'message',
                    'Offer activated successfully, check your email for more details'
                );
            });
        } catch (\Exception $e) {
            return $this->indexOrShowResponse('message', $e->getMessage());

        }
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
        if ($phoneOffer == null)
            return $this->indexOrShowResponse('message', 'error, you do not activate this offer');

        $phoneOffer->delete();
        // lad($phoneOffer);
        return $this->sudResponse('offer deleted successfully');
    }

    public function deactivateAllOffers(Request $request)
    {
        $phone_number = PhoneNumber::where('phone_number', $request->phone_number)->first();
        $phone_number->phoneOffers()->delete();
        return $this->sudResponse('all your offers deleted successfully');

    }

    protected function validateOfferActivation($offer, $phone_number)
    {
        if (!$offer) {
            return 'Failed request, this offer '.$offer->name.' does not exist';
        }

        if ($phone_number->balance < $offer->price) {
            return 'sorry, Failed request,reasons: your balance is less than the offer '.$offer->name.' price';
        }

        $phoneOffers = $phone_number->phoneOffers;

        $checkOffer = $phoneOffers->where('offer_id', $offer->id)->first();
        if (($checkOffer != null && $checkOffer->expiration_date > now())) {
            return 'sorry, Failed request,reasons: you already activated the offer ' . $offer->name;
        }

        if ($phoneOffers->count() >= 5) {
            return 'sorry, Failed request,reasons: you reached your limits, you already activated 5 offers';
        }

        return null;
    }

    protected function createPhoneOffer($phone_number, $offer)
    {
        return PhoneOffer::forceCreate([
            'phone_number_id' => $phone_number->id,
            'offer_id' => $offer->id,
            'offer_full_amount' => 100,
            'offer_used_amount' => 0,
            'expiration_date' => now()->addHours($offer->duration_in_hours)
        ]);
    }
    protected function updatePhoneNumberBalance($phone_number, $offer)
    {
        $new_balance = $phone_number->balance - $offer->price;
        $new_bonus_points = $phone_number->bonus_points + $offer->bonus_points;
        $phone_number->forceFill(['balance' => $new_balance, 'bonus_points' => $new_bonus_points]);
        $phone_number->update();
    }
}
