<?php

	require '../vendor/autoload.php';
	use Goutte\Client;
	
	$client = new Client();
	
	// Login page
	$crawler = $client->request('GET', 'http://github.com/');
	
	// Select Login form
	$form = $crawler->selectButton('Log in')->form();
	
	// Submit form
	$crawler = $client->submit($form, array(
	    'user' => 'Usuario',
	    'pass' => 'Contraseña',
	));
	
	// PHP Configuration page
	$link = $crawler->selectLink('Your profile')->link();
	$crawler = $client->click($link);
	
	//var_dump($crawler);

	
	// Find PHP Configuration rows
	$configurationRows = $crawler->filter('link-gray-dark text-bold wb-break-all');
	$configurationRows->each(function($configurationRow, $index) {
	    $directive = $configurationRow->filter('td')->eq(1)->text();
	    $value     = $configurationRow->filter('td')->eq(3)->text();
	    echo sprintf("%-20s = %s\n", $directive, $value);
	});
	
?>