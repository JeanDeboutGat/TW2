<?php
require_once('../lib/session_start.php');
require_once('../lib/RequestParameters.class.php');
require_once('../lib/initDataLayer.php');

$response = array();

if(isset($_SESSION["rezozio_user"]) && !empty($_SESSION["rezozio_user"])){
  $user=$_SESSION["rezozio_user"];
    $followers = $data->getFollowers($user["login"]);
    $response["status"] = "ok";
    $response["result"] = $followers;
}
else{
  $response["status"] = "error";
  $response["message"] = "You are not connected,please verify you connection!!!";
}

echo json_encode($response);
?>
