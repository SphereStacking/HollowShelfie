<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    protected $fillable = ['count'];

    // ポリモーフィックリレーションを定義
    public function viewable()
    {
        return $this->morphTo();
    }
}
