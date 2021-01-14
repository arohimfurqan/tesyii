<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';


$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'id-ID',
    'sourceLanguage' => 'en-US',
    // 'catchAll' => [
    //     'site/maintenance',
    // ],
    'on beforeRequest' => function () {
        $db = Yii::$app->db;
        $maintenance = $db->createCommand("SELECT * FROM setting WHERE nama_setting='maintenance'")->queryOne();
        if ($maintenance['value'] == 'yes') {
            Yii::$app->catchAll = ['site/maintenance'];
        }
    },


    // 'on beforeAction' => function ($event) {
    //     $action = $event->action;
    //     $moduleID = $action->controller->module->id;
    //     $controllerID = $action->controller->id;
    //     $actionID = $action->id;
    //     $user = \Yii::$app->user;
    //     $userID = $user->id;
    //     if (!in_array($controllerID, ['default', 'site'])) {
    //         $auth = \app\models\Auth::find()
    //             ->where([
    //                 'module' => $moduleID,
    //                 'controller' => $controllerID,
    //                 'action' => $actionID,
    //                 'user_id' => $userID,
    //             ])
    //             ->count();
    //         if ($auth == 0) {
    //             if (!$action instanceof \yii\web\ErrorAction) {
    //                 if ($user->getIsGuest()) {
    //                     $user->loginRequired();
    //                 } else {
    //                     throw new \yii\web\ForbiddenHttpException('Anda tidak diizinkan untuk mengakses halaman ' . $action->id . ' ini!');
    //                 }
    //             }
    //         }
    //     }
    // },
    'timeZone' => 'Asia/Jakarta',
    'modules' => [
        'admin' => [
            'class' => 'app\modules\admin\Module',
        ],
        'mimin' => [
            'class' =>  '\hscstudio\mimin\Module',
        ],

    ],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],

    'as access' => [
        'class' =>  '\hscstudio\mimin\components\AccessControl',
        'allowActions' => [
            // add wildcard allowed action here!
            'site/*',
            // 'debug/*',
            // 'site/successCallback',
            // 'site/safeAttributes',
            // 'site/auth',
            'book-rest/*',
            'province-rest/*',

            'mimin/*', // only in dev mode
        ],
    ],

    'components' => [
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    //'basePath' => '@app/messages',
                    //'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'app' => 'app.php',
                        'app/error' => 'error.php',
                    ],
                ],
            ],
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                ['class' => 'yii\rest\UrlRule', 'controller' => 'book-rest', 'pluralize' => false,],
            ],
        ],
        'authManager' => [
            // 'class' => 'yii\rbac\PhpManager',
            'class' => 'yii\rbac\DbManager',
        ],
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'facebook' => [
                    'class' => 'yii\authclient\clients\Facebook',
                    'clientId' => '244148970455250',
                    'clientSecret' => 'b93c275b8ee007837a1cef8e447a7b9a',
                ],
                'google' => [
                    'class' => 'yii\authclient\clients\Google',
                    'clientId' => '700372965707-t594d0avjivq5fjeqat7rptncoi7j9la.apps.googleusercontent.com',
                    'clientSecret' => '4DdJwuuJmlATiZcjlRPCppn4',
                ],
                // 'twitter' => [
                //     'class' => 'yii\authclient\clients\Twitter',
                //     'consumerKey' => 'twitter_consumer_key',
                //     'consumerSecret' => 'twitter_consumer_secret',
                // ],
                // 'github' => [
                //     'class' => 'yii\authclient\clients\GitHub',
                //     'clientId' => 'github_client_id',
                //     'clientSecret' => 'github_client_secret',
                // ],
            ],
        ],

        // 'formatter' => [
        //     'class' => 'yii\i18n\Formatter',
        //     'dateFormat' => 'yyyy-mm-dd',
        //     'datetimeFormat' => ',=yyyy-mm-dd H:i:s',
        //     'timeFormat' => 'H:i:s',



        // ],


        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'dvIB5aSmDRwXgEnCSArmXCjCg9PTlB3r',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]

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
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => 'lovela97famazera@gmail.com',
                'password' => '02lovela97',
                'port' => '587',
                'encryption' => 'tls',
            ],

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
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
