<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/6
 * Time: 11:52
 */

namespace frontend\controllers;

use common\helps\tools;
use frontend\models\Config;
use frontend\models\Nav;
use frontend\models\News;
use yii\helpers\Json;
use yii\data\Pagination;
use Yii;

class NewsController extends CommonController
{
    public $enableCsrfValidation = false;
    public $layout = false;
    public $configModel;
    public $navModel;
    public $newsModel;
    public function init(){
        parent::init();
        $this->configModel = new Config();
        $this->navModel = new Nav();
        $this->newsModel = new News();
    }

    /*
     * 新闻中心
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
        //热门推荐
        $hot = $this->newsModel->getHot(4);
        //新闻列表
        $news = $this->newsModel->find()->where(['new_state'=>1]);
        $pages = new Pagination(['totalCount'=>$news->count(),'pageSize'=>5]);
        $list = $news->offset($pages->offset)->limit($pages->limit)->orderBy('new_time DESC')->asArray()->all();
        //转换时间格式和截取新闻内容
        foreach($list as $key=>$value){
            $list[$key]['new_time'] = date('Y/m/d H:i:s',$value['new_time']);
            $list[$key]['new_content'] = tools::cutstr_html($value['new_content'],250);
        }
        //var_dump($list);
        //总条数
        $totalCount = $pages->totalCount;
        //把所以数据转换成json格式
        $config_json = Json::encode($config);
        $header_json = Json::encode($header);
        $nav_json = Json::encode($nav);
        $hot_json = Json::encode($hot);
        $list_json = Json::encode($list);
        //拼接json数据
        $json_data = '{"config":'.$config_json.',"header":'.$header_json.',"nav":'.$nav_json.',"hot":'.$hot_json.',"list":'.$list_json.',"totalCount":'.$totalCount.'}';
        return $json_data;
    }
    /*
     * 新闻详情
     */
    public function actionDetail(){
        if(Yii::$app->request->get('id')){
            //获取新闻ID
            $id = Yii::$app->request->get('id');
            //基本设置信息
            $config = $this->configModel->getConfig();
            //导航
            $nav = $this->navModel->getNavList();
            //详情信息及上下篇
            $info = $this->newsModel->getDetail($id);
            if(empty($info)){
                //跳转到404页面
                return $this->redirect('common/error404');
            }
            //详情
            $detail = $info['detail'];
            //转换时间格式
            $detail['new_time'] = date('Y/m/d H:i',$detail['new_time']);
            //替换新闻内容中的图片访问路径前缀'{img}'为'$config['con_prefix']'
            $detail['new_content'] = str_replace('{img}',$config['con_prefix'],$detail['new_content']);
            //上一篇
            $prev = $info['prev'];
            //下一篇
            $next = $info['next'];
            //三大标签
            $header['title'] = $detail['new_title']?$detail['new_title']:$config['con_title'];
            $header['keywords'] = $detail['new_keywords']?$detail['new_keywords']:$config['con_keywords'];
            $header['descriptions'] = $detail['new_descriptions']?$detail['new_descriptions']:$config['con_descriptions'];
            //热门推荐
            $hot = $this->newsModel->getHot(4);
            //把所以数据转换成json格式
            $config_json = Json::encode($config);
            $header_json = Json::encode($header);
            $nav_json = Json::encode($nav);
            $detail_json = Json::encode($detail);
            $prev_json = Json::encode($prev);
            $next_json = Json::encode($next);
            $hot_json = Json::encode($hot);
            //拼接json数据
            $json_data = '{"config":'.$config_json.',"header":'.$header_json.',"nav":'.$nav_json.',"detail":'.$detail_json.',"prev":'.$prev_json.',"next":'.$next_json.',"hot":'.$hot_json.'}';
            return $json_data;
        }
    }
}