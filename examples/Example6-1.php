<?php
	//Tutorial: https://www.menubar.io/php-scraping-tutorial-scrape-reddit-with-goutte/
	
	// Form Login Example

	require '../vendor/autoload.php';
	use Goutte\Client;

	$url = "http://github.com/";

	$client = new Client();

	// Go to the website
	$crawler = $client->request('GET', $url);

	$crawler = $client->click($crawler->selectLink('Sign in')->link());

	$form = $crawler->selectButton('Sign in')->form();
	//$form = $crawler->filter('.default')->form();

	// 'login' and 'password' are the name field
	$crawler = $client->submit($form, array('login' => 'usuario', 'password' => 'contraseña'));

	$crawler->filter('.flash-error')->each(function($node){
		print $node->text()."\n";
	});

	// Save the response to an html file so I can show where this output is coming from
	file_put_contents('blah.html', $client->getResponse()->getContent());

?>