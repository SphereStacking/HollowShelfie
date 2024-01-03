<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomIdentifiable extends Model
{
    use HasFactory;

    protected $fillable = ['alias_name'];

    public function aliasable()
    {
        return $this->morphTo();
    }
}
