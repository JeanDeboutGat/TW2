<!-- message form -->
<div class="formulairemessage">
  <p>Poster un message</p>
  <form id="postmessage" method="post">
    <textarea name="source" rows="8" cols="80"></textarea>
    <button type="submit">Post Message</button>
  </form>
  <div class="filtrage">
    <form id="filters">
      <fieldset>
        <legend>Filtre les messages</legend>
        <div id="authorsearch">
          <input type="text" name="author" id="author" placeholder="Filtre par auteur" onkeypress="authorSearch()">
        </div>
        <button name="action" value="filter" type="submit">Filtre</button>
        <button name="action" value="annuler" type="submit">Annuler les filtres</button>
      </fieldset>
    </form>
  </div>
</div>
