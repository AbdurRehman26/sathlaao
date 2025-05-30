<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DeliveryRequest extends Model
{
    protected $fillable = [
        'delivery_location', 'delivery_country',
        'preferred_delivery_date', 'delivery_deadline', 'status'
    ];

    public function product(): BelongsTo { return $this->belongsTo(Product::class); }
    public function matches(): HasMany { return $this->hasMany(DeliveryMatch::class); }
}
