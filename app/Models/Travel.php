<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Travel extends Model
{
    protected $fillable = [
        'user_id', 'from_location', 'to_location', 'from_country',
        'to_country', 'departure_date', 'arrival_date', 'airline', 'notes'
    ];

    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function matches(): HasMany { return $this->hasMany(DeliveryMatch::class); }
}
