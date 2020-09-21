<?php
 try {
	 $connexion=new PDO(
	 "pgsql:host=localhost;dbname=deroissart","deroissart","deroissart");
 } 
 catch (PDOException $e) {
	 echo ("Erreur connexion : ".$e ->getMessage() );
	 exit();
 }

$stmt = $connexion -> prepare(
			"select coureurs.nom,coureurs.equipe,equipes.directeur from coureurs,equipes where coureurs.equipe = equipes.nom"
			);
$stmt -> execute();
$stmt ->setFetchMode(PDO::FETCH_ASSOC);
echo "<table>";
while ($ligne = $stmt->fetch()) {
	echo "<tr><td>{$ligne['nom']}</td>".	
		 "<td>{$ligne['equipe']}</td>".
		 "<td>{$ligne['directeur']}</td></tr>";
	}
echo "</table>";
		
		

?>
