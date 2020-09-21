<?php
require_once('../lib/session_start.php');
require_once('../lib/RequestParameters.class.php');
require_once('../lib/initDataLayer.php');

header('content-type:application/json');

$response = array();
$req = new RequestParameters();

$req->defineString("before", ['dimension' => "scalar", 'default' => ""]);
$req->defineInt("count", ['dimension' => "scalar", 'default' => 15]);

if(isset($_SESSION["rezozio_user"]) && !empty($_SESSION["rezozio_user"])){
  $userId=$_SESSION["rezozio_user"]["login"];

  if($req->isValid()){
    $before = $req->getValue("before");
    $count = $req->getValue("count");

    $messages = $data->findFollowedMessages($userId, $before, $count);
    $response["status"] = "ok";
    $response["result"] = $messages;

  }
  else{
    $response["status"] = "error";
    $response["message"] = "Empty Input,please verify your input !!!";
  }

}
else {
  $response["status"] = "error";
  $response["message"] = "You are not connected,please verify you connection!!!";
}



echo json_encode($response);
?>
