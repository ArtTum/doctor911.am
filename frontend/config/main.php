<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);
$trustedProxyConfig = require __DIR__ . '/../../common/config/trusted-proxies.php';

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => array_merge([
            'csrfParam' => '_csrf-frontend',
            'baseUrl' => '',
            'csrfCookie' => [
                'httpOnly' => true,
                'secure' => YII_ENV_PROD,
                'sameSite' => \yii\web\Cookie::SAME_SITE_LAX,
            ],
        ], $trustedProxyConfig),
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => [
                'name' => '_identity-frontend',
                'httpOnly' => true,
                'secure' => YII_ENV_PROD,
                'sameSite' => \yii\web\Cookie::SAME_SITE_LAX,
            ],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
            'cookieParams' => [
                'httponly' => true,
                'secure' => YII_ENV_PROD,
                'samesite' => \yii\web\Cookie::SAME_SITE_LAX,
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                    'logVars' => [],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '/' => 'site/index',
                '<language:(ru|en)>' => 'site/index',
                'add-subscribe' => 'site/add-subscribe',
                'captcha' => 'site/captcha',


                [
                    'pattern' => 'services',
                    'route' => 'site/services',
                ],
                [
                    'pattern' => '<language:(ru|en)>/services',
                    'route' => 'site/services',
                ],
                [
                    'pattern' => 'contact',
                    'route' => 'site/contact',
                ],
                [
                    'pattern' => '<language:(ru|en)>/contact',
                    'route' => 'site/contact',
                ],
                [
                    'pattern' => 'page/<alias>',
                    'route' => 'site/page',
                ],
                [
                    'pattern' => '<language:(ru|en)>/page/<alias>',
                    'route' => 'site/page',
                ],
                [
                    'pattern' => 'doctors',
                    'route' => 'doctors/index',
                ],
                [
                    'pattern' => 'doctors/hospital-<hospital>/profession-<profession>/<page>',
                    'route' => 'doctors/index',
                    'defaults' => ['page' => 1],
                ],
                [
                    'pattern' => 'doctors/hospital-<hospital>/<page>',
                    'route' => 'doctors/index',
                    'defaults' => ['page' => 1],
                ],
                [
                    'pattern' => 'doctors/<page>',
                    'route' => 'doctors/index',
                    'defaults' => ['page' => 1],
                ],
                [
                    'pattern' => '<language:(ru|en)>/doctors/<page>',
                    'route' => 'doctors/index',
                    'defaults' => ['page' => 1],
                ],
                [
                    'pattern' => 'gallery/<alias>',
                    'route' => 'doctors/gallery',
                ],
                [
                    'pattern' => '<language:(ru|en)>/gallery/<alias>',
                    'route' => 'doctors/gallery',
                ],

                [
                    'pattern' => 'plastic-surgeon/<page>',
                    'route' => 'doctors/plastic-surgeon',
                    'defaults' => ['page' => 1],
                ],
                [
                    'pattern' => '<language:(ru|en)>/plastic-surgeon/<page>',
                    'route' => 'doctors/plastic-surgeon',
                    'defaults' => ['page' => 1],
                ],

                [
                    'pattern' => 'service-doctor/<alias>/<page>',
                    'route' => 'doctors/service-doctor',
                    'defaults' => ['page' => 1],
                ],
                [
                    'pattern' => '<language:(ru|en)>/service-doctor/<alias>/<page>',
                    'route' => 'doctors/service-doctor',
                    'defaults' => ['page' => 1],
                ],

                [
                    'pattern' => 'search/<search_text>',
                    'route' => 'site/search',
                    'defaults' => ['search_text' => null],
                ],
                [
                    'pattern' => '<language:(ru|en)>/search/<search_text>',
                    'route' => 'site/search',
                    'defaults' => ['search_text' => null],
                ],
                [
                    'pattern' => '<language:(ru|en)>/disease-directory/<letter>',
                    'route' => 'disease-directory/index',
                    'defaults' => ['letter' => 'А'],
                ],
                [
                    'pattern' => 'disease-directory/<letter>',
                    'route' => 'disease-directory/index',
                    'defaults' => ['letter' => 'А'],
                ],
                [
                    'pattern' => '<language:(ru|en)>/disease/<alias>',
                    'route' => 'disease-directory/disease',
                ],
                [
                    'pattern' => 'disease/<alias>',
                    'route' => 'disease-directory/disease',
                ],

                [
                    'pattern' => '<language:(ru|en)>/news/<page>',
                    'route' => 'news/index',
                    'defaults' => ['page' => 1],
                ],
                [
                    'pattern' => 'news/<page>',
                    'route' => 'news/index',
                    'defaults' => ['page' => 1],
                ],
                [
                    'pattern' => '<language:(ru|en)>/single-news/<alias>',
                    'route' => 'news/single-news',
                ],
                [
                    'pattern' => 'single-news/<alias>',
                    'route' => 'news/single-news',
                ],

                'doctor/<alias>' => 'doctors/doctor',
                '<language:(ru|en)>/doctor/<alias>' => 'doctors/doctor',


                '<type>' => 'hospitals/index',
                '<language:(ru|en)>/<type>' => 'hospitals/index',

                '<type>/<alias>' => 'hospitals/hospital',
                '<language:(ru|en)>/<type>/<alias>' => 'hospitals/hospital',


            ],
        ],

    ],
    'params' => $params,
    // 'language' => Yii::$app->language,
];
