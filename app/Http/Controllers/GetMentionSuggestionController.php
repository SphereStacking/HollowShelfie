<?php

namespace App\Http\Controllers;

use App\Models\ScreenName;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\MentionSuggestionJsonResource;

class GetMentionSuggestionController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        // Userの検索
        $query = $request->input('q');
        $screenNames = ScreenName::query()->searchByScreenNameOrMorphName($query)->paginate(12);

        return response()->json([
            'status' => 'success',
            'suggestions' => new MentionSuggestionJsonResource($screenNames),
        ]);
    }
}
