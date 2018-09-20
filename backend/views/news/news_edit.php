<?php
use yii\helpers\Html;
?>
<html>
<head>
    <meta charset="utf-8">
    <title>修改新闻</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <?= Html::cssFile('@web/layui/css/layui.css?v='.time()) ?>

    <?= Html::cssFile('@web/css/public.css?v='.time()) ?>

    <style>
        .banner{
            position: relative;
        }
        .img{
            width:100%;
            position: absolute;
            top: -10px;
            left: 150px;
        }
        .img img{
            display:block;
            width: 120px;
            height: 60px;
        }
    </style>
</head>
<body class="childrenBody">
<form class="layui-form" style="width:80%;">
    <input type="hidden" name="News[id]" value="<?=$news_info['id']?>" class="layui-input">
    <div class="layui-form-item layui-row layui-col-xs6 banner" style="margin-top: 20px;">
        <label class="layui-form-label">新闻图片</label>
        <div class="layui-input-block">
            <button type="button" class="layui-btn" id="imgUrl">
                <i class="layui-icon">&#xe67c;</i>上传图片
            </button>
        </div>
        <div style="margin-left: 110px;margin-top: 5px">
            <span style="color: red;">建议尺寸：268x163</span>
        </div>
        <div class="layui-input-block img" <?php if(empty($news_info['new_img'])){echo 'hidden';}?> >
            <img src="<?=$con_prefix.$news_info['new_img']?>" alt="">
        </div>
    </div>
    <div class="layui-form-item layui-row layui-col-xs10">
        <label class="layui-form-label">标题</label>
        <div class="layui-input-block">
            <input type="text" name="News[new_title]" value="<?=$news_info['new_title']?>" class="layui-input" lay-verify="required" placeholder="请输入新闻标题">
        </div>
    </div>
    <div class="layui-form-item layui-row layui-col-xs10">
        <label class="layui-form-label">关键词</label>
        <div class="layui-input-block">
            <input type="text" name="News[new_keywords]" value="<?=$news_info['new_keywords']?>" class="layui-input" lay-verify="required" placeholder="请输入新闻关键词">
        </div>
    </div>
    <div class="layui-form-item layui-row layui-col-xs10">
        <label class="layui-form-label">描述</label>
        <div class="layui-input-block">
            <textarea class="layui-textarea" name="News[new_descriptions]" lay-verify="required" ><?=$news_info['new_descriptions']?></textarea>
        </div>
    </div>
    <div class="layui-form-item layui-row layui-col-xs12">
        <label class="layui-form-label">新闻内容</label>
        <div class="layui-input-block">
            <?=common\widgets\ueditor\Ueditor::widget(['options'=>['lang' =>'zh-cn','initialFrameWidth' => 850,'initialFrameHeight' => 450],'id'=>'News[new_content]', 'value'=>$news_info['new_content']])?>
        </div>
    </div>
    <div class="layui-form-item layui-row layui-col-xs6">
        <label class="layui-form-label">发布时间</label>
        <div class="layui-input-block">
            <input type="text"  name="News[new_time]" value="<?=$news_info['new_time']?>" id="new_time" class="layui-input " style="width: 50%" lay-verify="required" placeholder="请选择时间">
        </div>
    </div>
    <div class="layui-form-item layui-row layui-col-xs6">
        <label class="layui-form-label">阅读量</label>
        <div class="layui-input-block">
            <input type="text" name="News[new_number]" value="<?=$news_info['new_number']?>" class="layui-input" style="width: 50%" lay-verify="amount" placeholder="请输入阅读量(整数)">
        </div>
        <div style="margin-left: 110px;margin-top: 5px">
            <span style="color: red;">不填时，阅读量默认在(300-500)之间</span>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">发布</label>
        <div class="layui-input-block">
            <input type="checkbox" name="News[new_state]" lay-skin="switch"  lay-text="已发|未发" <?php if($news_info['new_state']==1){echo 'checked';} ?> >
        </div>
    </div>
    <div class="layui-form-item layui-row layui-col-xs6">
        <div class="layui-input-block">
            <button class="layui-btn layui-btn-sm" lay-submit="" lay-filter="edit_btn">立即修改</button>
            <button type="reset" class="layui-btn layui-btn-sm layui-btn-primary">重置</button>
        </div>
    </div>
</form>
<?= Html::jsFile('@web/layui/layui.js?v='.time()) ?>

<script type="text/javascript">
    layui.use(['form','layer','jquery','upload','laydate'],function(){
        var form = layui.form;
        layer = parent.layer === undefined ? layui.layer : top.layer;
        upload = layui.upload;
        laydate = layui.laydate;
        $ = layui.jquery;

        //日期
        laydate.render({
            elem: '#new_time',
            type: 'datetime',
            format: 'yyyy/MM/dd HH:mm:ss'
        });

        //验证阅读量
        form.verify({
            amount:function (value,item) {
                if(!/^[0-9]*$/.test(value)){
                    return "请输入数字(整数)";
                }
            }
        });
        //图片上传
        var imgFile;
        var uploadInst = upload.render({
            elem: '#imgUrl',
            auto:false,
            field:"News[new_img]",//这是上传图片的input 的name 值
            choose: function(obj){
                //将每次选择的文件追加到文件队列
                var files = obj.pushFile();
                //预读本地文件，如果是多文件，则会遍历。(不支持ie8/9)
                obj.preview(function(index, file, result){
                    $(".img").show();
                    imgFile = file;
                    $(".img img").attr('src',result);
                });
            }
        });
        var index;
        form.on("submit(edit_btn)",function(data){
//            if(!imgFile){
//                layer.msg('请上传图片',{icon:5,shift:6});
//                return false
//            }
            var form_data = new FormData($('form')[0]);
            $.ajax({
                url:'/news/news_edit',
                type:'post',
                dataType:"json",
                data:form_data,
                cache: false,
                processData: false,
                contentType: false,
                beforeSend:function(){
                    index = top.layer.msg('数据提交中，请稍候',{icon: 16,time:false,shade:0.8});
                },
                success:function(res){
                    if(res.code==0){
                        layer.msg(res.msg);
                        layer.close(index);
                        //parent.location.reload();
                    }else {
                        layer.msg(res.msg);
                        layer.closeAll("iframe");
                        parent.location.reload();
                    }
                }
            });
            return false;
        });
    })
</script>
</body>
</html>
