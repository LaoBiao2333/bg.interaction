<?php
/**
 * Created by PhpStorm.
 * User: Jerry
 * Date: 2016/10/10
 * Time: 8:49
 * 图片上传以及图片处理类
 *
 */
namespace backend\components;
use yii;
use yii\base\Component;
use yii\web\UploadedFile;
use yii\imagine\Image;
class Images extends Component{

    /**
     * 单一图片上传类(返回地址)
     * UploadImg($this->model, 'image', 'uploads/config, '../../frontend/web')
     * @param $model [实例化的模型]
     * @param $field [图片存储的字段]
     * @param $picUrl [图片保存的地址]
     * @param string $dir [图片保存的前缀，是当前目录还是前台目录]
     * @param boolean $isthumb    [是否要缩略图]
     * @return array
     */
    public function UploadImg($model, $field, $picUrl, $dir = '',$isthumb=false,$thumbwidth='180',$thumbheight='108')
    {
        $dir = empty($dir) ? $_SERVER['DOCUMENT_ROOT'] : $dir;
        $root = $dir . '/' . $picUrl;
        $files = UploadedFile::getInstance($model, $field);
        if (empty($files)) {
            return ['code' => 0, 'msg' => "没有图片"];
        }
        $folder = '/' . date('Ymd') . "/";
        $pre = rand(999, 9999) . time();
        if ($files && ($files->type == "image/jpeg" || $files->type == "image/pjpeg" || $files->type == "image/png" || $files->type == "image/x-png" || $files->type == "image/gif")) {
            $newName = $pre . '.' . $files->getExtension();
        } else {
            return ['code' => 0, 'msg' => "格式错误"];
        }
        if ($files->size > 2000000) {
            return ['code' => 0, 'msg' => "文件太大"];
        }
        if (!is_dir($root . $folder)) {
            if (!mkdir($root . $folder, 0777, true)) {
                return ['code' => 0, 'msg' => "创建目录失败"];
            } else {
                chmod($root . $folder, 0777);
            }
        }
        if ($files->saveAs($root . $folder . $newName)) {
            //判断是否有缩略图
            if($isthumb){
                $this->thumbphoto($root.$folder.$newName,$root.$folder."thumb".$newName,$thumbwidth,$thumbheight);
                return [
                    'code' => 1,
                    'msg' => "图片上传成功",
                    'img_url' => '/'.$picUrl.$folder.$newName,
                    'thumb_url' => '/'.$picUrl.$folder."thumb".$newName,
                ];
            }else{
                return [
                    'code' => 1,
                    'msg' => "图片上传成功",
                    'img_url' => '/' . $picUrl . $folder . $newName
                ];
            }
        } else {
            return ['code' => 0, 'msg' => "图片保存失败"];
        }
    }

    //生成缩略图
    public function thumbphoto($pic_url,$thumb_url,$width,$height) {
        Image::thumbnail($pic_url,$width,$height)->save($thumb_url,['quality' => 100]);
    }
}

?>