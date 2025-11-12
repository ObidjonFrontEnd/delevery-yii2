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
    'language' => 'uz-UZ',
    'components' => [
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'locale' => 'uz-UZ',
        ],
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'frontend\models\UsersModel',
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
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'login' => 'auth/login',
                'signup' => 'auth/signup',
                'logout' => 'auth/logout',
                '<controller>/page/<page:\d+>' => '<controller>/index',
                '<controller>/category/<category:\d+>' => '<controller>/index',
                '<controller>/category/<category:\d+>/page/<page:\d+>' => '<controller>/index',
                '<controller>/<id:\d+>' => '<controller>/view',
                '<controller>' => '<controller>/index',
            ],
        ],

    ],
    'params' => $params,
];
