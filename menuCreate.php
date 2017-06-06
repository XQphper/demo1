<?php


include "./wxModel.php";

$wxObj = new wxModel();

$arr = array(
    "button"=>array(
        array(
            "type"=>"click",
            "name"=>urlencode("历史消息"),
            "key"=>"10000"
        ),
        array(
            "name"=>urlencode("菜单"),
            "sub_button"=>array(
                array(
                    "type"=>"click",
                    "name"=>urlencode("今日新闻"),
                    "key"=>"20000"
                ),
                array(
                    "type"=>"click",
                    "name"=>urlencode("帅哥"),
                    "key"=>"21000"
                ),
                array(
                    "type"=>"click",
                    "name"=>urlencode("美女"),
                    "key"=>"22000"
                )
            )
        ),
        array(
            "type"=>"click",
            "name"=>urlencode("关于我们"),
            "key"=>"30000"
        )
    )

);

//访问一个自定义菜单接口
//http请求方式：POST（请使用https协议） https://api.weixin.qq.com/cgi-bin/menu/create?access_token=ACCESS_TOKEN

$url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$wxObj->getAccessToken();

// echo $url;

//curl post 请求
$datajson = urldecode(json_encode($arr));

// echo $datajson;

$ret = $wxObj->getData($url,"POST", $datajson);

echo $ret;

//天气预报的key值
//AppKey：aa48cda31fe51a4a72820d5e6004ecaf

//   http://v.juhe.cn/weather/index?format=2&cityname=广州&key=aa48cda31fe51a4a72820d5e6004ecaf