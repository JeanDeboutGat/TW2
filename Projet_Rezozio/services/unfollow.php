<?php
require_once('../lib/session_start.php');
require_once('../lib/RequestParameters.class.php');
require_once('../lib/initDataLayer.php');

$response = array();
$req = new RequestParameters();

$req->defineNonEmptyString("target");

if(isset($_SESSION["rezozio_user"]) && !empty($_SESSION["rezozio_user"])){
  $target = $req->getValue("target");
  $user=$_SESSION["rezozio_user"];
  if ($req->isValid()){
    $follow = $data->unfollow($user["login"], $target);

    if ($follow){
      $response["status"] = "ok";
      $response["result"] = true;

    }
    else{
    //they have already followed
      $response["status"] = "error";
      $response["message"] = "You dont follow this user !!!";
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
  $response["message"] = "You are not connected,please login!!!";
}

echo json_encode($response);
?>
