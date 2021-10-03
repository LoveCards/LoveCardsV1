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
                    $ip = fliter_sql($xip);
                    break;
                }
            }
        }
        return $ip;
    }

    //常用变量
    $ip = GetClientIp();
    //判断是否登入
    if (empty($_SESSION['id'])) {
        echo '<script>window.location.href="login.php?notifications=2&notifications_content=请先登录"</script>';
        exit;
    }
    
    //获取管理员信息数据
    $sql = Execute($conn, "select * from user where id = '{$_SESSION['id']}'");//查询数据
    $admin_data = mysqli_fetch_assoc($sql);

    //系统修改
    if ($_POST['state'] == 'system') {
        //判断当前登录者权限
        if ($admin_data['power'] !== "1") {
            echo "<script>window.location.href=\"index.php?notifications=3&notifications_content=权限不足\"</script>";
            exit;
        }

        if ($_POST['rule'] == SYSTEM_RULE && $_POST['tittle'] == SYSTEM_TITTLE && $_POST['keyworld'] == SYSTEM_KEYWORDS && $_POST['description'] == SYSTEM_DESCRIPTION && $_POST['notice'] == SYSTEM_NOTICE && $_POST['notice1'] == SYSTEM_NOTICE1 && $_POST['copyright'] == SYSTEM_COPYRIGHT && $_POST['friend'] == SYSTEM_FRIENDS) {
            echo '<script>window.location.href="system.php?notifications=2&notifications_content=请修改后再提交"</script>';
            exit;
        }
        if ($_POST['delet'] !== "true" && $_POST['delet'] !== "false") {
            echo "<script>window.location.href=\"system.php?notifications=2&notifications_content=检查管理员删除锁\"</script>";
            exit;
        }
        if (mb_strlen($_POST['tittle'], 'UTF8') > 32) {
            echo "<script>window.location.href=\"system.php?notifications=2&notifications_content=网站名不能超出32个字符\"</script>";
            exit;
        }
        if (mb_strlen($_POST['keyworld'], 'UTF8') > 32) {
            echo "<script>window.location.href=\"system.php?notifications=2&notifications_content=关键词不能超出32个字符\"</script>";
            exit;
        }
        if (mb_strlen($_POST['description'], 'UTF8') > 32) {
            echo "<script>window.location.href=\"system.php?notifications=2&notifications_content=站点描述不能超出32个字符\"</script>";
            exit;
        }
        if (mb_strlen($_POST['notice'], 'UTF8') > 160) {
            echo "<script>window.location.href=\"system.php?notifications=2&notifications_content=留言条不能超出160个字符\"</script>";
            exit;
        }
        if (mb_strlen($_POST['notice1'], 'UTF8') > 160) {
            echo "<script>window.location.href=\"system.php?notifications=2&notifications_content=留言条不能超出160个字符\"</script>";
            exit;
        }
        if (mb_strlen($_POST['copyright'], 'UTF8') > 160) {
            echo "<script>window.location.href=\"system.php?notifications=2&notifications_content=版权不能超出160个字符\"</script>";
            exit;
        }
        if (mb_strlen($_POST['friend'], 'UTF8') > 160) {
            echo "<script>window.location.href=\"system.php?notifications=2&notifications_content=友情链接不能超出160个字符\"</script>";
            exit;
        }
        $_POST = str_replace(PHP_EOL, '', $_POST);//去除换行
        $filename='../config/systemConfig.php';
        $str_file=file_get_contents($filename);
        $pattern="/'SYSTEM_TITTLE',.*?\)/";
        if (preg_match($pattern, $str_file)) {
            $_POST['tittle']=addslashes($_POST['tittle']);
            $str_file=preg_replace($pattern, "'SYSTEM_TITTLE','{$_POST['tittle']}')", $str_file);
        }
        $pattern="/'SYSTEM_KEYWORDS',.*?\)/";
        if (preg_match($pattern, $str_file)) {
            $_POST['keywords']=addslashes($_POST['keywords']);
            $str_file=preg_replace($pattern, "'SYSTEM_KEYWORDS','{$_POST['keywords']}')", $str_file);
        }
        $pattern="/'SYSTEM_DESCRIPTION',.*?\)/";
        if (preg_match($pattern, $str_file)) {
            $_POST['description']=addslashes($_POST['description']);
            $str_file=preg_replace($pattern, "'SYSTEM_DESCRIPTION','{$_POST['description']}')", $str_file);
        }
        $pattern="/'SYSTEM_NOTICE',.*?\)/";
        if (preg_match($pattern, $str_file)) {
            $_POST['notice']=addslashes($_POST['notice']);
            $str_file=preg_replace($pattern, "'SYSTEM_NOTICE','{$_POST['notice']}')", $str_file);
        }
        $pattern="/'SYSTEM_NOTICE1',.*?\)/";
        if (preg_match($pattern, $str_file)) {
            $_POST['notice1']=addslashes($_POST['notice1']);
            $str_file=preg_replace($pattern, "'SYSTEM_NOTICE1','{$_POST['notice1']}')", $str_file);
        }
        $pattern="/'SYSTEM_COPYRIGHT',.*?\)/";
        if (preg_match($pattern, $str_file)) {
            $_POST['copyright']=addslashes($_POST['copyright']);
            $str_file=preg_replace($pattern, "'SYSTEM_COPYRIGHT','{$_POST['copyright']}')", $str_file);
        }
        $pattern="/'SYSTEM_FRIENDS',.*?\)/";
        if (preg_match($pattern, $str_file)) {
            $_POST['friend']=addslashes($_POST['friend']);
            $str_file=preg_replace($pattern, "'SYSTEM_FRIENDS','{$_POST['friend']}')", $str_file);
        }
        $pattern="/'SYSTEM_RULE',.*?\;/";
        if (preg_match($pattern, $str_file)) {
            $_POST['rule']=addslashes($_POST['rule']);
            $str_file=preg_replace($pattern, "'SYSTEM_RULE','{$_POST['rule']}');", $str_file);
        }
        $pattern="/'SYSTEM_DELET',.*?\)/";
        if (preg_match($pattern, $str_file)) {
            $_POST['delet']=addslashes($_POST['delet']);
            $str_file=preg_replace($pattern, "'SYSTEM_DELET','{$_POST['delet']}')", $str_file);
        }
        if (!file_put_contents($filename, $str_file)) {
            echo '<script>window.location.href="system.php?notifications=2&notifications_content=修改失败，请检查权限！"</script>';
            exit;
        }
        echo '<script>window.location.href="system.php?notifications=1&notifications_content=修改成功"</script>';
        exit;
    }

    //账号添加
    if ($_POST['state'] == 'adduser') {
        //判断当前登录者权限
        if ($admin_data['power'] !== "1") {
            echo "<script>window.location.href=\"index.php?notifications=3&notifications_content=权限不足\"</script>";
            exit;
        }

        if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['power'])) {
            echo '<script>window.location.href="user.php?state=adduser&notifications=2&notifications_content=请勿留空！"</script>';
            exit;
        }
        if (mb_strlen($_POST['username'], 'UTF8') > 24) {
            echo "<script>window.location.href=\"user.php?state=adduser&notifications=2&notifications_content=用户名名不能超出24个字符\"</script>";
            exit;
        }
        if (mb_strlen($_POST['username'], 'UTF8') < 6) {
            echo "<script>window.location.href=\"user.php?state=adduser&notifications=2&notifications_content=用户名不得低于6个字符\"</script>";
            exit;
        }

        $query="select * from user where username='{$_POST['username']}'";
        $result=Execute($conn, $query);
        if (mysqli_num_rows($result)) {
            echo "<script>window.location.href=\"user.php?state=adduser&notifications=2&notifications_content=用户名已存在请更换后再试\"</script>";
            exit;
        }
        
        if (mb_strlen($_POST['password'], 'UTF8') > 24) {
            echo "<script>window.location.href=\"user.php?state=adduser&notifications=2&notifications_content=密码不能超出24个字符\"</script>";
            exit;
        }
        if (mb_strlen($_POST['password'], 'UTF8') < 6) {
            echo "<script>window.location.href=\"user.php?state=adduser&notifications=2&notifications_content=密码不能低于6个字符\"</script>";
            exit;
        }
        if ($_POST['power'] !== "1" && $_POST['power'] !== "2") {
            echo "<script>window.location.href=\"user.php?state=adduser&notifications=2&notifications_content=power参数无效\"</script>";
            exit;
        }

        $_POST['password'] = md5($_POST['password']);
        $sql = "INSERT INTO user (username,password,power)
        VALUES ('{$_POST['username']}','{$_POST['password']}','{$_POST['power']}')";
        
        if (Execute($conn, $sql)) {
            echo "<script>window.location.href=\"user.php?notifications=1&notifications_content=添加成功\"</script>";
            exit;
        }
        echo "<script>window.location.href=\"user.php?state=adduser&notifications=3&notifications_content=系统出错,数据写入失败！\"</script>";
        exit;
    }

    //账号删除
    if ($_GET['state'] == 'deleteuser' && !empty($_GET['id'])) {
        //判断当前登录者权限
        if ($admin_data['power'] !== "1") {
            echo "<script>window.location.href=\"index.php?notifications=3&notifications_content=权限不足\"</script>";
            exit;
        }

        $sql = Execute($conn, "select * from user where id = '{$_GET['id']}'");//查询数据
        if (mysqli_num_rows($sql) !== 1) {
            echo "<script>window.location.href=\"user.php?state=adduser&notifications=2&notifications_content=该用户不存在\"</script>";
            exit;
        }

        $sql = "delete from user where id='{$_GET['id']}'";
        if (Execute($conn, $sql)) {
            echo "<script>window.location.href=\"user.php?notifications=1&notifications_content=删除成功\"</script>";
            exit;
        }
        echo "<script>window.location.href=\"user.php?&notifications=3&notifications_content=系统出错,数据删除失败！\"</script>";
        exit;
    }

    //修改账号
    if ($_POST['state'] == 'edituser' && !empty($_POST['id'])) {
        //判断当前登录者权限
        if ($admin_data['power'] !== "1") {
            echo "<script>window.location.href=\"index.php?notifications=3&notifications_content=权限不足\"</script>";
            exit;
        }

        $sql = Execute($conn, "select * from user where id = '{$_POST['id']}'");//查询数据
        if (mysqli_num_rows($sql) !== 1) {
            echo "<script>window.location.href=\"user.php?state=edituser&id={$_POST['id']}&notifications=2&notifications_content=该用户不存在\"</script>";
            exit;
        }
        if (empty($_POST['username']) || empty($_POST['power'])) {
            echo "<script>window.location.href=\"user.php?state=edituser&id={$_POST['id']}&notifications=2&notifications_content=密码除外请勿留空！\"</script>";
            exit;
        }
        if ($_POST['power'] !== "1" && $_POST['power'] !== "2") {
            echo "<script>window.location.href=\"user.php?state=edituser&id={$_POST['id']}&notifications=2&notifications_content=power参数无效\"</script>";
            exit;
        }
        
        $sql = Execute($conn, "select * from user where id = '{$_POST['id']}'");//查询数据
        $user_data = mysqli_fetch_assoc($sql);
        if ($_POST['username'] == $user_data['username']) {
            //帐号不修改
            //判断密码是否修改
            if (empty($_POST['password'])) {
                //不修改时
                $sql = "update user set power = {$_POST['power']} where id='{$_POST['id']}'";
                
                if (Execute($conn, $sql)) {
                    echo "<script>window.location.href=\"user.php?notifications=1&notifications_content=修改成功\"</script>";
                    exit;
                }
                echo "<script>window.location.href=\"user.php?state=edituser&id={$_POST['id']}&notifications=3&notifications_content=系统出错,数据修改失败！\"</script>";
                exit;
            }
            //修改时
            if (mb_strlen($_POST['password'], 'UTF8') > 24) {
                echo "<script>window.location.href=\"user.php?state=edituser&id={$_POST['id']}&notifications=2&notifications_content=密码不能超出24个字符\"</script>";
                exit;
            }
            if (mb_strlen($_POST['password'], 'UTF8') < 6) {
                echo "<script>window.location.href=\"user.php?state=edituser&id={$_POST['id']}&notifications=2&notifications_content=密码不能低于6个字符\"</script>";
                exit;
            }
            $_POST['password'] = md5($_POST['password']);
            $sql = "update user set password = '{$_POST['password']}',power = {$_POST['power']} where id='{$_POST['id']}'";
            
            if (Execute($conn, $sql)) {
                echo "<script>window.location.href=\"user.php?notifications=1&notifications_content=修改成功\"</script>";
                exit;
            }
            echo "<script>window.location.href=\"user.php?state=edituser&id={$_POST['id']}&notifications=3&notifications_content=系统出错,数据修改失败！\"</script>";
            exit;
        }

        //账号修改时
        if (mb_strlen($_POST['username'], 'UTF8') > 24) {
            echo "<script>window.location.href=\"user.php?state=edituser&id={$_POST['id']}&notifications=2&notifications_content=用户名名不能超出24个字符\"</script>";
            exit;
        }
        if (mb_strlen($_POST['username'], 'UTF8') < 6) {
            echo "<script>window.location.href=\"user.php?state=edituser&id={$_POST['id']}&notifications=2&notifications_content=用户名不得低于6个字符\"</script>";
            exit;
        }
        //判断账号是否存在
        $query="select * from user where username='{$_POST['username']}'";
        $result=Execute($conn, $query);
        if (mysqli_num_rows($result)) {
            echo "<script>window.location.href=\"user.php?state=edituser&id={$_POST['id']}&notifications=2&notifications_content=用户名已存在请更换后再试\"</script>";
            exit;
        }

        //判断密码是否修改
        if (empty($_POST['password'])) {
            //不修改时
            $sql = "update user set username = '{$_POST['username']}',power = {$_POST['power']} where id='{$_POST['id']}'";
            
            if (Execute($conn, $sql)) {
                echo "<script>window.location.href=\"user.php?notifications=1&notifications_content=修改成功\"</script>";
                exit;
            }
            echo "<script>window.location.href=\"user.php?state=edituser&id={$_POST['id']}&notifications=3&notifications_content=系统出错,数据修改失败！\"</script>";
            exit;
        }
        //修改时
        if (mb_strlen($_POST['password'], 'UTF8') > 24) {
            echo "<script>window.location.href=\"user.php?state=edituser&id={$_POST['id']}&notifications=2&notifications_content=密码不能超出24个字符\"</script>";
            exit;
        }
        if (mb_strlen($_POST['password'], 'UTF8') < 6) {
            echo "<script>window.location.href=\"user.php?state=edituser&id={$_POST['id']}&notifications=2&notifications_content=密码不能低于6个字符\"</script>";
            exit;
        }
        $_POST['password'] = md5($_POST['password']);
        $sql = "update user set username = '{$_POST['username']}',password = '{$_POST['password']}',power = {$_POST['power']} where id='{$_POST['id']}'";
        
        if (Execute($conn, $sql)) {
            echo "<script>window.location.href=\"user.php?notifications=1&notifications_content=修改成功\"</script>";
            exit;
        }
        echo "<script>window.location.href=\"user.php?state=edituser&id={$_POST['id']}&notifications=3&notifications_content=系统出错,数据修改失败！\"</script>";
        exit;
    }

    //表白卡修改
    if ($_POST['state'] == 'editcard' && !empty($_POST['id'])) {
        $sql = Execute($conn, "select * from card where id = '{$_POST['id']}'");//查询数据
        if (mysqli_num_rows($sql) !== 1) {
            echo "<script>window.location.href=\"card.php?state=editcard&id={$_POST['id']}&notifications=2&notifications_content=表白卡不存在\"</script>";
            exit;
        }
        $card_data = mysqli_fetch_assoc($sql);

        if ($_POST['name1'] == $card_data['name_1'] && $_POST['name2'] == $card_data['name_2'] && $_POST['img'] == $card_data['img'] && $_POST['cont'] == $card_data['cont'] && $_POST['zan'] == $card_data['zan']) {
            echo "<script>window.location.href=\"card.php?state=editcard&id={$_POST['id']}&notifications=2&notifications_content=请修改后在提交\"</script>";
            exit;
        }

        if (empty($_POST['name1'])) {
            $_POST['name1'] = 'false';
        }
        if (mb_strlen($_POST['name1'], 'UTF8') > 6) {
            echo "<script>window.location.href=\"card.php?state=editcard&id={$_POST['id']}&notifications=2&notifications_content=名字不能超出6个字符\"</script>";
            exit;
        }
        if (empty($_POST['name2'])) {
            echo "<script>window.location.href=\"card.php?state=editcard&id={$_POST['id']}&notifications=2&notifications_content=请输入TA的名字\"</script>";
            exit;
        }
        if (mb_strlen($_POST['name2'], 'UTF8') > 6) {
            echo "<script>window.location.href=\"card.php?state=editcard&id={$_POST['id']}&notifications=2&notifications_content=名字不能超出6个字符\"</script>";
            exit;
        }

        if (empty($_POST['img'])) {
            $_POST['img'] = 'false';
        }

        if (empty($_POST['cont'])) {
            echo "<script>window.location.href=\"card.php?state=editcard&id={$_POST['id']}&notifications=2&notifications_content=请输入内容\"</script>";
            exit;
        }
        if (mb_strlen($_POST['cont'], 'UTF8') > 120) {
            echo "<script>window.location.href=\"card.php?state=editcard&id={$_POST['id']}&notifications=2&notifications_content=内容不能超出120个字符\"</script>";
            exit;
        }
        if (is_int($_POST['zan'])) {
            echo "<script>window.location.href=\"card.php?state=editcard&id={$_POST['id']}&notifications=2&notifications_content=赞数请输入整数值\"</script>";
            exit;
        }
        
        $_POST['name1'] = Escape($conn, $_POST['name1']);
        $_POST['name2'] = Escape($conn, $_POST['name2']);
        $_POST['img'] = Escape($conn, $_POST['img']);
        $_POST['cont'] = Escape($conn, $_POST['cont']);
        $_POST['zan'] = Escape($conn, $_POST['zan']);

        $comment_sql = "update card set name_1='{$_POST['name1']}',name_2='{$_POST['name2']}',cont='{$_POST['cont']}',img='{$_POST['img']}',zan='{$_POST['zan']}' where id='{$_POST['id']}'";
        $comment_result = Execute($conn, $comment_sql);

        if ($comment_result === false) {
            echo "<script>window.location.href=\"card.php?state=editcard&id={$_POST['id']}&notifications=3&notifications_content=出现内部错误，提交失败！\"</script>";
        }
        echo "<script>window.location.href=\"card.php?notifications=1&notifications_content=修改成功！\"</script>";
        exit;
    }

    //删除表白卡
    if ($_GET['state'] == 'deletecard' && !empty($_GET['id'])) {

        //判断当前登录者权限以及删除开关
        if (SYSTEM_DELET == "false") {
            if ($admin_data['power'] !== "1") {
                echo "<script>window.location.href=\"index.php?notifications=3&notifications_content=权限不足\"</script>";
                exit;
            }
        }

        $sql = Execute($conn, "select * from card where id = '{$_GET['id']}'");//查询数据
        if (mysqli_num_rows($sql) !== 1) {
            echo "<script>window.location.href=\"card.php?&notifications=2&notifications_content=表白卡不存在\"</script>";
            exit;
        }

        $sql = "delete from card where id='{$_GET['id']}'";
        $sql1 = "delete from comment where cardid='{$_GET['id']}'";
        if (Execute($conn, $sql) && Execute($conn, $sql1)) {
            echo "<script>window.location.href=\"card.php?notifications=1&notifications_content=删除成功\"</script>";
            exit;
        }
        echo "<script>window.location.href=\"card.php?notifications=3&notifications_content=系统出错,数据删除失败！\"</script>";
        exit;
    }

    //评论修改
    if ($_POST['state'] == 'editcomment' && !empty($_POST['id'])) {
        $sql = Execute($conn, "select * from comment where id = '{$_POST['id']}'");//查询数据
        if (mysqli_num_rows($sql) !== 1) {
            echo "<script>window.location.href=\"comment.php?state=editcomment&id={$_POST['id']}&notifications=2&notifications_content=评论不存在\"</script>";
            exit;
        }
        $comment_data = mysqli_fetch_assoc($sql);

        if ($_POST['name'] == $comment_data['name'] && $_POST['cont'] == $comment_data['cont']) {
            echo "<script>window.location.href=\"comment.php?state=editcomment&id={$_POST['id']}&notifications=2&notifications_content=请修改后在提交\"</script>";
            exit;
        }

        if (empty($_POST['name'])) {
            echo "<script>window.location.href=\"comment.php?id={$id}&notifications=2&notifications_content=请输入名字\"</script>";
            exit;
        }
        if (mb_strlen($_POST['name'], 'UTF8') > 6) {
            echo "<script>window.location.href=\"comment.php?id={$id}&notifications=2&notifications_content=名字不能超出6个字符\"</script>";
            exit;
        }
        if (empty($_POST['cont'])) {
            echo "<script>window.location.href=\"comment.php?id={$id}&notifications=2&notifications_content=请输入内容\"</script>";
            exit;
        }
        if (mb_strlen($_POST['cont'], 'UTF8') > 24) {
            echo "<script>window.location.href=\"comment.php?id={$id}&notifications=2&notifications_content=内容不能超出24个字符\"</script>";
            exit;
        }

        $_POST['name'] = Escape($conn, $_POST['name']);
        $_POST['cont'] = Escape($conn, $_POST['cont']);

        $sql = "update comment set name='{$_POST['name']}',cont='{$_POST['cont']}' where id='{$_POST['id']}'";

        if (Execute($conn, $sql)) {
            echo "<script>window.location.href=\"comment.php?notifications=1&notifications_content=修改成功\"</script>";
            exit;
        }
        echo "<script>window.location.href=\"comment.php?notifications=3&notifications_content=系统出错,修改失败！\"</script>";
        exit;
    }

    //删除评论
    if ($_GET['state'] == 'deletecomment' && !empty($_GET['id'])) {
        //判断当前登录者权限以及删除开关
        if (SYSTEM_DELET == "false") {
            if ($admin_data['power'] !== "1") {
                echo "<script>window.location.href=\"index.php?notifications=3&notifications_content=权限不足\"</script>";
                exit;
            }
        }
        $sql = Execute($conn, "select * from comment where id = '{$_GET['id']}'");//查询数据

        if (mysqli_num_rows($sql) !== 1) {
            echo "<script>window.location.href=\"comment.php?&notifications=2&notifications_content=评论不存在\"</script>";
            exit;
        }
        $sql = mysqli_fetch_assoc($sql);
        $sql1 = "delete from comment where id='{$_GET['id']}'";
        $sql2 = "update card set comment=comment-1 where id ='{$sql['cardid']}'";
        if (Execute($conn, $sql2) && Execute($conn, $sql1)) {
            echo "<script>window.location.href=\"comment.php?notifications=1&notifications_content=删除成功\"</script>";
            exit;
        }
        echo "<script>window.location.href=\"comment.php?notifications=3&notifications_content=系统出错,数据删除失败！\"</script>";
        exit;
    }

echo "<script>window.location.href=\"index.php?notifications=3&notifications_content=参数传递出错！\"</script>";
exit;
