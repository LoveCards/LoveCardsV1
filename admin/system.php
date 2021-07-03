<?php
    include './header.php';
    //判断当前登录者权限
    if($admin_data['power'] !== "1"){
        echo "<script>window.location.href=\"index.php?notifications=3&notifications_content=权限不足\"</script>";
        exit;
    }
    //判断管理员锁开关
    $switch = "true";
    $switch1 = "开";
    if(SYSTEM_DELET == "false"){ 
        $switch = "false";
        $switch1 = "关";
    }
?>

<!-- 内容标题 -->
<div class="row">
  <div class="col-12">
    <div class="page-title-box">
      <h4 class="page-title">系统管理</h4>
    </div>
  </div>
</div>     
<!-- 内容标题 --> 

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">基本设置</h4>
                <p class="text-muted">
                    版权,友情链接内均可插入HTML代码.  <strong>“注意：提交成功后将在3分钟内更改完成，请勿着急！”</strong>
                </p>

                <form action="api.php" method="post">
                <input name="state" style="display: none;" value="system">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="simpleinput">站点名</label>
                            <input type="text" name="tittle" class="form-control" placeholder="LoveCards表白墙" value='<?php echo stripslashes(SYSTEM_TITTLE);?>'>
                        </div>
                        <div class="form-group mb-3">
                            <label for="simpleinput">站点关键词</label>
                            <input type="text" name="keywords" class="form-control" placeholder="LoveCards,表白墙,吃纸怪" value='<?php echo stripslashes(SYSTEM_KEYWORDS);?>'>
                        </div>
                        <div class="form-group mb-3">
                            <label for="simpleinput">站点描述</label>
                            <input type="text" name="description" class="form-control" placeholder="LoveCards表白墙一个专业的表白墙！" value='<?php echo stripslashes(SYSTEM_DESCRIPTION);?>'>
                        </div>

                        <div class="form-group mb-3">
                            <label for="example-textarea">留言条</label>
                            <textarea class="form-control" name="notice" rows="5" placeholder="欢迎来到LoveCards表白墙！"><?php echo stripslashes(SYSTEM_NOTICE);?></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="example-textarea">后台留言条</label>
                            <textarea class="form-control" name="notice1" rows="5" placeholder="欢迎来到LoveCards表白墙！"><?php echo stripslashes(SYSTEM_NOTICE1);?></textarea>
                        </div>
                    </div> <!-- end col -->

                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="example-textarea">版权</label>
                            <textarea class="form-control" name="copyright" rows="5" placeholder="LoveCards表白墙 by <a href='chizg.cn'>吃纸怪</a>"><?php echo stripslashes(SYSTEM_COPYRIGHT);?></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="example-textarea">友情链接</label>
                            <textarea class="form-control" name="friend" rows="5" placeholder="<a href='chizg.cn'>吃纸怪</a>"><?php echo stripslashes(SYSTEM_FRIENDS);?></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="example-textarea">屏蔽词语</label>
                            <textarea class="form-control" name="rule" rows="5" placeholder="/(test)|(test2)/"><?php echo stripslashes(SYSTEM_RULE);?></textarea>
                        </div>
                        <label for="example-textarea">管理员删除建开关</label>
                        <select name="delet"  class="form-control">
                            <option value="<?php echo $switch?>" selected><?php echo $switch1?></option>
                            <option value="true">开</option>
                            <option value="false">关</option>
                        </select>
                    </div> <!-- end col -->
                </div>
                <!-- end row-->
                <br>
                <button type="submit" class="foot-right btn btn-primary">提交</button>
                </form>
                    
            </div> <!-- end card-body -->
        </div> <!-- end card -->
    </div><!-- end col -->
</div>

<?php include 'footer.php';?>