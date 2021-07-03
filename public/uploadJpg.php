<?php
    @header("Content-type: text/html; charset=utf-8");
    //引入基本配置
    require_once "../config/systemConfig.php";
    if (is_uploaded_file($_FILES['myfile']['tmp_name'])) {
        $arr=pathinfo($_FILES['myfile']['name']);
        
        $arr['extension']=strtolower($arr['extension']);

        //3请上传PNG,JPG,JPGE,GIF格式文件！
        if ($arr['extension'] !== 'png' && $arr['extension'] !== 'jpg' && $arr['extension'] !== 'jpeg' && $arr['extension'] !== 'gif') {
            $arr1['state'] = '3';
            echo json_encode($arr1);
            exit;
        }
        //2超出2M
        if ($_FILES['myfile']['size'] > 2097152) {
            $arr1['state'] = '2';
            echo json_encode($arr1);
            exit;
        }
        
        $newName=date('YmdGis').rand(1000, 9999);
        $namejpg = $newName.'.'.$arr['extension'];
        if (move_uploaded_file($_FILES['myfile']['tmp_name'], "../uploads/{$namejpg}")) {
            //1上传成功！
            $arr1 = array(
                'state' => '1',
                'url' => '//'.SYSTEM_URL.'/uploads/'.$namejpg
            );
            echo json_encode($arr1);
            exit;
        } else {
            //4对不起移动文件失败！
            $arr1['state'] = '4';
            echo json_encode($arr1);
            exit;
        }
    } else {
        //5可能有攻击，请你做合法的事情！
        $arr1['state'] = '5';
        echo json_encode($arr1);
        exit;
    }
