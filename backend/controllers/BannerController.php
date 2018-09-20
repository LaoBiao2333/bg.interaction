<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/12
 * Time: 9:36
 */

namespace backend\controllers;

use backend\models\Banner;
use backend\models\Config;
use Yii;
use yii\data\Pagination;
use yii\helpers\Json;

class BannerController extends CommonController
{
    public $enableCsrfValidation = false;
    public $layout = false;
    public $bannerModel;
    public $configModel;
    public $con_prefix;
    public function init(){
        parent::init(); // TODO: Change the autogenerated stub
        $this->bannerModel = new Banner();
        $this->configModel = new Config();
        //图片访问路径前缀
        $prefix = $this->configModel->find()->select('con_prefix')->asArray()->one();
        $this->con_prefix = $prefix['con_prefix'];
    }
    /*
     * PC端轮播图列表
     */
    public function actionBanner_pc(){

        return $this->render('banner_pc',['con_prefix'=>$this->con_prefix]);
    }
    public function actionPc_data(){
        //获取分页的page和limit
        $get_data = Yii::$app->request->get();
        //每页条数
        $get_data['limit'] = $get_data['limit']?$get_data['limit']:10;
        //读取数据并进行分页
        $banner = $this->bannerModel->find()->where(['ban_ispc'=>1]);
        $pages = new Pagination(['totalCount'=>$banner->count(),'pageSize'=>$get_data['limit']]);
        $list = $banner->offset($pages->offset)->limit($pages->limit)->orderBy('ban_level DESC')->asArray()->all();
        //总条数
        $totalCount = $pages->totalCount;
        //转换成json格式
        $list_json = Json::encode($list);
        //拼接json数据
        $json_data = '{"code":0,"msg":"","count":'.$totalCount.',"data":'.$list_json.'}';
        return $json_data;
    }
    /*
     * 移动端轮播图列表
     */
    public function actionBanner_wap(){
        return $this->render('banner_wap',['con_prefix'=>$this->con_prefix]);
    }
    public function actionWap_data(){
        //获取分页的page和limit
        $get_data = Yii::$app->request->get();
        //每页条数
        $get_data['limit'] = $get_data['limit']?$get_data['limit']:10;
        //读取数据并进行分页
        $banner = $this->bannerModel->find()->where(['ban_ispc'=>2]);
        $pages = new Pagination(['totalCount'=>$banner->count(),'pageSize'=>$get_data['limit']]);
        $list = $banner->offset($pages->offset)->limit($pages->limit)->orderBy('ban_level DESC')->asArray()->all();
        //总条数
        $totalCount = $pages->totalCount;
        //转换成json格式
        $list_json = Json::encode($list);
        //拼接json数据
        $json_data = '{"code":0,"msg":"","count":'.$totalCount.',"data":'.$list_json.'}';
        return $json_data;
    }
    /*
     * 添加轮播图
     */
    public function actionBanner_add(){
        if(Yii::$app->request->isPost){
            //接收提交的数据
            $post = Yii::$app->request->post();
            //判断是否有上传图片
            if ($_FILES["Banner"]['error']['ban_img'] == 0) {
                //图片保存路径
                if($post['Banner']['ban_ispc']==1){
                    $picUrl = 'uploads/banner/pc';
                }elseif($post['Banner']['ban_ispc']==2){
                    $picUrl = 'uploads/banner/wap';
                }else{
                    $picUrl = 'uploads/banner';
                }
                //上传图片
                $upload = Yii::$app->imgoperate->UploadImg($this->bannerModel,'ban_img',$picUrl,Yii::getAlias('@frontend').'/web',false);
                //图片上传成功
                if($upload['code'] == 1){
                    //图片路径
                    $post['Banner']['ban_img'] = $upload['img_url'];
                }else{
                    $data['code'] = 0;
                    $data['msg'] = $upload['msg'];
                    return Json::encode($data);
                }
            }
            //状态赋值
            if(isset($post['Banner']['ban_state']) && $post['Banner']['ban_state'] == 'on'){
                $post['Banner']['ban_state'] = 1;
            }else{
                $post['Banner']['ban_state'] = 0;
            }
            //添加数据
            $this->bannerModel->load($post);
            if($this->bannerModel->save(false)){
                $data['code'] = 1;
                $data['msg'] = '添加成功!';
                return Json::encode($data);
            }else{
                $data['code'] = 0;
                $data['msg'] = '添加失败!';
                return Json::encode($data);
            }
        }else{
            //pc或移动
            $ban_ispc = Yii::$app->request->get('ban_ispc');
            //如果没有值，默认是PC
            $ban_ispc = $ban_ispc?$ban_ispc:1;
            return $this->render('banner_add',['ban_ispc'=>$ban_ispc]);
        }
    }
    /*
     * 修改轮播图
     */
    public function actionBanner_edit(){
        if(Yii::$app->request->isPost){
            //接收提交的数据
            $post = Yii::$app->request->post();
            //判断是否有上传图片
            if($_FILES["Banner"]['error']['ban_img'] == 0){
                //图片保存路径
                if($post['Banner']['ban_ispc']==1){
                    $picUrl = 'uploads/banner/pc';
                }elseif($post['Banner']['ban_ispc']==2){
                    $picUrl = 'uploads/banner/wap';
                }else{
                    $picUrl = 'uploads/banner';
                }
                //上传图片
                $upload = Yii::$app->imgoperate->UploadImg($this->bannerModel,'ban_img',$picUrl,Yii::getAlias('@frontend').'/web',false);
                //图片上传成功
                if($upload['code'] == 1){
                    //图片路径
                    $post['Banner']['ban_img'] = $upload['img_url'];
                    //删除旧图
                    $ban_img = $this->bannerModel->find()->select('ban_img')->where(['id'=>$post['Banner']['id']])->asArray()->one();
                    $old_path = Yii::getAlias('@frontend').'/web'.$ban_img['ban_img'];
                    @unlink($old_path);
                }else{
                    $data['code'] = 0;
                    $data['msg'] = $upload['msg'];
                    return Json::encode($data);
                }
            }
            //状态赋值
            if(isset($post['Banner']['ban_state']) && $post['Banner']['ban_state'] == 'on'){
                $post['Banner']['ban_state'] = 1;
            }else{
                $post['Banner']['ban_state'] = 0;
            }
            //修改数据
            if ($this->bannerModel->updateAll($post['Banner'],['id'=>$post['Banner']['id']])){
                $data['code'] = 1;
                $data['msg'] = '修改成功!';
                return Json::encode($data);
            } else {
                $data['code'] = 0;
                $data['msg'] = '修改失败!';
                return Json::encode($data);
            }
        }else{
            //获取ID
            $id = Yii::$app->request->get('id');
            if($id){
                //根据ID查询要修改的数据
                $banner_info = $this->bannerModel->find()->where(['id'=>$id])->asArray()->one();
                if($banner_info){
                    return $this->render('banner_edit',['banner_info'=>$banner_info,'con_prefix'=>$this->con_prefix]);
                }else{
                    return $this->redirect(['/site/error_404', '该数据不存在!']);
                }
            }else{
                return $this->redirect(['/site/error_404', '参数错误!']);
            }
        }
    }
    /*
     * 删除轮播图
     */
    public function actionBanner_del(){
        if(Yii::$app->request->isPost){
            //获取ID
            $id = Yii::$app->request->post("id");
            //获取图片地址
            $ban_img = $this->bannerModel->find()->select('ban_img')->where(['id'=>$id])->asArray()->one();
            //删除数据
            if ($this->bannerModel->findOne($id)->delete()){
                //删除旧图
                if($ban_img['ban_img']){
                    $old_path = Yii::getAlias('@frontend').'/web'.$ban_img['ban_img'];
                    @unlink($old_path);
                }
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