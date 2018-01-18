<?php
	//Tutorial: https://www.menubar.io/php-scraping-tutorial-scrape-reddit-with-goutte/
	
	// Form Login Example

	require '../vendor/autoload.php';
	use Goutte\Client;

	$url = "https://www.mercadona.es/es/inicio/";

	$client = new Client();

	// Go to the website
	$crawler = $client->request('GET', $url);

	$crawler = $client->click($crawler->selectLink('Compra online')->link());

	var_dump($crawler);

/*
	$form = $crawler->selectButton('Compra online')->form();
	//$form = $crawler->filter('.default')->form();

	// 'login' and 'password' are the name field
	$crawler = $client->submit($form, array('username' => 'usuario', 'password' => 'contraseña'));

	$crawler->filter('.flash-error')->each(function($node){
		print $node->text()."\n";
	});
*/
?>