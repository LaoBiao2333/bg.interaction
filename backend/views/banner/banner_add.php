<?php
use yii\helpers\Html;
?>
<html>
<head>
    <meta charset="utf-8">
    <title>添加轮播图</title>
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
            width: 200px;
            height: 60px;
        }
    </style>
</head>
<body class="childrenBody">
<form class="layui-form" style="width:80%;">
    <div class="layui-form-item layui-row layui-col-xs6 banner" style="margin-top: 20px;">
        <label class="layui-form-label">轮播图</label>
        <div class="layui-input-block">
            <button type="button" class="layui-btn" id="imgUrl">
                <i class="layui-icon">&#xe67c;</i>上传图片
            </button>
        </div>
        <div style="margin-left: 110px;margin-top: 5px">
            <?php if($ban_ispc==1){?>
            <span style="color: red;">建议尺寸：1920x678</span>
            <?php }else{?>
            <span style="color: red;">建议尺寸：750x700</span>
            <?php }?>
        </div>
        <div class="layui-input-block img" hidden>
            <img src="" alt="">
        </div>
    </div>
    <div class="layui-form-item layui-row layui-col-xs6">
        <label class="layui-form-label">轮播图链接</label>
        <div class="layui-input-block">
            <input type="text" name="Banner[ban_url]" class="layui-input" lay-verify="required" placeholder="请输入轮播图链接">
        </div>
    </div>
    <div class="layui-form-item layui-row layui-col-xs6">
        <label class="layui-form-label">短标题</label>
        <div class="layui-input-block">
            <input type="text" name="Banner[ban_short_title]" class="layui-input" lay-verify="required" placeholder="请输入轮播图短标题">
        </div>
    </div>
    <div class="layui-form-item layui-row layui-col-xs6">
        <label class="layui-form-label">长标题</label>
        <div class="layui-input-block">
            <input type="text" name="Banner[ban_long_title]" class="layui-input" lay-verify="required" placeholder="请输入轮播图长标题">
        </div>
    </div>
    <div class="layui-form-item layui-row layui-col-xs6">
        <label class="layui-form-label">描述</label>
        <div class="layui-input-block">
            <input type="text" name="Banner[ban_text]" class="layui-input" lay-verify="required" placeholder="请输入轮播图描述">
        </div>
    </div>
    <div class="layui-form-item layui-row layui-col-xs6">
        <label class="layui-form-label">按钮</label>
        <div class="layui-input-block">
            <input type="text" name="Banner[ban_button]" class="layui-input" lay-verify="required" placeholder="请输入按钮名字">
        </div>
    </div>
    <div class="layui-form-item layui-row layui-col-xs6">
        <label class="layui-form-label">按钮链接</label>
        <div class="layui-input-block">
            <input type="text" name="Banner[ban_button_url]" class="layui-input" lay-verify="required" placeholder="请输入按钮链接">
        </div>
    </div>
    <div class="layui-form-item layui-row layui-col-xs6">
        <label class="layui-form-label">优先级</label>
        <div class="layui-input-block">
            <input type="text" name="Banner[ban_level]" class="layui-input" lay-verify="level" placeholder="请输入优先级(整数)">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">状态</label>
        <div class="layui-input-block">
            <input type="checkbox" name="Banner[ban_state]" lay-skin="switch"  lay-text="显示|隐藏" checked>
        </div>
    </div>
    <input type="hidden" name="Banner[ban_ispc]" value="<?=$ban_ispc?>" class="layui-input">
    <div class="layui-form-item layui-row layui-col-xs6">
        <div class="layui-input-block">
            <button class="layui-btn layui-btn-sm" lay-submit="" lay-filter="add_btn">立即添加</button>
            <button type="reset" class="layui-btn layui-btn-sm layui-btn-primary">重置</button>
        </div>
    </div>
</form>
<?= Html::jsFile('@web/layui/layui.js?v='.time()) ?>

<script type="text/javascript">
    layui.use(['form','layer','jquery','upload'],function(){
        var form = layui.form;
        layer = parent.layer === undefined ? layui.layer : top.layer;
        upload = layui.upload;
            $ = layui.jquery;

        //验证优先级
        form.verify({
            level:function (value,item) {
                if(!/^[0-9]*$/.test(value)||value==''){
                    return "请输入数字(整数)";
                }
            }
        });
        //图片上传
        var imgFile;
        var uploadInst = upload.render({
            elem: '#imgUrl',
            auto:false,
            field:"Banner[ban_img]",//这是上传图片的input 的name 值
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
        form.on("submit(add_btn)",function(data){
            if(!imgFile){
                layer.msg('请上传图片',{icon:5,shift:6});
                return false
            }
            var form_data = new FormData($('form')[0]);
            $.ajax({
                url:'/banner/banner_add',
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
