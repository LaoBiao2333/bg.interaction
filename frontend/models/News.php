<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/12
 * Time: 14:13
 */

namespace frontend\models;

use common\helps\tools;

class News extends \yii\db\ActiveRecord
{
    public static function tableName(){
        return 'in_news';
    }

    public function rules()
    {
        return [
            [['new_title','new_keywords','new_descriptions','new_content','new_time'], 'required'],
            [['new_img'], 'string', 'max' => 255],
            [['new_title'], 'string', 'max' => 255],
            [['new_keywords'], 'string', 'max' => 255],
            [['new_descriptions','new_content'], 'string'],
            [['new_time'], 'string', 'max' => 255],
            [['new_number','new_state'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'new_img' => '新闻图片地址',
            'new_title' => '新闻标题',
            'new_keywords' => '新闻关键词',
            'new_descriptions' => '新闻描述',
            'new_content' => '新闻内容',
            'new_time' => '新闻发布时间',
            'new_number' => '新闻阅读量',
            'new_state' => '新闻发布状态：1发布，0未发布',
        ];
    }

    //首页新闻资讯
    public function getInformation($limit){
        $information = $this->find()->where(['new_state'=>1])->limit($limit)->orderBy('new_time DESC')->asArray()->all();
        //转换时间格式和截取新闻内容
        foreach($information as $key=>$value){
            $information[$key]['new_time'] = date('Y/m/d H:i',$value['new_time']);
            $information[$key]['new_content'] = tools::cutstr_html($value['new_content'],200);
        }
        return $information;
    }
    //热门推荐
    public function getHot($limit){
        $hot = $this->find()
            ->select('id,new_title')
            ->where(['new_state'=>1])
            ->limit($limit)
            ->orderBy('new_number DESC')
            ->asArray()->all();
        return $hot;
    }
    //新闻详情
    public function getDetail($id){
        //详情
        $detail = $this->find()->where(['new_state'=>1,'id'=>$id])->asArray()->one();
        $data = '';
        if($detail){
            //更新阅读量
            $detail['new_number'] = $detail['new_number']+1;
            $this->updateAll($detail,['id'=>$id]);
            //上一篇
            $prev = $this->find()->select('id,new_title')
                ->where(['new_state' => 1])
                ->andWhere('new_time>'.$detail['new_time'])
                ->orderBy('new_time asc')
                ->asArray()->one();
            if(empty($prev)){
                $prev = ['id' => 'javascript:;', 'new_title' => '暂无上一篇!'];
            }
            //下一篇
            $next = $this->find()->select('id,new_title')
                ->where(['new_state' => 1])
                ->andWhere('new_time<'.$detail['new_time'])
                ->orderBy('new_time desc')
                ->asArray()->one();
            if(empty($next)){
                $next = ['id' => 'javascript:;', 'new_title' => '暂无下一篇!'];
            }
            $data = ['detail'=>$detail,'prev'=>$prev,'next'=>$next];
            return $data;
        }else{
            return $data;
        }
    }

}