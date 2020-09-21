<?php
 require_once('../lib/session_start.php');
 require_once('../lib/RequestParameters.class.php');
 require_once('../lib/initDataLayer.php');


 $response = array();
 $req = new RequestParameters("GET");

 $req->defineNonEmptyString("userId");

 if($req->isValid()){
   $userId = $req->getValue("userId");
   $user = $data->getUser($userId);

   if($user){
     // user created
     $response["status"] = "ok";
     $response["message"] = " the user has been found and obtained";
     $response["result"] = ["userId" => $user["login"], "pseudo" => $user["pseudo"]];
   }
   else{
     $response["status"] = "error";
     $response["message"] = "the user doesn't exist, the user was not obtained";
   }

 }
 else{
   $response["status"] = "error";
   $response["message"] = "Inputs invalid, the user was not obtained ";
 }

 echo json_encode($response);

 ?>
