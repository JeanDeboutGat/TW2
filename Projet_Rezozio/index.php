<?php require_once("lib/session_start.php");?>
<?php require_once("lib/functions.php");?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<!-- head part -->
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projet Rezozio</title>
    <link rel="stylesheet" href="style/style.css">
  </head>
<!-- body part -->
  <body>
    <div class="content">
      <div class="head">
        <p>Rézozio</p>
      </div>
      <!--left part of body -->
      <div class="main left">
        <div class="page" id="messages">
          <?php include_once("views/formulaire_message.php"); ?>
          <div id="list_messages"></div>
          <button onclick="displayMoreMessages()">Afficher plus de messages</button>
        </div>
        <div class="page" id="abonnes"></div>
        <div class="page hide" id="abonnements"></div>
        <div class="page hide" id="profile"></div>
        <div class="page hide" id="avatar">
          <?php include_once("views/formulaire_avatar.php");?>
        </div>
      </div>
       <!--right part of body -->
      <div class="menu right">
        <?php include_once("views/formulaire_login.php");?>
        <?php include_once("views/formulaire_createUser.php");?>
      </div>
      <div class="clearfix"></div>
    </div>
      <!-- login constant initialisation -->
    <?php if(isloggedin()){?>
      <script>
        const connected = true;
      </script>
    <?php } else{ ?>
      <script>
        const connected = false;
      </script>
    <?php } ?>
     <!-- Java script inclusion part -->
    <script type="text/javascript" src="js/request.js"></script>
    <script type="text/javascript" src="js/app.js"></script>
  </body>
</html>
