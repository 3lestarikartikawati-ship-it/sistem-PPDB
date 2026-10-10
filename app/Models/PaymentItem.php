<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentItem extends Model
{
    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
        'amount' => 'decimal:2',
    ];
}
