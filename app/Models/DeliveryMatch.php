<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeliveryMatch extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'delivery_request_id', 'travel_id', 'status', 'message', 'user_id'
    ];

    public function deliveryRequest(): BelongsTo { return $this->belongsTo(DeliveryRequest::class); }

    public function travel(): BelongsTo { return $this->belongsTo(Travel::class); }

    public function approve(): void
    {
        $this->status = 'approved';
        $this->save();
    }

    public function reject(): void
    {
        $this->status = 'rejected';
        $this->save();
    }

    public function messages(): HasMany { return $this->hasMany(Message::class); }
}
