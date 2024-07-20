<?php

return [
    /*
    |--------------------------------------------------------------------------
    | 外部フォームサービス
    |--------------------------------------------------------------------------
    */
    'issue_forms' => [
        'feedback' => [
            'id' => env('FEEDBACK_GOOGLE_FORM_ID'),
            'url' => 'https://docs.google.com/forms/d/'.env('FEEDBACK_GOOGLE_FORM_ID').'/viewform',
        ],
        'bug_report' => [
            'id' => env('BUG_REPORT_GOOGLE_FORM_ID'),
            'url' => 'https://docs.google.com/forms/d/'.env('BUG_REPORT_GOOGLE_FORM_ID').'/viewform',
        ],
        'new_feature' => [
            'id' => env('NEW_FEATURE_GOOGLE_FORM_ID'),
            'url' => 'https://docs.google.com/forms/d/'.env('NEW_FEATURE_GOOGLE_FORM_ID').'/viewform',
        ],
    ],
    'supportings' => [
        'fanbox' => 'https://spherestacking.fanbox.cc',
        'fanbox_post' => 'https://spherestacking.fanbox.cc/posts/7645124',
        'patreon' => 'https://www.patreon.com/SphereStacking',
        'patreon_post' => 'https://www.patreon.com/posts/gozhi-yuan-103705539?utm_medium=clipboard_copy&utm_source=copyLink&utm_campaign=postshare_creator&utm_content=join_link',
        'paypal' => 'https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=LEZH4L3FZK4ZU&currency_code=JPY',
    ],

    'gravatar' => [
        'profile' => 'https://www.gravatar.com/avatar/',
    ],
];
