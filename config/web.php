<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'defaultRoute' => 'api',
    'components' => [
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules'=> [
                'api/v1'=>'api',
                'GET,HEAD,POST api/v1/<controller:\w+>/method/<method:\w+>' => 'api/<controller>/<method>',
                'GET,HEAD,POST api/v1/<controller:\w+>/method/<method:\w+>/<id:\w+>' => 'api/<controller>/<method>',
                'PUT,PATCH api/v1/<controller:\w+>/<id:\w+>' => 'api/<controller>/update',
                'DELETE api/v1/<controller:\w+>' => 'api/<controller>/delete_all',
                'DELETE api/v1/<controller:\w+>/<id:\w+>' => 'api/<controller>/delete',
                'POST api/v1/<controller:\w+>/' => 'api/<controller>/create',
                'GET,HEAD api/v1/<controller:\w+>' => 'api/<controller>/list',
                'GET,HEAD api/v1/<controller:\w+>/<id:\w+>' => 'api/<controller>/read',
            ],
        ],
        'request' => [
            'enableCookieValidation' => true,
            'enableCsrfValidation' => false,
            'cookieValidationKey' => 'xxxxxxx',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),

    ],
    'modules' => [
        'api' => [
            'class' => 'app\modules\api\v1\module',
        ],
    ],
    'params' => $params,
    'extensions' => require(__DIR__ . '/../vendor/yiisoft/extensions.php'),
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
//    $config['bootstrap'][] = 'debug';
//    $config['modules']['debug'] = 'yii\debug\Module';
//
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
//    $config['modules']['gii']['allowedIPs'] = ['*'];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['127.0.0.1', '::1', '50.62.10.149', '*'],
    ];
}

return $config;
