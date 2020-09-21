<?php
  require_once('../lib/session_start.php');
  require_once('../lib/RequestParameters.class.php');
  require_once('../lib/initDataLayer.php');

  $response = array();
  $req = new RequestParameters("POST");

  $req->defineNonEmptyString("pseudo");
  $req->defineNonEmptyString("password");
  $req->defineNonEmptyString("description");

  //$response["args"] = $req->getValues();
  if(isset($_SESSION["rezozio_user"]) && !empty($_SESSION["rezozio_user"])){
    $user=$_SESSION["rezozio_user"];


    if($req->isValid()){

      $pseudo = $req->getValue("pseudo");
      $pass = $req->getValue("password");
      $description = $req->getValue("description");

      $profile = $data->setProfile($user["login"],$pseudo, $pass, $description);

      if($profile ==-1){
        $response["status"] = "error";
        $response["message"] = "Description must not exceed  1024 characters !!!";

      }
      elseif ($profile == 0) {
        $response["status"] = "error";
        $response["message"] = "Pseudo must not be more than 25 characters!";
      }
      else{
        $response["result"]=$profile;
        $response["status"] = "ok";
        $response["message"] = "Profile is set !";

      }

    }else{
      $response["status"] = "error";
      $response["message"] = "Parameters are not valid, please verify your inputs!!!!!!!!";
    }
  }
  else {
    $response["status"] = "error";
    $response["message"] = "You are not connected,please login!!!";
  }



  echo json_encode($response);
?>
