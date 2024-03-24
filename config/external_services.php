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
    'supportings'=>[
        'fanbox'=>'https://spherestacking.fanbox.cc',
    ],
    'gravatar' => [
        'profile' => 'https://www.gravatar.com/avatar/',
    ],
];
