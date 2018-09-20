<?php
use yii\helpers\Html;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>管理员列表</title>
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
                <a class="layui-btn layui-btn-normal add_btn">添加管理员</a>
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
        <a class="layui-btn layui-btn-xs layui-btn-warm" lay-event="editPwd">修改密码</a>
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

        //用户列表
        var tableIns = table.render({
            elem: '#userList',
            url : '/admin/admin_data',
            cellMinWidth : 95,
            page : true,
            height : "full-125",
            limits : [10,15,20,25],
            limit : 10,
            id : "userListTable",
            cols : [[
                //{type: "checkbox", fixed:"left", width:50},
                {field: 'id', title: '编号', width:60, fixed:"left", align:"center"},
                {field: 'username', title: '管理员名称', minWidth:100, align:"center"},
                {field: 'login_ip', title: '最后登录IP', minWidth:100, align:"center"},
                {field: 'login_time', title: '最后登录时间', align:'center',minWidth:150},
                {field: 'state', title: '状态',  align:'center', templet:function(d){return d.state == "1" ? "激活" : "禁用";}},
                {title: '操作', minWidth:175, templet:'#userListBar',fixed:"right",align:"center"}
            ]]
        });

        $(".add_btn").click(function(){
            admin_add();
        });

        //添加管理员
        function admin_add(){
            var index = layui.layer.open({
                title : "添加管理员",
                type : 2,
                content : "/admin/admin_add",
                success : function(layero, index){
                    var body = layui.layer.getChildFrame('body', index);
                    setTimeout(function(){
                        layui.layer.tips('点击此处返回管理员列表', '.layui-layer-setwin .layui-layer-close', {
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

        //修改管理员
        function admin_edit(edit){
            var index = layui.layer.open({
                title : "修改管理员",
                type : 2,
                content : "/admin/admin_edit?id="+edit.id,
                success : function(layero, index){
                    var body = layui.layer.getChildFrame('body', index);
                    setTimeout(function(){
                        layui.layer.tips('点击此处返回管理员列表', '.layui-layer-setwin .layui-layer-close', {
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

        //修改密码
        function changePwd(edit){
            var index = layui.layer.open({
                title : "修改密码",
                type : 2,
                content : "/admin/admin_pwd?id="+edit.id,
                success : function(layero, index){
                    var body = layui.layer.getChildFrame('body', index);
                    setTimeout(function(){
                        layui.layer.tips('点击此处返回管理员列表', '.layui-layer-setwin .layui-layer-close', {
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
                //编辑管理员
                admin_edit(data);
            }else if(layEvent === 'editPwd'){
                //修改密码
                changePwd(data);
            }else if(layEvent === 'del'){
                //删除管理员
                layer.confirm('确定删除该管理员？',{icon:3, title:'提示信息'},function(index){
                    $.ajax({
                        url:'/admin/admin_del',
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

        //批量删除
//        $(".delAll_btn").click(function(){
//            var checkStatus = table.checkStatus('userListTable'),
//                data = checkStatus.data,
//                newsId = [];
//            if(data.length > 0) {
//                for (var i in data) {
//                    newsId.push(data[i].newsId);
//                }
//                layer.confirm('确定删除选中的用户？', {icon: 3, title: '提示信息'}, function (index) {
//                     $.get("删除文章接口",{
//                         newsId : newsId  //将需要删除的newsId作为参数传入
//                     },function(data){
//                    tableIns.reload();
//                    layer.close(index);
//                     })
//                })
//            }else{
//                layer.msg("请选择需要删除的用户");
//            }
//        });

    })

</script>
</body>
</html>