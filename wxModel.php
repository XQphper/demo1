<?php
/**
 * wechat php test
 */

//define your token
define("TOKEN", "weixin");
$wechatObj = new wxModel();


if ($_GET['echostr'])
{
    $wechatObj->valid();
}
else
{
    $wechatObj->responseMsg();
}

$wechatObj->valid();

class wxModel
{
    //接口配置信息，此信息需要你有自己的服务器资源，填写的URL需要正确响应微信发送的Token验证
    public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
            echo $echoStr;
            exit;
        }
    }
    //微信发送消息，开发者服务器接收xml格式数据，然后进行业务的逻辑处理
    public function responseMsg()
    {
        //get post data, May be due to the different environments
//		 $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        $postStr = file_get_contents('php://input');

        include "./db.php";
        $data = array(
            'xml' =>$postStr,
        );
        $database->insert('xml' ,$data);

        //extract post data
        if (!empty($postStr)){
            /* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
               the best way is to check the validity of xml by yourself */
            libxml_disable_entity_loader(true);

            //接收服务器发送过来的xml数据，分为 时间、消息，按照msgType分类 转换为对象
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);

            //  开发者拿到用户发来的信息

            $fromusername = $postObj->FromUserName;
            $tousername = $postObj->ToUserName;
            $msgtype = $postObj->MsgType;
            $keyword = trim($postObj->Content);
            
            //根据类型判断关键字，返回数据给用户
            if($msgtype == 'text') {

            	//判断关键字是否是图文
            	if($keyword == '新闻') {

            		//php + mysql 读取数据库 ，拿到文章列表的数据
            		$arr = array(

            			 array(
                            'title' => "流星眉、果冻唇已经out了！现在流行这样化妆",
                            'date' => "2017-6-4",
                            'url' => "http://fashion.huanqiu.com/news/2017-06/10782629.html",
                            'description' => '日前，唯品会清空了官方微博，成功的引起了众人的注意。',
                            'picurl' => "https://b.bdstatic.com/boxlib/20170604/2017060420091584943597996.jpg"
                        ),
                        array(
                            'title' => "要嫁就嫁小包总要嫁就嫁小包总",
                            'date' => "2017-6-4",
                            'url' => "http://fashion.huanqiu.com/news/2017-06/10782622.html",
                            'description' => '京东集团创始人、董事局主席兼首席执行官及京东集团今天下午在中国人民大学宣布',
                            'picurl' => "https://b.bdstatic.com/boxlib/20170604/201706042009167154745049.jpg"
                        ),
                        array(
                            'title' => "陈妍希美图仙气十足 素颜自拍冻龄吸睛",
                            'date' => "2017-6-4",
                            'url' => "http://fashion.huanqiu.com/news/2017-06/10782624.html",
                            'description' => '充电 5 分钟，通话 2 小时这句广告词',
                            'picurl' => "https://b.bdstatic.com/boxlib/20170604/201706042009164053282039.jpg"
                        )

            			);

					//发送消息的xml格式模板 文本模板
					$textTpl = <<<EOT
					<xml>
					<ToUserName><![CDATA[%s]]></ToUserName>
					<FromUserName><![CDATA[%s]]></FromUserName>
					<CreateTime>%s</CreateTime>
					<MsgType><![CDATA[%s]]></MsgType>
					<ArticleCount>%s</ArticleCount>
					<Articles>

EOT;

					//遍历输出数据
					$str = "";
					foreach($arr as $v) {

						$str .="<item>";
						$str .="<Title><![CDATA[".$v['title']."]]></Title> ";
						$str .="<Description><![CDATA[".$v['description']."]]></Description>"; 
						$str .="<PicUrl><![CDATA[".$v['picurl']."]]></PicUrl>";
						$str .="<Url><![CDATA[".$v['url']."]]></Url>";
						$str .="</item>";
		            	}
		            $textTpl .= $str;
		            $textTpl .="</Articles>";
		            $textTpl .="</xml>";

		            $time = time();
					$msgtype = 'news';
					$content = count($arr); //文章数量
		            //格式化的字符串
		            $res = sprintf($textTpl, $fromusername, $tousername, $time, $msgtype, $content);

		           echo $res;

				}

				  //接收关键字美女 返回美女图片

				if($keyword == '帅哥') {

					////发送消息的xml格式模板 图片消息模板

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

					$time = time();
					$msgtype = 'image';
					$media_id = '-IBQpUlGp2nHQN4baITRG41qia8EhcOVVkSmQXeGh21xTmqE4AmdS9oN7Rsm3DVT';
					//格式化的字符串
					$res = sprintf($textTpl, $fromusername, $tousername, $time, $msgtype, $media_id);
					echo $res;
				}
            }

            //判断是否发生了事件的推送
            if($msgtype == 'event') {

            	$event = $postObj->Event;
            	//订阅事件(关注、取消事件)用户未关注时，进行关注后的事件推送
            	if($event == 'Event') {
					$textTpl = "<xml>
								<ToUserName><![CDATA[%s]]></ToUserName>
								<FromUserName><![CDATA[%s]]></FromUserName>
								<CreateTime>%s</CreateTime>
								<MsgType><![CDATA[%s]]></MsgType>
								<Content><![CDATA[%s]]></Content>
								<FuncFlag>0</FuncFlag>
							 </xml>"; 

					$time = time();
					$msgtype = $postObj->MsgType;
					$content = "欢迎来到自娱自乐公众号开发世界!请输入帅哥查看图片，有效期仅限今天";  

					$res = sprintf($textTpl, $fromusername, $tousername, $time, $msgtype, $content);
					echo $res;

            		
            	}
            }

        //关注时默认发送的消息
        $textTpl = "<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[%s]]></MsgType>
						<Content><![CDATA[%s]]></Content>
						<FuncFlag>0</FuncFlag>
					</xml>"; 

			$time = time();
			$msgtype = 'text';
			$content = "欢迎来到自娱自乐公众号开发世界!";  

			$res = sprintf($textTpl, $fromusername, $tousername, $time, $msgtype, $content);
			echo $res;

			
        }else {
            echo "";
            exit;
        }
    }

    //验证服务器地址的有效性
    private function checkSignature()
    {
        /*
        1）将token、timestamp、nonce三个参数进行字典序排序
        2）将三个参数字符串拼接成一个字符串进行sha1加密
        3）开发者获得加密后的字符串可与signature对比，标识该请求来源于微信*/
        // you must define TOKEN by yourself
        if (!defined("TOKEN")) {
            throw new Exception('TOKEN is not defined!');
        }

        $signature = $_GET["signature"];

        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        $token = TOKEN;

        $tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }


    //curl请求 ，获取返回的数据
    public function getAccessToken ()
    {

    	//判断session中是否有access_token这个值 及是否在有效期内
    	if($_SESSION['access_token'] && (time()-$_SESSION['expire_time']) < 7200 ) {

    			return $_SESSION['access_token'];
    	}else{

    	$appID = "wxedd491740234652e";
		$appsecret = "3c8d369477fff7e9c612f6adc64a0900";
		$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appID."&secret=".$appsecret;
    	//没有则写入session
    	$access_token = $this->jsonToArray($this->getData($url))['access_token'];

    	$_SESSION['access_token'] = $access_token;
    	$_SESSION['expire_time'] = time(); 

    	return access_token;
    	}
    }

    //获取accessToken的值

    public function getData() {
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

	    //返回
	   return $res;
    }

    //JSON转化为数组
    public function jsonToArray($json) {

    	$arr = json_decode($json , true);

    	return $arr;
    }
}

?>
