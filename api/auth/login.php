<?php

    header("Access-Control-Allow-Methods: POST");
    header("Content-Type: application/json");

    include('../../config/config.php');

    $config = new Config();

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $email = $_POST['email'];
        $password = $_POST['password'];

        $res = $config->loginUser($email, $password);

        if($res){
            $arr['auth']=true;
            $arr['data']="User Login Successfully...";
        }else{
            $arr['auth']=false;
            $arr['data']="User Login Failed...";
        }

    }else{
        $arr['Error'] = 'Only Post Method Allow..';
    }

    echo json_encode($arr);

?>