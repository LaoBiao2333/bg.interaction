<?php
namespace backend\controllers;

use Yii;
use yii\helpers\Json;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\Admin;
use common\models\LoginForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    public $enableCsrfValidation = false;
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'captcha', 'login-validate','error_404'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        //'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            //验证码
            'captcha' => [
                'class' => 'backend\components\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'maxLength' => 4, //最大显示个数
                'minLength' => 4,//最少显示个数
                'padding' => 3,//间距
                'offset' => 4,//设置字符偏移量 有效果
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * 登录界面
     */
    public function actionLogin()
    {
        //判断是否登录
        if(isset(Yii::$app->session['userInfo'])){
            return $this->redirect(['index/index']);
        }else{
            $this->layout = false;
            return $this->render('login');
        }
    }
    /*
     * 登录验证
     */
    public function actionLoginValidate(){
        if(Yii::$app->request->isPost){
            //获取登录信息
            $post = Yii::$app->request->post();
            //验证码验证
            $yz = $this->createAction('captcha');
            $result = $yz->validate($post['code'],false);
            if(!$result){
                $data['code'] = 0;
                $data['msg'] = '验证码错误!';
                return Json::encode($data);
            }
            //登录账户密码验证
            $adminModel = new Admin();
            $res_data = $adminModel->getLogin($post);
            return Json::encode($res_data);
        }
    }

    /**
     * 退出登录
     */
    public function actionLogout(){
        if (isset(Yii::$app->session['userInfo'])){
            unset(Yii::$app->session['userInfo']);
            $data['code'] = 1;
            $data['msg'] = '退出成功!';
            return Json::encode($data);
        }
    }

    /*
     * 404页面
     */
    public function actionError_404(){
        $this->layout = false;
        if(Yii::$app->request->get()){
            if (Yii::$app->request->get('1')) {
                $message = Yii::$app->request->get('1');
            } else {
                $message = '页面被外星人挟持了!';
            }
        }else{
            $message = '页面被外星人挟持了!';
        }
        return $this->render('404',['message'=>$message]);
    }
}
