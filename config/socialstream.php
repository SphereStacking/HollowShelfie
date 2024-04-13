<?php

use JoelButcher\Socialstream\Features;
use JoelButcher\Socialstream\Providers;

return [
    'middleware' => ['web'],
    'prompt' => 'OR',
    'providers' => [
        // Providers::github(),
        Providers::google(),
        [
            'id' => 'discord',
            'name' => 'Discord',
            'label' => 'Discord',
        ],
    ],
    'features' => [
        Features::createAccountOnFirstLogin(),
        // Features::generateMissingEmails(),
        Features::rememberSession(),
        Features::providerAvatars(),
        Features::refreshOAuthTokens(),
        Features::loginOnRegistration(),
    ],
    'home' => '/dashboard',
    'redirects' => [
        'login' => '/dashboard',
        'register' => '/dashboard',
        'login-failed' => '/login',
        'registration-failed' => '/register',
        'provider-linked' => '/user/profile',
        'provider-link-failed' => '/user/profile',
    ],
];
