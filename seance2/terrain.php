<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Deuxieme exercice PHP</title>
        <meta charset="UTF-8" />
        <link rel="stylesheet" href="terrain.css" />
        <script src="terrain.js"></script>
    </head>
    <body>
        <header>
            <h1>Deuxieme exercice PHP</h1>
            <h2>Réalisé par <span class="nom">Maxime Deroissart</span></h2>
        </header>
        
		<section>
	        <h2>Question 2</h2>
				<?php
				$nbcar = 0;
				$nbline = 0;
				$err = "";
				$table = "<table class='terrain'><tbody>";

				
				$file = fopen("terrain.txt", "r+");
				$line = fgets($file);

				while ($line !== FALSE && $err === "")
				{
					$line = str_replace("\n", "", $line);
					$line = str_replace("\r", "", $line);
					$nbline = $nbline + 1;

					if ($nbcar === 0)
						$nbcar = strlen($line);
					
					else
					{
						if ($nbcar !== strlen($line))
							$err = "<p>Les lignes sont de longueur differente !</p>";
					}

					$table .= "<tr>";
					while (strlen($line) > 0 && $err === "")
					{
						$car = substr($line, 0, 1);


						if ($car === "B")
							$table .= "<td class=\"blanc\" onclick=\"clicTableau(this);\"></td>";
						else if ($car === "N")
							$table .= "<td class=\"noir\" onclick=\"clicTableau(this);\"></td>";
						else if ($car === "-")
							$table .= "<td onclick=\"clicTableau(this);\"> </td>";
						else
							$err = "<p>Ce caractere n'existe pas.</p>";

						$line = substr($line, 1);
					}
					$table .= "</tr>";
					$line = fgets($file);
				}
				$table .= "</tbody></table>";

				if ($err === "")
				{
					if ($nbline === $nbcar)
						echo $table;
					else
						echo "<p>Ce n'est pas un caractere !</p>";
				}
				else
					echo $err;
				?>
		</section>

    </body>
    
</html>
