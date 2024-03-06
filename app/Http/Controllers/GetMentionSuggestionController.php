<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomIdentifiable;
use App\Http\Resources\MentionsuggestionJsonResource;

class GetMentionSuggestionController extends Controller
{
    public function __invoke(Request $request)
    {
        $searchResults = CustomIdentifiable::search($request->input('q'))->paginate(10);
        $customIds = $searchResults->pluck('id')->toArray();
        $customIdentities = CustomIdentifiable::with('aliasable')
            ->whereIn('id', $customIds)
            ->get();
        // searchResults の data を customIdentities で置き換える
        $searchResults->setCollection($customIdentities);
        return response()->json([
            'status' => 'success',
            'suggestions' => new MentionsuggestionJsonResource($searchResults),
        ]);
    }
}
