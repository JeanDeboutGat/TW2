<?php
require_once('../lib/session_start.php');
require_once('../lib/RequestParameters.class.php');
require_once('../lib/initDataLayer.php');

$response = array();
$req = new RequestParameters("POST");

//verification of parameters
$req->defineNonEmptyString("source");

if(isset($_SESSION["rezozio_user"]) && !empty($_SESSION["rezozio_user"])){
  $user=$_SESSION["rezozio_user"];
  if($req->isValid()){
    $postMessage=$data->postMessage($user["login"],$req->getValue("source"));
    if($postMessage){
      $response["status"] = "ok";
      $response["result"] = true;
    }else {
      $response["status"] = "error";
      $response["message"] = "Message must be longer than 280 characters,please lengthen your input !!!";
    }

  }
  else{
    $response["status"] = "error";
    $response["message"] = "Empty Input,please verify your input !!!";
  }

}
else{
  $response["status"] = "error";
  $response["message"] = "You are not connected,please verify you connection!!!";
}
echo json_encode($response);
?>
