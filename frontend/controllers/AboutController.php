<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/14
 * Time: 13:34
 */

namespace frontend\controllers;

use frontend\models\Config;
use frontend\models\Nav;
use yii\helpers\Json;
use Yii;

class AboutController extends CommonController
{
    public $enableCsrfValidation = false;
    public $layout = false;
    public $configModel;
    public $navModel;
    public function init(){
        parent::init();
        $this->configModel = new Config();
        $this->navModel = new Nav();
    }
    /*
     * 关于我们
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
        //把所以数据转换成json格式
        $config_json = Json::encode($config);
        $header_json = Json::encode($header);
        $nav_json = Json::encode($nav);
        //拼接json数据
        $json_data = '{"config":'.$config_json.',"header":'.$header_json.',"nav":'.$nav_json.'}';
        return $json_data;
    }

}