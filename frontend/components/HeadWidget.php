<?php
/*
*Created by PhpStorm
*User: Liang
*Date: 2016/11/28
*Time: 15:58
*/


namespace frontend\components;

use yii\base\Widget;
use yii;

class HeadWidget extends Widget
{
    public function run(){
        return $this->render('@app/views/site/_head');
    }
}