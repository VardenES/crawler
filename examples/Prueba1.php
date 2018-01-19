<?php

	// NOTA: Completar el sacar el resto de información del juego
	// Que se recorran todas las páginas disponibles dentro de una categoría
	// Ya tengo que compruebe que no es error 404
	// Que responda true/false y sirva dentro del bucle

	require '../vendor/autoload.php';
	use Goutte\Client;

	// Variables globales
	$info_tesoros = array();
	$links_tesoros = array();
	$exist = null;

	$site = "xxxxxx";

	

$contador = 1;
/*
do{
	$site.=$contador;
	$contador++;

	$exist = is_404($site);

	if($exist){
		echo "Contaremos la página y sacaremos los enlaces";
		$url = get_links_tesoros($site);
		var_dump($url);
		/*
		// Información de los juegos
		foreach($url as $key => $value) {
			get_info_tesoros($value);
			
			control_link($value);
			echo "<p>";
			echo $info_tesoros[0]["name"][0]."<br>";
			echo $info_tesoros[0]["description"][0]."</p>";
		}
		*/
/*	}
	else
	{
		echo "La web es 404";
	}




} while($contador > 3); //while(!$exist[0] == 'HTTP/1.1 404 Not Found');
	
	//$exist = control_link($site);

*/
while($contador <=3){	
	$web = $site.$contador;
	$contador++;

	$exist = is_404($web);

	if($exist){		
		echo $web."<br>";
		$url = get_links_tesoros($web);
		var_dump($url);
		/*
		// Información de los juegos
		foreach($url as $key => $value) {
			get_info_tesoros($value);
			
			control_link($value);
			echo "<p>";
			echo $info_tesoros[0]["name"][0]."<br>";
			echo $info_tesoros[0]["description"][0]."</p>";
		}
		*/
	}
	else
	{
		echo "La web es 404";
	}




}; //while(!$exist[0] == 'HTTP/1.1 404 Not Found');
	
	//$exist = control_link($site);
















	function is_404($site) {
		$exist = get_headers($site);
		if($exist[0] == 'HTTP/1.1 404 Not Found')
		{
			return false;
		}
		else
		{
			return true;
		}
	}

	function get_info_tesoros($url){
		global $info_tesoros;

		$name_selector = "h1.product_title";
		$price_selector = "ins>span.woocommerce-Price-amount";
		$description_selector = "div.woocommerce-Tabs-panel--description";

		$client = new Client();
		$crawler = $client->request('GET', $url);

		// Patrón para arreglar la salida de la descripción
			$pattern = '/\s*(Descripción)/';
			$replacement = '';
			$subject = $crawler->filter($description_selector)->extract('_text');

		// Cargamos la información que se devuelve
		$info_tesoros = array(
			array(
				"name" => $crawler->filter($name_selector)->extract('_text'),
				"url" => $url,	
				"description" => preg_replace($pattern, $replacement, $subject)
			)
		);

		return $info_tesoros;
	}

	function get_links_tesoros($url){
		global $links_tesoros;

		$link_selector = "a.woocommerce-loop-product__link";
		$get = "href";

		$client = new Client();
		$crawler = $client->request('GET', $url);

		$css_selector_title = "h3.kw-details-title";

		$links_tesoros = $crawler->filter($link_selector)->extract($get);
		
		return $links_tesoros;
	}




?>