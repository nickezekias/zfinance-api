<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CreditCardRequestResource extends JsonResource
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
            'cardNetwork' => $this->card_network,
            'cardIssuer' => $this->card_issuer,
            'cardType' => $this->card_type,
            'userId' => $this->user_id,
            'validatedBy' => $this->validated_by,
            'validationMessages' => $this->validation_messages,
            'validationStatus' => $this->validation_status,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at
        ];
    }
}
