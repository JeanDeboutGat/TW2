<!-- formulaire login -->
<div id="signup">
  <?php if(!isloggedin()){?>
      <p class="seconnecter">Créer un compte</p>
      <form method="POST" id="createUser">
        <input type="text" name="userId" value="" placeholder="Login"/>
          <input type="text" name="pseudo" value="" placeholder="Pseudo"/>
        <input type="password" name="password" value="" placeholder="Password" />
        <input type="text" name="description" value="" placeholder="Description" />
        <input type="submit" value="Créer mon compte" />
      </form>
  <?php } ?>
</div>
