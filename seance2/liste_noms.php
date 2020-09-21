<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Premier exercice PHP</title>
        <meta charset="UTF-8" />
        <link rel="stylesheet" href="liste_noms.css" />
    </head>
    <body>
        <header>
            <h1>Premier exercice PHP</h1>
            <h2>Réalisé par <span class="nom">Maxime Deroissart</span></h2>
        </header>
        <section>
            <h2>Question 1</h2>
			
			<br/>
			<?php 
			
			$file= fopen("liste_noms.txt","r+");
			$line = fgets ($file);
			echo "<ul>";
			while ($line)
			{
				echo "<li>".$line."</li>";
				$line = fgets ($file);
			}
			fclose($file);
			echo "</ul>";
			
			?>		
			
        </section>
        
	</body>
</html>
        
        
