<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CreditCardResource extends JsonResource
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
            'amount' => $this->amount,
            'accountNumber' => $this->account_number,
            'cvc' => $this->cvc,
            'expiryDate' => $this->expiry_date,
            'holder' => $this->holder,
            'isActive' => $this->is_active,
            'issuer' => $this->issuer,
            'network' => $this->network,
            'number' => $this->number,
            'type' => $this->type,
            'userId' => $this->user_id,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at
        ];
    }
}
