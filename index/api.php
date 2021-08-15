<?php
    @header("Content-type: text/html; charset=utf-8");
    //引入数据库配置
    require_once "../config/sqlConfig.php";
    //引入数据库操作函数库
    require_once "../public/dbInc.php";

    //启动session
    @session_start();

    //数据库连接检测
    $conn = Connect();

    //其余

    //引入基本配置
    require_once "../config/systemConfig.php";
    
    //ip获取函数
    function GetClientIp()
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        if (isset($_SERVER['HTTP_CLIENT_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']) and preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches)) {
            foreach ($matches[0] as $xip) {
                if (!preg_match('#^(10|172\.16|192\.168)\.#', $xip)) {
                    $ip = $xip;
                    break;
                }
            }
        }
        return $ip;
    }
    
    $ip = GetClientIp();
    
    //点赞
    if ($_POST['state'] == 'zan') {
        $id = $_POST['id'];
        
        $zan_sql = "select * from zan where cardid='$id' and ip='$ip'";
        $zan_result = Execute($conn, $zan_sql);
        
        if (mysqli_num_rows($zan_result)) {
            $zan_sql1 = "select * from card where id='$id'";
            $zan_result1 = Execute($conn, $zan_sql1);
            while ($bookInfo = mysqli_fetch_array($zan_result1)) { //返回查询结果到数组
        
                $xzan = $bookInfo["zan"];
        
                echo $xzan;
            }
        } else {
            $zan_sql2 = "insert into zan (cardid,ip,time) values('$id','$ip','$sql_time')"; //插入点在数据
            $zan_result2 = Execute($conn, $zan_sql2);
            
            $zan_sql0 = "update card set zan=zan+1 where id='$id'"; //更新卡数据
            $zan_result0 = Execute($conn, $zan_sql0);
            
            $zan_sql1 = "select * from card where id='$id'";
            $zan_result1 = Execute($conn, $zan_sql1);
            
            while ($bookInfo = mysqli_fetch_array($zan_result1)) { //返回查询结果到数组
        
                $xzan = $bookInfo["zan"];
        
                echo $xzan;
            }
        }
        exit;
    }

    //评论
    if ($_POST['state'] == 'comment') {

        //极验二次验证
        require_once dirname(dirname(__FILE__)) . '/public/geetest/lib/class.geetestlib.php';
        require_once dirname(dirname(__FILE__)) . '/public/geetest/config/config.php';
        
        $GtSdk = new GeetestLib(CAPTCHA_ID, PRIVATE_KEY);
        if ($_SESSION['gtserver'] == 1) {   //服务器正常
            $result = $GtSdk->success_validate($_POST['geetest_challenge'], $_POST['geetest_validate'], $_POST['geetest_seccode']);
            if ($result) {
            } else {
                echo '<script>window.location.href="writeCard.php?notifications=2&notifications_content=人机验证失败，请重新验证！"</script>';
                exit;
            }
        } else {  //服务器宕机,走failback模式
            if ($GtSdk->fail_validate($_POST['geetest_challenge'], $_POST['geetest_validate'], $_POST['geetest_seccode'])) {
            } else {
                echo '<script>window.location.href="writeCard.php?notifications=2&notifications_content=人机验证失败，请重新验证！"</script>';
                exit;
            }
        }

        if (empty($_POST['cardid'])) {
            echo '<script>window.location.href="index.php?notifications=2&notifications_content=cardid参数无效"</script>';
            exit;
        }
        $id = $_POST['cardid'];
        if (empty($_POST['name'])) {
            echo "<script>window.location.href=\"card.php?id={$id}&notifications=2&notifications_content=请输入名字\"</script>";
            exit;
        }
        if (mb_strlen($_POST['name'], 'UTF8') > 6) {
            echo "<script>window.location.href=\"card.php?id={$id}&notifications=2&notifications_content=名字不能超出6个字符\"</script>";
            exit;
        }
        if (empty($_POST['cont'])) {
            echo "<script>window.location.href=\"card.php?id={$id}&notifications=2&notifications_content=请输入内容\"</script>";
            exit;
        }
        if (mb_strlen($_POST['cont'], 'UTF8') > 24) {
            echo "<script>window.location.href=\"card.php?id={$id}&notifications=2&notifications_content=内容不能超出24个字符\"</script>";
            exit;
        }

        $_POST['name'] = Escape($conn, $_POST['name']);
        $_POST['cont'] = Escape($conn, $_POST['cont']);

        $comment_sql = "insert into comment (cardid,cont,ip,name,time) values ('$id','{$_POST['cont']}','{$ip}','{$_POST['name']}','{$sql_time}')";
        $comment_sql1 = "update card set comment=comment+1 where id ='{$_POST['cardid']}'";
        $comment_result = Execute($conn, $comment_sql);
        $comment_result1 = Execute($conn, $comment_sql1);

        if ($comment_result === false || $comment_result1 === false) {
            echo '<script>window.location.href="index.php?notifications=3&notifications_content=出现内部错误，提交失败！"</script>';
        }
        echo "<script>window.location.href=\"card.php?id={$id}&notifications=1&notifications_content=提交成功！\"</script>";
        exit;
    }

    //写表白卡
    if ($_POST['state'] == 'writecard') {

        //极验二次验证
        require_once dirname(dirname(__FILE__)) . '/public/geetest/lib/class.geetestlib.php';
        require_once dirname(dirname(__FILE__)) . '/public/geetest/config/config.php';
        
        $GtSdk = new GeetestLib(CAPTCHA_ID, PRIVATE_KEY);
        if ($_SESSION['gtserver'] == 1) {   //服务器正常
            $result = $GtSdk->success_validate($_POST['geetest_challenge'], $_POST['geetest_validate'], $_POST['geetest_seccode']);
            if ($result) {
            } else {
                echo '<script>window.location.href="writeCard.php?notifications=2&notifications_content=人机验证失败，请重新验证！"</script>';
                exit;
            }
        } else {  //服务器宕机,走failback模式
            if ($GtSdk->fail_validate($_POST['geetest_challenge'], $_POST['geetest_validate'], $_POST['geetest_seccode'])) {
            } else {
                echo '<script>window.location.href="writeCard.php?notifications=2&notifications_content=人机验证失败，请重新验证！"</script>';
                exit;
            }
        }

        if (empty($_POST['name1'])) {
            $_POST['name1'] = 'false';
        }
        if (mb_strlen($_POST['name1'], 'UTF8') > 6) {
            echo "<script>window.location.href=\"writeCard.php?notifications=2&notifications_content=名字不能超出6个字符\"</script>";
            exit;
        }
        if (empty($_POST['name2'])) {
            echo "<script>window.location.href=\"writeCard.php?notifications=2&notifications_content=请输入TA的名字\"</script>";
            exit;
        }
        if (mb_strlen($_POST['name2'], 'UTF8') > 6) {
            echo "<script>window.location.href=\"writeCard.php?notifications=2&notifications_content=名字不能超出6个字符\"</script>";
            exit;
        }

        if (empty($_POST['img'])) {
            $_POST['img'] = 'false';
        }

        if (empty($_POST['cont'])) {
            echo "<script>window.location.href=\"writeCard.php?notifications=2&notifications_content=请输入内容\"</script>";
            exit;
        }
        if (mb_strlen($_POST['cont'], 'UTF8') > 120) {
            echo "<script>window.location.href=\"writeCard.php?notifications=2&notifications_content=内容不能超出120个字符\"</script>";
            exit;
        }

        $_POST['name1'] = Escape($conn, $_POST['name1']);
        $_POST['name2'] = Escape($conn, $_POST['name2']);
        $_POST['img'] = Escape($conn, $_POST['img']);
        $_POST['cont'] = Escape($conn, $_POST['cont']);

        $comment_sql = "insert into card (name_1,name_2,cont,img,ip,zan,comment,time) values ('{$_POST['name1']}','{$_POST['name2']}','{$_POST['cont']}','{$_POST['img']}','{$ip}','0','0','{$sql_time}')";
        $comment_result = Execute($conn, $comment_sql);

        if ($comment_result === false) {
            echo '<script>window.location.href="writeCard.php?notifications=3&notifications_content=出现内部错误，提交失败！"</script>';
        }
        echo "<script>window.location.href=\"wall.php?notifications=1&notifications_content=提交成功！\"</script>";
        exit;
    }

    //电子邮件
    if ($_POST['state'] == 'email') {

        //极验二次验证
        require_once dirname(dirname(__FILE__)) . '/public/geetest/lib/class.geetestlib.php';
        require_once dirname(dirname(__FILE__)) . '/public/geetest/config/config.php';
        
        $GtSdk = new GeetestLib(CAPTCHA_ID, PRIVATE_KEY);
        if ($_SESSION['gtserver'] == 1) {   //服务器正常
            $result = $GtSdk->success_validate($_POST['geetest_challenge'], $_POST['geetest_validate'], $_POST['geetest_seccode']);
            if ($result) {
            } else {
                echo '<script>window.location.href="email.php?notifications=2&notifications_content=人机验证失败，请重新验证！"</script>';
                exit;
            }
        } else {  //服务器宕机,走failback模式
            if ($GtSdk->fail_validate($_POST['geetest_challenge'], $_POST['geetest_validate'], $_POST['geetest_seccode'])) {
            } else {
                echo '<script>window.location.href="email.php?notifications=2&notifications_content=人机验证失败，请重新验证！"</script>';
                exit;
            }
        }

        if (empty($_POST['toemail'])) {
            echo "<script>window.location.href=\"email.php?notifications=2&notifications_content=请输入对方邮箱\"</script>";
            exit;
        }
        if (empty($_POST['id'])) {
            echo "<script>window.location.href=\"email.php?notifications=2&notifications_content=请输入要发送的卡ID\"</script>";
            exit;
        }

        $_POST['id'] = addslashes($_POST['id']);
        $_POST['toemail'] = addslashes($_POST['toemail']);

        //验证表白卡并获取表白卡
        $card_result = Execute($conn, "select * from card where id ={$_POST['id']}");//获得表白卡内容
        if (mysqli_num_rows($card_result) <= 0) {
            echo "<script>window.location.href=\"email.php?notifications=2&notifications_content=该表白卡不存在\"</script>";
            exit;
        }
        $card_row = mysqli_fetch_array($card_result);
        $id = $card_row['id'];
        if ($card_row['name_1'] == 'false') {
            $card_row['name_1'] = "匿名";
        }

        //获取评论并判断存在
        $page_result =  Execute($conn, "select * from comment where cardid = '{$id}' order by id desc limit 1");
        $page_row = mysqli_fetch_array($page_result);
        if (mysqli_num_rows($page_result) <= 0) {
            $comment_data = "暂无评论";
        } else {
        $comment_data = $page_row['name'].":".$page_row['cont']."|".$page_row['time'];
        }

        //构建DATA
        $getdata = "&bbk_name1=".$card_row['name_1']."&bbk_name2=".$card_row['name_2']."&bbk_content=".$card_row['cont']."&bbk_pl=".$card_row['comment']."&bbk_zan=".$card_row['zan']."&bbk_comment=".$comment_data."&bbk_url=http://".SYSTEM_URL."/index/card.php?id=".$card_row['id']."&img=".$card_row['img'];
        //请求邮箱服务
        $url= "https://api.fatda.cn/mail/api.php?toemail=".$_POST['toemail'].$getdata;//构造请求地址
        //构建$file_content的https请求条件
        $stream_opts = [
            "ssl" => [
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ]
        ]; 
        @$file_content = file_get_contents($url,false, stream_context_create($stream_opts));//发起请求并返回标准的json
        
        //判断请求是否失败
        if(!$file_content){
            echo '<script>window.location.href="email.php?notifications=2&notifications_content=邮件服务器连接失败！"</script>';
            exit;
        }else{
            $arr = json_decode($file_content,true);//对json格式的字符串进行编码，同时进行数组化
            if($arr['code'] == "501"){
                echo '<script>window.location.href="email.php?notifications=2&notifications_content='.$arr['code'].':'.$arr['state'].'！"</script>';
                exit;
            }
            echo '<script>window.location.href="email.php?notifications=1&notifications_content=邮件发送成功！"</script>';
            exit;
        }
    }

    echo '<script>window.location.href="index.php?notifications=3&notifications_content=state参数无效"</script>';
?>