<?php

namespace App\Models;

use App\Enums\PaymentSource;
use App\Enums\PaymentType;
use App\Traits\Balance;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use Balance,SoftDeletes;

    protected $fillable = [
        'account_id',
        'amount',
        'type',
        'is_atm',
    ];

    protected $casts = [
        'type' => PaymentType::class,
    ];

    protected $dates = ['deleted_at'];

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }
}
