<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlatformTransaction extends Model
{
    protected $fillable = [
        'super_admin_user_id',
        'hotspot_sale_id',
        'reseller_id',
        'type',
        'gross_amount',
        'fee_percentage',
        'fee_amount',
        'currency',
        'description',
    ];

    protected $casts = [
        'gross_amount' => 'decimal:2',
        'fee_percentage' => 'decimal:2',
        'fee_amount' => 'decimal:2',
    ];

    public function superAdmin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'super_admin_user_id');
    }

    public function hotspotSale(): BelongsTo
    {
        return $this->belongsTo(HotspotSale::class, 'hotspot_sale_id');
    }

    public function reseller(): BelongsTo
    {
        return $this->belongsTo(Reseller::class, 'reseller_id');
    }
}
