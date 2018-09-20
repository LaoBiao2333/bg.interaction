<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/11
 * Time: 11:45
 */

namespace backend\models;


class Config extends \yii\db\ActiveRecord
{
    public static function tableName(){
        return 'in_config';
    }

    public function rules()
    {
        return [
            [['con_logo','con_title','con_keywords','con_descriptions','con_company','con_address','con_copyright'], 'required'],
            [['con_logo','con_title','con_keywords','con_prefix'], 'string', 'max' => 255],
            [['con_company','con_address','con_copyright'], 'string', 'max' => 150],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'con_logo' => 'LOGO图片地址',
            'con_title' => '三大标签-标题',
            'con_keywords' => '三大标签-关键词',
            'con_descriptions' => '三大标签-描述',
            'con_company' => '公司名称',
            'con_address' => '公司地址',
            'con_copyright' => '版权',
            'con_webscript_pc' => 'PC端底部统计代码',
            'con_webscript_m' => '移动端底部统计代码',
            'con_prefix' => '图片访问路径前缀',
        ];
    }

}