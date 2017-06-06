<?php
	
	include "./wxModel.php";
	include "./vendor/autoload.php";

	$wxObj = new wxModel();
 		//群发消息
// 根据OpenID列表群发【订阅号不可用，服务号认证后可用】
	// 数据：
	/*

	{
	   "touser":[
	    "OPENID1",
	    "OPENID2"
	   ],
	    "msgtype": "text",
	    "text": { "content": "hello from boxer."}
	}

	*/
	// $json = '{
	//    "touser":[
	//     "OPENID1",
	//     "OPENID2"
	//    ],
	//     "msgtype": "text",
	//     "text": { "content": "hello from boxer."}
	// }';
	// $arr = json_decode($json, 1);

	// dump($arr);

	$arr = array(

		'touser'=>array(

			'oEmhF1clA0Xg6IeLjzjaa2ktlZCs',
			'oEmhF1QBAwXwFWndxOWXgqYK-mGQ'
			),
		'msgtype'=>'text',
		'text'=>array(
			'content'=>'hello from boxer'
			)

		);
    	//http请求方式: POST
		//https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token=ACCESS_TOKEN
    	$url = "https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token=".$this->getAccessToken();

    	echo $this->getData($url,'POST',$arr);
