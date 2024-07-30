<?php

namespace App\Http\Middleware;

use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;
use Illuminate\Http\Request;
use App\Http\Resources\AuthUserJsonResource;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'ziggy' => fn () => [
                ...(new Ziggy())->toArray(),
                'location' => $request->url(),
                'query' => $request->query(),
            ],
            'config' => [
                'appName' => fn () => config('app.name'),
                'twitter' => fn () => config('app.twitter'),
                'github' => fn () => config('app.github'),
                'discordInvite' => fn () => config('app.discord_invite'),
                'VRChatGroup' => fn () => config('app.VRChatGroup'),
                'credit' => fn () => config('app.credit'),
                'issueForms' => [
                    'bug_report' => fn () => config('external_services.issue_forms.bug_report.url'),
                    'feedback' => fn () => config('external_services.issue_forms.feedback.url'),
                    'new_feature' => fn () => config('external_services.issue_forms.new_feature.url'),
                ],
                'supportings' => [
                    'fanbox' => fn () => config('external_services.supportings.fanbox'),
                    'patreon' => fn () => config('external_services.supportings.patreon'),
                ],
            ],
            // Laravel\Jetstream\Http\Middleware\ShareInertiaDataのauth.userを上書きする。
            'auth' => fn () => AuthUserJsonResource::make($request->user()),
            // flash
            'response' => fn () => $request->hasSession()
                ? $request->session()->get('response')
                : null,
        ];
    }
}
