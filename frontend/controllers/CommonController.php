<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/6
 * Time: 11:56
 */

namespace frontend\controllers;

use yii\web\Controller;

class CommonController extends Controller
{
    public $enableCsrfValidation = false;
    public $layout = false;
    //404页面
    public function actionError(){
        return '404,页面走丢了~~~~';
    }

}