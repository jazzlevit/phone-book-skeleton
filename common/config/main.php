<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            /*'transport' => [
               'class' => 'Swift_SmtpTransport',
               'host' => 'localhost',
               'username' => 'username',
               'password' => 'password',
               'port' => '587',
               'encryption' => 'tls',
           ],*/
        ],
        'formatter' => [
            'class' => '\yii\i18n\Formatter',
            'timeZone' => 'Europe/Kiev',
            'dateFormat' => 'y-MM-dd',
            'decimalSeparator' => '.',
            'thousandSeparator' => '',
            //'currencyCode' => 'EUR',
        ],
    ],
];
