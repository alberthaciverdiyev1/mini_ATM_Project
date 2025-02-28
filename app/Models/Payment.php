<?php

namespace App\Models;

use App\Enums\PaymentSource;
use App\Enums\PaymentStatus;
use App\Enums\PaymentType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'account_id',
        'amount',
        'type',
        'source',
        'status'
    ];

    protected $casts = [
        'type' => PaymentType::class,
        'source' => PaymentSource::class,
        'status' => PaymentStatus::class,
    ];
    public function account(): BelongsTo {
        return $this->belongsTo(Account::class);
    }
}
