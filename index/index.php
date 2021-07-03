<?php   
	include './header.php';

	$sqlcont='select * from card';//卡
	$cntcont=mysqli_num_rows(Execute($conn,$sqlcont));
	
	$resspk='select * from comment';//评论
	$cntspk=mysqli_num_rows(Execute($conn,$resspk));
	
	$reszan='select * from zan';//赞
	$rowzan=mysqli_num_rows(Execute($conn,$reszan));
?>
<!-- 内容标题 -->
<div class="row">
	<div class="col-12">
		<div class="page-title-box">
			<h4 class="page-title">门户首页</h4>
		</div>
	</div>
</div>     

<!-- 内容标题 --> 
<div class="mt-1 mb-1">

	<div class="col-12">

		<!-- 便签卡 -->
		<div class="text-center">
			<h1 style="font-size:50px"><strong><?php echo stripslashes(SYSTEM_TITTLE);?></strong></h1><br>
			<div class="btn btn-block btn-danger">
				<h1 style="font-size:20px">站长留下的便签</h1>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="card-deck-wrapper">
						<div class="card-deck">
							<div class="card d-block">
								<div class="card-body">
									<p class="card-text"><strong><?php echo stripslashes(SYSTEM_NOTICE)?></strong></p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div><br><br>
		<!-- 便签卡 -->		

		<!-- 表白卡排名 --> 
		<div class="col-12">
			<div class="text-center">
				<h1 style="font-size:20px">人气榜</h1>
			</div><br>
			<div class="row">

<?php
	//排名
	$number_result =  Execute($conn,"select * from card order by comment*0.3+zan*0.7 desc limit 0,8");
	//赞X0.7+评论x0.3
	while ($page_row = mysqli_fetch_array($number_result)){  

		//判断是否匿名1
		$card_staet1 = "danger";
		$card_staet2 = "实名";
		//判断是否匿名2
		if($page_row['name_1'] == 'false'){
			$card_staet1 = "light";
			$card_staet2 = "匿名";
			$page_row['name_1'] = "匿名";
		} 

		//判断当前ip是否点赞
		$zan_id = $page_row['id'];
		$zan_ip = GetClientIp();
		$zan_sql1 = "select * from zan where cardid='{$zan_id}' and ip='{$zan_ip}'"; //判断数据
		$zan_result1 = Execute($conn,$zan_sql1);
		if (mysqli_num_rows($zan_result1)) {
			$zan_colour = "#fa5c7c";
			$zan_state = "pointer-events:none";
		}else{
			$zan_colour = "#fa5c7c80";
			$zan_state = "";
		}
		//判断是否存在图片
		if($page_row['img'] == 'false'){
?>
				<div class="col-md-6 col-lg-3">
					<div class="card d-block">

						<div class="card-body">
							<h5 class="card-title">
								<?php echo str(SYSTEM_RULE,$str1,$page_row['name_1'])?>的表白卡
								<span class="foot-right">
									<span class='badge badge-<?php echo $card_staet1?>'><?php echo $card_staet2?>
								</span>
							</h5>
							<h6 class="card-subtitle text-muted"><?php echo str(SYSTEM_RULE,$str1,$page_row['name_1'])?> 表白 <?php echo str(SYSTEM_RULE,$str1,$page_row['name_2'])?></h6>
							
							<br>
							<a href="card.php?id=<?php echo $page_row['id']?>">
								<p class="card-text"><?php echo str(SYSTEM_RULE,$str1,$page_row['cont'])?></p>
							</a>
								<br>

								<span class="foot-left mdi mdi-comment-multiple"></span>
								<span class="foot-left">评论<?php echo $page_row['comment']?></span>
								<!--点赞-->
								<a href="javascript:;" class="foot-right dza" style="<?php echo $zan_state?>" rel="<?php echo $page_row['id']?>">
									<span class=" mdi mdi-cards-heart" id="<?php echo $page_row['id']?>" style="color: <?php echo $zan_colour?>;"></span>
									<span class="foot-right dianzan"  style="color: <?php echo $zan_colour?>;">喜欢<?php echo $page_row['zan']?></span>
								</a>
								<!--点赞-->
							<br>
						</div> <!-- end card-body-->
					</div> <!-- end card-->
				</div><!-- end col -->
<?php
	}else{
?>
				<div class="col-md-6 col-lg-3">
					<div class="card d-block">

						<div class="card-body">
							<h5 class="card-title">
								<?php echo str(SYSTEM_RULE,$str1,$page_row['name_1'])?>的表白卡
								<span class="foot-right">
									<span class='badge badge-<?php echo $card_staet1?>'><?php echo $card_staet2?>
								</span>
							</h5>
							<h6 class="card-subtitle text-muted"><?php echo str(SYSTEM_RULE,$str1,$page_row['name_1'])?> 表白 <?php echo str(SYSTEM_RULE,$str1,$page_row['name_2'])?></h6>
						</div>

						<img class="img-fluid" src="<?php echo $page_row['img']?>">

						<div class="card-body">
							<a href="card.php?id=<?php echo $page_row['id']?>">
								<p class="card-text"><?php echo str(SYSTEM_RULE,$str1,$page_row['cont'])?></p>
							</a>
								<br>

								<span class="foot-left mdi mdi-comment-multiple"></span>
								<span class="foot-left">评论<?php echo $page_row['comment']?></span>
								<!--点赞-->
								<a href="javascript:;" class="foot-right dza" style="<?php echo $zan_state?>" rel="<?php echo $page_row['id']?>">
									<span class=" mdi mdi-cards-heart" id="<?php echo $page_row['id']?>" style="color: <?php echo $zan_colour?>;"></span>
									<span class="foot-right dianzan"  style="color: <?php echo $zan_colour?>;">喜欢<?php echo $page_row['zan']?></span>
								</a>
							<!--点赞-->
							<br>
						</div> <!-- end card-body-->
					</div> <!-- end card-->
				</div><!-- end col -->

<?php
		}
	}
?>
			</div>	
			<!-- 表白卡 --> 
			
			<!-- 全站数据 -->
			<div class="row mt-2">
				<div class="col-md-4">
					<div class="text-center mt-3 pl-1 pr-1">
						<i class="mdi mdi-heart-box btn-danger maintenance-icon text-white mb-2"></i>
						<h5 class="text-uppercase"><?php echo $cntcont;?>张</h5>
						<p class="text-muted">表白卡总数</p>
					</div>
				</div> 
				<div class="col-md-4">
					<div class="text-center mt-3 pl-1 pr-1">
						<i class="mdi mdi-tooltip-text btn-danger maintenance-icon text-white mb-2"></i>
						<h5 class="text-uppercase"><?php echo $cntspk;?>条</h5>
						<p class="text-muted">评论总数</p>
					</div>
				</div> 
				<div class="col-md-4">
					<div class="text-center mt-3 pl-1 pr-1">
						<i class="mdi mdi-thumb-up  btn-danger maintenance-icon text-white mb-2"></i>
						<h5 class="text-uppercase"><?php echo $rowzan;?>个</h5>
						<p class="text-muted">点赞总数</p>
					</div>
				</div> 
			</div>
			<!-- 全站数据 -->
		</div>
	</div>
</div>

<?php include './footer.php';?>
