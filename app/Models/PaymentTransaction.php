<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentTransaction extends Model
{
    protected $fillable = [
        'provider','channel','customer_unique_id','merchant_reference',
        'provider_transaction_id','provider_reference','redirect_url','phone','amount','currency',
        'status','failure_code','failure_message','paid_at','last_checked_at',
        'request_payload','response_payload',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'paid_at' => 'datetime',
            'last_checked_at' => 'datetime',
            'request_payload' => 'array',
            'response_payload' => 'array',
        ];
    }
}
