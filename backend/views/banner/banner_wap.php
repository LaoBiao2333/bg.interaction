<?php
use yii\helpers\Html;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>移动端轮播图列表</title>
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
<form class="layui-form">
    <blockquote class="layui-elem-quote quoteBox">
        <form class="layui-form">
            <div class="layui-inline">
                <a class="layui-btn layui-btn-normal add_btn">添加移动端轮播图</a>
            </div>
            <!--<div class="layui-inline">
				<a class="layui-btn layui-btn-danger layui-btn-normal delAll_btn">批量删除</a>
			</div>-->
        </form>
    </blockquote>
    <table id="userList" lay-filter="userList"></table>
    <!--操作-->
    <script type="text/html" id="userListBar">
        <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
        <a class="layui-btn layui-btn-xs layui-btn-danger" lay-event="del">删除</a>
    </script>
</form>
<?= Html::jsFile('@web/layui/layui.js?v='.time()) ?>

<!--<script type="text/javascript" src="userList.js"></script>-->
<script type="text/javascript">
    layui.use(['form','layer','table','laytpl'],function(){
        var form = layui.form,
            layer = parent.layer === undefined ? layui.layer : top.layer,
            $ = layui.jquery,
            laytpl = layui.laytpl,
            table = layui.table;

        //移动端轮播图列表
        var tableIns = table.render({
            elem: '#userList',
            url : '/banner/wap_data',
            cellMinWidth : 95,
            page : true,
            height : "full-125",
            limits : [10,15,20,25],
            limit : 10,
            id : "userListTable",
            cols : [[
                //{type: "checkbox", fixed:"left", width:50},
                {field: 'id', title: '编号', width:60, fixed:"left", align:"center"},
                {field: 'ban_img', title: '轮播图', minWidth:100, align:"center", templet:function(d){return '<img src="<?=$con_prefix?>'+d.ban_img+'"/>';}},
                {field: 'ban_url', title: '轮播图链接', minWidth:150, align:"center"},
                {field: 'ban_short_title', title: '短标题', minWidth:100, align:"center"},
                {field: 'ban_long_title', title: '长标题', minWidth:100, align:"center"},
                {field: 'ban_level', title: '优先级', align:'center',width:80},
                {field: 'ban_state', title: '状态',  align:'center', width:80, templet:function(d){return d.ban_state == "1" ? "显示" : "隐藏";}},
                {field: 'ban_ispc', title: '设备',  align:'center', width:80, templet:function(d){return d.ban_ispc == "1" ? "PC端" : "移动端";}},
                {title: '操作', width:150, templet:'#userListBar',fixed:"right",align:"center"}
            ]]
        });

        $(".add_btn").click(function(){
            banner_add();
        });

        //添加移动端轮播图
        function banner_add(){
            var index = layui.layer.open({
                title : "添加移动端轮播图",
                type : 2,
                content : "/banner/banner_add?ban_ispc=2",
                success : function(layero, index){
                    var body = layui.layer.getChildFrame('body', index);
                    setTimeout(function(){
                        layui.layer.tips('点击此处返回移动端轮播图列表', '.layui-layer-setwin .layui-layer-close', {
                            tips: 3
                        });
                    },500)
                }
            });
            layui.layer.full(index);
            window.sessionStorage.setItem("index",index);
            //改变窗口大小时，重置弹窗的宽高，防止超出可视区域（如F12调出debug的操作）
            $(window).on("resize",function(){
                layui.layer.full(window.sessionStorage.getItem("index"));
            })
        }

        //修改移动端轮播图
        function banner_edit(edit){
            var index = layui.layer.open({
                title : "修改移动端轮播图",
                type : 2,
                content : "/banner/banner_edit?id="+edit.id,
                success : function(layero, index){
                    var body = layui.layer.getChildFrame('body', index);
                    setTimeout(function(){
                        layui.layer.tips('点击此处返回移动端轮播图列表', '.layui-layer-setwin .layui-layer-close', {
                            tips: 3
                        });
                    },500)
                }
            });
            layui.layer.full(index);
            window.sessionStorage.setItem("index",index);
            //改变窗口大小时，重置弹窗的宽高，防止超出可视区域（如F12调出debug的操作）
            $(window).on("resize",function(){
                layui.layer.full(window.sessionStorage.getItem("index"));
            })
        }

        //列表操作
        table.on('tool(userList)', function(obj){
            var layEvent = obj.event,
                data = obj.data;
            if(layEvent === 'edit'){
                //修改移动端轮播图
                banner_edit(data);
            }else if(layEvent === 'del'){
                //删除移动端轮播图
                layer.confirm('确定删除该轮播图？',{icon:3, title:'提示信息'},function(index){
                    $.ajax({
                        url:'/banner/banner_del',
                        type:'post',
                        dataType:"json",
                        data:{id:data.id},
                        success:function(res){
                            if(res.code==0){
                                //alert(res.msg);
                                layer.msg(res.msg);
                                layer.close(index);
                                //parent.location.reload();
                            }else {
                                layer.msg(res.msg);
                                tableIns.reload();
                                layer.close(index);
                            }
                        }
                    });
                    return false;
                });
            }
        });
    })

</script>
</body>
</html>