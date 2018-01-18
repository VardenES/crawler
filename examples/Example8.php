<?php
	//Tutorial: http://showmethecode.es/php/php-goutte-una-libreria-para-hacer-web-scraping/
	
	require '../vendor/autoload.php';
	use Goutte\Client;
	

	$url = "http://x3demob.cpx3demo.com:2082/?locale=en";

	$client = new Client();
	 
	// Login page
	$crawler = $client->request('GET', $url);
	 
	// Select Login form
	$form = $crawler->selectButton('Log in')->form();
	 
	// Submit form
	$crawler = $client->submit($form, array(
	    'user' => 'x3demob',
	    'pass' => 'x3demob',
	));
	 
	// PHP Configuration page
	$link = $crawler->selectLink('PHP Configuration')->link();
	$crawler = $client->click($link);
	 
	// Find PHP Configuration rows
	$configurationRows = $crawler->filter('#phptbl tbody tr');
	 
	$configurationRows->each(function($configurationRow, $index) {
	 
	    $directive = $configurationRow->filter('td')->eq(1)->text();
	    $value     = $configurationRow->filter('td')->eq(3)->text();
	 
	    echo sprintf("%-20s = %s\n", $directive, $value);
	});

?>