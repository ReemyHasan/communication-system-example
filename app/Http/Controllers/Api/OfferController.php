<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Responses;
use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\Service;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    use Responses;

    public function show($service, $offer)
    {
        $service = Service::where('name',$service)->first();
        if(!$service)
        return $this->indexOrShowResponse('message', 'error, this service not exist');
        $offer = $service->offers->where('offer_number',$offer)->first();
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

}
