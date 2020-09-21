<?php require_once ("lib/fonctionsSVG.php"); ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr" xml:lang="fr">
    <head>
        <meta charset="UTF-8" />
        <title>Test SVG</title>
        <style>
            * {
                font-family : sans-serif;
            }
            svg {
                width : 400px;
                height : 400px;
                border : solid 1pt black;
            }
            #dessin * {
                fill-opacity : 0.7;
            }
            svg rect {
                fill : lightblue;
                stroke : black;
            }
            svg circle {
                fill : red;
            }
            svg polygon {
                fill : black;
            }
            line.axe {
                stroke : grey;
                stroke-width : 1;
            }
            line.marque {
                stroke : grey;
                stroke-width : 1;
            }
            svg text {
                text-anchor : middle;
                font-size:7pt;

            }
        </style>
    </head>
    <body>
        <h1>Test SVG</h1>
        <svg viewbox="-320,-320,640,640" preserveAspectRatio="xMedYMed meet" xmlns="http://www.w3.org/2000/svg">
            <!-- axes et graduations -->
            <line class ="axe" id="axeX" x1="0" y1="0" x2="300" y2="0"/>
            <line class="axe" id="axey" x1="0" y1="0" x2="0" y2="300"/>
            <g transform="translate(100,0)">
                <line class="marque" x1="0" y1="0" x2="0" y2="-3" />:
                <text x="0" y="-4" fill="blue">100</text>
            </g>
            <g transform="translate(0,100) rotate (-90)">
                <line class="marque" x1="0" y1="0" x2="0" y2="-3" />:
                <text x="0" y="-4" fill="blue">100</text>
            </g>
            <g transform="translate(200,0)">
                <line class="marque" x1="0" y1="0" x2="0" y2="-3" />:
                <text x="0" y="-4" fill="blue">200</text>
            </g>
            <g transform="translate(0,200) rotate (-90)">
                <line class="marque" x1="0" y1="0" x2="0" y2="-3" />:
                <text x="0" y="-4" fill="blue">200</text>
            </g>
            <g transform="translate(300,0)">
                <line class="marque" x1="0" y1="0" x2="0" y2="-3" />:
                <text x="0" y="-4" fill="blue">300</text>
            </g>
            <g transform="translate(0,300) rotate (-90)">
                <line class="marque" x1="0" y1="0" x2="0" y2="-3" />:
                <text x="0" y="-4" fill="blue">300</text>
            </g>
            <!-- dessin   -->
            <g id="dessin">

                <!-- circle dessine un cercle de centre cx, cy et de rayon r
                  Exemple : cercle de rayon 70 et de centre (100,150)
                -->
				<?php

        $erreur = False;
        if(isset($_GET["cx"])) {"test"; }
        if(isset($_GET["cx"]) && is_int((int)$_GET["cx"])) {
          if(isset($_GET["cy"]) && is_int((int)$_GET["cy"])) {
            if(isset($_GET["r"]) && is_int((int)$_GET["r"]) && $_GET["r"] > 0) {
              echo cercle($_GET["cx"],$_GET["cy"],$_GET["r"]);
            } else { $erreur = True; }
          } else { $erreur = True; }
        } else { $erreur = True; }
        if($erreur) {
          require("page_erreur.html");
          exit();
        }
				?>
                <!-- rect dessine un rectangle de coin inf�rieur x,y , de largeur width et de hauteur height
                     ce rectangle peut �tre tourn� : rotate(angle,origineX,origineY)
                     o� angle est en degr�; origine X et origineY d�signe le point fixe de la rotation

                    NB : l'attribut transform est optionnel. On peut l'appliquer � tous les �l�ments SVG

                     Exemple ci-dessous : rectangle de largeur 100, hauteur 50 commen�ant au coin (0,50)
                     et tourn� de 30 degr�s autour du point (0,50).

                -->
                <!--<rect x="0" y="50" width="50" height="50" transform="rotate(30,0,50)"/>-->

                <?php
                echo carre($_GET["cx"],$_GET["cy"],$_GET["r"],$_GET["a"]);
                ?>

                <!-- polygon dessine un polygone dont les sommets sont indiqu�s par l'attribut points
                     (ici : un triangle)
                     Exemple ci-dessous : triangle de sommets (200,200), (250,250), (200,250)
                -->
                <polygon points="200,200 250,250 200,250" />

                <!--
                     Exemple ci-dessous : triangle de sommets (200,50), (250,100), (200,100)
                     tourn� de 45 degr�s  autour du point (200,80)
                -->
                <polygon points="200,50 250,100 200,100" transform="rotate(45,200,80)"/>
            </g>
        </svg>
    </body>
</html>
