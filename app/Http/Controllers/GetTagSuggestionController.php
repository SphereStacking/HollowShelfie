<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class GetTagSuggestionController extends Controller
{
    public function __invoke(Request $request)
    {
        $suggestions = Tag::search($request->input('q'))->query(function ($builder) {
            $builder->withCount(['taggables', 'events', 'users']);
        })->paginate(10);

        return response()->json([
            'status' => 'success',
            'suggestions' => $suggestions,
        ]);
    }
}
