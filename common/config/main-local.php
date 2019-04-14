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
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => 'sippm.del@gmail.com',
                'password' => 'SistemInformasiProyekDel',
                'port' => '587',
                'encryption' => 'tls',
            ],
            'viewPath' => '@common/mail',
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
