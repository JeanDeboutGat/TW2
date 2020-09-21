<?php
function cercle($cx,$cy,$r){
	return "<circle cx=\"".$cx."\" cy=\"".$cy."\" r=\"".$r."\" />";
}

function carre($cx, $cy, $r,$angle=0) {
	$c = $r*sqrt(2);
	return '<rect x="'.($cx - ($c / 2)).'" y="'.($cy - ($c / 2)).'" width="'.$c.'" height="'.$c.'" transform="rotate('.$angle.','.$cx.','.$cy.')"/>';
}


?>
