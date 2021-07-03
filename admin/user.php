<?php
    include './header.php';

    //判断当前登录者权限
    if($admin_data['power'] !== "1"){
        echo "<script>window.location.href=\"index.php?notifications=3&notifications_content=权限不足\"</script>";
        exit;
    }

     //分页1
     $page_per_number = 8; //设定每页显示个数
     $page_now_page = $_GET['page'];
 
     $page_sql_whole = Execute($conn,'select * from user'); //获得记录总数
     $page_rs = mysqli_num_rows($page_sql_whole);
         
     $page_totalPage = ceil($page_rs/$page_per_number);
     if (!isset($page_now_page)) {
         $page_now_page = 1;
     }
     
     $page_start_count = ($page_now_page-1)*$page_per_number;
 
     $page_result =  Execute($conn,"select * from user order by id desc limit {$page_start_count},{$page_per_number}");
 
 ?>

<!-- 内容标题 -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title">系统管理</h4>
        </div>
    </div>
</div>     

<?php
    //判断是修改
    if(!empty($_GET['id']) && $_GET['state'] == 'edituser'){

        $sql = Execute($conn,"select * from user where id = '{$_GET['id']}'");//查询数据
        if(mysqli_num_rows($sql) !== 1){
            echo "<script>window.location.href=\"user.php?notifications=2&notifications_content=该用户不存在\"</script>";
            exit;
        }
        $user_data = mysqli_fetch_assoc($sql);
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">修改账号<small class="foot-right">ID:<?php echo $user_data['id'];?></small></h4>
                <p class="text-muted">
                    密码不填默认不修改，其他项为必填项.
                </p>

                <form action="./api.php" method="post">
                <input name="state" style="display: none;" value="edituser">
                <input name="id" style="display: none;" value="<?php echo $user_data['id'];?>">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="simpleinput">用户名</label>
                            <input type="text" name="username" class="form-control" placeholder="chizhiguai" value="<?php echo $user_data['username'];?>">
                        </div>
                        <div class="form-group mb-3">
                            <label for="simpleinput">密码</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                    </div> <!-- end col -->

                    <div class="col-md-6">
                        <h4 class="header-title">权限等级</h4>
                        <p class="text-muted">
                            站长有管理"系统管理"的权限,管理仅有"数据管理"权限请慎重选择.
                        </p>

                        <select name="power" class="custom-select mt-3">
                            <option value="0" selected>请选择</option>
                            <option value="2">管理员</option>
                            <option value="1">站长</option>
                        </select>
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
    //判断是添加
    }elseif(empty($_GET['id']) && $_GET['state'] == 'adduser'){
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">添加账号</h4>
                <p class="text-muted">
                    全部为必填项目.
                </p>

                <form action="./api.php" method="post">
                <input name="state" style="display: none;" value="adduser">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="simpleinput">用户名</label>
                            <input type="text" name="username" class="form-control" placeholder="chizhiguai">
                        </div>
                        <div class="form-group mb-3">
                            <label for="simpleinput">密码</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                    </div> <!-- end col -->

                    <div class="col-md-6">
                        <h4 class="header-title">权限等级</h4>
                        <p class="text-muted">
                            站长有管理"系统管理"的权限,管理仅有"数据管理"权限请慎重选择.
                        </p>

                        <select name="power" class="custom-select mt-3">
                            <option value="0" selected>请选择</option>
                            <option value="2">管理员</option>
                            <option value="1">站长</option>
                        </select>
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
    }else{
?>

<!-- 列表-->
<div class="card">
    <div class="card-body">
        <h4 class="header-title mb-3">账号列表：<a href="user.php?state=adduser"><button type="button" class="foot-right btn btn-info btn-rounded">添加账号</button></a></h4>
        

        <div class="table-responsive">
            <table class="table table-bordered table-centered mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>用户名</th>
                        <th>等级</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
<?php
    //分页2
    while ($page_row = mysqli_fetch_array($page_result)){  

        $card_staet = '管理员';
        $card_staet1 = 'success';
        //判断权力等级
        if($page_row['power'] == '1'){
            $card_staet = "站长";
            $card_staet1 = 'danger';
        }
        
?>
                    <tr>
                        <td><?php echo $page_row['id'];?></td>
                        <td><?php echo $page_row['username'];?></td>
                        <td><span class="badge badge-<?php echo $card_staet1;?>"><?php echo $card_staet;?></span></td>
                        <td class="table-action">
                            <a href="<?php echo 'user.php?id='.$page_row['id'];?>&state=edituser" class="action-icon"> <i class="mdi mdi-pencil"></i></a>
                            <a href="<?php echo 'api.php?id='.$page_row['id'];?>&state=deleteuser" class="action-icon"> <i class="mdi mdi-delete"></i></a>
                        </td>
                    </tr>
<?php
    }
?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- 列表-->

<!-- 翻页 --> 
<div class="pagination justify-content-center" >
    <li class="page-item"><a class="page-link" href="?search=&searchcont=<?php echo $_GET['searchcont']?>&page=1">首页</a></li>

    <?php if(isset($_GET['page']) && $_GET['page'] !== "1"){ ?>
        <li class="page-item"><a class="page-link" id="pagebtn-s" href="?search=&searchcont=<?php echo $_GET['searchcont']?>&page=<?php echo $page_now_page - 1;?>">上页</a></li>
    <?php }?>

    <li class="page-item"><a class="page-link"><?php echo $page_now_page ?>/<?php echo $page_totalPage ?></a></li>

    <?php if($page_totalPage > $page_now_page){?>
        <li class="page-item"><a class="page-link" id="pagebtn-x" href="?search=&searchcont=<?php echo $_GET['searchcont']?>&page=<?php echo $page_now_page + 1;?>">下页</a></li>
    <?php }?>

    <li class="page-item"><a class="page-link" href="?search=&searchcont=<?php echo $_GET['searchcont']?>&page=<?php echo $page_totalPage;?>">尾页</a></li>

</div>
<br><br>	
<!-- 翻页 --> 

<?php } include './footer.php';?>