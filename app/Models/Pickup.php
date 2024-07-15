<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pickup extends Model
{
    use HasFactory;
    protected $fillable = [
        'pickupable_type',
        'pickupable_id',
    ];

    public function pickupable()
    {
        return $this->morphTo();
    }

    public function scopeOfTypes($query, array $types)
    {
        return $query->whereIn('pickupable_type', $types);
    }
}
