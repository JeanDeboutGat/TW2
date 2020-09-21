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
			"select equipes.directeur, equipes.couleur from equipes where equipes.nom like '$_POST[equipe]'"
			);
$stmt -> execute();
$stmt ->setFetchMode(PDO::FETCH_ASSOC);
echo "<table>";
while ($ligne = $stmt->fetch()) {
	echo "<tr><td>{$ligne['directeur']}</td>".	
		 "<td>{$ligne['couleur']}</td></tr>";
	}
echo "</table>";

$stmt = $connexion -> prepare(
			"select coureurs.nom from coureurs where coureurs.equipe like '$_POST[equipe]'"
			);
$stmt -> execute();
$stmt ->setFetchMode(PDO::FETCH_ASSOC);
echo "<table>";
while ($ligne = $stmt->fetch()) {
	echo "<tr><td>{$ligne['nom']}</td></tr>";
	}
echo "</table>";
		
		

?>
