<?php
require_once('../lib/session_start.php');
require_once('../lib/RequestParameters.class.php');
require_once('../lib/initDataLayer.php');

$response = array();
$req = new RequestParameters();

//verification of parameters
$req->defineNonEmptyString("target");

if(isset($_SESSION["rezozio_user"]) && !empty($_SESSION["rezozio_user"])){
  $target = $req->getValue("target");
  $user=$_SESSION["rezozio_user"];
  if ($req->isValid()){
    $follow = $data->follow($user["login"], $target);

    if ($follow == 1){
      $response["status"] = "ok";
      $response["result"] = true;

    }
    elseif($follow == -1){
    //they have already followed
      $response["status"] = "error";
      $response["message"] = "Already subscribed!!!";
    }
    elseif($follow == 0){
    //The user you want to follow doesn't exist
      $response["status"] = "error";
      $response["message"] = "The user you want to follow doesn't exist!!!";
    }
  }
  //in case no string entered
  else{
    $response["status"] = "error";
    $response["message"] = "Empty Input,please verify your input !!!";
  }

}
//the session of client is not valid
else{
  $response["status"] = "error";
  $response["message"] = "You are not connected,please verify you connection!!!";
}

echo json_encode($response);
?>
