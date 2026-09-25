<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HotelGuest extends Model
{
    use HasFactory;

    protected $fillable = [
        'voucher_number',
        'guest_name',
        'gender',
        'nationality',
        'document_type',
        'document_number',
        'phone',
        'email',
        'address',
        'room_number',
        'check_in',
        'check_out',
        'adults',
        'children',
        'purpose',
        'notes',
        'registered_by',
    ];

    protected $casts = [
        'check_in' => 'datetime',
        'check_out' => 'datetime',
        'adults' => 'integer',
        'children' => 'integer',
    ];

    public function registrar(): BelongsTo
    {
        return $this->belongsTo(User::class, 'registered_by');
    }
}
