<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditCard extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'account_number',
        'cvc',
        'expiry_date',
        'holder',
        'issuer',
        'network',
        'number',
        'type',
        'user_id'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean'
        ];
    }

    /**
     * Check credit card is still valid by checking it's active and not over exp date
     * @return bool
     */
    public function is_valid(): bool
    {
        return $this->is_active == 1 && $this->expiry_date > now();
    }

    /**
     * Check credit card has sufficient funds for given amount
     * @param float amount
     * @return bool
     */
    public function has_sufficient_funds(float $amount)
    {
        return $this->amount >= $amount;
    }
}
