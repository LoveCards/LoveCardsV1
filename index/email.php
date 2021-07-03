<?php
    include 'header.php';
?>

<!-- 内容标题 -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title">
                表白卡邮局
            </h4>
        </div>
    </div>
</div>     
<!-- 内容标题 --> 

<!-- 表单 --> 
<div class="account-pages mt-5 mb-5">
    <div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6">
        <div class="card">
            <!-- Logo -->
            <div class="btn btn-block btn-danger">
                <h1 style="font-size:20px">信封</h1>
                </div>

                <div class="card-body p-4">
                <div class="text-center w-75 m-auto">
                    <h4 class="text-dark-50 text-center mt-3 font-weight-bold">请认真填写哦</h4>
                </div>
                    <!--表单-->      
                    <form action="api.php" method="post" class="needs-validation">
                    <input name="state" style="display: none;" value="email" />
                    <div class="form-group mb-3">
                        <label for="validationTooltipUsername">表白卡ID</label>
                        <input type="text" class="form-control" name="id" placeholder="必填" value="<?php echo $_GET['id'];?>"/><br>
                        <label for="validationTooltipUsername">TA的邮箱</label>
                        <input type="email" class="form-control" name="toemail" placeholder="必填"/><br>
                    </div>


                    <!-- 极验 --> 
                    <div id="embed-captcha"></div>
                    <div id="notice" class="hide" role="alert">请先完成验证</div>
                    <p id="wait" class="show">正在加载验证码......</p><br>

                    <button id="embed-submit" type="submit" value="提交" class="foot-right btn btn-danger">提交</button>
                    
                    </form>
                <!--表单-->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- 内容标题 -->

<?php include 'footer.php';?>

<!-- 引入极验所需 -->
<?php require_once '../public/geetest/geetest.php';?>