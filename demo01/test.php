<?php
//测试图片消息
// $postStr = <<<EOT
// <xml>
//  <ToUserName><![CDATA[toUser]]></ToUserName>
//  <FromUserName><![CDATA[fromUser]]></FromUserName>
//  <CreateTime>1348831860</CreateTime>
//  <MsgType><![CDATA[image]]></MsgType>
//  <PicUrl><![CDATA[this is a url]]></PicUrl>
//  <MediaId><![CDATA[media_id]]></MediaId>
//  <MsgId>1234567890123456</MsgId>
//  </xml>
// EOT;

// var_dump($postStr);

// file_put_contents("data.txt", date("Y-m-d H:i:s"."\n".$postStr."\n", FILE_APPEND);

$textTpl = <<<EOT
			<xml>
			<ToUserName><![CDATA[%s]]></ToUserName>
			<FromUserName><![CDATA[%s]]></FromUserName>
			<CreateTime>%s</CreateTime>
			<MsgType><![CDATA[%s]]></MsgType>
			<Image>
			<MediaId><![CDATA[%s]]></MediaId>
			</Image>
			</xml>
EOT;

var_dump($textTpl);
file_put_contents("data.txt", date("Y-m-d H:i:s"."\n".$postStr."\n", FILE_APPEND);

