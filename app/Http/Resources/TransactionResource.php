<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
            'beneficiary' => $this->beneficiary,
            'createdAt' => $this->created_at,
            'date' => $this->date,
            'description' => $this->description,
            'status' => $this->status,
            'type' => $this->type,
            'updatedAt' => $this->updated_at,
            'userId' => $this->user_id
        ];
    }
}
