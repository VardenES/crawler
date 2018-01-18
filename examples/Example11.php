<?php
	//Tutorial: https://www.menubar.io/php-scraping-tutorial-scrape-reddit-with-goutte/
	require '../vendor/autoload.php';
	use Goutte\Client;

	$url = 'http://XXXXXXXXXXXXX';
	$cookie_file = 'path/to/cookie.txt';

	$client = new Client([
	    'curl' => array(
	        CURLOPT_COOKIEFILE => $cookie_file,
	        CURLOPT_COOKIEJAR => $cookie_file,
	        CURLOPT_RETURNTRANSFER  => 1,
	        CURLOPT_SSL_VERIFYHOST  => FALSE,
	        CURLOPT_SSL_VERIFYPEER  => FALSE,
	        CURLOPT_FOLLOWLOCATION  => TRUE,
	        CURLOPT_COOKIESESSION  => TRUE,
	    ),
	    'cookies' => true
	]);

	//$client->getClient()->setDefaultOption('config/curl/'.CURLOPT_SSL_VERIFYHOST, FALSE);
	//$client->getClient()->setDefaultOption('config/curl/'.CURLOPT_SSL_VERIFYPEER, FALSE);
	//$client->getClient()->setDefaultOption('config/curl/'.CURLOPT_RETURNTRANSFER, TRUE);
	//$client->getClient()->setDefaultOption('config/curl/'.CURLOPT_FOLLOWLOCATION, TRUE);
	//$client->getClient()->setDefaultOption('config/curl/'.CURLOPT_COOKIESESSION, TRUE);
	$client->setHeader('User-Agent', "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36");
	$crawler = $client->request('GET', $url);


	// Many attribute values at once
	$output = $crawler->filter($css_selector)->extract(array('_text', 'class', 'href'));



	var_dump($output);

?>