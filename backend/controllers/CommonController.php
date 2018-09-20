<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/6
 * Time: 15:04
 */

namespace backend\controllers;

use backend\models\Admin;
use yii\web\Controller;
use Yii;

class CommonController extends Controller
{
    private $adminModel;
    public function init()
    {
        parent::init();
        $this->adminModel=new Admin();
    }

    public function beforeaction($action){
        //判断用户是否已登录
        if (!isset(Yii::$app->session['userInfo'])) {
            //跳转到登录界面
            $this->redirect(['/site/login']);
        } else {
            //判断用户是否启用
            $state = $this->adminModel->checkState(Yii::$app->session['userInfo']['id']);
            if(!empty($state) && $state['state']==1){
                return true;
            }else{
                //删除session，并跳转到登录界面
                unset(Yii::$app->session['userInfo']);
                $this->redirect(['/site/login']);
            }
        }
    }

}