<?php
  require_once('../lib/session_start.php');
  require_once('../lib/RequestParameters.class.php');
  require_once('../lib/initDataLayer.php');

  header('content-type:application/json');

  $response = array();
  $req = new RequestParameters("POST");

  $req->defineNonEmptyString("userId");
  $req->defineNonEmptyString("password");
  $req->defineNonEmptyString("pseudo");
  $req->defineNonEmptyString("description");


  $response["args"] = $req->getValues();
  if($req->isValid()){
    $login = $req->getValue("userId");
    $pass = $req->getValue("password");
    $pseudo = $req->getValue("pseudo");
    $description = $req->getValue("description");

    $user = $data->createUser($login, $pass, $pseudo, $description);
    if($user == 1){
      // user created
      $response["status"] = "ok";
      $response["message"] = "Account was created !";
    }
    elseif ($user == -1) {
      $response["status"] = "error";
      $response["message"] = "Error, This username exists already try with a different one!";
    }
    else{
      // user not created
      $response["status"] = "error";
      $response["message"] = "Account was not created !";
    }

  }else{
    $response["status"] = "error";
    $response["message"] = "Parameters are not valid";
  }

  echo json_encode($response);
?>
