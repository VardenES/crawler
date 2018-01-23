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

	//$site = "http://www.distrimagen.es/catalogo/book.asp?id=5371&coleccion=VAMPIRO%3AREQUIEM";

$site = "http://www.xxxxxx/catalogo/lista.asp?pagina=";	
$dominio = "http://www.xxxxxx.es";


$contador = 1;


while($contador <=1){	
	$web = $site.$contador."&coleccion=VAMPIRO&categoria=";
	$contador++;

	$exist = is_404($web);

	if($exist){		
		echo $web."<br>";
		$url = get_links_distrimagen($web);
		//var_dump($url);
		
		// Información de los juegos
		foreach($url as $key => $value) {
			get_info_distrimagen($dominio."/catalogo/".$value);
			
			echo "<p>";
			echo $info_distrimagen[0]["name"]."<br>";
			echo $info_distrimagen[0]["description"]."<br>";
			echo $info_distrimagen[0]["price"]."<br>";

			if (!empty($info_distrimagen[0]["image"])) {
			    echo "<img src=\"".$info_distrimagen[0]["image"]." \"></p>";
			} else {			    
			}	



						
		}
		
	}
	else
	{
		echo "La web es 404";
	}




}; 


	function get_info_distrimagen($url){
		global $info_distrimagen;
		global $dominio;

		$name_selector = "td>p>font";
		$price_selector = "td.txtpeq>font";
		$description_selector = "td>p>font"; //td.txt
		$image_selector = "td.txtpeq>img";

		$product_name = "";
		$product_description = "";
		$product_image = "";

		$client = new Client();
		$crawler = $client->request('GET', $url);

		//var_dump($crawler->filter($name_selector)->extract('_text'));

		$info_producto = array($crawler->filter($name_selector)->extract('_text'));
		if (!empty($info_producto[0][0])) {
		    $product_name = $info_producto[0][0];
		} else {
		    $product_name = "";
		}

		if (!empty($info_producto[0][2])) {
		    $product_description = $info_producto[0][2];
		} else {
		    $product_description = "";
		}




		$image_producto = array($crawler->filter($image_selector)->extract('src'));
		//var_dump($image_producto);

		if (!empty($image_producto[0][0])) {
		    $product_image = $dominio.$image_producto[0][0];
		} else {
		    $product_image = "";
		}	

		//var_dump($image_producto);

		// Patrón para arreglar la salida del precio
			$pattern = '/[0-9]*[,]*[0-9]{0,2}( €)/';
			//$pattern = '/((PVP:\<\/b\> )[0-9]*[,]*[0-9]{0,2})/';
			$subject = $crawler->filter($price_selector)->extract('_text');

			$price = "";

			//var_dump($subject);


// Pendiente de desglose de la siguiente info:
// Precio (Sin IVA): 28,75 € IVA (4%): 1,15 € PVP: 29,90 € Páginas: 128Número: 1061
			





// Comprueba que hay valor que cumpla la expresión regular
				if(preg_match($pattern, $subject[0])){
					preg_match_all($pattern, $subject[0], $price, PREG_SET_ORDER);
				}else{

				}



		// Cargamos la información que se devuelve
		$info_distrimagen = array(
			array(
				"name" => $product_name,
				"url" => $url,	
				"description" => $product_description,
				"price" => $subject[0],
				"image" => $product_image
				//"price" => $price
			)
		

		);

		return $info_distrimagen;
	}








	function get_links_distrimagen($url){
		global $links_distrimagen;

		$link_selector = "form>tr>td>font>b>a";
		$get = "href";

		$client = new Client();
		$crawler = $client->request('GET', $url);

		$css_selector_title = "h3.kw-details-title";

		$links_distrimagen = $crawler->filter($link_selector)->extract($get);
		
		//var_dump($links_distrimagen);
		return $links_distrimagen;
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