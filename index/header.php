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
        .left-side-menu{
            background: linear-gradient(135deg,#fa5c7c 0,#fa5c7cf0 60%);
        }
        .enlarged .side-nav .side-nav-item:hover .side-nav-link{
            background: linear-gradient(135deg,#fa5c7c 0,#fa5c7cf0 60%);
        }
        a{
            color:#fa5c7c80;
        }
        a:hover{
            color:#fa5c7c;
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
							<h1 class="mdi mdi-heart-pulse text-white" style="font-size:80px"></h1>
                        </span>
                        <span class="logo-sm">
                            <img src="../assets/htmlimg/logo_sm.png" alt="" height="16">
                        </span>
                    </a>

                    <!--- 导航 -->
                    <ul class="metismenu side-nav">

                        <li class="side-nav-title side-nav-item">导航</li>

                        <li class="side-nav-item">
                            <a href="./index.php" class="side-nav-link">
                                <i class="dripicons-meter"></i>
                                <span class="badge badge-success float-right">人气</span>
                                <span> 门户首页 </span>
                            </a>
                        </li>

                        <li class="side-nav-item">
                            <a href="./wall.php" class="side-nav-link">
                                <i class="mdi mdi-wall"></i>
                                <span> 表白墙 </span>
                            </a>
                        </li>

                        <li class="side-nav-item">
                            <a href="./writeCard.php" class="side-nav-link">
                                <i class="mdi mdi-heart-box"></i>
                                <span> 我要表白 </span>
                            </a>
                        </li>

                        <li class="side-nav-item">
                            <a href="./email.php" class="side-nav-link">
                                <i class="mdi mdi-email"></i>
                                <span class="badge badge-success float-right">新</span>
                                <span> 邮局 </span>
                            </a>
                        </li>

                        <li class="side-nav-item">
                            <a href="./search.php" class="side-nav-link">
                                <i class="mdi mdi-database-search"></i>
                                <span> 搜索 </span>
                            </a>
                        </li>
                    </ul>
                  
                    <!-- Help Box
                    <div class="help-box text-center text-white">
                        <a href="" class="float-right close-btn text-white">
                            <i class="mdi mdi-close"></i>
                        </a>
                        <img src="../assets/htmlimg/help-icon.svg" height="90" alt="" />
                        <h5 class="mt-3">遇到问题?</h5>
                        <p class="mb-3">点击下面按钮联系客服</p>
                        <a href="tencent://Message/?Uin=2635435377&amp;websiteName=q-zone.qq.com&amp;Menu=yes" class="btn btn-outline-light btn-sm">联系我</a>
                    </div>
                    end Help Box -->
                    
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
                                        <!-- ip定位 -->
                                  已保存来访记录
                                  <script src="https://pv.sohu.com/cityjson?ie=utf-8"></script>  
                                  <script type="text/javascript">document.write(returnCitySN["cip"]+','+returnCitySN["cname"])</script>    
                                        <!-- ip定位 -->
                                </a>
                            </li>
                        </ul>
                      
                        <div class="app-search">
                            <form action="search.php" method="get">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="searchcont" placeholder="Search...">
                                    <span class="mdi mdi-magnify"></span>
                                    <div class="input-group-append">
                                        <button class="btn btn-danger" name="search" type="submit">搜索</button>
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