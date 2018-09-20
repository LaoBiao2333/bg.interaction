<?php
use yii\helpers\Html;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>后台管理</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="Access-Control-Allow-Origin" content="*">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <?= Html::cssFile('@web/layui/css/layui.css?v='.time()) ?>

    <?= Html::cssFile('@web/css/index.css?v='.time()) ?>

</head>
<body class="main_body">
<div class="layui-layout layui-layout-admin">
    <!-- 顶部 -->
    <div class="layui-header header">
        <div class="layui-main mag0">
            <a href="#" class="logo">后台管理系统</a>
            <!-- 显示/隐藏菜单 -->
            <a href="javascript:;" class="seraph hideMenu icon-caidan"></a>
            <!-- 顶部右侧菜单 -->
            <ul class="layui-nav top_menu">
                <!--<li class="layui-nav-item" pc>
                    <a href="javascript:;" class="clearCache"><i class="layui-icon" data-icon="&#xe640;">&#xe640;</i><cite>清除缓存</cite><span class="layui-badge-dot"></span></a>
                </li>-->
                <li class="layui-nav-item" id="userInfo">
                    <a href="javascript:;"><cite class="adminName">网站设置</cite></a>
                    <dl class="layui-nav-child">
                        <dd pc><a href="javascript:;" class="functionSetting"><i class="layui-icon">&#xe620;</i><cite>功能设定</cite><span class="layui-badge-dot"></span></a></dd>
                        <dd pc><a href="javascript:;" class="changeSkin"><i class="layui-icon">&#xe61b;</i><cite>更换皮肤</cite></a></dd>
                        <!--<dd pc><a href="javascript:;" data-url="/admin/edit_pwd"><i class="layui-icon">&#xe770;</i><cite>修改密码</cite></a></dd>-->
                        <dd><a href="javascript:;" class="signOut"><i class="seraph icon-tuichu"></i><cite>退出</cite></a></dd>
                    </dl>
                </li>
            </ul>
        </div>
    </div>
    <!-- 左侧导航 -->
    <div class="layui-side layui-bg-black">
        <div class="user-photo">
            <a class="img" title="我的头像" ><img src="/images/face.jpg" class="userAvatar"></a>
            <p>你好！<span class="userName"><?php echo $_SESSION['userInfo']['username'] ?></span>, 欢迎登录</p>
        </div>
        <div class="navBar layui-side-scroll" id="navBar">
            <ul class="layui-nav layui-nav-tree">
                <li class="layui-nav-item layui-this">
                    <a href="javascript:;" data-url=""><i class="layui-icon"></i><cite>后台首页</cite></a>
                </li>
                <li class="layui-nav-item">
                    <a><i class="layui-icon">&#xe716;</i><cite>基本设置</cite><span class="layui-nav-more"></span></a>
                    <dl class="layui-nav-child">
                        <dd>
                            <a data-url="/config/index"><i class="layui-icon">&#xe631;</i><cite>基本设置信息</cite></a>
                        </dd>
                    </dl>
                </li>
                <li class="layui-nav-item">
                    <a><i class="layui-icon">&#xe770;</i><cite>管理员管理</cite><span class="layui-nav-more"></span></a>
                    <dl class="layui-nav-child">
                        <dd>
                            <a data-url="/admin/admin_list"><i class="layui-icon">&#xe60a;</i><cite>管理员列表</cite></a>
                        </dd>
                    </dl>
                </li>
                <li class="layui-nav-item">
                    <a><i class="layui-icon">&#xe656;</i><cite>导航管理</cite><span class="layui-nav-more"></span></a>
                    <dl class="layui-nav-child">
                        <dd>
                            <a data-url="/nav/nav_list"><i class="layui-icon">&#xe715;</i><cite>导航列表</cite></a>
                        </dd>
                    </dl>
                </li>
                <li class="layui-nav-item">
                    <a><i class="layui-icon">&#xe634;</i><cite>轮播图管理</cite><span class="layui-nav-more"></span></a>
                    <dl class="layui-nav-child">
                        <dd>
                            <a data-url="/banner/banner_pc"><i class="layui-icon">&#xe638;</i><cite>PC端轮播图</cite></a>
                        </dd>
                        <dd>
                            <a data-url="/banner/banner_wap"><i class="layui-icon">&#xe63b;</i><cite>移动端轮播图</cite></a>
                        </dd>
                    </dl>
                </li>
                <li class="layui-nav-item">
                    <a><i class="layui-icon">&#xe705;</i><cite>新闻管理</cite><span class="layui-nav-more"></span></a>
                    <dl class="layui-nav-child">
                        <dd>
                            <a data-url="/news/news_list"><i class="layui-icon">&#xe630;</i><cite>新闻列表</cite></a>
                        </dd>
                    </dl>
                </li>
            </ul>
        </div>
    </div>
    <!-- 右侧内容 -->
    <div class="layui-body layui-form">
        <div class="layui-tab mag0" lay-filter="bodyTab" id="top_tabs_box">
            <ul class="layui-tab-title top_tab" id="top_tabs">
                <li class="layui-this" lay-id=""><i class="layui-icon">&#xe68e;</i> <cite>后台首页</cite></li>
            </ul>
            <ul class="layui-nav closeBox">
                <li class="layui-nav-item">
                    <a href="javascript:;"><i class="layui-icon caozuo">&#xe643;</i> 页面操作</a>
                    <dl class="layui-nav-child">
                        <dd><a href="javascript:;" class="refresh refreshThis"><i class="layui-icon">&#x1002;</i> 刷新当前</a></dd>
                        <dd><a href="javascript:;" class="closePageOther"><i class="seraph icon-prohibit"></i> 关闭其他</a></dd>
                        <dd><a href="javascript:;" class="closePageAll"><i class="seraph icon-guanbi"></i> 关闭全部</a></dd>
                    </dl>
                </li>
            </ul>
            <div class="layui-tab-content clildFrame">
                <div class="layui-tab-item layui-show">
                    <iframe src="/index/home"></iframe>
                </div>
            </div>
        </div>
    </div>
    <!-- 底部 -->
    <div class="layui-footer footer">
        <p><span>后台管理系统 © 2018年</span></p>
    </div>
</div>

<!-- 移动导航 -->
<div class="site-tree-mobile"><i class="layui-icon">&#xe602;</i></div>
<div class="site-mobile-shade"></div>
<script type="text/javascript" src="/layui/layui.js"></script>
<script type="text/javascript" src="/js/index.js"></script>
<script type="text/javascript" src="/js/cache.js"></script>
</body>
</html>