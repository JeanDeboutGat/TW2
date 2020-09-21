<?php
require_once('../lib/session_start.php');
require_once('../lib/RequestParameters.class.php');
require_once('../lib/initDataLayer.php');

$response = array();
$req = new RequestParameters("POST");

$req->defineNonEmptyString("messageId");

if($req->isValid()){
  $messageId=$data->getMessage($req->getValue("messageId"));
  if($messageId){
    $response["status"] = "ok";
    $response["result"] = $messageId;
  }else {
    $response["status"] = "error";
    $response["message"] = "the message Id doesn't exist!!!!";
  }

}
else{
  $response["status"] = "error";
  $response["message"] = "Empty Input,please verify your input !!!";
}

echo json_encode($response);
?>
