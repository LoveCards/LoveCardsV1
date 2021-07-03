<?php include './header.php';?>

<!-- 内容标题 -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title">搜索</h4>
        </div>
    </div>
</div>     

<?php
    //判断是否提交搜索
    if (isset($_GET['search'])) {
        //判断是否传入值
        if (empty($_GET['searchcont'])) {
            echo '<script>window.location.href="search.php?notifications=2&notifications_content=请填写搜索内容"</script>';
            exit;
        }

        $searchcont = Escape($conn, $_GET['searchcont']);

        //分页1
        $page_per_number = 8; //设定每页显示个数
        $page_now_page = $_GET['page'];

        $page_sql_whole = Execute($conn, "select * from card where id like binary '%{$searchcont}%' or cont like binary '%{$searchcont}%' or name_1 like binary '%{$searchcont}%' or name_2 like binary '%{$searchcont}%' or time like binary '%{$searchcont}%'"); //获得记录总数
        $page_rs = mysqli_num_rows($page_sql_whole);
            
        $page_totalPage = ceil($page_rs/$page_per_number);
        if (empty($page_now_page)) {
            $page_now_page = 1;
        }
        
        $page_start_count = ($page_now_page-1)*$page_per_number;

        $page_result =  Execute($conn, "select * from card where id like binary '%{$searchcont}%' or cont like binary '%{$searchcont}%' or name_1 like binary '%{$searchcont}%' or name_2 like binary '%{$searchcont}%' or time like binary '%{$searchcont}%' order by id desc limit {$page_start_count},{$page_per_number}"); ?>
<div class="row">
    <div class="col-xl-12">

        <!-- Pricing Title-->
        <div class="text-center">
            <form action="search.php" method="GET">
            <div class="input-group col-sm-8  m-auto">
                <input type="text" class="form-control" name="searchcont" placeholder="Search...">
                <div class="input-group-append">
                    <button class="btn btn-danger" name="search" type="submit">搜索</button>
                </div>
            </div>
            </form>
            <br>
            <p class="text-muted w-50 m-auto">
                可搜索表白卡的ID，双方姓名，内容，时间
            </p>
        </div>

    </div>
        <!-- end row -->

</div> <!-- end col-->
<br><br><br>
<div class="card">
    <div class="card-body">
        <h4 class="header-title mb-3"><?php echo $searchcont; ?> 搜索结果：</h4>

        <div class="table-responsive">
            <table class="table table-hover table-centered mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>写卡人</th>
                        <th>写卡对象</th>
                        <th>表白内容</th>
                        <th>图片</th>
                        <th>评论</th>
                        <th>赞</th>
                        <th>时间</th>
                    </tr>
                </thead>
                <tbody>
<?php
    //分页2
    while ($page_row = mysqli_fetch_array($page_result)) {
        $card_staet1 = 'danger';
        //判断是否匿名2
        if ($page_row['name_1'] == 'false') {
            $page_row['name_1'] = "匿名";
            $card_staet1 = 'light';
        }
        //判断是否有图
        if ($page_row['img'] == 'false') {
            $page_row['img'] = "×";
        } else {
            $page_row['img'] = "√";
        }
        //判断是否超过规定显示字数
        if (mb_strlen($page_row['cont'])>5) {
            $page_row['cont']=mb_substr($page_row['cont'], 0, 5, "utf-8").'...';
        } ?>
                    <tr onclick="window.open('<?php echo 'card.php?id='.$page_row['id']; ?>');">
                        <td><span class="badge badge-<?php echo $card_staet1; ?>"><?php echo $page_row['id']; ?></span></td>
                        <td><?php echo $page_row['name_1']; ?></td>
                        <td><?php echo $page_row['name_2']; ?></td>
                        <td><?php echo $page_row['cont']; ?></td>
                        <td><?php echo $page_row['img']; ?></td>
                        <td><?php echo $page_row['comment']; ?><a></td>
                        <td><?php echo $page_row['zan']; ?></td>
                        <td><?php echo $page_row['time']; ?></td>
                    </tr>
<?php
    } ?>
                </tbody>
            </table>
        </div> <!-- end table responsive-->
    </div>
</div>

<!-- 翻页 --> 
<div class="pagination justify-content-center" >
    <li class="page-item"><a class="page-link" href="?search=&searchcont=<?php echo $_GET['searchcont']?>&page=1">首页</a></li>

    <?php if (!empty($_GET['page']) && $_GET['page'] !== "1") { ?>
        <li class="page-item"><a class="page-link" id="pagebtn-s" href="?search=&searchcont=<?php echo $_GET['searchcont']?>&page=<?php echo $page_now_page - 1;?>">上页</a></li>
    <?php } ?>

    <li class="page-item"><a class="page-link"><?php echo $page_now_page ?>/<?php echo $page_totalPage ?></a></li>

    <?php if ($page_totalPage > $page_now_page) {?>
        <li class="page-item"><a class="page-link" id="pagebtn-x" href="?search=&searchcont=<?php echo $_GET['searchcont']?>&page=<?php echo $page_now_page + 1;?>">下页</a></li>
    <?php } ?>

    <li class="page-item"><a class="page-link" href="?search=&searchcont=<?php echo $_GET['searchcont']?>&page=<?php echo $page_totalPage; ?>">尾页</a></li>

</div>
<br><br>	
<!-- 翻页 --> 
<?php
    } else {
        ?>
<div class="row">
    <div class="col-xl-12">

        <!-- Pricing Title-->
        <div class="text-center">
            <form action="search.php" method="get">
            <div class="input-group col-sm-8  m-auto">
                <input type="text" class="form-control" name="searchcont" placeholder="Search...">
                <div class="input-group-append">
                    <button class="btn btn-danger" name="search" type="submit">搜索</button>
                </div>
            </div>
            </form>
            <br>
            <p class="text-muted w-50 m-auto">
                可搜索表白卡的ID，双方姓名，内容，时间
            </p>
        </div>

    </div>
        <!-- end row -->

</div> <!-- end col-->

<?php
    } include './footer.php';?>