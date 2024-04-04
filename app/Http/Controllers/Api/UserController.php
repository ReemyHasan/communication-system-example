<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Responses;
use App\Http\Controllers\Controller;
use App\Models\PhoneNumber;

use App\Http\Requests\PhoneNumber\BuyNumberRequest;
use App\Models\PhoneNumberBackup;
use App\Models\User;
use Illuminate\Support\Facades\DB;
class UserController extends Controller
{
    use Responses;
    public function buyMobileNumber(BuyNumberRequest $request)
    {

        return DB::transaction(function () use ($request) {
            $validated = $request->validated();

            $user = User::where('identification_number', $request->identification_number)->first();
            if ($user && $user->phoneNumbers->count() >= 4) {
                return $this->sudResponse('User has reached the maximum allowed mobile numbers.', 422);
            }
            if (!$user) {
                $user = User::create($validated);
            }
            $mobileNumber = PhoneNumberBackup::where('sold', false)->first();
            $binCode = $this->generateUniqueBINCode();

            $phoneNumber = new PhoneNumber;

            $phoneNumber->forceCreate( [
                'phone_number' => $mobileNumber->number,
                'user_id' => $user->id,
                'bin_code' => $binCode,
            ]);
            $mobileNumber->forceFill(['sold'=>true]);
            $mobileNumber->update();

            return $this->indexOrShowResponse('your phone number', [
                'message' => 'Mobile number purchased successfully.',
                'mobile_number' => $mobileNumber->number,
                'bin_code' => $binCode,
            ], 200);
        });
    }

    private function generateUniqueBINCode()
    {
        $binCodes = PhoneNumber::pluck('bin_code');
        $binCode = bin2hex(random_bytes(4));
        while ($binCodes->contains($binCode)) {
            $binCode = bin2hex(random_bytes(4));
        }

        return $binCode;
    }

}
