<?php

namespace App\Http\Requests\PhoneNumber;

use Illuminate\Foundation\Http\FormRequest;

class GiftAmountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'phone_number'=>"required|exists:phone_numbers,phone_number",
            'target_phone_number'=>"required|exists:phone_numbers,phone_number",
            'amount' => "required|numeric|max:50000"
        ];
    }
}
