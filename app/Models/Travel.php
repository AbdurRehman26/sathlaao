<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Travel extends Model
{
    use SoftDeletes;

    protected $table = 'travels';

    protected $fillable = [
        'user_id', 'from_location', 'to_location', 'from_country',
        'to_country', 'departure_date', 'arrival_date', 'airline', 'notes'
    ];

    public function toCountry(): BelongsTo { return $this->belongsTo(Country::class, 'to_country'); }
    public function fromCountry(): BelongsTo { return $this->belongsTo(Country::class, 'from_country'); }

    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function matches(): HasMany { return $this->hasMany(DeliveryMatch::class); }
}
