<?php
//授权代码
$key=rawurlencode(SYSTEM_KEY);
$url= "https://server.fatda.cn/api.php?key={$key}&name={$_SERVER['HTTP_HOST']}&version=".SYSTEM_VERSION;//构造请求地址

//构建$file_content的https请求条件
$stream_opts = [
    "ssl" => [
        "verify_peer"=>false,
        "verify_peer_name"=>false,
    ]
]; 
@$file_content = file_get_contents($url,false, stream_context_create($stream_opts));//发起请求并返回标准的json

//判断请求是否失败
if(!$file_content){
    $contents = "授权服务器连接失败！";
}else{
    $arr = json_decode($file_content,true);//对json格式的字符串进行编码，同时进行数组化
    if($arr['state'] == "500"){
        $state ="500";
        $contents = $arr['contents'];
    }
    if($arr['state'] == "300"){
        $state ="300";
        $contents = $arr['contents'];
    }
    if($arr['state'] == "501"){
        $state ="501";
        $contents = $arr['contents'];
    }
    if($arr['state'] == "502"){
        $state ="502";
        $contents = $arr['contents'];
    }
    if($arr['state'] == "200"){
        if($arr['url_state'] == "0"){
            $state ="0";
            $contents = $arr['contents'];
        }
        if($arr['url_state'] == "2"){
            $state ="2";
            $contents = $arr['contents'];
        }
        if($arr['url_state'] == "1"){
            $state ="200";
        }
        
    }
    if($state !== "200"){
    echo "<html>
            <head>
                <meta charset=\"utf-8\"><meta name=\"viewport\" content=\"width=device-width\">
                <link rel=\"stylesheet\" href=\"https://cdn.bootcss.com/mdui/0.4.3/css/mdui.min.css\"/>
            </head>
            <body class=\"mdui-theme-primary-indigo mdui-theme-accent-pink\"><div class=\"mdui-container\">
                <div class=\"mdui-row mdui-m-t-2\">	<div class=\"mdui-col-md-6 mdui-col-offset-md-3\">
                    <div class=\"mdui-card\">
                        <div class=\"mdui-card-media\">
                            <img src=\"https://api.ixiaowai.cn/mcapi/mcapi.php\"/>
                        </div>
                        
                        <div class=\"mdui-card-content\"><h2>⚠-Code:{$state}-{$contents}</h2><br>
                            <h3>{$arr['site_name']}|{$arr['site_version']}-{$arr['site_time']}:</h3>
                            {$arr['site_introduce']}
                            </div>
                    </div>
                </div>
            </body>
            <script src=\"https://cdn.bootcss.com/mdui/0.4.3/js/mdui.min.js\"></script>
        </html>";
    exit;
    }
}

?>