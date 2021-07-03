<?php
header('Content-type:text/html;charset=utf-8');
require_once "../config/sqlConfig.php";
if (!empty($_GET['tishi'])) {
    echo <<<"STR"
<script type="text/javascript">
	window.onload=function(){
	  mdui.snackbar({
	    message: '{$_GET['tishi']}',
	    position: 'left-top'
	  });
	}
</script>
STR;
}

if (isset($_POST['submit'])) {
    
    if (empty($_POST['url'])) {
        header("location:/install/install-3.php?&tishi=域名不得为空！#example1-tab4");
        exit;
    }
    if (empty($_POST['email'])) {
        header("location:/install/install-3.php?&tishi=email不得为空！#example1-tab4");
        exit;
    }

    //请求key
    $url= "https://server.fatda.cn/public-api.php?state=addurl&email=".$_POST['email']."&url=".$_POST['url'];//构造请求地址
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
        header("location:/install/install-3.php?&tishi=授权服务器连接失败！#example1-tab4");
        exit;
    }else{
        //请求有效
        $arr = json_decode($file_content,true);//对json格式的字符串进行编码，同时进行数组化
        if($arr['code'] == "501"){
            header('location:/install/install-3.php?&tishi='.$arr['code'].':'.$arr['state'].'！#example1-tab4');
            exit;
        }
        if($arr['code'] == "200"){

            if (empty($arr['key'])) {
                header("location:/install/install-3.php?&tishi=key为空值，请重试！#example1-tab4");
                exit;
            }

            $filename='../config/systemConfig.php';
            $str_file=file_get_contents($filename);
            $pattern="/'SYSTEM_KEY',.*?\)/";
            if (preg_match($pattern, $str_file)) {
                $arr['key']=addslashes($arr['key']);
                $str_file=preg_replace($pattern, "'SYSTEM_KEY','{$arr['key']}')", $str_file);
            }
            $pattern="/'SYSTEM_URL',.*?\)/";
            if (preg_match($pattern, $str_file)) {
                $_POST['url']=addslashes($_POST['url']);
                $str_file=preg_replace($pattern, "'SYSTEM_URL','{$_POST['url']}')", $str_file);
            }
            if (!file_put_contents($filename, $str_file)) {
                header("location:/install/install-3.php?&tishi=基础配置文件写入失败，请检查程序目录权限后再试！#example1-tab4");
                exit;
            }
            if (!file_put_contents("lock.txt", "FatDa")) {
                header("location:/install/install-4.php?tishi=安装记录生成失败,请删除install文件夹！#example1-tab5");
                exit;
            }
            header("location:/install/install-4.php?&tishi=配置文件写入成功，授权结束，请删除install文件夹！#example1-tab5");
            exit;
        }
        header('location:/install/install-3.php?&tishi=未知错误'.$arr['code'].':'.$arr['state'].'！#example1-tab4');
        exit;
    }
}
?>
<?php include_once "header.php"; ?>
				<div class="mdui-tab mdui-tab-full-width" mdui-tab>
				  	<a href="#example1-tab1" class="mdui-ripple" disabled>程序介绍</a>
				  	<a href="#example1-tab2" class="mdui-ripple" disabled>数据库配置</a>
				  	<a href="#example1-tab3" class="mdui-ripple" disabled>管理员配置</a>
				  	<a href="#example1-tab4" class="mdui-ripple" >获取授权</a>
                    <a href="#example1-tab5" class="mdui-ripple" disabled>安装完成</a>
				</div>

				<div id="example1-tab4" class="mdui-p-a-2">
					<form  method="post" enctype="multipart/form-data">
						<div class="mdui-textfield mdui-textfield-floating-label">
							<label class="mdui-textfield-label">域名(不加[http://.../])</label>
							<input class="mdui-textfield-input" name="url" value="<?php echo $_SERVER['HTTP_HOST'];?>" />
						</div>
						<div class="mdui-textfield mdui-textfield-floating-label">
							<label class="mdui-textfield-label">邮箱</label>
							<input class="mdui-textfield-input" name="email"/>
						</div>
						<div class="mdui-textfield mdui-textfield-floating-label">
                            <!-- 极验 --> 
                            <div id="embed-captcha"></div>
                            <div id="notice" class="hide mdui-chip ">
                                <span class="mdui-chip-title">请先完成验证</span>
                            </div>
                            <p id="wait" class="show">正在加载验证码......</p>
						</div>

						<div class="mdui-divider mdui-m-t-4 mdui-m-b-2"></div>
						<a href="install-2.php?#example1-tab3"><button type="button" class="mdui-btn mdui-color-pink-accent mdui-m-a-1 mdui-float-left">上一步</button></a>
						<button id="embed-submit" type="submit" name="submit" class="mdui-btn mdui-color-pink-accent mdui-m-a-1 mdui-float-right">下一步</button>
					</form>
				</div>
<!-- 引入极验所需 -->
<?php require_once '../public/geetest/geetest.php';?>
<?php include_once "footer.php"; ?>