<?php
/*
 * @Description: 
 * @Autor: 吃纸怪
 * @QQ: 2903074366
 * @Email: 2903074366@qq.com
 * @QQgroup: 801235342
 * @Github: https://github.com/zhiguai
 */
if ($_GET['state'] == "server") {
    @header("content-type:application/json; charset=utf-8");
    @header('Access-Control-Allow-Origin: *');
    //引入数据库配置
    require_once "./config/sqlConfig.php";
    //引入数据库操作函数库
    require_once "./public/dbInc.php";
    //数据库连接检测
    $conn = Connect();
    // 报告 E_NOTICE 之外的所有错误
    error_reporting(E_ALL & ~E_NOTICE);
	$sqlcont='select * from card';//卡
	$data['cntcont']=mysqli_num_rows(Execute($conn,$sqlcont));
	$resspk='select * from comment';//评论
	$data['cntspk']=mysqli_num_rows(Execute($conn,$resspk));
	$reszan='select * from zan';//赞
	$data['rowzan']=mysqli_num_rows(Execute($conn,$reszan));
    $data['version'] = SYSTEM_VERSION;
    $data['version_r'] = "1.0.4.3";//详细版本号
    $data['state'] = "200";
    echo json_encode($data);
    exit;
}
if (is_dir("./install")) {
    if (file_exists("./install/lock.txt")) {
        header("location:./index/index.php?notifications=2&notifications_content=请务必删除程序主目录下的install文件夹后再投入使用！！！");
        exit;
    }
    header("location:./install/index.php");
    exit;
}
header("location:./index/index.php");
exit;
