<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/10
 * Time: 13:52
 */

namespace backend\models;

use common\helps\crypto;

class Admin extends \yii\db\ActiveRecord
{
    public static function tableName(){
        return 'in_admin';
    }

    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            [['username'], 'string', 'max' => 255],
            [['password'], 'string', 'max' => 255],
            [['login_time'], 'string', 'max' => 255],
            [['login_ip'], 'string', 'max' => 255],
            [['state'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '管理员名称',
            'password' => '密码',
            'login_time' => '登录时间',
            'login_ip' => '登录IP',
            'state' => '管理员状态',
        ];
    }

    /*
     * 管理员登录验证
     */
    public function getLogin($post){
        //用户名
        $username = $post['username'];
        //密码
        $password = $post['password'];
        //根据用户名查找用户信息
        $admin_data = $this->find()->where(['username'=>$username])->asArray()->one();
        if(!$admin_data){
            $data['code'] = 0;
            $data['msg'] = '用户名错误，请重新输入!';
            return $data;
        }else{
            //判断该用户是否被禁用
            if($admin_data['state']==0){
                $data['code'] = 0;
                $data['msg'] = '该用户已被禁用!';
                return $data;
            }
            //验证密码
            $key = 'hdsw';
            $crypt = new crypto();
            if($password == $crypt->decrypt($admin_data['password'],$key)){
                //设置登录session
                $session = \Yii::$app->session;
                //开启session
                if($session->isActive){
                    $session->open();
                }
                $session['userInfo'] = [
                    "id" => $admin_data['id'],
                    'username' => $admin_data['username'],
                ];
                //更改该用户信息
                @self::updateAll(['login_time' => time(), 'login_ip' => \Yii::$app->request->userIP], ['id' => $admin_data['id']]);
                //登录成功
                $data['code'] = 1;
                $data['msg'] = '登录成功!';
                return $data;
            }else{
                $data['code'] = 0;
                $data['msg'] = '密码错误，请重新输入!';
                return $data;
            }
        }
    }

    //检查用户是否启用
    public function checkState($id)
    {
        return $this->find()->select('state')->where(['id' => $id])->asArray()->one();
    }
    //通过ID查找管理员
    public function getAdminByid($id)
    {
        return $this->find()->where(['id'=>$id])->asArray()->one();
    }
    //检查账号是否重复
    public function checkName($username,$id)
    {
        return $this->find()->where(['username' => $username])->andWhere(['<>', 'id', $id])->asArray()->one();
    }

}