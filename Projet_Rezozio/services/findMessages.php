<?php
require_once('../lib/session_start.php');header('content-type:application/json');
require_once('../lib/RequestParameters.class.php');
require_once('../lib/initDataLayer.php');

header('content-type:application/json');

$response = array();
$req = new RequestParameters();

$req->defineString("author", ['dimension' => "scalar", 'default' => ""]);
$req->defineString("before", ['dimension' => "scalar", 'default' => ""]);
$req->defineInt("count", ['dimension' => "scalar", 'default' => 15]);

if($req->isValid()){
  $author = $req->getValue("author");
  $before = $req->getValue("before");
  $count = $req->getValue("count");


  $messages = $data->findMessages($author, $before, $count);
  $response["status"] = "ok";
  $response["result"] = $messages;
}
else{
  $response["status"] = "error";
  $response["message"] = "Empty Input,please verify your input !!!";
}

echo json_encode($response);
?>
