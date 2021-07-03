<?php
header('Content-type:text/html;charset=utf-8');
require_once "../config/sqlConfig.php";
require_once "../config/systemConfig.php";
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
?>
<?php include_once "header.php"; ?>
				<div class="mdui-tab mdui-tab-full-width" mdui-tab>
				  	<a href="#example1-tab1" class="mdui-ripple" disabled>程序介绍</a>
				  	<a href="#example1-tab2" class="mdui-ripple" disabled>数据库配置</a>
				  	<a href="#example1-tab3" class="mdui-ripple" disabled>管理员配置</a>
				  	<a href="#example1-tab4" class="mdui-ripple" disabled>获取授权</a>
                    <a href="#example1-tab5" class="mdui-ripple" >安装完成</a>
				</div>

				<div id="example1-tab5" class="mdui-p-a-2">
                    <div class="mdui-typo">
                            <h1 class="mdui-text-center">安装完成</h1>
                            <p>  
                                <ul>
                                    <li>管理地址：<a href="//<?php echo SYSTEM_URL;?>/admin";>//<?php echo SYSTEM_URL;?>/admin</a></li>
                                    <li>门户首页：<a href="//<?php echo SYSTEM_URL;?>/index";>//<?php echo SYSTEM_URL;?>/index</a></li>
                                </ul>
                            </p>
                            <blockquote>如果您安装并使用了该程序，将默认您阅读并同意该条款<a href="http://fatda.cn/index.php/archives/8/">《Fatda用户条款》</a></blockquote>
                            <blockquote>Made by 吃纸怪 ©<?=date("Y")?> FatDa. All rights reserved. </blockquote>
                            <blockquote>最终解释权归FatDa所有</blockquote>
                        </div>
                        <div class="mdui-divider mdui-m-t-4 mdui-m-b-2"></div>
                        <div class="mdui-col">
                            <a href="/index"><button class="mdui-btn mdui-btn-block mdui-color-theme-accent mdui-ripple  mdui-color-pink-accent">开启全新时代</button></a>
                        </div>
                    </div>
				</div>
<!-- 引入极验所需 -->
<?php require_once '../public/geetest/geetest.php';?>
<?php include_once "footer.php"; ?>