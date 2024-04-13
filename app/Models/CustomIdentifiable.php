<?php

namespace App\Models;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomIdentifiable extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['alias_name'];

    public function aliasable(): MorphTo
    {
        return $this->morphTo('aliasable', 'identifiable_type', 'identifiable_id');
    }

    /**
     * MeiliSearch 検索可能な配列に変換します。
     */
    public function toSearchableArray(): array
    {
        return $this->only(
            [
                'alias_name',
            ]
        );

    }
}
