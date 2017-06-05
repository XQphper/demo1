<?php

    include "../vendor/autoload.php";

    $json = <<<EOT
     {
     "button":[
     {	
          "type":"click",
          "name":"今日歌曲",
          "key":"V1001_TODAY_MUSIC"
      },
      {
           "name":"菜单",
           "sub_button":[
           {	
               "type":"view",
               "name":"搜索",
               "url":"http://www.soso.com/"
            },
            {
                 "type":"miniprogram",
                 "name":"wxa",
                 "url":"http://mp.weixin.qq.com",
                 "appid":"wx286b93c14bbf93aa",
                 "pagepath":"pages/lunar/index.html"
             },
            {
               "type":"click",
               "name":"赞一下我们",
               "key":"V1001_GOOD"
            }]
       }]
 }
EOT;

    $arr = json_decode($json,1);
//    dump($arr);

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
                        "name"=>urlencode("美妆"),
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
    // dump($arr);
    echo urldecode(json_encode($arr));

