<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeliveryRequest extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'delivery_location', 'delivery_country',
        'preferred_delivery_date', 'delivery_deadline', 'status', 'user_id', 'delivery_note',
        'delivery_weight', 'delivery_price'
    ];

    public function deliveryCountry(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'delivery_country');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function products(): HasManyThrough
    {
        return $this->hasManyThrough(Product::class, DeliveryRequestProduct::class, 'delivery_request_id', 'id');
    }
    public function matches(): HasMany { return $this->hasMany(DeliveryMatch::class); }

    public function myMatch(): HasOne { return $this->hasOne(DeliveryMatch::class)->where('user_id', auth()->user()->id); }
}
