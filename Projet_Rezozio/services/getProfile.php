<?php
  require_once('../lib/session_start.php');
  require_once('../lib/RequestParameters.class.php');
  require_once('../lib/initDataLayer.php');

  $response = array();
  $req = new RequestParameters();

  $req->defineNonEmptyString("userId");

  if($req->isValid()){
    $connected = (isset($_SESSION["rezozio_user"]) && !empty($_SESSION["rezozio_user"])) ? $_SESSION["rezozio_user"]["login"] : false;
    $profile = $data->getProfile($req->getValue("userId"), $connected);

    if(!empty($profile)){
      $response["status"] = "ok";
      $response["result"] = $profile;
    }else{
      $response["status"] = "error";
      $response["message"] = "Sorry, user was not found !";
    }

  }else{
    $response["status"] = "error";
    $response["message"] = "Parameters are not valid, please verify your inputs!!!!!!!!";
  }




  echo json_encode($response);
?>
