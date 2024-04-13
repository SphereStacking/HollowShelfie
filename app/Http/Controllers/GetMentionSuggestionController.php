<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\CustomIdentifiable;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\MentionsuggestionJsonResource;

class GetMentionSuggestionController extends Controller
{
    public function __invoke(Request $request):JsonResponse
    {
        $searchResults = CustomIdentifiable::search($request->input('q'))->query(function ($builder) {
            $builder->with(['aliasable']);
        })->paginate(10);
        return response()->json([
            'status' => 'success',
            'suggestions' => new MentionsuggestionJsonResource($searchResults),
        ]);
    }
}
