<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'createdAt' => $this->created_at,
            'firstName' => $this->first_name,
            'lastName' => $this->last_name,
            'email' => $this->email,
            'emailVerifiedAt' => $this->email_verified_at,
            'IDDocument' => $this->ID_document,
            'IDDocumentVerifiedAt' => $this->ID_document_verified_at,
            'isActive' => $this->is_active,
            'phone' => $this->phone,
            'phoneVerifiedAt' => $this->phone_verified_at,
            'updateAt' => $this->updated_at
        ];
    }
}
