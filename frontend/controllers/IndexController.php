<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/6
 * Time: 11:52
 */

namespace frontend\controllers;


use frontend\models\Banner;
use frontend\models\Config;
use frontend\models\Nav;
use frontend\models\News;
use yii\helpers\Json;
use Yii;

class IndexController extends CommonController
{
    public $enableCsrfValidation = false;
    public $layout = false;
    public $configModel;
    public $navModel;
    public $bannerModel;
    public $newsModel;
    public function init(){
        parent::init();
        $this->configModel = new Config();
        $this->navModel = new Nav();
        $this->bannerModel = new Banner();
        $this->newsModel = new News();
    }

    /*
     * 前台首页
     */
    public function actionIndex(){
        //获取当前URL
        $url = Yii::$app->request->url;
        //基本设置信息
        $config = $this->configModel->getConfig();
        //当前导航三大标签
        $three_label = $this->navModel->getThreeLabel($url);
        //三大标签
        $header['title'] = $three_label['nav_title']?$three_label['nav_title']:$config['con_title'];
        $header['keywords'] = $three_label['nav_keywords']?$three_label['nav_keywords']:$config['con_keywords'];
        $header['descriptions'] = $three_label['nav_descriptions']?$three_label['nav_descriptions']:$config['con_descriptions'];
        //导航
        $nav = $this->navModel->getNavList();
        //轮播图(PC端)
        $banner_pc = $this->bannerModel->getBannerList(1);
        //轮播图(移动端)
        $banner_wap = $this->bannerModel->getBannerList(2);
        //新闻资讯
        $information = $this->newsModel->getInformation(4);
        //把所以数据转换成json格式
        $config_json = Json::encode($config);
        $header_json = Json::encode($header);
        $nav_json = Json::encode($nav);
        $banner_pc_json = Json::encode($banner_pc);
        $banner_wap_json = Json::encode($banner_wap);
        $information_json = Json::encode($information);
        //拼接json数据
        $json_data = '{"config":'.$config_json.',"header":'.$header_json.',"nav":'.$nav_json.',"banner_pc":'.$banner_pc_json.',"banner_wap":'.$banner_wap_json.',"information":'.$information_json.'}';
        return $json_data;
    }
}