<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/params.php')
);

$common_params_local = __DIR__ . '/../../common/config/params-local.php';

if(file_exists($common_params_local)){
    $params = array_merge($params, require($common_params_local));
}

$params_local = __DIR__ . '/params-local.php';

if(file_exists($params_local)){
    $params = array_merge($params, require($params_local));
}

return [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'console\controllers',
    'controllerMap' => [
        'fixture' => [
            'class' => 'yii\console\controllers\FixtureController',
            'namespace' => 'common\fixtures',
          ],
    ],
    'components' => [
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'categories' => ['house_parser'], //категория логов
                    'logFile' => '@console/runtime/logs/house_parser.log', //куда сохранять
                    'logVars' => []
                ],
                [
                    'class' => 'common\components\loggers\TelegramTargetInfo', //в файл
                    'categories' => ['house_parser_telegram'], //категория логов
                    'logFile' => '@console/runtime/logs/house_parser2.log', //куда сохранять
                    'logVars' => [] //не добавлять в лог глобальные переменные ($_SERVER, $_SESSION...)
                ],
            ],
        ],
    ],
    'params' => $params,
];
