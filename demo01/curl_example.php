<?php
    include '../vendor/autoload.php';
    // $url = 'https://www.jd.com';
    $appID = "wxedd491740234652e";
    $appsecret = "3c8d369477fff7e9c612f6adc64a0900";
    $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appID."&secret=".$appsecret;


    //1.初始化
    $ch = curl_init();

    //2.设置Curl选项
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1); //0是以页面显示 1是以代码显示
    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);

    //3.执行cURL请求
    $ret = curl_exec($ch);

    //4.关闭资源
    curl_close($ch);

    //打印
    dump($ret);




