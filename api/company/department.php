<?php
    
    header("Access-Control-Allow-Methods: POST");
    header("Content-Type: application/json");

    include('../../config/config.php');

    $config = new Config();

    if($_SERVER['REQUEST_METHOD']=='POST'){
        $name = $_POST['name'];
        
        $res = $config->insertDepartment($name);
        
        if($res){
            http_response_code(201);
            $arr['msg'] = "Data Inserted...";
        }else{
            $arr['msg'] = "Data not Inserted...";
        }
    }else{
        $arr['Error'] = "Only Access POST HTTP request type";
    }

    echo json_encode($arr);
    //POST => ARRAY => ENCODE => json_encode

?>