<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/12
 * Time: 14:13
 */

namespace backend\models;


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

}