<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Premier exercice PHP</title>
        <meta charset="UTF-8" />
        <link rel="stylesheet" href="iniPHP.css" />
    </head>
    <body>
        <header>
            <h1>Premier exercice PHP</h1>
            <h2>Réalisé par <span class="nom">Maxime Deroissart</span></h2>
        </header>
        <section>
            <h2>Question 1</h2>
			<?php 
			date_default_timezone_set("Europe/Paris");         
			echo "Nous sommes le ".date('d/m/Y')
			?>
        </section>
        <section>
            <h2>Question 2</h2>
			<?php 
			date_default_timezone_set("Europe/Paris");         
			echo "La version de PHP utilisée est ".PHP_VERSION;
			echo"La version du système d'exploitation du serveur est ".PHP_OS
			?>
            

        </section>
        <section>
            <h2>Question 3</h2>
			<?php 
			$n=5;
			$texte="veau"
			
			echo "n vaut";
			?>
            

        </section>
    </body>
    
</html>
