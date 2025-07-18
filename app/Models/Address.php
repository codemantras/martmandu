<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'email',
        'street_address',
        'city',
        'state',
        'zipcode'
    ];

    public function order(): BelongsTo {
        return $this->belongsTo(Order::class);
    }
}
