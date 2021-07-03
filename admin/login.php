<?php
    @header("Content-type: text/html; charset=utf-8");
    //引入数据库配置
    require_once "../config/sqlConfig.php";
    //引入数据库操作函数库
    require_once "../public/dbInc.php";

    //启动session
    @session_start();

    //数据库连接检测
    $conn = Connect();

    //其余

    //引入基本配置
    require_once "../config/systemConfig.php";
    //require_once "../pubic/serverInc.php";//引入授权文件
    
    //判断是否登入
    if (!empty($_SESSION['id'])) {
        echo '<script>window.location.href="index.php?notifications=1&notifications_content=您已登录"</script>';
        exit;
    }

    if ($_POST['state'] == 'login') {

        //极验二次验证
        require_once dirname(dirname(__FILE__)) . '/public/geetest/lib/class.geetestlib.php';
        require_once dirname(dirname(__FILE__)) . '/public/geetest/config/config.php';
        
        $GtSdk = new GeetestLib(CAPTCHA_ID, PRIVATE_KEY);
        if ($_SESSION['gtserver'] == 1) {   //服务器正常
            $result = $GtSdk->success_validate($_POST['geetest_challenge'], $_POST['geetest_validate'], $_POST['geetest_seccode']);
            if ($result) {
            } else {
                echo '<script>window.location.href="login.php?notifications=2&notifications_content=人机验证失败，请重新验证！"</script>';
                exit;
            }
        } else {  //服务器宕机,走failback模式
            if ($GtSdk->fail_validate($_POST['geetest_challenge'], $_POST['geetest_validate'], $_POST['geetest_seccode'])) {
            } else {
                echo '<script>window.location.href="login.php?notifications=2&notifications_content=人机验证失败，请重新验证！"</script>';
                exit;
            }
        }
        

        if (empty($_POST['username'])) {
            echo '<script>window.location.href="login.php?notifications=2&notifications_content=请输入账号"</script>';
            exit;
        }
        if (empty($_POST['password'])) {
            echo '<script>window.location.href="login.php?notifications=2&notifications_content=请输入密码"</script>';
            exit;
        }

        $username = addslashes($_POST['username']);//获取登录表单信息
        $password = md5($_POST['password']);//获取登录表单信息

        $sql = Execute($conn, "select * from user where username = '{$username}' and password = '{$password}'");//查询数据库

        if (mysqli_num_rows($sql) !== 1) {
            echo '<script>window.location.href="login.php?notifications=2&notifications_content=账号或密码错误"</script>';
            exit;
        }

        $result = mysqli_fetch_array($sql);

        //登陆成功设置session id
        $_SESSION['id'] = $result['id'];

        echo '<script>window.location.href="index.php?notifications=1&notifications_content=登陆成功"</script>';
        exit;
    }
    Close($conn); //关闭数据库连接
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
		<meta name="viewport" content="width=device-width">
        <title><?php echo SYSTEM_TITTLE;?></title>
		<meta name="keywords" content="<?php echo SYSTEM_KEYWORDS;?>">
		<meta name="description" content="<?php echo SYSTEM_DESCRIPTION;?>">
        <!-- App favicon -->
        <link rel="shortcut icon" href="./favicon.ico">
        <!-- App css -->
        
        <!-- build:css -->
		<meta name=”referrer” content=”no-referrer” />
        <link href="../assets/css/app.min.css" rel="stylesheet" type="text/css" />
        <!-- endbuild -->
    </head>

    <body class="authentication-bg">
      
        <div class="account-pages mt-5 mb-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5">

<?php
    /*
    弹窗提示
    $_GET['notifications'] 状态
    参数1，2，3/success,warning,danger
    $_GET['notifications_content'] 内容
    */
    if ($_GET['notifications'] == "1" || $_GET['notifications'] == "2" || $_GET['notifications'] == "3") {
        if ($_GET['notifications'] == '1') {
            $notifications = 'success';
        }
        if ($_GET['notifications'] == '2') {
            $notifications = 'warning';
        }
        if ($_GET['notifications'] == '3') {
            $notifications = 'danger';
        } ?>
                    <div class="alert alert-<?php echo $notifications?> alert-dismissible bg-<?php echo $notifications?> text-white border-0 fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <?php echo $_GET['notifications_content']?>
                    </div>
<?php
    }
?>
                        <div class="card">

                            <!-- Logo -->
                            <div class="card-header pt-4 pb-4 text-center bg-primary">
                                <span class="logo-lg">
                                        <h1 class="mdi mdi-heart-pulse" style="font-size:80px"></h1>
                                </span>
                            </div>

                            <div class="card-body p-4">
                                
                                <div class="text-center w-75 m-auto">
                                    <h4 class="text-dark-50 text-center mt-0 font-weight-bold">管理后台</h4>
                                </div><br>

                                <form method="post" action="login.php">
                                    <input name="state" style="display: none;" value="login" />
                                    <div class="form-group mb-3">
                                        <label for="emailaddress">账号</label>
                                        <input class="form-control" type="text" name="username" placeholder="请输入账号...">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="password">密码</label>
                                        <input class="form-control" type="password" name="password" placeholder="请输入密码..." >
                                    </div>

                                    <div  class="form-group mb-3"><br>
                                        <!-- 极验 --> 
                                        <div id="embed-captcha"></div>
                                        <div id="notice" class="hide" role="alert">请先完成验证</div>
                                        <p id="wait" class="show">正在加载验证码......</p>
                                    </div>

                                    <div class="form-group mb-0 text-center">
                                        <button id="embed-submit" class="btn btn-primary" name="login" type="submit"> 登 录 </button>
                                    </div>

                                </form>
                            </div> <!-- end card-body -->
                        </div>
                        <!-- end card -->

                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end page -->
        <footer class="footer footer-alt">
            <?php echo SYSTEM_COPYRIGHT;?>
        </footer>
<!-- 引入极验所需 -->
<?php require_once '../public/geetest/geetest.php';?>
    </body>
</html>
