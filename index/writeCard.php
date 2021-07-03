<?php
    include 'header.php';
?>

<!-- 内容标题 -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title">
                填写表白卡
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
                <h1 style="font-size:20px">表白卡</h1>
                </div>

                <div class="card-body p-4">
                <div class="text-center w-75 m-auto">
                    <h4 class="text-dark-50 text-center mt-3 font-weight-bold">请认真填写哦</h4>
                </div>
                    <!--表单-->      
                    <form action="api.php" method="post" class="needs-validation">
                    <input name="state" style="display: none;" value="writecard" />
                    <div class="form-group mb-3">
                        <label for="validationTooltipUsername">我是</label>
                        <input type="text" class="form-control" name="name1" placeholder="选填/默认不填为“匿名卡"/><br>
                        <label for="validationTooltipUsername">Ta是</label>
                        <input type="text" class="form-control" name="name2" placeholder="必填"/><br>

                        <label for="validationTooltipUsername">上传图片</label>
                        <div class="input-group">
                            <!-- 图片上传 -->
                            <input id="url" type="text" name='img' class="form-control col-md-8" placeholder="选填图片URL/默认不填为“无图卡" >
                            <input class="btn btn-danger col-md-4" type="file" id="filejpg">
                            <!-- 图片上传 -->
                        </div><br>

                        <label for="validationTooltipUsername">我想说</label>
                        <textarea name="cont" rows="6" class="form-control" maxlength="60" placeholder="必填"></textarea>
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

<!-- 图片上传 -->
<script>
    $(function () {
        $(":file").change(function () {
            var formData = new FormData();
            formData.append("myfile", document.getElementById("filejpg").files[0]);   
            $("#url").attr("value",);
            $("#url").attr("placeholder",'正在上传请稍后');
            $.ajax({
                url: "../public/uploadJpg.php",
                type: "POST",
                dataType: 'json',
                data: formData,
                /**
                *必须false才会自动加上正确的Content-Type,否则会执行error步骤
                */
                contentType: false,
                /**
                * 必须false才会避开jQuery对 formdata 的默认处理，否则会报Uncaught TypeError: Illegal invocation
                * XMLHttpRequest会对 formdata 进行正确的处理
                */
                processData: false,
                success: function (data) {
                    if(data.state == '1'){
                        $("#url").attr("value",data.url);
                        return;
                    }
                    if(data.state == '2'){
                        $("#url").attr("value",);
                        $("#url").attr("placeholder",'文件不得大于2M');
                        return;
                    }
                    if(data.state == '3'){
                        $("#url").attr("value",);
                        $("#url").attr("placeholder",'请上传格式为PNG,JPG,JPEG,GIF的文件');
                        return;
                    }
                    if(data.state == '4'){
                        $("#url").attr("value",);
                        $("#url").attr("placeholder",'文件写入失败，请联系管理员');
                        return;
                    }
                    if(data.state == '5'){
                        $("#url").attr("value",);
                        $("#url").attr("placeholder",'传入文件错误');
                        return;
                    }
                },
                error: function () {
                    $("#url").attr("value",);
                    $("#url").attr("placeholder",'上传失败');
                }
            });
        });
    });
</script>
<!-- 引入极验所需 -->
<?php require_once '../public/geetest/geetest.php';?>