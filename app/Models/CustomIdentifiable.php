<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Laravel\Scout\Searchable;

class CustomIdentifiable extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['screen_name'];

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
                'screen_name',
            ]
        );

    }
}
