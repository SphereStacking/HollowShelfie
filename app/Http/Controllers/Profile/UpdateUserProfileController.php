<?php

namespace App\Http\Controllers\Profile;

use App\Models\ScreenName;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateUserProfileRequest;

class UpdateUserProfileController extends Controller
{
    public function __construct() {}

    /**
     * ユーザーのプロファイルを表示します。
     */
    public function __invoke(UpdateUserProfileRequest $request, $screen_name)
    {
        $screenNameable = ScreenName::findScreenNameable($screen_name);
        $user = $screenNameable->user()->first();

        if (Auth::user()->id !== $user->id ) {
            return abort(403, '他人のプロフィールは編集できません!');
        }

        // リンクの更新
        $user->links()->delete();
        $links = $request->input('links');
        $user->links()->createMany($links);

        // タグの更新
        $user->tags()->delete();
        $tags = $request->input('tags');
        $formattedTags = array_map(fn($tag) => ['name' => $tag], $tags);
        $user->tags()->createMany($formattedTags);

        // 自己紹介の更新
        $user->bio = $request->input('bio');
        $user->save();

        return redirect()->back()->with([
            'response' => [
                'status' => 'success',
                'message' => 'プロフィールを更新しました。',
            ],
        ]);
    }
}
