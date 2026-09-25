<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HotspotPurchaseRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'router_name',
        'mac_address',
        'ip_address',
        'package_id',
        'package_name',
        'amount',
        'currency',
        'phone',
        'payment_gateway',
        'merchant_reference',
        'payment_transaction_id',
        'payment_status',
        'paid_at',
        'activation_status',
        'activation_started_at',
        'activated_at',
        'activation_failed_at',
        'login_url',
        'link_login',
        'original_destination',
        'hotspot_username',
        'hotspot_password',
        'activation_error',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'activation_started_at' => 'datetime',
        'activated_at' => 'datetime',
        'activation_failed_at' => 'datetime',
    ];

    public function package(): BelongsTo
    {
        return $this->belongsTo(PackageList::class, 'package_id');
    }

    public function paymentTransaction(): BelongsTo
    {
        return $this->belongsTo(
            PaymentTransaction::class,
            'payment_transaction_id'
        );
    }

    public function activationAttempts(): HasMany
    {
        return $this->hasMany(HotspotActivationAttempt::class);
    }

    public function isPaymentSuccessful(): bool
    {
        return $this->payment_status === 'paid';
    }

    public function isActivated(): bool
    {
        return $this->activation_status === 'activated';
    }
}
