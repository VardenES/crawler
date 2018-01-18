<?php
	//Tutorial: https://www.menubar.io/php-scraping-tutorial-scrape-reddit-with-goutte/
	require '../vendor/autoload.php';
	use Goutte\Client;

	$url = "http://www.reddit.com";
	$css_selector = "a.title.may-blank";
	$thing_to_scrape = "_text";

	/* Other things we can fetch:
		href - scrape a url
		src - scrape a link to an image
		class - scrape a CSS class
		_text - scrape text

	 */

	$client = new Client();
	$crawler = $client->request('GET', $url);
	//$output = $crawler->filter($css_selector)->extract($thing_to_scrape);


	// Many attribute values at once
	$output = $crawler->filter($css_selector)->extract(array('_text', 'class', 'href'));



	// We can access node by its position on the list. Eg. 2
	/*
	$output = $crawler
		->filter($css_selector) //CSS selector
		->eq(1) // node position
		->extract('_text'); // DOM attribute to extract
	*/



	var_dump($output);




?>