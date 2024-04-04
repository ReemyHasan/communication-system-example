<?php

namespace Database\Factories;

use App\Models\PhoneNumberBackup;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PhoneNumberBackup>
 */
class PhoneNumberBackupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'price' =>1000,
            'number' => $this->generateUniqueMobileNumber()
        ];
    }
    private function generateUniqueMobileNumber()
    {
        $mobileNumbers = PhoneNumberBackup::pluck('number');
        $mobileNumber = '09' . str_pad(mt_rand(0, 99999999), 8, '0', STR_PAD_LEFT);

        while ($mobileNumbers->contains($mobileNumber)) {
            $mobileNumber = '09' . str_pad(mt_rand(0, 99999999), 8, '0', STR_PAD_LEFT);
        }

        return $mobileNumber;
    }
}
