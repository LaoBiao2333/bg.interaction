<?php
use yii\helpers\Html;
?>
<html>
<head>
    <meta charset="utf-8">
    <title>系统基本参数</title>
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
<blockquote class="layui-elem-quote layui-bg-green">
    <div id="nowTime"></div>
</blockquote>
<div class="layui-row layui-col-space10">
    <div class="layui-col-lg12 layui-col-md12">
        <blockquote class="layui-elem-quote title">系统基本参数</blockquote>
        <table class="layui-table magt0">
            <colgroup>
                <col width="350">
                <col>
            </colgroup>
            <tbody>
            <tr>
                <td>开发作者</td>
                <td class="author">程序员</td>
            </tr>
            <tr>
                <td>系统语言</td>
                <td class="lang">zh_cn</td>
            </tr>
            <tr>
                <td>当前PHP版本</td>
                <td class="version"><?php echo PHP_VERSION; ?></td>
            </tr>
            <tr>
                <td>服务器环境</td>
                <td class="server">linux</td>
            </tr>
            <tr>
                <td>数据库版本</td>
                <td class="dataBase">3.3.7</td>
            </tr>
            <tr>
                <td>最大上传限制</td>
                <td class="maxUpload">5M</td>
            </tr>
            <tr>
                <td>当前登录账号</td>
                <td class="user"><?=$data['username']?></td>
            </tr>
            <tr>
                <td>登录ip</td>
                <td class="login_ip"><?=$data['login_ip']?></td>
            </tr>
            <tr>
                <td>登录时间</td>
                <td class="login_time"><?=date('Y年m月d日 H:i:s',$data['login_time'])?></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<?= Html::jsFile('@web/layui/layui.js?v='.time()) ?>

<?= Html::jsFile('@web/js/main.js?v='.time()) ?>

</body>
</html>

