<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=sippm-del',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'assetManager' => [
            'bundles' => [
                'wbraganca\dynamicform\DynamicFormAsset' => [
                    'sourcePath' => '@app/web/js',
                    'js' => [
                        '..\..\frontend\web\js\yii2-dynamic-form.js'
                    ],
                ],
            ],
        ],
    ],
    'modules' => [
        'redactor' => 'yii\redactor\RedactorModule',
    ],
    // 'params' => $params
];
