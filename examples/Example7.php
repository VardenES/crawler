<?php
	//Tutorial: https://www.menubar.io/php-scraping-tutorial-scrape-reddit-with-goutte/
	
	// Basic HTTP Auth Example

	require '../vendor/autoload.php';
	use Goutte\Client;

	$url = "http://www.symfony.com/blog";


	$client = new Client();

	// Go to the website
	$crawler = $client->request('GET', $url);

	// Get the URI
	print 'Request URI : ' . $crawler->getUri() . PHP_EOL;

	// Get the Symfony\Component\BrowserKit\Response object
	$response = $client->getResponse();

	// Get important stuff out of the Response object
	$status = $response->getStatus();
	$content = $response->getContent();
	$headers = $response->getHeaders();

	print 'HTTP status code : ' . $status . PHP_EOL;
	print 'Content of response : ' . $content . PHP_EOL;
	print 'HTTP Headers : ' . print_r($headers) . PHP_EOL;


?>