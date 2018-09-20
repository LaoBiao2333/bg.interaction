<?php

/*
*Created by PhpStorm
*User: Liang
*Date: 2016/9/8
*Time: 15:36
*/
namespace frontend\components;

use yii\base\Widget;


class NavWidget extends Widget
{
    public function run() {
        return $this->render('@app/views/site/_nav');
    }
}