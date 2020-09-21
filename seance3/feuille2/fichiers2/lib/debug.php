<?php
header("Content-Type: text/plain;charset=UTF-8"); 
require_once("lib/fonctionsLivre.php");    // inclusion de fichier

/* Test question 1.1
 */
/* $ligneOK = " nom_de_prop : machin chose ";
$ligneKO = " nom_de_prop  machin chose ";
echo '|'.propertyName($ligneOK).'|';
echo "\n";
echo '|'.propertyValue($ligneOK).'|';
echo "\n";
echo '|'.propertyValue($ligneKO).'|'; */

/* Test question 1.2
 */
/*
$file = fopen('data/exempleLivre.txt','r');
$livre = readBook($file);
print_r($livre);
*/

/* Test question 1.3.1
 */
/* $propName='titre';
$elementType='h2';
$text='La marque du diable';
echo '|'.elementBuilder($propName, $elementType, $text).'|'; */

/* Test question 1.3.2
 */
/* $authors='Marini - Desberg';

echo '|'.authorsToHTML($authors).'|'; */

/* Test question 1.3.3
 */
/* $fileName='scorpion.jpg';

echo '|'.coverToHTML($fileName).'|'; 
 */
/* Test question 1.3.4
 */

/* echo '|'.propertyToHTML('titre', 'La marque du diable').'|';
echo '|'.propertyToHTML('auteurs', 'Marini - Desberg').'|';
echo '|'.propertyToHTML('couverture', 'scorpion.jpg').'|';
echo '|'.propertyToHTML('année', '2006').'|';
echo '|'.propertyToHTML('autre', 'La marque du diable').'|'; */


/* Test question 1.3.5
 */
 
/* $file = fopen('data/exempleLivre.txt','r');
$livre = readBook($file);

echo '|'.bookToHTML($livre).'|'; */


/* Test question 2.1
 */

$file = fopen('../data/livres.txt','r');
$livre = readBook($file);
print_r($livre);





 



?>