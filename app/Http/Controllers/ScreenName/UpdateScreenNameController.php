<?php

namespace App\Http\Controllers\ScreenName;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateScreenNameRequest;
use App\Models\ScreenName;

class UpdateScreenNameController extends Controller
{
    public function __invoke(UpdateScreenNameRequest $request, $screenName)
    {
        $model = ScreenName::findScreenNameable($screenName);
        $newScreenName = $request->input('screen_name');
        $model->ScreenNameable->changeScreenName($newScreenName);
        $model->save();

        return redirect(route('teams.show', $newScreenName))->with([
            'response' => [
                'status' => 'success',
                'message' => 'スクリーンネームを更新しました。',
            ],
        ]);
    }
}
