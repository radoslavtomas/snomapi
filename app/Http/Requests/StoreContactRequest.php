<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
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
            'first_names' => 'required|string',
            'last_name' => 'required|string',
            'date_of_birth' => 'sometimes|nullable|string',
            'phone' => 'sometimes|nullable',
            'email' => 'sometimes|nullable|email',
        ];
    }
}
