<?php

return [
    'name' => 'Affirm',
    'manifest' => [
        'name' => env('APP_NAME', 'Affirm'),
        'short_name' => 'Affirm',
        'start_url' => '/',
        'background_color' => '#729343',
        'theme_color' => '#096A2E',
        'display' => 'standalone',
        'orientation'=> 'any',
        'status_bar'=> 'black',
        'icons' => [
            '72x72' => [
                'path' => '/images/icons/android-launchericon-72-72.png',
                'purpose' => 'any'
            ],
            '96x96' => [
                'path' => '/images/icons/android-launchericon-96-96.png',
                'purpose' => 'any'
            ],
            '128x128' => [
                'path' => '/images/icons/128.png',
                'purpose' => 'any'
            ],
            '144x144' => [
                'path' => '/images/icons/android-launchericon-144-144.png',
                'purpose' => 'any'
            ],
            '152x152' => [
                'path' => '/images/icons/152.png',
                'purpose' => 'any'
            ],
            '192x192' => [
                'path' => '/images/icons/android-launchericon-192-192.png',
                'purpose' => 'any'
            ],
            '384x384' => [
                'path' => '/images/icons/256.png',
                'purpose' => 'any'
            ],
            '512x512' => [
                'path' => '/images/icons/android-launchericon-512-512.png',
                'purpose' => 'any'
            ],
        ],
        'splash' => [
            '640x1136' => '/images/spash_screens/4__iPhone_SE__iPod_touch_5th_generation_and_later_portrait.png',
            '750x1334' => '/images/icons/splash_screens/iPhone_8__iPhone_7__iPhone_6s__iPhone_6__4.7__iPhone_SE_portrait.png',
            '828x1792' => '/images/icons/splash_screens/iPhone_11__iPhone_XR_portrait.png',
            '1125x2436' => '/images/icons/splash_screens/iPhone_13_mini__iPhone_12_mini__iPhone_11_Pro__iPhone_XS__iPhone_X_portrait.png',
            '1242x2208' => '/images/icons/splash_screens/iPhone_8_Plus__iPhone_7_Plus__iPhone_6s_Plus__iPhone_6_Plus_portrait.png',
            '1242x2688' => '/images/icons/splash_screens/iPhone_11_Pro_Max__iPhone_XS_Max_portrait.png',
            '1536x2048' => '/images/icons/spash_screens/9.7__iPad_Pro__7.9__iPad_mini__9.7__iPad_Air__9.7__iPad_portrait.png',
            '1668x2224' => '/images/icons/splash_screens/10.5__iPad_Air_portrait.png',
            '1668x2388' => '/images/icons/splash_screens/11__iPad_Pro__10.5__iPad_Pro_portrait.png',
            '2048x2732' => '/images/icons/splash_screens/12.9__iPad_Pro_portrait.png',
        ],
        'shortcuts' => [
            [
                'name' => 'Affirm',
                'description' => 'Affirmations just a tap away',
                'url' => '/',
                'icons' => [
                    "src" => "/images/icons/android-launchericon-72-72.png",
                    "purpose" => "any"
                ]
            ],
            [
                'name' => 'Affirm',
                'description' => 'Your Daily Affirmations',
                'url' => '/'
            ]
        ],
        'custom' => []
    ]
];
