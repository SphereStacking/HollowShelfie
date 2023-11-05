<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instance extends Model
{
    use HasFactory;

    /**
     * @var array 可変の属性
     */
    protected $appends = [
        'instance_type_name',
    ];

    /**
     * インスタンスの名前を返す
     *
     * @return string|null
     */
    public function getInstanceTypeNameAttribute()
    {
        return $this->instance_type->name;
    }

    //イベントに紐づくinstance
    public function instance_type()
    {
        return $this->belongsTo(InstanceType::class);
    }
}
