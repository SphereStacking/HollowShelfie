<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Event;
use App\Enums\EventStatus;
use Illuminate\Http\Request;
use App\Http\Requests\EventRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class PerformerController extends Controller
{

    /**
     * 指定したPerformerを閲覧。
     *
     * @param Event $event
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show($event)
    {
        return Inertia::render('Performer/Show', [
            'performer' => User::find($event),
        ]);
    }
}
