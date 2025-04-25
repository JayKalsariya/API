<?php

    header("Access-Control-Allow-Methods: PUT, PATCH");
    header("Content-Type: application/json");

    include('../config/config.php');

    $config = new Config();

    if($_SERVER['REQUEST_METHOD']=='PUT' || $_SERVER['REQUEST_METHOD']=='PATCH'){

        $input = file_get_contents('php://input');

        parse_str($input, $_UPDATE);

        $id = $_UPDATE['id'];
        $name = $_UPDATE['name'];
        $age = $_UPDATE['age'];
        $course = $_UPDATE['course'];

        $res = $config->updateStudent($id, $name, $age, $course);

        if($res){
            $arr['data'] = "Student Data Updated...";
        }else{
            $arr['data'] = "Student Data Not Updated...";
        }

    }else{
        $arr['error'] = "Only Access PUT & PATCH HTTP request type";
    }

    echo json_encode($arr);

?>