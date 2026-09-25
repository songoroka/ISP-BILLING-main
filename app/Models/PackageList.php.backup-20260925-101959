<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageList extends Model
{
    use HasFactory;

    protected $fillable = [
        'package', 'price', 'description', 'merchant_company',
        'plan_label', 'speed', 'features', 'is_featured', 'show_on_site', 'sort_order',
        'mikrotik_rate_limit', 'push_to_mikrotik', 'service_type', 'mikrotik_local_address', 'mikrotik_remote_address',
        'router_name',
        'reseller_id',
        'ttl_mangle_enabled',
        'ttl_value',
        'ttl_chain',
        'validity_type', 'validity_duration',
    ];

    protected $casts = [
        'features' => 'array',
        'is_featured' => 'boolean',
        'show_on_site' => 'boolean',
        'push_to_mikrotik' => 'boolean',
        'ttl_mangle_enabled' => 'boolean',
        'ttl_value' => 'integer',
        'validity_type' => 'string',
        'validity_duration' => 'string',
    ];

    public function router()
    {
        return $this->belongsTo(RouterList::class, 'router_name', 'router_name');
    }

    public function reseller()
    {
        return $this->belongsTo(Reseller::class, 'reseller_id');
    }
}
