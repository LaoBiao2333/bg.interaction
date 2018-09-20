<?php
use yii\helpers\Html;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html class="loginHtml">
<head>
    <meta charset="utf-8">
    <title>登录</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <?= Html::cssFile('@web/layui/css/layui.css?v='.time()) ?>

    <?= Html::cssFile('@web/css/public.css?v='.time()) ?>

</head>
<body class="loginBody">
<?php $this->beginBody() ?>
<form class="layui-form">
    <div class="login_face"><img src="/images/face.jpg" class="userAvatar"></div>
    <div class="layui-form-item input-item">
        <label for="userName">用户名</label>
        <input type="text" placeholder="请输入用户名" name="username" autocomplete="off" id="userName" class="layui-input" lay-verify="required">
    </div>
    <div class="layui-form-item input-item">
        <label for="password">密码</label>
        <input type="password" placeholder="请输入密码" name="password" autocomplete="off" id="password" class="layui-input" lay-verify="required">
    </div>
    <div class="layui-form-item input-item" id="imgCode">
        <label for="code">验证码</label>
        <input type="text" placeholder="请输入验证码" name="code" autocomplete="off" id="code" class="layui-input" lay-verify="required">
        <?= \yii\captcha\Captcha::widget(['name' => 'captcha', 'captchaAction' => 'site/captcha', 'imageOptions' => ['id' => 'captchaimg', 'title' => '换一个', 'alt' => '换一个', 'style' => 'cursor:pointer;', 'width' => 100 ,'height' => 36], 'template' => '{image}']) ?>
    </div>
    <div class="layui-form-item">
        <button class="layui-btn layui-block" lay-submit="" lay-filter="login">登录</button>
    </div>
</form>

<?= Html::jsFile('@web/layui/layui.js?v='.time()) ?>

<?php $this->endBody() ?>

<script type="text/javascript">
    layui.use(['form','layer','jquery'],function(){
        var form = layui.form,
            layer = parent.layer === undefined ? layui.layer : top.layer;
        $ = layui.jquery;
        var index;
        //登录按钮
        form.on("submit(login)",function(data){
            //$(this).text("登录中...").attr("disabled","disabled").addClass("layui-disabled");
            // 提交登录信息
            $.ajax({
                url:"/site/login-validate",
                type:"post",
                dataType:"json",
                data:data.field,
                beforeSend:function(){
                    index = top.layer.msg('数据提交中，请稍候',{icon: 16,time:false,shade:0.8});
                },
                success:function(res){
                    if(res.code==0){
                        layer.msg(res.msg);
                        layer.close(index);
                        $("#captchaimg").trigger('click');
                        //window.location.reload();
                    }else {
                        layer.msg(res.msg);
                        layer.closeAll("iframe");
                        parent.location.reload();
                        //window.location.href = "/index/index";
                    }
                }
            });
            return false;
        });

        //表单输入效果
        $(".loginBody .input-item").click(function(e){
            e.stopPropagation();
            $(this).addClass("layui-input-focus").find(".layui-input").focus();
        });
        $(".loginBody .layui-form-item .layui-input").focus(function(){
            $(this).parent().addClass("layui-input-focus");
        });
        $(".loginBody .layui-form-item .layui-input").blur(function(){
            $(this).parent().removeClass("layui-input-focus");
            if($(this).val() != ''){
                $(this).parent().addClass("layui-input-active");
            }else{
                $(this).parent().removeClass("layui-input-active");
            }
        });
    });
</script>

</body>
</html>

<?php $this->endPage() ?>

