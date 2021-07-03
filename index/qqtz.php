<?php
$conf['qqjump']=1;
if(strpos($_SERVER['HTTP_USER_AGENT'], 'QQ/')!==false && $conf['qqjump']==1){
	$a='http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"]; 
echo '
<!DOCTYPE html>
<html>
	<head> 
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
	<meta charset="utf-8" />
	<title>'.stripslashes(SYSTEM_TITTLE).' - 浏览器跳转</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta content="Coderthemes" name="author" />
	<!-- App favicon -->
	<link rel="shortcut icon" href="./favicon.ico">

	<!-- App css -->
	<!-- build:css -->
	<link href="../assets/css/app.min.css" rel="stylesheet" type="text/css" />
	<!-- endbuild -->
	<script src="https://open.mobile.qq.com/sdk/qqapi.js?_bid=152"></script> 
	<script type="text/javascript"> mqq.ui.openUrl({ target: 2,url: "'.$a.'"}); </script>
	<!-- endbuild -->

	</head>
	
    <body>

        <div class="mt-5 mb-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12">

                        <div class="text-center">
                            <img src="../assets/htmlimg/maintenance.svg" height="140" alt="">
                            <h3 class="mt-4">请使用浏览器查看</h3>
                            <p class="text-muted">点击右上角，选择使用浏览及打开即可自动跳转至浏览器访问.</p>

                            <div class="row mt-5">
                                <div class="col-md-4">
                                    <div class="text-center mt-3 pl-1 pr-1">
                                        <i class="dripicons-jewel bg-primary maintenance-icon text-white mb-2"></i>
                                        <h5 class="text-uppercase">为什么无法打开网页</h5>
                                        <p class="text-muted">因腾讯限制个别网页可能无法正常浏览.</p>
                                    </div>
                                </div> <!-- end col-->
                                <div class="col-md-4">
                                    <div class="text-center mt-3 pl-1 pr-1">
                                        <i class="dripicons-clock bg-primary maintenance-icon text-white mb-2"></i>
                                        <h5 class="text-uppercase">如何手动打开网页</h5>
                                        <p class="text-muted"><code>'.$a.'</code>复制该网址到浏览器即可.</p>
                                    </div>
                                </div> <!-- end col-->
                                <div class="col-md-4">
                                    <div class="text-center mt-3 pl-1 pr-1">
                                        <i class="dripicons-question bg-primary maintenance-icon text-white mb-2"></i>
                                        <h5 class="text-uppercase">站长留下的便签</h5>
                                        <p class="text-muted">'.stripslashes(SYSTEM_NOTICE).'</p>
                                    </div>
                                </div> <!-- end col-->
                            </div> <!-- end row-->
                        </div> <!-- end /.text-center-->

                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end page -->

        <footer class="footer footer-alt">
            '.stripslashes(SYSTEM_COPYRIGHT).'
        </footer>

        <!-- App js -->
        <script src="../assets/javascript/app.min.js"></script>
    </body>
</html>
';
exit;
}
 ?>