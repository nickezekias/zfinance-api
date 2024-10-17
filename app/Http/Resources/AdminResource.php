<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
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
            'avatar' => $this->avatar,
            'birthDate' => $this->birth_date,
            'createdAt' => $this->created_at,
            'firstName' => $this->first_name,
            'fullName' => $this->full_name,
            'lastName' => $this->last_name,
            'email' => $this->email,
            'emailVerifiedAt' => $this->email_verified_at,
            'isActive' => $this->is_active,
            'gender' => $this->gender,
            'phone' => $this->phone,
            'occupation' => $this->occupation,
            'phoneVerifiedAt' => $this->phone_verified_at,
            'updateAt' => $this->updated_at
        ];
    }
}
