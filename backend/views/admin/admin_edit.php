<?php
use yii\helpers\Html;
?>
<html>
<head>
    <meta charset="utf-8">
    <title>修改管理员</title>
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
<form class="layui-form" style="width:80%;">
    <div class="layui-col-xs12 layui-col-sm6 layui-col-md6">
        <input type="hidden" name="Admin[id]" value="<?=$admin_info['id']?>" >
        <div class="layui-form-item layui-row layui-col-xs6">
            <label class="layui-form-label">管理员名称</label>
            <div class="layui-input-block">
                <input type="text" name="Admin[username]" value="<?=$admin_info['username']?>" class="layui-input userName" lay-verify="required" placeholder="请输入管理员名称">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">状态</label>
            <div class="layui-input-block">
                <input type="checkbox" name="Admin[state]" lay-skin="switch"  lay-text="激活|禁用" <?php if($admin_info['state']==1){echo 'checked';} ?>>
            </div>
        </div>
    </div>
    <div class="layui-form-item layui-row layui-col-xs6">
        <div class="layui-input-block">
            <button class="layui-btn layui-btn-sm" lay-submit="" lay-filter="addUser">立即修改</button>
            <button type="reset" class="layui-btn layui-btn-sm layui-btn-primary">重置</button>
        </div>
    </div>
</form>
<?= Html::jsFile('@web/layui/layui.js?v='.time()) ?>

<!--<script type="text/javascript" src="userAdd.js"></script>-->
<script type="text/javascript">
    layui.use(['form','layer'],function(){
        var form = layui.form;
        layer = parent.layer === undefined ? layui.layer : top.layer;
        $ = layui.jquery;

        var index;
        form.on("submit(addUser)",function(data){
            $.ajax({
                url:'/admin/admin_edit',
                type:'post',
                dataType:"json",
                data:data.field,
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
