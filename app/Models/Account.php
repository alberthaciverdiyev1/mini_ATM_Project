<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Account extends Model
{
    protected $fillable = [
        'name',
        'user_id',
        'type'
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

}
