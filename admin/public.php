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

    // 报告 E_NOTICE 之外的所有错误
    error_reporting(E_ALL & ~E_NOTICE);
    //引入基本配置
    require_once "../config/systemConfig.php";
    //require_once "../public/serverInc.php";
    
    //ip获取函数
    function GetClientIp()
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        if (isset($_SERVER['HTTP_CLIENT_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']) and preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches)) {
            foreach ($matches[0] as $xip) {
                if (!preg_match('#^(10|172\.16|192\.168)\.#', $xip)) {
                    $ip = $xip;
                    break;
                }
            }
        }
        return $ip;
    }

    //常用变量
    $ip = GetClientIp();
    //判断是否登入
    if (empty($_SESSION['id'])) {
        echo '<script>window.location.href="login.php?notifications=2&notifications_content=请先登录"</script>';
        exit;
    }
    //账号退出
    if ($_POST['state'] == 'logout') {
        unset($_SESSION['id']);
        echo '<script>window.location.href="../index/index.php?notifications=1&notifications_content=退出成功"</script>';
        exit;
    }
    
    //获取管理员信息
    $sql = Execute($conn, "select * from user where id = '{$_SESSION['id']}'");//查询数据
    $admin_data = mysqli_fetch_assoc($sql);
/*
    //判断当前登录者权限
    if($admin_data['power'] !== "1"){
        echo "<script>window.location.href=\"index.php?notifications=3&notifications_content=权限不足\"</script>";
        exit;
    }
 */
