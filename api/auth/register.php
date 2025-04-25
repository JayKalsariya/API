<?php

    header("Access-Control-Allow-Methods: POST");
    header("Content-Type: application/json");

    include('../../config/config.php');

    $config = new Config();

    if($_SERVER['REQUEST_METHOD']=='POST'){

        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        $res = $config->registerUser($username, $email, $password);

        if($res){
            $arr['Data'] = "User Registerd...";
        }else{
            $arr['Data'] = "User Registration Failed...";
        }

    }else{
        $arr['Error'] = 'Only Post Method Allow..';
    }

    echo json_encode($arr);

?>