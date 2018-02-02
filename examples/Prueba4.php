<?php 

require '../vendor/autoload.php';
use Goutte\Client;
//include("class_geeksity.php");

include('../lib/geeksity/class_geeksity.php');



 // TESOROS
$b = new geeksity();

$b->set_zacatrus();

$enlaces = $b->get_links("http://zacatrus.es/juegos-de-mesa/tablero.html?p=27");

//var_dump($enlaces);

foreach($enlaces as $url){
	$b->get_product_info($url);
}


//$b->get_product_info();
//$b->get_product_info("http://zacatrus.es/great-western-trail-la-gran-ruta-del-oeste.html");

/*
$enlaces = array();

//Nota: Hay 30 páginas de juegos de tablero.
for($i = 1; $i <= 2; $i++){
	$enlace_base = "http://zacatrus.es/juegos-de-mesa/tablero.html?p=";
	$enlace_mod = $enlace_base.$i;

	$enlaces = $b->get_links($enlace_mod);
}

var_dump($enlaces);*/

?>