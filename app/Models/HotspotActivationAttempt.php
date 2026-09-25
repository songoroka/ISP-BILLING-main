<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HotspotActivationAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'hotspot_purchase_request_id',
        'router_name',
        'mac_address',
        'attempt_number',
        'status',
        'started_at',
        'completed_at',
        'error_message',
        'request_payload',
        'response_payload',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'request_payload' => 'array',
        'response_payload' => 'array',
    ];

    public function purchaseRequest(): BelongsTo
    {
        return $this->belongsTo(
            HotspotPurchaseRequest::class,
            'hotspot_purchase_request_id'
        );
    }
}
