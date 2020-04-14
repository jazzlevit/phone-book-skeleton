<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'console\controllers',
    'components' => [
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\DbTarget',
                    'logTable' => '{{%app_log_console}}',
                    'levels' => [
                        'error',
                        'warning',
                        'info',
                        // 'trace',
                        // 'profile',
                    ],
                    'except' => [
                        'yii\web\Session::open', 'yii\db\Command::query', 'yii\db\Connection::open'
                    ],
                    'logVars' => [],
                ],
            ],
        ],
    ],
    'params' => $params,
];
