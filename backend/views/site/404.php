<?php
use yii\helpers\Html;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>404页面</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <?= Html::cssFile('@web/layui/css/layui.css?v='.time()) ?>

    <?= Html::cssFile('@web/css/public.css?v='.time()) ?>

</head>
<body class="childrenBody">
<div class="noFind">
    <div class="ufo">
        <i class="seraph icon-test ufo_icon"></i>
        <i class="layui-icon page_icon">&#xe638;</i>
    </div>
    <div class="page404">
        <i class="layui-icon">&#xe61c;</i>
        <p><?=$message?></p>
        <p class="sec"><span>3秒后自动跳转</span><a href="javascript:;" class="go_back">点击返回</a></p>
    </div>
</div>
<?= Html::jsFile('@web/layui/layui.js?v='.time()) ?>

<script type="text/javascript">
    layui.use(['form','layer'],function(){
        var form = layui.form;
        layer = parent.layer === undefined ? layui.layer : top.layer;
        $ = layui.jquery;

        $(".go_back").click(function(){
            go();
        });
        function go(){
            //window.history.back(-1);
            parent.location.reload();
        }
        $(function(){
            var countdown=4;
            function settime() {
                if (countdown == 0) {
                    go();
                    countdown=-1;
                    clearTimeout(time);
                } else {
                    $('.sec span').text(countdown +'秒后自动跳转');
                    countdown--;
                }
                time = setTimeout(function() {
                    settime()
                },1000)
            }
             settime();
        })
    });
</script>
</body>
</html>
