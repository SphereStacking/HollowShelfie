<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Instance extends Model
{
    use HasFactory;

    /**
     * 可変の属性
     *
     * @var array<int, string>
     */
    protected $appends = [
        'instance_type_name',
    ];

    /**
     * マスアサインメントで代入を許可する属性
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'instance_type_id',
        'access_url',
        'display_name',
    ];

    /**
     * インスタンスの名前を返す
     */
    public function getInstanceTypeNameAttribute(): string|null
    {
        return $this->instance_type->name;
    }

    /**
     * イベントに紐づくinstance
     */
    public function instance_type():BelongsTo
    {
        return $this->belongsTo(InstanceType::class);
    }
}
