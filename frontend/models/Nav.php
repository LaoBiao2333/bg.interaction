<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/11
 * Time: 16:13
 */

namespace frontend\models;


class Nav extends \yii\db\ActiveRecord
{
    public static function tableName(){
        return 'in_nav';
    }

    public function rules()
    {
        return [
            [['nav_name', 'nav_url', 'nav_title', 'nav_keywords', 'nav_descriptions'], 'required'],
            [['nav_name'], 'string', 'max' => 50],
            [['nav_url'], 'string', 'max' => 255],
            [['nav_title'], 'string', 'max' => 255],
            [['nav_keywords'], 'string', 'max' => 255],
            [['nav_level','nav_state'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nav_name' => '导航名称',
            'nav_url' => '导航链接',
            'nav_title' => '导航三大标签-标题',
            'nav_keywords' => '导航三大标签-关键词',
            'nav_descriptions' => '导航三大标签-描述',
            'nav_level' => '导航优先级',
            'nav_state' => '导航状态：1显示，0不显示',
        ];
    }

    //获取导航列表
    public function getNavList(){
        $list = $this->find()
            ->where(['nav_state'=>1])
            ->orderBy('nav_level DESC')
            ->asArray()->all();
        return $list;
    }
    //获取导航三大标签
    public function getThreeLabel($nav_url){
        $three_label = $this->find()
            ->select('nav_title,nav_keywords,nav_descriptions')
            ->where(['nav_state'=>1,'nav_url'=>$nav_url])
            ->asArray()->one();
        return $three_label;
    }

}