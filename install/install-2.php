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
    require_once "../public/dbInc.php";
    //连接数据库
    $conn=Connect();

    if (empty($_POST['username']) || empty($_POST['password'])) {
        header("location:/install/install-2.php?&tishi=请勿留空！#example1-tab3");
        exit;
    }
    if (mb_strlen($_POST['username'], 'UTF8') > 24) {
        header("location:/install/install-2.php?&tishi=用户名名不能超出24个字符！#example1-tab3");
        exit;
    }
    if (mb_strlen($_POST['username'], 'UTF8') < 6) {
        header("location:/install/install-2.php?&tishi=用户名不得低于6个字符！#example1-tab3");
        exit;
    }

    $query="select * from user where username='{$_POST['username']}'";
    $result=Execute($conn, $query);
    if (mysqli_num_rows($result)) {
        header("location:/install/install-2.php?&tishi=用户名已存在请更换后再试！#example1-tab3");
        exit;
    }
    
    if (mb_strlen($_POST['password'], 'UTF8') > 24) {
        header("location:/install/install-2.php?&tishi=密码不能超出24个字符！#example1-tab3");
        exit;
    }
    if (mb_strlen($_POST['password'], 'UTF8') < 6) {
        header("location:/install/install-2.php?&tishi=密码不能低于6个字符！#example1-tab3");
        exit;
    }

    $_POST['password'] = md5($_POST['password']);
    $sql = "INSERT INTO user (username,password,power)
    VALUES ('{$_POST['username']}','{$_POST['password']}','1')";
    
    if (Execute($conn, $sql)) {
        header("location:/install/install-3.php?tishi=账户添加成功！#example1-tab4");
        exit;
    }
    header("location:/install/install-2.php?&tishi=账户添加失败,请检查权限后重试！#example1-tab3");
    exit;
}
?>
<?php include_once "header.php"; ?>
                <div class="mdui-tab mdui-tab-full-width" mdui-tab>
				  	<a href="#example1-tab1" class="mdui-ripple" disabled>程序介绍</a>
				  	<a href="#example1-tab2" class="mdui-ripple" disabled>数据库配置</a>
				  	<a href="#example1-tab3" class="mdui-ripple" >管理员配置</a>
				  	<a href="#example1-tab4" class="mdui-ripple" disabled>获取授权</a>
                      <a href="#example1-tab5" class="mdui-ripple" disabled>安装完成</a>
				</div>
				<div id="example1-tab3" class="mdui-p-a-2">
					<form  method="post" enctype="multipart/form-data">
						<div class="mdui-textfield mdui-textfield-floating-label">
							<label class="mdui-textfield-label">用户名</label>
							<input class="mdui-textfield-input" name="username" />
						</div>
						<div class="mdui-textfield mdui-textfield-floating-label">
							<label class="mdui-textfield-label">密码</label>
							<input class="mdui-textfield-input" name="password" type="password" />
						</div>

						<div class="mdui-divider mdui-m-t-4 mdui-m-b-2"></div>
						<a href="install-1.php?tab=2#example1-tab2"><button type="button" class="mdui-btn mdui-color-pink-accent mdui-m-a-1 mdui-float-left">上一步</button></a>
						<button type="submit" name="submit" class="mdui-btn mdui-color-pink-accent mdui-m-a-1 mdui-float-right">下一步</button>
					</form>
				</div>
<?php include_once "footer.php"; ?>