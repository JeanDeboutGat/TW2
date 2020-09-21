<?php
  require_once('../lib/session_start.php');
  require_once('../lib/RequestParameters.class.php');
  require_once('../lib/initDataLayer.php');

  header('content-type:application/json');

  $response = array();
  $req = new RequestParameters("POST");
  //parameters verification
  $req->defineNonEmptyString("login");
  $req->defineNonEmptyString("password");
  
  $response["args"] = $req->getValues();
  if($req->isValid()){
    $login = $req->getValue("login");
    $password = $req->getValue("password");
    $user = $data->login($login, $password);

    if($user == false){
        $response["status"] = "error";
        $response["message"] = "Error, Username or password is incorrect!";
    }else{
        $informations = ["login" => $user["login"], "pseudo" => $user["pseudo"]];
        $response["status"] = "ok";
        $response["message"] = "User connected!";
        $response["result"] = $informations;
        $_SESSION["rezozio_user"] = $informations;
    }
  }else{
    $response["status"] = "error";
    $response["message"] = "Parameters are not valid";
  }

  echo json_encode($response);
?>
