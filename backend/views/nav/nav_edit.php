<?php
use yii\helpers\Html;
?>
<html>
<head>
    <meta charset="utf-8">
    <title>修改导航</title>
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
    <input type="hidden" name="Nav[id]" value="<?=$nav_info['id']?>" class="layui-input">
    <div class="layui-form-item layui-row layui-col-xs6">
        <label class="layui-form-label">导航名称</label>
        <div class="layui-input-block">
            <input type="text" name="Nav[nav_name]" value="<?=$nav_info['nav_name']?>" class="layui-input" lay-verify="required" placeholder="请输入导航名称">
        </div>
    </div>
    <div class="layui-form-item layui-row layui-col-xs6">
        <label class="layui-form-label">导航链接</label>
        <div class="layui-input-block">
            <input type="text" name="Nav[nav_url]" value="<?=$nav_info['nav_url']?>" class="layui-input" lay-verify="required" placeholder="请输入导航链接">
        </div>
    </div>
    <div class="layui-form-item layui-row layui-col-xs6">
        <label class="layui-form-label">标题</label>
        <div class="layui-input-block">
            <input type="text" name="Nav[nav_title]" value="<?=$nav_info['nav_title']?>" class="layui-input" lay-verify="required" placeholder="请输入标题">
        </div>
    </div>
    <div class="layui-form-item layui-row layui-col-xs6">
        <label class="layui-form-label">关键词</label>
        <div class="layui-input-block">
            <input type="text" name="Nav[nav_keywords]" value="<?=$nav_info['nav_keywords']?>" class="layui-input" lay-verify="required" placeholder="请输入关键词">
        </div>
    </div>
    <div class="layui-form-item layui-row layui-col-xs6">
        <label class="layui-form-label">描述</label>
        <div class="layui-input-block">
            <textarea class="layui-textarea" name="Nav[nav_descriptions]" lay-verify="required" ><?=$nav_info['nav_descriptions']?></textarea>
        </div>
    </div>
    <div class="layui-form-item layui-row layui-col-xs6">
        <label class="layui-form-label">优先级</label>
        <div class="layui-input-block">
            <input type="text" name="Nav[nav_level]" value="<?=$nav_info['nav_level']?>" class="layui-input" lay-verify="level" placeholder="请输入优先级(整数)">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">状态</label>
        <div class="layui-input-block">
            <input type="checkbox" name="Nav[nav_state]" lay-skin="switch"  lay-text="显示|隐藏" <?php if($nav_info['nav_state']==1){echo 'checked';} ?>>
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
    layui.use(['form','layer'],function(){
        var form = layui.form;
        layer = parent.layer === undefined ? layui.layer : top.layer;
            $ = layui.jquery;

        //验证优先级
        form.verify({
            level:function (value,item) {
                if(!/^[0-9]*$/.test(value)||value==''){
                    return "请输入数字(整数)";
                }
            }
        });

        var index;
        form.on("submit(edit_btn)",function(data){
            $.ajax({
                url:'/nav/nav_edit',
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
