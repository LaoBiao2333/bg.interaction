<?php
/*
*Created by PhpStorm
*User: Liang
*Date: 2016/11/28
*Time: 16:01
*/
?>
<head>
    <meta charset="UTF-8">
    <title>111111</title>
    <meta name="keywords" content="1111111">
    <meta name="description" content="1111111">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-param" content="_csrf-frontend">
	<meta name="applicable-device" content="pc,mobile">
	<meta name="MobileOptimized" content="width"/>
	<meta name="HandheldFriendly" content="true"/>
    <script type="text/javascript">
        function to_wap() {
            var url = window.location.pathname;
            var search = window.location.search;

            if(!Is_PC()){
                window.location.href = "https://m.xxx.com"+url+search;
            }
        }
        function Is_PC(){
            var userAgentInfo = navigator.userAgent;
            var Agents = new Array("Android", "iPhone", "SymbianOS", "Windows Phone", "iPad", "iPod");
            var flag = true;
            for(var v = 0; v < Agents.length; v++){
                if(userAgentInfo.indexOf(Agents[v]) > 0){
                    flag = false;
                    break;
                }
            }
            return flag;
        }
        to_wap();
    </script>
</head>
