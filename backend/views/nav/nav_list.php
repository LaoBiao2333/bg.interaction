<?php
use yii\helpers\Html;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>导航列表</title>
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
                <a class="layui-btn layui-btn-normal add_btn">添加导航</a>
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

        //导航列表
        var tableIns = table.render({
            elem: '#userList',
            url : '/nav/list_data',
            cellMinWidth : 95,
            page : true,
            height : "full-125",
            limits : [10,15,20,25],
            limit : 10,
            id : "userListTable",
            cols : [[
                //{type: "checkbox", fixed:"left", width:50},
                {field: 'id', title: '编号', width:60, fixed:"left", align:"center"},
                {field: 'nav_name', title: '导航名称', minWidth:100, align:"center"},
                {field: 'nav_url', title: '导航链接', minWidth:100, align:"center"},
                {field: 'nav_level', title: '优先级', align:'center',minWidth:150},
                {field: 'nav_state', title: '状态',  align:'center', templet:function(d){return d.nav_state == "1" ? "显示" : "隐藏";}},
                {title: '操作', minWidth:175, templet:'#userListBar',fixed:"right",align:"center"}
            ]]
        });

        $(".add_btn").click(function(){
            nav_add();
        });

        //添加导航
        function nav_add(){
            var index = layui.layer.open({
                title : "添加导航",
                type : 2,
                content : "/nav/nav_add",
                success : function(layero, index){
                    var body = layui.layer.getChildFrame('body', index);
                    setTimeout(function(){
                        layui.layer.tips('点击此处返回导航列表', '.layui-layer-setwin .layui-layer-close', {
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

        //修改导航
        function nav_edit(edit){
            var index = layui.layer.open({
                title : "修改导航",
                type : 2,
                content : "/nav/nav_edit?id="+edit.id,
                success : function(layero, index){
                    var body = layui.layer.getChildFrame('body', index);
                    setTimeout(function(){
                        layui.layer.tips('点击此处返回导航列表', '.layui-layer-setwin .layui-layer-close', {
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
                //修改导航
                nav_edit(data);
            }else if(layEvent === 'del'){
                //删除导航
                layer.confirm('确定删除该导航？',{icon:3, title:'提示信息'},function(index){
                    $.ajax({
                        url:'/nav/nav_del',
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