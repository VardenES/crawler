<?php
	//Tutorial: https://www.menubar.io/php-scraping-tutorial-scrape-reddit-with-goutte/
	require '../vendor/autoload.php';
	use Goutte\Client;

	$url = "http://www.symfony.com/blog/";
	$css_selector = "a.title.may-blank";
	$thing_to_scrape = "_text";

	/* Other things we can fetch:
		href - scrape a url
		src - scrape a link to an image
		class - scrape a CSS class
		_text - scrape text

	 */

	$client = new Client();

	// Go to the website
	$crawler = $client->request('GET', $url);

	// Click on the "Security Advisories" link
	$link = $crawler->selectLink('Security Advisories')->link();
	$crawler = $client->click($link);

	// Get the latest post in this category and display the titles
	$crawler->filter('h2> a')->each(function($node){
		print $node->text()."\n";
	});



?>