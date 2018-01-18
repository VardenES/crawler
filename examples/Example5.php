<?php
	//Tutorial: https://www.menubar.io/php-scraping-tutorial-scrape-reddit-with-goutte/
	
	// Basic HTTP Auth Example

	require '../vendor/autoload.php';
	use Goutte\Client;

	$url = "http://browserspy.dk/password-ok.php";

	$client = new Client();

	// Params are username, password, and auth type (basic & digest)
	$client->setAuth('test', 'test', 'basic');

	// Go to the website
	$crawler = $client->request('GET', $url);

	print $client->getResponse()->getStatus();
	// 401 = no good, 200 = happy

?>