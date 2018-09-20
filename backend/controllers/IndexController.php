<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/10
 * Time: 15:17
 */

namespace backend\controllers;

use backend\models\Admin;
use Yii;

class IndexController extends CommonController
{
    public $enableCsrfValidation = false;
    public $layout = false;
    /*
     * 后台首页
     */
    public function actionIndex(){

        return $this->render('index');
    }
    /*
     * 网站基本参数
     */
    public function actionHome()
    {
        $user = Yii::$app->session['userInfo'];
        $admin = new Admin();
        $data = $admin->getAdminByid($user['id']);
        return $this->render('home', ['data' => $data]);
    }
}