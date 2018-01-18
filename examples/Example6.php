<?php
	//Tutorial: https://www.menubar.io/php-scraping-tutorial-scrape-reddit-with-goutte/
	
	// Form Login Example

	require '../vendor/autoload.php';
	use Goutte\Client;

	$url = "https://www.mercadona.es/ns/entrada.php?js=1";

	$client = new Client();

	// Go to the website
	$crawler = $client->request('GET', $url);

	$crawler = $client->click($crawler->selectLink('Sign in')->link());

	$form = $crawler->selectButton('Sign in')->form();

	$crawler = $client->submit($form, array('login' => 'ususario', 'password' => 'contraseña'));

	$crawler->filter('.flash-error')->each(function($node){
		print $node->text()."\n";
	});



?>