<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Session;

/**
 * ビューカウントサービスクラス
 */
class ViewCountService
{
    /**
     * モデルのビューカウントを増やす
     *
     * @param  Model  $model ビューカウントを増やすモデル
     * @param  bool  $skipSessionCheck セッションチェックをスキップするかどうか
     */
    public function incrementCount(Model $model, $skipSessionCheck = false)
    {
        $key = 'viewed.'.$model::class.$model->getKey();
        if ($skipSessionCheck || ! Session::has($key)) {
            Redis::incr(':'.$model::class.':'.$model->getKey().':viewcount');
            Session::put($key, true);
        }
    }
}
