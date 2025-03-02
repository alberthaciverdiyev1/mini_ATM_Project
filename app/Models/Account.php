<?php

namespace App\Models;

use App\Enums\PaymentType;
use App\Traits\Balance;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use Balance,SoftDeletes;
    protected $fillable = [
        'name',
        'user_id',
        'type'
    ];

    protected $dates = ['deleted_at'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


}
