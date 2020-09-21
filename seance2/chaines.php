<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <title>Troisieme exercice PHP</title>
        <meta charset="UTF-8" />
        <link rel="stylesheet" href="chaines.css" />
    </head>

    <body>
        <header>
            <h1>Troisieme exercice PHP</h1>
            <h2>Réalisé par <span class="nom">Maxime Deroissart</span></h2>
        </header>

        <section>
            <h2>Question 3.1</h2>
            <?php
            $chaine = "Et qu'on sorte+ Vistement : +Car Clément + Le vous mande.";
            $listeChaines = explode("+", $chaine);
            for($i = 0; $i < count($listeChaines); $i++)
            {
                $listeChaines[$i] = trim($listeChaines[$i]);
                echo "<p>" . $listeChaines[$i]. "</p>";
            }

            ?>
        </section>
        <section>
            <h2>Question 3.2</h2>
            <?php
            $chaine = "Dupont - Dupond - Hadock - Tournesol - Tintin";
            $listeChaines = explode("-", $chaine);
            for($i = 0; $i < count($listeChaines); $i++)
            {
                $listeChaines[$i] = trim($listeChaines[$i]);
                echo "<span>" . $listeChaines[$i]. "</span>";
            }

            ?>
        </section>
        <section>
            <h2>Question 3.3</h2>
            <?php

            function enSpan($s)
            {
                $listeChaines = explode(" - ", $s);
                $res = "";
                for($i = 0; $i < count($listeChaines); $i++)
                {
                    $listeChaines[$i] = trim($listeChaines[$i]);
                    $res .= "<span>" .$listeChaines[$i]. "</span>";
                }
                return $res ;
            }

            $chaine = "Dupont - Dupond - Hadock - Tournesol - Tintin";
            echo(enSpan($chaine));

            ?>
        </section>

    </body>

</html>
