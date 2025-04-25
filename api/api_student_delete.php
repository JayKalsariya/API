<?php

    header("Access-Control-Allow-Methods: DELETE");
    header("Content-Type: application/json");

    include('../config/config.php');

    $config = new Config();

    if($_SERVER['REQUEST_METHOD']=='DELETE'){

        $input = file_get_contents('php://input'); //always return string "id:14"

        parse_str($input, $_DELETE);
        $id = $_DELETE['id'];

        $res = $config->deleteData($id);

        if($res){
            $arr['data'] = "Student Deleted Successfully...";
        }else{
            $arr['data'] = "Student Deletion Failed...";
        }

    }else{
        $arr['error'] = "Only Access DELETE HTTP request type";
    }

    echo json_encode($arr);

?>