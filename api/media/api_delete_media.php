<?php

    header("Access-Control-Allow-Methods: DELETE");
    header("Content-Type: application/json");

    include('../../config/config.php');

    $config = new Config();

    if($_SERVER['REQUEST_METHOD']=='DELETE'){

        $input = file_get_contents('php://input'); //always return string "id:14"

        parse_str($input, $_DELETE); //String -> Array
        $id = $_DELETE['id'];

        $res = $config->deleteMedia($id);

        if($res){
            $arr['data'] = "Media Deleted Successfully...";
        }else{
            $arr['data'] = "Media Deletion Failed...";
        }

    }else{
        $arr['error'] = "Only Access DELETE HTTP request type";
    }

    echo json_encode($arr);

?>