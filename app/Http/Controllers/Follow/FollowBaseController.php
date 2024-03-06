<?php

namespace App\Http\Controllers\Follow;

use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;

/**
 * フォロー関連の操作を管理するコントローラー
 */
class FollowBaseController extends Controller
{
    /**
     * レスポンスを生成します。
     *
     * @param  string  $message
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    protected function generateResponse($message,$target)
    {
        if (request()->wantsJson()) {
            // Ajaxリクエストの場合はJSONレスポンスを返す
            return response()->json([
                'status' => 'success',
                'message' => $message,
                'is_followed' => $target->isFollowedByCurrentUser(),
                'followers_count' => $target->followersCount()
            ]);
        } else {
            // それ以外の場合はInertiaレスポンス（またはリダイレクト）を返す
            return Redirect::back()->with([
                'status' => 'success',
                'message' => $message
            ]);
        }
    }
}

