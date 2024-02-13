<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use PhpParser\Node\Expr\FuncCall;

class CustomIdentifiable extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['alias_name'];

    public function aliasable()
    {
        return $this->morphTo('aliasable', 'identifiable_type', 'identifiable_id');
    }

    /**
     * MeiliSearch 検索可能な配列に変換します。
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return $this->only(
            [
                'alias_name',
            ]
        );
    }
}
