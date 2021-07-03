<?php
    include './header.php';
    
    //分页1
    $page_per_number = 8; //设定每页显示个数
    $page_now_page = $_GET['page'];

    $page_sql_whole = Execute($conn,'select * from card'); //获得记录总数
    $page_rs = mysqli_num_rows($page_sql_whole);
        
    $page_totalPage = ceil($page_rs/$page_per_number);
    if (empty($page_now_page)) {
        $page_now_page = 1;
    }
    
    $page_start_count = ($page_now_page-1)*$page_per_number;

    $page_result =  Execute($conn,"select * from card order by id desc limit {$page_start_count},{$page_per_number}");
?>

<!-- 内容标题 -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title">表白墙</h4>
        </div>
    </div>
</div>     

<!-- 表白卡 --> 
<div class="row">

    <?php
        //分页2
        while ($page_row = mysqli_fetch_array($page_result)){  

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
                <h6 class="card-subtitle text-muted"><?php echo  str(SYSTEM_RULE,$str1,$page_row['name_1'])?> 表白 <?php echo  str(SYSTEM_RULE,$str1,$page_row['name_2'])?></h6>
                
                <br>
                <a href="card.php?id=<?php echo $page_row['id']?>">
                    <p class="card-text"><?php echo  str(SYSTEM_RULE,$str1,$page_row['cont'])?></p>
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

<!-- 翻页 --> 
<div class="pagination justify-content-center" >
    <li class="page-item"><a class="page-link" href="?page=1">首页</a></li>

    <?php if(!empty($_GET['page']) && $_GET['page'] !== "1"){ ?>
        <li class="page-item"><a class="page-link" id="pagebtn-s" href="?page=<?php echo $page_now_page - 1;?>">上页</a></li>
    <?php }?>

    <li class="page-item"><a class="page-link"><?php echo $page_now_page ?>/<?php echo $page_totalPage ?></a></li>

    <?php if($page_totalPage > $page_now_page){?>
        <li class="page-item"><a class="page-link" id="pagebtn-x" href="?page=<?php echo $page_now_page + 1;?>">下页</a></li>
    <?php }?>

    <li class="page-item"><a class="page-link" href="?page=<?php echo $page_totalPage;?>">尾页</a></li>

</div>
<br><br>	
<!-- 翻页 --> 

<?php include './footer.php';?>