<?php include './public.php';?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
		<meta name="viewport" content="width=device-width">
        <title><?php echo stripslashes(SYSTEM_TITTLE);?></title>
		<meta name="keywords" content='<?php echo stripslashes(SYSTEM_KEYWORDS);?>'>
		<meta name="description" content='<?php echo stripslashes(SYSTEM_DESCRIPTION);?>'>
		
        <!-- App favicon -->
        <link rel="shortcut icon" href="../favicon.png">
        <!-- App css -->
        
        <!-- build:css -->
		<meta name=”referrer” content=”no-referrer” />
        <link href="../assets/css/app.min.css" rel="stylesheet" type="text/css" />
        <!-- endbuild -->
      
        <!-- css -->
        <style type="text/css">
        .foot-left{
            float: left;
            font-size: 13px;
            font-family: "微软雅黑";
            font-weight: bold;
        }
        .foot-right{
            float: right;
            font-size: 13px;
            font-family: "微软雅黑";
            font-weight: bold;
        }
        </style>
        <!-- css -->
    </head>

    <body>
        <!-- 侧栏 -->
        <div class="wrapper">

            <!-- ========== Left Sidebar Start ========== -->
            <div class="left-side-menu">

                <div class="slimscroll-menu">

                    <!-- LOGO图标 -->
					<a class="logo text-center mb-4 active">
                        <span class="logo-lg">
								<h1 class="mdi mdi-heart-pulse" style="font-size:80px"></h1>
                        </span>
                        <span class="logo-sm">
                            <img src="../assets/htmlimg/logo_sm.png" alt="" height="16">
                        </span>
                    </a>

                    <!--- 导航 -->
                    <ul class="metismenu side-nav">

                        <li class="side-nav-title side-nav-item">管理员导航</li>

                        <li class="side-nav-item">
                            <a href="./index.php" class="side-nav-link">
                                <i class="dripicons-meter"></i>
                                <span> 后台首页 </span>
                            </a>
                        </li>

                        <li class="side-nav-item">
                            <a href="" class="side-nav-link">
                                <i class="mdi mdi-heart-box"></i>
                                <span> 数据管理 </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul class="side-nav-second-level" aria-expanded="false">
                                <li style="display:none">
                                    <a href="./index.php"></a>
                                </li>
                                <li>
                                    <a href="./card.php">卡片管理</a>
                                </li>
                                <li>
                                  	<a href="./comment.php">评论管理</a>
                                </li>
                                </li>
                                <li style="display:none">
                                    <a href="./system.php">基本设置</a>
                                </li>
                                <li style="display:none">
                                  	<a href="./user.php">账号管理</a>
                                </li>
                            </ul>
                        </li>
<?php
if($admin_data['power'] == "1"){
?>
                        <li class="side-nav-item">
                            <a href="" class="side-nav-link">
                                <i class="mdi mdi-server"></i>
                                <span> 系统管理 </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul class="side-nav-second-level" aria-expanded="false">
                                <li style="display:none">
                                    <a href="./index.php"></a>
                                </li>
                                <li style="display:none">
                                    <a href="./card.php">卡片管理</a>
                                </li>
                                <li style="display:none">
                                  	<a href="./comment.php">评论管理</a>
                                </li>
                                </li>
                                <li>
                                    <a href="./system.php">基本设置</a>
                                </li>
                                <li>
                                  	<a href="./user.php">账号管理</a>
                                </li>
                            </ul>
                        </li>
<?php }?>
                        <li class="side-nav-item">
                            <a href="../index.php" class="side-nav-link">
                                <input type="submit" class="btn btn-warning btn-rounded" style="width:100%" value="返回主站">
                            </a>
                        </li> 

    					<li class="side-nav-item">
                            <a href="" class="side-nav-link"> 		
                                <form method="post" action="index.php">
                                    <input name="state" type="hidden" value="logout" style="display: none;" />
                                    <input type="submit" class="btn btn-danger btn-rounded" style="width:100%" value="登出后台">
                                </form>
                            </a>
                          </li> 
                                       
                    </ul>
                    <!-- End Sidebar -->

                    <div class="clearfix"></div>

                </div>
                <!-- 导航 -->

            </div>
            <!-- 侧栏 -->

            <!-- ============================================================== -->
            <!-- 分界线 -->
            <!-- ============================================================== -->

            <div class="content-page">
                <div class="content">

                    <!-- 顶栏 -->
                    <div class="navbar-custom">
                      
                        <ul class="list-unstyled topbar-right-menu float-right mb-0">
                            <li class="dropdown notification-list">
                                <a href="" class="nav-link right-bar-toggle mr-0">
                                    当前帐号:<?php echo $admin_data['username'];?>
                                </a>
                            </li>
                        </ul>
                      
                        <div class="app-search">
                            <form action="card.php" method="get">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="searchcont" placeholder="Search...">
                                    <span class="mdi mdi-magnify"></span>
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" name="search" type="submit">搜索</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <button class="button-menu-mobile open-left disable-btn">
                            <i class="mdi mdi-menu"></i>
                        </button>
                    </div>
                    <!-- 顶栏 -->

                    <!-- Start Content-->
                    <div class="container-fluid">
                        <!-- 头部引入页面-->
                <?php 
                    /*
                    弹窗提示
                    $_GET['notifications'] 状态
                    参数1，2，3/success,warning,danger
                    $_GET['notifications_content'] 内容
                    */
                    if($_GET['notifications'] == "1" || $_GET['notifications'] == "2" || $_GET['notifications'] == "3"){
                        if($_GET['notifications'] == '1'){
                            $notifications = 'success';
                        }
                        if($_GET['notifications'] == '2'){
                            $notifications = 'warning';
                        }
                        if($_GET['notifications'] == '3'){
                            $notifications = 'danger';
                        }
                ?>
                    <div class="alert alert-<?php echo $notifications?> alert-dismissible bg-<?php echo $notifications?> text-white border-0 fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <?php echo $_GET['notifications_content']?>
                    </div>
                <?php 
                    }
                ?>