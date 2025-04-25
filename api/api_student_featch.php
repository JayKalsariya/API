<?php

    header("Access-Control-Allow-Methods: GET");
    header("Content-Type: application/json");

    include('../config/config.php');

    $config = new Config();

    if($_SERVER['REQUEST_METHOD']=='GET'){
        http_response_code(200);

        $result = $config->featchData();

        $all_students =[];

        while($record = mysqli_fetch_assoc($result)){
            array_push($all_students, $record);
        }

        $arr['data'] = $all_students;
    }else{
        $arr['error'] = "Only Access GET HTTP request type";
    }

    echo json_encode($arr);

?>