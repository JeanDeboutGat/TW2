<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Bibliothèque</title>
		<meta charset="UTF-8" />
	</head>
	<body>
		<header>
			<h1>Bibliothèque</h1>
		</header>

		<?php
			require_once("fonctionsLivre.php");    // Appelle le fichier contenant les fonctions du livre
			$file = fopen('../data/exempleLivre.txt','r');
			echo bookToHTML(readBook($file)[0]); //Rédige l'article conformément à exemplelivre.html
		?>		
	</body>
</html>