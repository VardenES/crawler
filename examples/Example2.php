<?php
	//Tutorial: https://www.menubar.io/php-scraping-tutorial-scrape-reddit-with-goutte/
	require '../vendor/autoload.php';
	use Goutte\Client;

	//Multiple pages
	$url = array(
		'http://www.reddit.com',
		'https://www.reddit.com/new/',
		'https:://www.reddit.com/rising/'
	);
	
	$selector = "a.title.may-blank";
	$attribute = "_text";

	/* Other things we can fetch:
		href - scrape a url
		src - scrape a link to an image
		class - scrape a CSS class
		_text - scrape text

	 */

	foreach($url as $key => $value) {
		$client = new Client();

		// iterations
		$crawler = $client->request('GET', $value);

		$output[$key] = $crawler
		->filter($selector) //CSS selector
		->eq(1) // node position
		->extract($attribute); // DOM attribute to extract

	}

	var_dump($output);




?>