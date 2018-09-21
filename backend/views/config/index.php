<?php
use yii\helpers\Html;
?>
<html>
<head>
    <meta charset="utf-8">
    <title>基本设置信息</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <?= Html::cssFile('@web/layui/css/layui.css?v='.time()) ?>

    <?= Html::cssFile('@web/css/public.css?v='.time()) ?>

    <style>
        .logo{
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
            width: 190px;
            height: 58px;
        }
    </style>
</head>
<body class="childrenBody">
<div class="layui-col-lg12 layui-col-md12" style="margin-bottom: 20px;">
    <blockquote class="layui-elem-quote title">基本设置信息</blockquote>
</div>
<form class="layui-form" style="width:80%;">
    <input type="hidden" name="Config[id]" value="<?=$config_info['id']?>">
    <div class="layui-form-item layui-row layui-col-xs6 logo">
        <label class="layui-form-label">LOGO</label>
        <div class="layui-input-block">
            <button type="button" class="layui-btn" id="imgUrl">
                <i class="layui-icon">&#xe67c;</i>上传图片
            </button>
        </div>
        <div style="margin-left: 110px;margin-top: 5px">
            <span style="color: red;">建议尺寸：190x58</span>
        </div>
        <div class="layui-input-block img" <?php if(empty($config_info['con_logo'])){echo 'hidden';}?> >
            <img src="<?=$config_info['con_prefix'].$config_info['con_logo']?>" alt="">
        </div>
    </div>
    <div class="layui-form-item layui-row layui-col-xs12">
        <label class="layui-form-label">标题</label>
        <div class="layui-input-block">
            <input type="text" name="Config[con_title]" value="<?=$config_info['con_title']?>" class="layui-input" lay-verify="required" placeholder="请输入三大标签-标题">
        </div>
    </div>
    <div class="layui-form-item layui-row layui-col-xs12">
        <label class="layui-form-label">关键词</label>
        <div class="layui-input-block">
            <input type="text" name="Config[con_keywords]" value="<?=$config_info['con_keywords']?>" class="layui-input" lay-verify="required" placeholder="请输入三大标签-关键词">
        </div>
    </div>
    <div class="layui-form-item layui-row layui-col-xs12">
        <label class="layui-form-label">描述</label>
        <div class="layui-input-block">
            <textarea class="layui-textarea" name="Config[con_descriptions]" lay-verify="required" ><?=$config_info['con_descriptions']?></textarea>
        </div>
    </div>
    <div class="layui-form-item layui-row layui-col-xs12">
        <label class="layui-form-label">公司名称</label>
        <div class="layui-input-block">
            <input type="text" name="Config[con_company]" value="<?=$config_info['con_company']?>" class="layui-input" lay-verify="required" placeholder="请输入公司名称">
        </div>
    </div>
    <div class="layui-form-item layui-row layui-col-xs12">
        <label class="layui-form-label">公司地址</label>
        <div class="layui-input-block">
            <input type="text" name="Config[con_address]" value="<?=$config_info['con_address']?>" class="layui-input" lay-verify="required" placeholder="请输入公司地址">
        </div>
    </div>
    <div class="layui-form-item layui-row layui-col-xs12">
        <label class="layui-form-label">版权信息</label>
        <div class="layui-input-block">
            <input type="text" name="Config[con_copyright]" value="<?=$config_info['con_copyright']?>" class="layui-input" lay-verify="required" placeholder="请输入版权信息">
        </div>
    </div>
    <div class="layui-form-item layui-row layui-col-xs12">
        <label class="layui-form-label">统计代码pc</label>
        <div class="layui-input-block">
            <textarea class="layui-textarea" name="Config[con_webscript_pc]" ><?=$config_info['con_webscript_pc']?></textarea>
        </div>
    </div>
    <div class="layui-form-item layui-row layui-col-xs12">
        <label class="layui-form-label">统计代码m</label>
        <div class="layui-input-block">
            <textarea class="layui-textarea" name="Config[con_webscript_m]" ><?=$config_info['con_webscript_m']?></textarea>
        </div>
    </div>
    <div class="layui-form-item layui-row layui-col-xs12">
        <label class="layui-form-label">路径前缀</label>
        <div class="layui-input-block">
            <input type="text" name="Config[con_prefix]" value="<?=$config_info['con_prefix']?>" class="layui-input" lay-verify="required" placeholder="请输入图片访问路径前缀">
            <span style="color: red;">图片访问路径前缀</span>
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
    layui.use(['form','layer','laypage','jquery','upload'],function(){
        var form = layui.form;
            layer = parent.layer === undefined ? layui.layer : top.layer;
            laypage = layui.laypage;
            upload = layui.upload;
            $ = layui.jquery;

        var index;
        //图片上传
        var imgFile;
        var uploadInst = upload.render({
            elem: '#imgUrl',
            auto:false,
            field:"Config[con_logo]",//这是上传图片的input 的name 值
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
        form.on("submit(edit_btn)",function(data){
            var form_data = new FormData($('form')[0]);
            $.ajax({
                url:'/config/index',
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
                        //alert(res.msg);
                        layer.msg(res.msg);
                        layer.close(index);
                    }else {
                        layer.close(index);
                        layer.msg(res.msg);
                        location.reload();
                    }
                }
            });
            return false;
        });
    })

</script>
<?= Html::jsFile('@web/js/cache.js?v='.time()) ?>

</body>
</html>