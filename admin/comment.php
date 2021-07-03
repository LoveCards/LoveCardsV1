<?php
    include './header.php';

 ?>

<!-- 内容标题 -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title">数据管理</h4>
        </div>
    </div>
</div>     

<?php
    //判断是修改
    if (!empty($_GET['id']) && $_GET['state'] == 'editcomment') {
        $sql = Execute($conn, "select * from comment where id = '{$_GET['id']}'");//查询数据
        if (mysqli_num_rows($sql) !== 1) {
            echo "<script>window.location.href=\"comment.php?notifications=2&notifications_content=表白卡不存在\"</script>";
            exit;
        }
        $card_data = mysqli_fetch_assoc($sql); ?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">修改评论<small class="foot-right">ID:<?php echo $card_data['id']; ?>-CardID:<?php echo $card_data['cardid']; ?>-IP:<?php echo $card_data['ip']; ?>-TIME:<?php echo $card_data['time']; ?></small></h4>
                <p class="text-muted">
                    请修改后提交.
                </p>

                <form action="./api.php" method="post">
                <input name="state" style="display: none;" value="editcomment">
                <input name="id" style="display: none;" value="<?php echo $card_data['id']; ?>">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="simpleinput">发布者名称</label>
                            <input type="text" name="name" class="form-control" placeholder="chizhiguai" value="<?php echo $card_data['name']; ?>">
                        </div>
                    </div> <!-- end col -->

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="simpleinput">内容</label>
                            <textarea name="cont" rows="6" class="form-control" maxlength="60" placeholder="必填"><?php echo $card_data['cont']; ?></textarea>
                        </div>
                    </div> <!-- end col -->
                </div><br>
                <!-- end row-->
                <button type="submit" class="foot-right btn btn-primary">提交</button>
                </form>
                    
            </div> <!-- end card-body -->
        </div> <!-- end card -->
    </div><!-- end col -->
</div>
<?php
    //判断是否提交搜索
    } elseif (isset($_GET['search'])) {
        //判断是否传入值
        if (empty($_GET['searchcont'])) {
            echo '<script>window.location.href="comment.php?notifications=2&notifications_content=请填写搜索内容"</script>';
            exit;
        }

        $searchcont = Escape($conn, $_GET['searchcont']);

        //分页1
        $page_per_number = 8; //设定每页显示个数
        $page_now_page = $_GET['page'];

        $page_sql_whole = Execute($conn, "select * from comment where id like binary '%{$searchcont}%' or cardid like binary '%{$searchcont}%' or cont like binary '%{$searchcont}%' or ip like binary '%{$searchcont}%'  or time like binary '%{$searchcont}%'"); //获得记录总数
        $page_rs = mysqli_num_rows($page_sql_whole);
            
        $page_totalPage = ceil($page_rs/$page_per_number);
        if (empty($page_now_page)) {
            $page_now_page = 1;
        }
        
        $page_start_count = ($page_now_page-1)*$page_per_number;

        $page_result =  Execute($conn, "select * from comment where id like binary '%{$searchcont}%' or cardid like binary '%{$searchcont}%' or cont like binary '%{$searchcont}%' or ip like binary '%{$searchcont}%'  or time like binary '%{$searchcont}%' order by id desc limit {$page_start_count},{$page_per_number}"); ?>
<!-- 搜索-->
<div class="row">
    <div class="col-xl-12">
        <div class="text-center">
            <form action="comment.php" method="GET">
            <div class="input-group col-sm-8  m-auto">
                <input type="text" class="form-control" name="searchcont" placeholder="Search...">
                <div class="input-group-append">
                    <button class="btn btn-primary" name="search" type="submit">搜索</button>
                </div>
            </div>
            </form>
            <br>
            <p class="text-muted w-50 m-auto">
                可搜索表白卡的ID，ID，发布者，内容，IP，时间
            </p>
        </div>
    </div>
</div> 
<!-- 搜索-->
<br><br><br>
    <div class="card">
    <div class="card-body">
        <h4 class="header-title mb-3"><?php echo $searchcont; ?> 搜索结果：</h4>

        <div class="table-responsive">
            <table class="table table-bordered table-centered mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>CardID</th>
                        <th>发布者</th>
                        <th>表白内容</th>
                        <th>IP</th>
                        <th>时间</th>
                        <th>操作</th>
                    </tr>
                </thead>
            <tbody>
<?php
//分页2
while ($page_row = mysqli_fetch_array($page_result)) {
    //判断是否超过规定显示字数
    if (mb_strlen($page_row['cont'])>5) {
        $page_row['cont']=mb_substr($page_row['cont'], 0, 5, "utf-8").'...';
    } ?>
                    <tr>
                        <td><?php echo $page_row['id']; ?></td>
                        <td><?php echo $page_row['cardid']; ?></td>
                        <td><?php echo $page_row['name']; ?></td>
                        <td><?php echo $page_row['cont']; ?></td>
                        <td><?php echo $page_row['ip']; ?></td>
                        <td><?php echo $page_row['time']; ?></td>
                        <td class="table-action">
                            <a href="<?php echo 'comment.php?id='.$page_row['id']; ?>&state=editcomment" class="action-icon"> <i class="mdi mdi-pencil"></i></a>
                            <a href="<?php echo 'api.php?id='.$page_row['id']; ?>&state=deletecomment" class="action-icon"> <i class="mdi mdi-delete"></i></a>
                        </td>
                    </tr>
<?php
} ?>
                </tbody>
            </table>
        </div> <!-- end table responsive-->
    </div>
</div>

<?php
    } else {
        //正常访问
        //分页1
		$page_per_number = 8; //设定每页显示个数
		$page_now_page = $_GET['page'];

        $page_sql_whole = Execute($conn, 'select * from comment'); //获得记录总数
        $page_rs = mysqli_num_rows($page_sql_whole);
        
        $page_totalPage = ceil($page_rs/$page_per_number);
        if (empty($page_now_page)) {
            $page_now_page = 1;
        }
    
        $page_start_count = ($page_now_page-1)*$page_per_number;

        $page_result =  Execute($conn, "select * from comment order by id desc limit {$page_start_count},{$page_per_number}"); ?>
<!-- 搜索-->
<div class="row">
    <div class="col-xl-12">
        <div class="text-center">
            <form action="comment.php" method="GET">
            <div class="input-group col-sm-8  m-auto">
                <input type="text" class="form-control" name="searchcont" placeholder="Search...">
                <div class="input-group-append">
                    <button class="btn btn-primary" name="search" type="submit">搜索</button>
                </div>
            </div>
            </form>
            <br>
            <p class="text-muted w-50 m-auto">
                可搜索表白卡的ID，ID，发布者，内容，IP，时间
            </p>
        </div>
    </div>
</div> 
<!-- 搜索-->
<br><br><br>
    <div class="card">
    <div class="card-body">
        <h4 class="header-title mb-3">评论管理：</h4>

        <div class="table-responsive">
            <table class="table table-bordered table-centered mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>CardID</th>
                        <th>发布者</th>
                        <th>评论内容</th>
                        <th>IP</th>
                        <th>时间</th>
                        <th>操作</th>
                    </tr>
                </thead>
            <tbody>
<?php
//分页2
while ($page_row = mysqli_fetch_array($page_result)) {
    //判断是否超过规定显示字数
    if (mb_strlen($page_row['cont'])>5) {
        $page_row['cont']=mb_substr($page_row['cont'], 0, 5, "utf-8").'...';
    } ?>
                    <tr>
                        <td><?php echo $page_row['id']; ?></td>
                        <td><?php echo $page_row['cardid']; ?></td>
                        <td><?php echo $page_row['name']; ?></td>
                        <td><?php echo $page_row['cont']; ?></td>
                        <td><?php echo $page_row['ip']; ?></td>
                        <td><?php echo $page_row['time']; ?></td>
                        <td class="table-action">
                            <a href="<?php echo 'comment.php?id='.$page_row['id']; ?>&state=editcomment" class="action-icon"> <i class="mdi mdi-pencil"></i></a>
                            <a href="<?php echo 'api.php?id='.$page_row['id']; ?>&state=deletecomment" class="action-icon"> <i class="mdi mdi-delete"></i></a>
                        </td>
                    </tr>
<?php
} ?>
                </tbody>
            </table>
        </div> <!-- end table responsive-->
    </div>
</div>
<?php
    }
if (empty($_GET['id']) || $_GET['state'] !== 'editcomment') {
    ?>
<!-- 翻页 --> 
    <?php
    if (!isset($_GET['search'])) {
    ?>
        <div class="pagination justify-content-center" >
            <li class="page-item"><a class="page-link" href="?page=1">首页</a></li>

            <?php if (!empty($_GET['page']) && $_GET['page'] !== "1") { ?>
                <li class="page-item"><a class="page-link" id="pagebtn-s" href="?page=<?php echo $page_now_page - 1;?>">上页</a></li>
            <?php } ?>

            <li class="page-item"><a class="page-link"><?php echo $page_now_page ?>/<?php echo $page_totalPage ?></a></li>

            <?php if ($page_totalPage > $page_now_page) {?>
                <li class="page-item"><a class="page-link" id="pagebtn-x" href="?page=<?php echo $page_now_page + 1;?>">下页</a></li>
            <?php } ?>

            <li class="page-item"><a class="page-link" href="?page=<?php echo $page_totalPage; ?>">尾页</a></li>

        </div>

    <?php
    }else{
    ?>
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
    <?php } ?>
<br><br>	
<!-- 翻页 -->  
<?php
} include './footer.php';?>