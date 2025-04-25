<?php
    
    header("Access-Control-Allow-Methods: POST");
    header("Content-Type: application/json");

    include('../../config/config.php');

    $config = new Config();

    if($_SERVER['REQUEST_METHOD']=='POST'){

        $name = $_FILES['fname']['name'];
        $tmp_name = $_FILES['fname']['tmp_name'];

        $uid = uniqid("student");

        $destination = '../../image/' . $uid . $name;

        $isUploaded = move_uploaded_file($tmp_name, $destination);

        if ($isUploaded) {
            $res = $config->insertMedia($uid.$name);

            if($res){
                $arr['msg'] = "Media Inserted...";
            }else{
                $arr['msg'] = "Media not Inserted...";
            }
        }else{
            $arr['Error'] = 'Media not Inserted...';
        }
    }else{
        $arr['Error'] = "Only Access POST HTTP request type";
    }

    echo json_encode($arr);
    //POST => ARRAY => ENCODE => json_encode

?>