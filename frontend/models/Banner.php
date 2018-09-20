<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/12
 * Time: 9:38
 */

namespace frontend\models;


class Banner extends \yii\db\ActiveRecord
{
    public static function tableName(){
        return 'in_banner';
    }

    public function rules()
    {
        return [
            [['ban_img'], 'required'],
            [['ban_img'], 'string', 'max' => 255],
            [['ban_url'], 'string', 'max' => 255],
            [['ban_short_title'], 'string', 'max' => 255],
            [['ban_long_title'], 'string', 'max' => 255],
            [['ban_text'], 'string', 'max' => 255],
            [['ban_button'], 'string', 'max' => 50],
            [['ban_button_url'], 'string', 'max' => 255],
            [['ban_state','ban_ispc','ban_level'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ban_img' => '轮播图图片地址',
            'ban_url' => '轮播图链接',
            'ban_short_title' => '轮播图短标题',
            'ban_long_title' => '轮播图长标题',
            'ban_text' => '轮播图描述',
            'ban_button' => '轮播图按钮',
            'ban_button_url' => '轮播图按钮链接',
            'ban_level' => '轮播图优先级',
            'ban_state' => '轮播图状态：1展示，0不展示',
            'ban_ispc' => 'PC或移动：1PC，2移动',
        ];
    }

    //获取轮播图
    public function getBannerList($ban_ispc){
        $list = $this->find()->where(['ban_state'=>1,'ban_ispc'=>$ban_ispc])->orderBy('ban_level DESC')->asArray()->all();
        return $list;
    }

}