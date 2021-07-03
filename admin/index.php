<?php
    include './header.php';

    $sqlcont='select * from card';//卡
    $cntcont=mysqli_num_rows(Execute($conn, $sqlcont));
    
    $resspk='select * from comment';//评论
    $cntspk=mysqli_num_rows(Execute($conn, $resspk));
    
    $reszan='select * from zan';//赞
    $rowzan=mysqli_num_rows(Execute($conn, $reszan));
?>
<!-- 内容标题 -->
<div class="row">
  <div class="col-12">
    <div class="page-title-box">
      <h4 class="page-title">后台首页</h4>
    </div>
  </div>
</div>     
<!-- 内容标题 --> 

<div class="row">
	<div class="col-md-4">
		<!-- Personal-Information -->
		<div class="card">
			<div class="card-body">
<?php
if($admin_data['power'] == "1"){
?>	
				<h4 class="header-title mt-0 mb-3"><?php echo $arr['site_name']; ?>系统详情卡</h4>
				<p class="text-muted font-13">
				<?php echo $arr['site_introduce']; ?>
				</p>

				<hr>
				<div class="text-left">
					<p class="text-muted"><strong>作者 :</strong> <span class="ml-2">吃纸怪</span></p>

					<p class="text-muted"><strong>Email :</strong> <span class="ml-2">2635435377@qq.com</span></p>
					<p class="text-muted"><strong>授权 :</strong>
						<span class="ml-2">剩余<?php echo $arr['url_time']; ?>天</span>
					</p>
					<p class="text-muted"><strong>系统版本 :</strong>
						<span class="ml-2"><?php echo SYSTEM_VERSION; ?></span>
					</p>
					<p class="text-muted"><strong>最新版本 :</strong>
						<span class="ml-2"><?php echo $arr['site_version']; ?>|TIME:<?php echo $arr['site_time']; ?></span>
					</p>
					<a href="//server.fatda.cn"><button type="submit" class="foot-right btn btn-primary">前往授权延时</button></a>
				</div>
<?php
} else {
?>
				<h4 class="header-title mt-0 mb-3">站长留言条</h4>
				</p>
				<hr>
				<div class="text-left">
					<p class="text-muted"><?php echo SYSTEM_NOTICE1; ?></p>
				</div>
<?php
}
?>
			</div>
		</div>
		<!-- Personal-Information -->
	</div> <!-- end col-->

	<div class="col-md-8">	
		<!-- End Chart-->

		<div class="row">
			<div class="col-sm-4">
				<div class="card tilebox-one">
					<div class="card-body">
						<i class="mdi mdi-heart-box float-right text-muted"></i>
						<h6 class="text-muted text-uppercase mt-0">表白卡总数</h6>
						<h2 class="m-b-20"><?php echo $cntcont;?>张</h2>
					</div> <!-- end card-body-->
				</div> <!--end card-->
			</div><!-- end col -->

			<div class="col-sm-4">
				<div class="card tilebox-one">
					<div class="card-body">
						<i class="mdi mdi-tooltip-text float-right text-muted"></i>
						<h6 class="text-muted text-uppercase mt-0">评论总数</h6>
						<h2 class="m-b-20"><?php echo $cntspk;?>条</h2>
					</div> <!-- end card-body-->
				</div> <!--end card-->
			</div><!-- end col -->

			<div class="col-sm-4">
				<div class="card tilebox-one">
					<div class="card-body">
						<i class="mdi mdi-thumb-up float-right text-muted"></i>
						<h6 class="text-muted text-uppercase mt-0">点赞总数</h6>
						<h2 class="m-b-20"><?php echo $rowzan;?>个</h2>
					</div> <!-- end card-body-->
				</div> <!--end card-->
			</div><!-- end col -->

		</div>
		<!-- end row -->
		 <!-- end row-->
	</div>
	<!-- end col -->
</div>

<?php include 'footer.php';?>