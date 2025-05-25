<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class DeliveryMatch extends Model
{
    protected $fillable = [
        'delivery_request_id', 'travel_id', 'status', 'message'
    ];

    public function deliveryRequest(): BelongsTo { return $this->belongsTo(DeliveryRequest::class); }
    public function travel(): BelongsTo { return $this->belongsTo(Travel::class); }
    public function approval(): HasOne { return $this->hasOne(DeliveryApproval::class); }
    public function messages(): HasMany { return $this->hasMany(Message::class); }
}
