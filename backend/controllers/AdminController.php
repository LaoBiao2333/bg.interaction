<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/10
 * Time: 17:17
 */

namespace backend\controllers;

use backend\models\Admin;
use yii\data\Pagination;
use yii\helpers\Json;
use Yii;
use common\helps\crypto;

class AdminController extends CommonController
{
    public $enableCsrfValidation = false;
    public $layout = false;
    public $adminModel;
    public $crypt;
    public $key = 'hdsw';
    public function init(){
        parent::init(); // TODO: Change the autogenerated stub
        $this->adminModel = new Admin();
        $this->crypt = new crypto();
    }

    /*
     * 管理员列表
     */
    public function actionAdmin_list(){
        return $this->render('admin_list');
    }
    public function actionAdmin_data(){
        //获取分页的page和limit
        $get_data = Yii::$app->request->get();
        //每页条数
        $get_data['limit'] = $get_data['limit']?$get_data['limit']:10;
        //读取管理员数据并进行分页
        $admin = $this->adminModel->find();
        $pages = new Pagination(['totalCount'=>$admin->count(),'pageSize'=>$get_data['limit']]);
        $list = $admin->offset($pages->offset)->limit($pages->limit)->asArray()->all();
        //转换时间格式
        foreach ($list as $key=>$value){
            $list[$key]['login_time'] = $value['login_time']?date('Y/m/d H:i:s',$value['login_time']):'';
        }
        //总条数
        $totalCount = $pages->totalCount;
        //转换成json格式
        $list_json = Json::encode($list);
        //拼接json数据
        $json_data = '{"code":0,"msg":"","count":'.$totalCount.',"data":'.$list_json.'}';
        return $json_data;
    }
    /*
     * 添加管理员
     */
    public function actionAdmin_add(){
        if(Yii::$app->request->isAjax){
            //接收提交的数据
            $post = Yii::$app->request->post();
            //去除空格
            $post['Admin']['username'] = trim($post['Admin']['username']);
            $post['Admin']['password'] = trim($post['Admin']['password']);
            $post['Admin']['pwd_repeat'] = trim($post['Admin']['pwd_repeat']);
            //判断两次输入的密码是否一致
            if($post['Admin']['password'] != $post['Admin']['pwd_repeat']){
                $data['code'] = 0;
                $data['msg'] = '两次密码不一致!';
                return Json::encode($data);
            }

            //判断用户名是否重复
            $one = $this->adminModel->find()->where(['username'=>$post['Admin']['username']])->asArray()->one();
            if($one){
                $data['code'] = 0;
                $data['msg'] = '该账号已存在,请添加其他账号!';
                return Json::encode($data);
            }else{
                $this->adminModel->load($post);
                //用户状态赋值
                if(isset($post['Admin']['state']) && $post['Admin']['state'] == 'on'){
                    $this->adminModel->state = 1;
                }else{
                    $this->adminModel->state = 0;
                }
                //加密密码
                $this->adminModel->password = $this->crypt->encrypt($post['Admin']['password'],$this->key);
                //添加数据
                if($this->adminModel->save(false)){
                    $data['code'] = 1;
                    $data['msg'] = '添加成功!';
                    return Json::encode($data);
                }else{
                    $data['code'] = 0;
                    $data['msg'] = '添加失败!';
                    return Json::encode($data);
                }
            }
        }else{
            return $this->render('admin_add');
        }
    }
    /*
     * 修改管理员
     */
    public function actionAdmin_edit(){
        if(Yii::$app->request->isPost){
            //接收提交的数据
            $post = Yii::$app->request->post();
            //去除空格
            $post['Admin']['username'] = trim($post['Admin']['username']);
            //判断用户名是否重复
            if($this->adminModel->checkName($post['Admin']['username'], $post['Admin']['id'])){
                $data['code'] = 0;
                $data['msg'] = '该账号已存在,请添加其他账号!';
                return Json::encode($data);
            }else{
                //用户状态赋值
                if(isset($post['Admin']['state']) && $post['Admin']['state'] == 'on'){
                    $post['Admin']['state'] = 1;
                }else{
                    $post['Admin']['state'] = 0;
                }
                //修改数据
                if ($this->adminModel->updateAll($post['Admin'],['id'=>$post['Admin']['id']])) {
                    $data['code'] = 1;
                    $data['msg'] = '修改成功!';
                    return Json::encode($data);
                } else {
                    $data['code'] = 0;
                    $data['msg'] = '修改失败!';
                    return Json::encode($data);
                }
            }
        }else{
            //获取id
            $id = Yii::$app->request->get('id');
            if($id){
                //根据ID查询管理员信息
                $admin_info = $this->adminModel->find()->where(['id'=>$id])->asArray()->one();
                if($admin_info){
                    return $this->render('admin_edit',['admin_info'=>$admin_info]);
                }else{
                    return $this->redirect(['/site/error_404', '该数据不存在!']);
                }
            }else{
                return $this->redirect(['/site/error_404', '参数错误!']);
            }

        }
    }
    /*
     * 修改密码
     */
    public function actionAdmin_pwd(){
        if(Yii::$app->request->isPost){
            //接收提交的数据
            $post = Yii::$app->request->post();
            //去除空格
            $post['Admin']['username'] = trim($post['Admin']['username']);
            $post['Admin']['password'] = trim($post['Admin']['password']);
            $post['Admin']['pwd_repeat'] = trim($post['Admin']['pwd_repeat']);
            //判断两次输入的密码是否一致
            if($post['Admin']['password'] != $post['Admin']['pwd_repeat']){
                $data['code'] = 0;
                $data['msg'] = '两次密码不一致!';
                return Json::encode($data);
            }else{
                //删除确认密码
                unset($post['Admin']['pwd_repeat']);
                //md5加密密码
                $post['Admin']['password'] = $this->crypt->encrypt($post['Admin']['password'],$this->key);
                //修改密码
                if ($this->adminModel->updateAll($post['Admin'],['id'=>$post['Admin']['id']])) {
                    $data['code'] = 1;
                    $data['msg'] = '修改密码成功!';
                    return Json::encode($data);
                } else {
                    $data['code'] = 0;
                    $data['msg'] = '修改密码失败!';
                    return Json::encode($data);
                }
            }
        }else{
            //获取id
            $id = Yii::$app->request->get('id');
            if($id){
                //根据ID查询管理员信息
                $admin_info = $this->adminModel->find()->where(['id'=>$id])->asArray()->one();
                if($admin_info){
                    return $this->render('admin_pwd',['admin_info'=>$admin_info]);
                }else{
                    return $this->redirect(['/site/error_404', '该数据不存在!']);
                }
            }else{
                return $this->redirect(['/site/error_404', '参数错误!']);
            }
        }
    }
    /*
     * 删除管理员
     */
    public function actionAdmin_del(){
        if(Yii::$app->request->isPost){
            //获取id
            $id = Yii::$app->request->post("id");
            //删除数据
            if ($this->adminModel->findOne($id)->delete()) {
                $info['code'] = 1;
                $info['msg'] = "删除成功!";
                return Json::encode($info);
            } else {
                $info['code'] = 0;
                $info['msg'] = "删除失败!";
                return Json::encode($info);
            }
        }
    }

}