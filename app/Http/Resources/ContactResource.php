<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'first_names' => $this->first_names,
            'last_name' => $this->last_name,
            'date_of_birth' => $this->date_of_birth,
            'phone' => $this->phone,
            'email' => $this->email,
        ];
    }
}
