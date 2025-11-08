<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => 'your-secret-key',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'class' => 'webvimark\modules\UserManagement\components\UserConfig',
            'on afterLogin' => function ($event) {
                \webvimark\modules\UserManagement\models\UserVisitLog::newVisitor($event->identity->id);
            },
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
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
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [],
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'cache' => 'cache', // Tambahan: untuk caching RBAC
        ],
    ],
    'modules' => [
        'user-management' => [
            'class' => 'webvimark\modules\UserManagement\UserManagementModule',
            'enableRegistration' => true,
            'useEmailAsLogin' => false,
            'emailConfirmationRequired' => false,
            'rolesAfterRegistration' => ['Kasir'], // default role
            'userCanHaveMultipleRoles' => false,
            'passwordRegexp' => '/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/',

            'on beforeAction' => function (yii\base\ActionEvent $event) {
                if (in_array($event->action->uniqueId, [
                    'user-management/auth/login',
                    'user-management/auth/registration'
                ])) {
                    $event->action->controller->layout = '@app/views/layouts/login.php';
                }
            },
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
