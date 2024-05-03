<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\MentionSuggestionJsonResource;

class GetMentionSuggestionController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        // Userの検索
        $query = $request->input('q');
        $users = User::query()
            ->where('screen_name', 'like', "%{$query}%")
            ->orWhere('name', 'like', "%{$query}%")
            ->paginate(15);

        return response()->json([
            'status' => 'success',
            'suggestions' => new MentionSuggestionJsonResource($users),
        ]);
    }
}
