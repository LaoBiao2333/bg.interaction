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
    'defaultRoute'=> 'index/index',//设置默认访问的控制器和方法
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
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
        'errorHandler' => [
            'errorAction' => 'common/error404',
        ],
        //assets清除缓存
        'assetManager' => [
            'linkAssets' => true,
        ],
        //路由设置
        'urlManager' => [
            //开启美化url配置
            'enablePrettyUrl' => true,
            //隐藏index.php
            'showScriptName' => false,
            //启用严格解析，默认不启用
            'enableStrictParsing' => false,
            //定义后缀
            //'suffix' => '.html',
            'rules' => [
                '/'=>'index/index',
                'news/<id:\d+>.html'=>'news/detail',
                'news/<id:\d+>'=>'news/detail',
                'news/page_<page:\d+>'=>'news/index',
                '<controller:\w+>' => '<controller>/index',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ],
        ],
    ],
    'params' => $params,
];
