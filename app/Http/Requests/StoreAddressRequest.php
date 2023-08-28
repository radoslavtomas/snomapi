<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAddressRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'address_line_1' => 'required|string',
            'address_line_2' => 'sometimes|nullable|string',
            'address_line_3' => 'sometimes|nullable|string',
            'address_line_4' => 'required|string',
            'postcode' => 'required|string',
            'country' => 'required|string',
        ];
    }
}
