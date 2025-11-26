<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'defaultRoute' => 'restaran/index',

    'components' => [
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'locale' => 'en-EN',
        ],
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'frontend\models\UserModel',
            'enableAutoLogin' => true,
            'loginUrl' => ['auth/login'],
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
            'class' => 'yii\web\Session',
            'timeout' => 3600 * 24,
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
            'languages' => ['ru', 'en', 'uz'],

            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'login' => 'auth/login',
                'signup' => 'auth/signup',
                'logout' => 'auth/logout',

                'order/status/<status:\w+>/sort/<sort:[\w\-]+>' => 'order/index',
                'order/status/<status:\w+>' => 'order/index',
                'order/sort/<sort:[\w\-]+>' => 'order/index',

                'order/create/<id:\d+>' => 'order/create',

                '<controller>/page/<page:\d+>' => '<controller>/index',
                'restaran/category/<category:\d+>' => 'restaran/index',
                'restaran/category/<category:\d+>/page/<page:\d+>' => 'restaran/index',
                '<controller>/<id:\d+>' => '<controller>/view',

                '<controller>' => '<controller>/index',
            ],
        ],

    ],
    'params' => $params,
];
