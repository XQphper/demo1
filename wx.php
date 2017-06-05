<?php

    include './wxModel.php';

    define("TOKEN", "weixin");

    $wechatObj = new wxModel();

    if(isset($_GET['echostr'])) {

        $wechatObj->valid();
    }else{

        //接收微信服务器发送过来的xml
        $wechatObj->responseMsg();
    }