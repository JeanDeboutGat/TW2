<?php
    //verification function if user is logged in or not
    function isloggedin(){
      return isset($_SESSION["rezozio_user"]) ?  !empty($_SESSION["rezozio_user"]) : false;
    }
    //function to identify the connected user
    function getConnectedUserProfile(){
      if(isloggedin()){
        return $_SESSION["rezozio_user"];
      }else{
        return false;
      }
    }

?>
