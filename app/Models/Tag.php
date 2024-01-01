<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function taggables()
    {
        return $this->hasMany(Taggable::class);
    }

    public function events()
    {
        return $this->morphedByMany(Event::class, 'taggable');
    }
}
