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
	$info_distrimagen = array();
	$links_distrimagen = array();

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

/*while($contador <=3){	
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
/*	}
	else
	{
		echo "La web es 404";
	}




}; //while(!$exist[0] == 'HTTP/1.1 404 Not Found');
	
	//$exist = control_link($site);

*/



	get_info_distrimagen($site);
	var_dump($info_distrimagen);
	echo "<p>";
	echo $info_distrimagen[0]["name"]."<br>";
	echo $info_distrimagen[0]["description"]."</p>";
	echo $info_distrimagen[0]["price"]."</p>";
	echo "<img src=\"http://www.xxxxxx".$info_distrimagen[0]["image"]." \"></p>";

	function get_info_distrimagen($url){
		global $info_distrimagen;

		$name_selector = "td>p>font";
		$price_selector = "td.txtpeq>font";
		$description_selector = "td>p>font"; //td.txt
		$image_selector = "a>img";

		$client = new Client();
		$crawler = $client->request('GET', $url);

		//var_dump($crawler->filter($name_selector)->extract('_text'));

		$info_producto = array($crawler->filter($name_selector)->extract('_text'));

		$image_producto = array($crawler->filter($image_selector)->extract('src'));
		var_dump($image_producto);

		// Patrón para arreglar la salida del precio
			$pattern = '/[0-9]*[,]*[0-9]{0,2}( €)/';
			//$pattern = '/((PVP:\<\/b\> )[0-9]*[,]*[0-9]{0,2})/';
			$subject = $crawler->filter($price_selector)->extract('_text');

			$price = "";

			//var_dump($subject);





// Comprueba que hay valor que cumpla la expresión regular
				if(preg_match($pattern, $subject[0])){
					preg_match_all($pattern, $subject[0], $price, PREG_SET_ORDER);
				}else{

				}



		// Cargamos la información que se devuelve
		$info_distrimagen = array(
			array(
				"name" => $info_producto[0][0],
				"url" => $url,	
				"description" => $info_producto[0][2],
				"price" => $subject[0],
				"image" => $image_producto[0][1]
				//"price" => $price
			)
		

		);

		return $info_distrimagen;
	}



$web = "xxxxxx";

get_links_distrimagen($web);

$links_distrimagen;


	function get_links_distrimagen($url){
		global $links_distrimagen;

		$link_selector = "form>tr>td>font>b>a";
		$get = "href";

		$client = new Client();
		$crawler = $client->request('GET', $url);

		$css_selector_title = "h3.kw-details-title";

		$links_distrimagen = $crawler->filter($link_selector)->extract($get);
		
		var_dump($links_distrimagen);
		//return $links_tesoros;
	}









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




?>