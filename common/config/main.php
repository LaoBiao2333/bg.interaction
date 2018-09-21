<?php
return [
    'language'=>"zh-CN",
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=interaction',
            'username' => 'root',
            'password' => '',
            'tablePrefix' => 'a50_',
            'charset' => 'utf8',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],


];
