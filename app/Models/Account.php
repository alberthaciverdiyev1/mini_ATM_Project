<?php

namespace App\Models;

use App\Enums\PaymentType;
use App\Traits\Balance;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Account extends Model
{
    use Balance;
    protected $fillable = [
        'name',
        'user_id',
        'type'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


}
