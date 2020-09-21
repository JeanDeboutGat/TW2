<?php
  require_once('../lib/session_start.php');
  require_once('../lib/RequestParameters.class.php');
  require_once('../lib/initDataLayer.php');

  $response = array();

  if(isset($_SESSION["rezozio_user"])){
    $login = $_SESSION["rezozio_user"]["login"];
    unset($_SESSION["rezozio_user"]);
    $response["status"] = "ok";
    $response["result"] = ["login" => $login];
  }else{
    $response["status"] = "error";
    $response["message"] = "User is not connected!";
  }

  echo json_encode($response);
?>
