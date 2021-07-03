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
    if (empty($_POST['sqlServerHost'])) {
        header("location:/install/install-1.php?tishi=数据库地址不得为空！#example1-tab2");
        exit;
    }
    if (empty($_POST['sqlDbPort'])) {
        header("location:/install/install-1.php?tishi=数据库服务端口不得为空！#example1-tab2");
        exit;
    }
    if (empty($_POST['sqlUserName'])) {
        header("location:/install/install-1.php?tishi=数据库用户名不得为空！#example1-tab2");
        exit;
    }
    if (!isset($_POST['sqlPassWord'])) {
        header("location:/install/install-1.php?tishi=数据库密码不存在！#example1-tab2");
        exit;
    }
    if (empty($_POST['sqlDbName'])) {
        header("location:/install/install-1.php?tishi=数据库名称不得为空！#example1-tab2");
        exit;
    }

    function insert($file, $name, $root, $pwd, $database, $port)
    {
        //将表导入数据库
        $_sql = file_get_contents($file);//写自己的.sql文件
        $_arr = explode(';', $_sql);
        $_mysqli = new mysqli($name, $root, $pwd, $database, $port);//第一个参数为域名，第二个为用户名，第三个为密码，第四个为数据库名字
        if (mysqli_connect_errno()) {
            return false;
        } else {
            //执行sql语句
            $_mysqli->query('set names utf8;'); //设置编码方式
            foreach ($_arr as $_value) {
                $_mysqli->query($_value.';');
            }
            return true;
        }
        $_mysqli->close();
        $_mysqli = null;
    }

    if (insert("mysql.sql", $_POST['sqlServerHost'], $_POST['sqlUserName'], $_POST['sqlPassWord'], $_POST['sqlDbName'], $_POST['sqlDbPort']) == false) {
        header("location:/install/install-1.php?tishi=数据库创建失败请检查填写是否有误，或是否给予权限！#example1-tab2");
        exit;
    }

    $filename='../config/sqlConfig.php';
    $str_file=file_get_contents($filename);
    $pattern="/'DB_HOST',.*?\)/";
    if (preg_match($pattern, $str_file)) {
        $_POST['sqlServerHost']=addslashes($_POST['sqlServerHost']);
        $str_file=preg_replace($pattern, "'DB_HOST','{$_POST['sqlServerHost']}')", $str_file);
    }
    $pattern="/'DB_USER',.*?\)/";
    if (preg_match($pattern, $str_file)) {
        $_POST['sqlUserName']=addslashes($_POST['sqlUserName']);
        $str_file=preg_replace($pattern, "'DB_USER','{$_POST['sqlUserName']}')", $str_file);
    }
    $pattern="/'DB_PASSWORD',.*?\)/";
    if (preg_match($pattern, $str_file)) {
        $_POST['sqlPassWord']=addslashes($_POST['sqlPassWord']);
        $str_file=preg_replace($pattern, "'DB_PASSWORD','{$_POST['sqlPassWord']}')", $str_file);
    }
    $pattern="/'DB_DATABASE',.*?\)/";
    if (preg_match($pattern, $str_file)) {
        $_POST['sqlDbName']=addslashes($_POST['sqlDbName']);
        $str_file=preg_replace($pattern, "'DB_DATABASE','{$_POST['sqlDbName']}')", $str_file);
    }
    $pattern="/\('DB_PORT',.*?\)/";
    if (preg_match($pattern, $str_file)) {
        $_POST['sqlDbPort']=addslashes($_POST['sqlDbPort']);
        $str_file=preg_replace($pattern, "('DB_PORT','{$_POST['sqlDbPort']}')", $str_file);
    }
    if (!file_put_contents($filename, $str_file)) {
        header("location:/install/install-1.php?tishi=数据库创建成功，数据库配置文件写入失败，请检查程序目录权限后再试！#example1-tab2");
        exit;
    }
    header("location:/install/install-2.php?tishi=数据库创建成功，配置文件写入成功，请添加管理账号！#example1-tab3");
    exit;
}
?>
<?php include_once "header.php"; ?>
				<div class="mdui-tab mdui-tab-full-width" mdui-tab>
				  	<a href="#example1-tab1" class="mdui-ripple" disabled>程序介绍</a>
				  	<a href="#example1-tab2" class="mdui-ripple">数据库配置</a>
				  	<a href="#example1-tab3" class="mdui-ripple" disabled>管理员配置</a>
				  	<a href="#example1-tab4" class="mdui-ripple" disabled>获取授权</a>
                      <a href="#example1-tab5" class="mdui-ripple" disabled>安装完成</a>
				</div>

				<div id="example1-tab2" class="mdui-p-a-2">
					<form method="post" enctype="multipart/form-data">
						<div class="mdui-textfield mdui-textfield-floating-label">
							<label class="mdui-textfield-label">数据库服务器</label>
							<input class="mdui-textfield-input" name="sqlServerHost" value="localhost"/>
						</div>
						<div class="mdui-textfield mdui-textfield-floating-label">
							<label class="mdui-textfield-label">数据库用户名</label>
							<input class="mdui-textfield-input" name="sqlUserName"/>
						</div>
						<div class="mdui-textfield mdui-textfield-floating-label">
							<label class="mdui-textfield-label">数据库密码</label>
							<input class="mdui-textfield-input" name="sqlPassWord" type="password"/>
						</div>
						<div class="mdui-textfield mdui-textfield-floating-label">
							<label class="mdui-textfield-label">数据库端口</label>
							<input class="mdui-textfield-input" name="sqlDbPort" value="3306"/>
						</div>
						<div class="mdui-textfield mdui-textfield-floating-label">
							<label class="mdui-textfield-label">数据库名</label>
							<input class="mdui-textfield-input" name="sqlDbName"/>
						</div>
						<div class="mdui-divider mdui-m-t-4 mdui-m-b-2"></div>
						<a href="index.php"><button type="button" class="mdui-btn mdui-color-pink-accent mdui-m-a-1 mdui-float-left">上一步</button></a>
						<button type="submit" name="submit" class="mdui-btn mdui-color-pink-accent mdui-m-a-1 mdui-float-right">下一步</button>
					</form>
				</div>
<?php include_once "footer.php"; ?>