<?php
 require_once('../lib/session_start.php');
 require_once('../lib/RequestParameters.class.php');
 require_once('../lib/initDataLayer.php');


 $response = array();
 $req = new RequestParameters("GET");

 $req->defineNonEmptyString("subId");

 if($req->isValid()){
   $subId = $req->getValue("subId");
   if(strlen($subId) > 2){
     $users = $data->findUsers($subId);

     if($users){
       // user created
       $response["status"] = "ok";
       $response["message"] = " the users have been found ";
       $response["result"] = $users;
     }
     else{
       $response["status"] = "error";
       $response["message"] = "None of users match your input !!!!! Try again";
     }
   }else{
     $response["status"] = "error";
     $response["message"] = "Sub id size incorrect";
   }
 }
 else{
   $response["status"] = "error";
   $response["message"] = "Empty inputs, try to enter a non empty string";
 }

 echo json_encode($response);
 ?>
