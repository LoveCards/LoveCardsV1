<?php
header('Content-type:text/html;charset=utf-8');
require_once "../config/sqlConfig.php";
if (file_exists("./lock.txt")) {
	header("location:../index/index.php?notifications=2&notifications_content=请务必删除程序主目录下的install文件夹后再投入使用！！！");
	exit;
}
?>
<?php include_once "header.php"; ?>
				<div class="mdui-tab mdui-tab-full-width" mdui-tab>
				  	<a href="#example1-tab1" class="mdui-ripple" >程序介绍</a>
				  	<a href="#example1-tab2" class="mdui-ripple" disabled>数据库配置</a>
				  	<a href="#example1-tab3" class="mdui-ripple" disabled>管理员配置</a>
				  	<a href="#example1-tab4" class="mdui-ripple" disabled>获取授权</a>
                    <a href="#example1-tab5" class="mdui-ripple" disabled>安装完成</a>
				</div>
				<div id="example1-tab1" class="mdui-p-a-2">
					<div class="mdui-typo">
						<h3>欢迎使用LoveCards<small><kbd><?php echo SYSTEM_VERSION?></kbd></small></h3>
					</div>
                    <div class="mdui-panel" mdui-panel>

                    <div class="mdui-panel-item  mdui-panel-item-open">
                        <div class="mdui-panel-item-header">详情</div>
                            <div class="mdui-panel-item-body">
                            <p>  
                                <ul>
                                    <li>作者：吃纸怪</li>
                                    <li>联系方式：
                                        <ul>
                                            <li>QQ：2903074366</li>
                                            <li>EMAIL：2903074366@qq.com</li>
                                        </ul>
                                    </li>
                                    <li>FatDa：<a href="http://fatda.cn">fatda.cn</a></li>
                                    <li>Github：<a href="https://github.com/zhiguai/">github.com/zhiguai</a></li>
                                    <li>QQ交流群：801235342</li>
                                </ul>
                            </p>
                            <blockquote>如果您安装并使用了该程序，将默认您阅读并同意该条款<a href="http://fatda.cn/index.php/archives/8/">《Fatda用户条款》</a></blockquote>
                            <blockquote>Made by 吃纸怪 ©<?=date("Y")?> FatDa. All rights reserved. </blockquote>
                            <blockquote>最终解释权归FatDa所有</blockquote>
                        </div>
                    </div>

                    <div class="mdui-panel-item">
                        <div class="mdui-panel-item-header">更新内容</div>
                        <div class="mdui-panel-item-body">
                            <p><?php echo SYSTEM_VERSION?></p>
                            <p>更新内容</p>
                            <p>源码全部开源到Github</p>
                            <p>更改授权策略为永久免费</p>
                        </div>
                    </div>

                    <div class="mdui-panel-item">
                        <div class="mdui-panel-item-header">安装帮助（<strong>必看</strong>）</div>
                        <div class="mdui-panel-item-body">
                            <p><strong>注意：</strong></p>
                            <p>绑定邮箱邮箱务必填写<strong>可用邮箱</strong>,这关于到更新推送！！</p>
                            <p>授权填写的域名请填写完全域名，不能只填写顶级域名，而且<strong>不要加</strong>'http://'或'https://'以及尾部的'/'，直接填写域名，例'xxx.xxx.cn'</p>
                            <p>如果您是<strong>更新</strong>程序，请<strong>务必</strong>先备份原程序主目录以及数据库，然后按照步骤进行完数据库配置，到添加管理员步骤即可退出</p>
                            <p>最后，将主目录下install文件夹删除即可正常访问了！</p>
                        </div>
                    </div>

                    </div>
					<div class="mdui-divider mdui-m-t-4 mdui-m-b-2"></div>
					<a href="install-1.php?tab=2#example1-tab2"><button class="mdui-btn mdui-color-pink-accent mdui-m-a-1 mdui-float-right">开始安装</button></a>
				</div>
<?php include_once "footer.php"; ?>