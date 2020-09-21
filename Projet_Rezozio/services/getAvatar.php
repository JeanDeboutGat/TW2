<?php
    require_once('../lib/session_start.php');
    require_once('../lib/RequestParameters.class.php');
    require_once('../lib/initDataLayer.php');
    
    $response = array();
    $req = new RequestParameters();
    $req->defineNonEmptyString("userId");
    $req->defineString("size", ['dimension' => "scalar", 'default' => "small"]);

    if($req->isValid()){
        $userId = $req->getValue("userId");
        $size = $req->getValue("size");

        $avatar = $data->getAvatar($userId, $size);
 
        if($avatar){
            $mime = $avatar["avatar_type"];
            header("Content-Type: $mime");
            $file = stream_get_contents($avatar["avatar"]);
            echo $file;
            exit();
        }else{
            $response["status"] = "error";
            $response["result"] = false; 
        }
    
    }else{
        $response["status"] = "error";
        $response["result"] = false;
    }

    header("Content-Type: application/json");
    echo json_encode($response);
?>