<?php 

require '../vendor/autoload.php';
use Goutte\Client;
//include("class_geeksity.php");

include('../lib/geeksity/class_geeksity.php');


 // DISTRIMAGEN
$a = new geeksity();

$a->set_distrimagen();

$a->get_links();
$a->get_product_info();


// hora actual
echo date('h:i:s') . "\n";

// dormir durante 10 segundos
sleep(10);

// ¡despierta!
echo date('h:i:s') . "\n";



 // TESOROS
$b = new geeksity();

$b->set_tesoros();

$b->get_links();

$b->get_product_info();


 // ZACATRUS
$c = new geeksity();

$c->set_zacatrus();

$c->get_links();

$c->get_product_info();


 // REDONDA
$d = new geeksity();

$d->set_redonda();

$d->get_links();

$d->get_product_info();

// Recordar, los selectores se cogen como en jquery
// https://api.jquery.com/category/selectors/

//Más info scraping
//http://safeerahmed.uk/web-scraping-101-with-php-and-goutte

?>