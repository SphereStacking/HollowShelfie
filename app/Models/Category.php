<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    use HasFactory;

    /**
     * 大量代入可能な属性
     *
     * @var array<int, string>
     */
    protected $fillable = ['name'];

    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class);
    }
}
