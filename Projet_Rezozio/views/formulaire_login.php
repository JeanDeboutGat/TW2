<!--  login form  -->

<div id="loginform">
<!-- verify if user is logged in -->
<?php if(!isloggedin()){?>
    <p class="seconnecter">Se connecter</p>
    <form method="POST" id="login">
      <input type="text" name="login" value="" placeholder="Login"/>
      <input type="password" name="password" value="" placeholder="Password" />
      <input type="submit" value="Se connecter" />
    </form>
<?php }else{
  $user = getConnectedUserProfile(); ?>
   <!-- if user is logged he/she get in his/her space account  -->
  <p>Bonjour <span class="pseudo"><?php echo $user["pseudo"];?></span></p>
  <img id="avatarimg" src="services/getAvatar.php?size=large&userId=<?php echo $user["login"];?>" alt="Avatar">
  <br>
  <button id="logout">Logout</button>
  <ul>
  
    <li><a href="#" onclick="showPage('messages')">Page d'Accueil</a></li>
    <li><a href="#" onclick="showPage('profile')">Mettre à jour mon profil</a></li>
    <li><a href="#" onclick="showPage('abonnes')">Mes abonnées</a></li>
    <li><a href="#" onclick="showPage('abonnements')">Liste des Abonnements</a></li>
    <li><a href="#" onclick="showPage('avatar')">Mettre à jour l'avatar</a></li>
  </ul>
<?php }?>
</div>
