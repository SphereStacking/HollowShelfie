<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class GetTagSuggestionController extends Controller
{
    public function __invoke(Request $request)
    {
        $suggestions = Tag::search($request->input('q'))
            ->paginate(10)
            ->through(function ($tag) {
                $tag->loadCount(['taggables', 'events', 'users']);

                return $tag;
            });

        return response()->json([
            'status' => 'success',
            'suggestions' => $suggestions,
        ]);
    }
}
