<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeliveryApproval extends Model
{
    protected $fillable = ['match_id', 'approved_by_user_id', 'approved_at'];

    public function match(): BelongsTo { return $this->belongsTo(DeliveryMatch::class); }
    public function approvedBy(): BelongsTo { return $this->belongsTo(User::class, 'approved_by_user_id'); }
}
