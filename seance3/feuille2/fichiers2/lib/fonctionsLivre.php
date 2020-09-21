<?php
//DEROISSART Maxime
// ajouter ici les fonctions à développer
function propertyName($line){
	$colonpos=strpos($line,":"); // position des deux points dans la chaine de caractères
	if ($colonpos == False){ // s'il n'y a pas de deux points
		return "Error";
	}
	else {
		$newline=substr($line,0,$colonpos); //récupère la portion de texte avant les deux points (ici la propriété)
		$newline=trim($newline); // supprime les espaces situés aux extrémités
	return $newline; // renvoie la propriété du paramètre
	}
}
function propertyValue($line){ // similaire à propertyName
	$colonpos=strpos($line,":");
	if ($colonpos == False){
		return "Error";
	}
	else {
		$newline=substr($line,$colonpos+1,-1);
		$newline=trim($newline);
		return $newline;
	}
}
/*  function readBook($file){
	$book=array(); //Initialisation du tableau
	$line=fgets($file); //Stockage ligne par ligne
	while($line != false){ //tant que le fichier n'a pas été parcouru intégralement
		$name=propertyName($line); //stockage nom
		$value=propertyValue($line); //stockage valeur
		$book[$name]=$value; //association clé(nom) valeur(valeur)
		$line=fgets($file);
	}
	fclose($file);
	return $book;
} */

function elementBuilder($propName, $elementType, $text){
	return '<'.$elementType." class=".'"'.$propName.'"'.">".$text."</".$elementType.">";
}

function authorsToHTML($authors){
	$arrayauthors=explode(" - ",$authors);
	return '<span>'.implode("</span> <span>",$arrayauthors).'</span>';
}

function coverToHTML($fileName){
	return '<img src="../couvertures/'.$fileName.'" alt="image de couverture" />';
}

function propertyToHTML($propName,$propValue){
	if ($propName == 'titre'){
		return elementBuilder($propName,'h2',$propValue);
	}
	else if ($propName == 'couverture'){
		return elementBuilder($propName,'div',coverToHTML($propValue));	
	}
	else if ($propName == 'auteurs'){
		return elementBuilder($propName,'div',authorsToHTML($propValue));	
	}
	else if ($propName == 'année'){
		return elementBuilder($propName,'time',$propValue);	
	}
	else{ //serie
		return elementBuilder($propName,'div',$propValue);
	}
}

function bookToHTML($book){
	$res="\t\t"."<section>"."\n\t\t\t".'<article class="livre">'."\n\t\t\t\t"; //Initialise le résultat
	foreach ($book as $propName => $propValue){ //propriété/valeur de chaque ligne
		$res.=propertyToHTML($propName,$propValue)."\n\t\t\t\t\t"; // ajoute au résultat final
		if ($propName == 'couverture'){
			$res.="\n\t\t\t\t".'<div class="description">'."\n\t\t\t\t\t";
		}
    }
	return $res."\n\t\t\t\t"."</div>"."\n\t\t\t"."</article>"."\n\t\t"."</section>"; // fermeture de la section'
}

function readBook($file){
	$library=array(); //Initialisation du tableau contenant tous les livres
	$book=array(); //Initialisation du tableau contenant un livre
	$line=fgets($file); //Stockage ligne par ligne
	
	while(feof($file) == false){ //tant que le fichier n'a pas été parcouru intégralement
		$name=propertyName($line); //stockage nom
		$value=propertyValue($line); //stockage valeur
		$book[$name]=$value; //association clé(nom) valeur(valeur)
		$line=fgets($file);
		if ($name == "catégorie"){ //Je n'ai pas réussi la question 2.1, je termine donc le livre dès lors que la propriété est catégorie, puis je saute une ligne
			$library[]=$book;
			$book=array(); //stockage du livre dans la bibliothèque et réinitialisation du livre
			$line=fgets($file);	
		}
	}
	fclose($file);
	return $library;
}

	
function libraryToHTML($file){
	$allbooks=readBook($file); //Bibliothèque
	$res="";
	foreach ($allbooks as $livre => $book){
		$res.=bookToHTML($book); //écriture du code livre par livre
	}
	return $res;
}	

?>

