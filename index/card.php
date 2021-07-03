<?php
    include './header.php';
    
    //判断是否传入ID值
    if (empty($_GET['id'])) {
        echo '<script>window.location.href="wall.php"</script>';
    }
    $_GET['id'] = addslashes($_GET['id']);
    $card_result = Execute($conn, "select * from card where id ={$_GET['id']}");//获得表白卡内容
    if (mysqli_num_rows($card_result) <= 0) {
        echo "<script>window.location.href=\"wall.php?notifications=2&notifications_content=该表白卡不存在\"</script>";
        exit;
    }
    $card_row = mysqli_fetch_array($card_result);

    $id = $card_row['id'];

    //判断当前ip是否点赞
    $zan_sql1 = "select * from zan where cardid='{$id}' and ip='{$ip}'"; //判断数据
    $zan_result1 = Execute($conn, $zan_sql1);
    if (mysqli_num_rows($zan_result1)) {
        $zan_colour = "#fa5c7c";
        $zan_state = "pointer-events:none";
    }else{
        $zan_colour = "#fa5c7c80";
        $zan_state = "";
    }

    //判断是否匿名1
    $card_staet1 = "danger";
    $card_staet2 = "实名";
    //判断是否匿名2
    if($card_row['name_1'] == 'false'){
        $card_staet1 = "light";
        $card_staet2 = "匿名";
        $card_row['name_1'] = "匿名";
    } 


    //分页1
    $page_per_number = 5; //设定每页显示个数
    $page_now_page = $_GET['page'];

    $page_sql_whole = Execute($conn, "select * from comment where cardid = '{$id}'"); //获得记录总数
    $page_rs = mysqli_num_rows($page_sql_whole);
        
    $page_totalPage = ceil($page_rs/$page_per_number);
    if (empty($page_now_page)) {
        $page_now_page = 1;
    }
    
    $page_start_count = ($page_now_page-1)*$page_per_number;
    //"SELECT * FROM comment where cardid = '{$id}' order by id asc limit 99999"
    $page_result =  Execute($conn, "select * from comment where cardid = '{$id}' order by id desc limit {$page_start_count},{$page_per_number}");
?>

<!-- 内容标题 -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title">
                <?php echo str(SYSTEM_RULE,$str1,$card_row['name_1'])?>的表白卡
                <small class="text-muted"><?php echo $card_row['time']?></small>
                <span class="foot-right">
                    <span class='badge badge-<?php echo $card_staet1?>'><?php echo $card_staet2?>
                </span>
            </h4>
        </div>
    </div>
</div>     
<!-- 内容标题 --> 

<!-- 主卡片 -->
<div class="row">
    <div class="col-sm-12">
        <div class="card bg-danger">
            <div class="card-body profile-user-box">
                <div class="row">
                <!-- 内 -->
                    <div class="col-sm-4">
                        <h4 class="mt-1 mb-1 text-white"><?php echo  str(SYSTEM_RULE,$str1,$card_row['name_1'])?></h4>
                    </div>
                    <div class="col-sm-4 text-center">
                        <h1 class="mt-1 mb-1 text-white"><i class="mdi mdi-heart-pulse"></i></h1>
                    </div>
                    <div class="col-sm-4 text-right">
                        <h4 class="mt-1 mb-1 text-white"><?php echo  str(SYSTEM_RULE,$str1,$card_row['name_2'])?></h4>
                    </div>
                </div>    
            </div>
        </div>
    </div>
</div>
<!-- 主卡片 -->
          
<div class="row">

	<div class="col-md-8">

    <?php
        //判断是否存在图片
        if ($card_row['img'] !== 'false') {
            ?>
        <!-- 图片卡-->
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3"><?php echo  str(SYSTEM_RULE,$str1,$card_row['name_1'])?>上传的图卡</h4>
                <div class="table-responsive">
                    <img class="card-img-top" src="<?php echo $card_row['img']?>">
                </div> <!-- end table responsive-->
            </div> <!-- end col-->
        </div>
        <!-- 图片卡-->
    <?php
        }
    ?>
		<!-- 内容卡 -->
		<div class="card">
			<div class="card-body">
				<h4 class="header-title mt-0 mb-3">表白内容</h4>
				<p class="text-muted font-13">
					<?php echo  str(SYSTEM_RULE,$str1,$card_row['cont'])?>
				</p>

				<hr>

				<div class="text-left">
                    <br>
                    <!--点赞-->
                    <a href="javascript:;" class="foot-right dza" style="<?php echo $zan_state?>" rel="<?php echo $card_row['id']?>">
                        <span class=" mdi mdi-cards-heart" id="<?php echo $card_row['id']?>" style="color: <?php echo $zan_colour?>;"></span>
                        <span class="foot-right dianzan"  style="color: <?php echo $zan_colour?>;">喜欢<?php echo $card_row['zan']?></span>
                    </a>
                    <!--点赞-->
					<br>
				</div>
			</div>
		</div>
		<!-- 内容卡 -->
    </div><!-- end col -->
    
    <!-- 邮局快捷键 -->
	<div class="col-md-4">
        <a href="./email.php?id=<?php echo $card_row['id'];?>">
            <div class="card text-white bg-danger">
                <div class="card-body">
                    <div class="toll-free-box text-center">
                        <h4> <i class="mdi mdi mdi-email-open"></i> I D : <?php echo $card_row['id'];?></h4>
                    </div>
                </div> <!-- end card-body-->
            </div>
        </a>
		<!-- 评论框 -->
		<div class="card">
			<div class="card-body">
				<h4 class="header-title mb-3">评论</h4>
				<div class="table-responsive">
               
                <form action="api.php" method="post" style="margin: 0px;padding: 0px;z-index: 999;">

                    <input name="state" style="display: none;" value="comment" />
                    <input name="cardid" style="display: none;" value="<?php echo $id?>" />

                  	<div class="form-group mb-3">	
						<input name="name" class="form-control" placeholder="名字" value="" style="width: 98%;margin-left: 1%;"/>
                    </div>
                    
					<div class="form-group mb-3">	
						<input name="cont" type="text" placeholder="内容..." class="form-control" style="width: 98%;margin-left: 1%;"/>
					</div>	
                    <div  class="form-group mb-3">
                        <!-- 极验 --> 
                        <div id="embed-captcha"></div>
                        <div id="notice" class="hide" role="alert">请先完成验证</div>
                        <p id="wait" class="show">正在加载验证码......</p>
                    </div>
                    <button id="embed-submit" type="submit" value="提交" class="foot-right btn btn-danger">提交</button>
                </form>
          
				</div> <!-- end table responsive-->
			</div> <!-- end col-->
		</div> <!-- end row-->
		<!-- 评论框 -->
		<!-- 评论卡 -->
         <div class="card">
			<div class="card-body">
				<h4 class="header-title mb-3">评论</span><small class="text-muted foot-right">共<?php echo $card_row['comment']?>条</small></h4>
                
				<div class="inbox-widget">
                  	<?php
                        while ($page_row = mysqli_fetch_array($page_result)) {
                            ?>
					<div class="inbox-item">
						<p class="inbox-item-author"><?php echo  str(SYSTEM_RULE,$str1,$page_row['name']);?></p>
                        <p class="inbox-item-text"><?php echo  str(SYSTEM_RULE,$str1,$page_row['cont'])?></p>
                        <small class="text-muted"><?php echo $page_row['id']?>#&nbsp;&nbsp;<?php echo $page_row['time']?></small>
					</div>
                  	<?php
                        }
                    ?>
				</div>
			</div>
		</div>
        <!-- 评论卡 -->

        <!-- 翻页 --> 
        <div class="pagination justify-content-center" >
            <li class="page-item"><a class="page-link" href="?id=<?php echo $id?>&page=1">首页</a></li>

            <?php if (!empty($_GET['page']) && $_GET['page'] !== "1") { ?>
                <li class="page-item"><a class="page-link" id="pagebtn-s" href="?id=<?php echo $id?>&page=<?php echo $page_now_page - 1;?>">上页</a></li>
            <?php }?>

            <li class="page-item"><a class="page-link"><?php echo $page_now_page ?>/<?php echo $page_totalPage ?></a></li>

            <?php if ($page_totalPage > $page_now_page) {?>
                <li class="page-item"><a class="page-link" id="pagebtn-x" href="?id=<?php echo $id?>&page=<?php echo $page_now_page + 1;?>">下页</a></li>
            <?php }?>

            <li class="page-item"><a class="page-link" href="?id=<?php echo $id?>&page=<?php echo $page_totalPage;?>">尾页</a></li>

        </div>
        <br><br>	
        <!-- 翻页 --> 
	</div>
</div>          
<!-- 引入极验所需 -->
<?php require_once '../public/geetest/geetest.php';?>
<?php include './footer.php';?>