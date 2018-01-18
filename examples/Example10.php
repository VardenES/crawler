<?php
	//Tutorial: https://www.menubar.io/php-scraping-tutorial-scrape-reddit-with-goutte/
	require '../vendor/autoload.php';
	use Goutte\Client;

	$url = "http://www.reddit.com/";
	$css_selector = "a.title.may-blank";
	$thing_to_scrape = "_text";	
	$link_text = "AskReddit"; //Link text";


	$guzzleClient = new \GuzzleHttp\Client(array( 'curl' => array( CURLOPT_SSL_VERIFYPEER => false, ), )); 
	$client = new Client();
	$client->setClient($guzzleClient);

	//$client = new Client();
	$crawler = $client->request('GET', $url);

	$link = $crawler->selectLink($link_text)->link();

	// With Goutte we can follow them
	// The 'click' method has two possible scenarious of work:
	// 1) it just follows a link and returns a new page
	// 2) if the link is inside a form, it will submit the form and return a new page

	// Here I will have a new website, may be with the same name the variable
	$pageCrawler = $client->click($link);

	// New Try to go to another page after the first one
	$link_text2 = "pics"; //Link text";
	$link2 = $pageCrawler->selectLink($link_text2)->link();
	$pageCrawler2 = $client->click($link2);


	//var_dump($pageCrawler2);


	// New Try to go to another page after the second one




	$link_text3 = "controversial"; //Link text";
	$link3 = $pageCrawler->selectLink($link_text3)->link();
	$pageCrawler3 = $client->click($link3);


	var_dump($pageCrawler3);



	//$link = $crawler->selectLink($link_text)->link();
	//$crawler = $client->click($link);


//var_dump($crawler);





?>