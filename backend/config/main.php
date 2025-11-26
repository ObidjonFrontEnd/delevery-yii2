<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],

    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'locale' => 'en-EN',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
            'class' => 'codemix\localeurls\UrlManager',
            'languages' => ['en', 'uz', 'ru'],
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                // Красивый URL с языком и ID
                '<controller>/<action>/<id:\d+>' => '<controller>/<action>',

                // Другие правила
                'dashboard/year/<year:\d{4}>' => 'site/index',
                'dashboard' => 'site/index',
            ],
        ],

        'i18n' => [
            'translations' => [
                '*'=>[
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common\messages',
                    'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'app' => 'app.php',
                        'language'=>'lan.php',
                    ]
                ],
            ]
        ],

    ],
    'params' => $params,
];
