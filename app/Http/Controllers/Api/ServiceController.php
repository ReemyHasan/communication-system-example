<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Responses;
use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    use Responses;
    public function index()
    {
        $services = Service::pluck('name');
        return $this->indexOrShowResponse('services_codes', $services);
    }

    public function show($service)
    {
        $service = Service::where('name',$service)->first();
        if(!$service)
        return $this->indexOrShowResponse('message', 'error, this service not exist');
        $offers = $service->offers->pluck('name','offer_number');
        return $this->indexOrShowResponse('service', ['code'=>$service->name, 'offers'=> $offers]);
    }

}
