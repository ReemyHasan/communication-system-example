<?php

namespace App\Http\Requests\PhoneNumber;

use Illuminate\Foundation\Http\FormRequest;

class BuyNumberRequest extends FormRequest
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
            'full_name' => 'required|string',
            'address' => 'required|string',
            'gender' => 'required|in:male,female',
            'email' => 'required|email',
            'identification_number' => 'required|digits:11',
        ];
    }
}
