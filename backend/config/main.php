<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'defaultRoute'=> 'site/login',//设置默认访问的控制器和方法
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
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
            'errorAction' => 'site/error_404',
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
            ],
        ],
        //上传图片类
        'imgoperate'=>[
            'class'=>'backend\components\Images',
        ],
    ],
    'params' => $params,
];
