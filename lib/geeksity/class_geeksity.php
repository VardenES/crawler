<?php

include('../vendor/autoload.php');
use Goutte\Client;

class geeksity
{
	

	public function set_tesoros(){
		$this->web_name = "Tesoros de la Marca";

		$this->catalog_url = "https://tesorosdelamarca.com/categoria-producto/juegos-de-rol/page/1";
		$this->product_url = "https://tesorosdelamarca.com/producto/7o-mar/";
		$this->dominio = "";

		$this->link_selector = "a.woocommerce-loop-product__link";
		$this->name_selector = "h1.product_title";
		$this->price_selector = "ins>span.woocommerce-Price-amount";
		$this->description_selector = "div.woocommerce-Tabs-panel--description";
		$this->image_selector = "a>img.attachment-shop_single";		
	}

	public function set_distrimagen(){
		$this->web_name = "Distrimagen";
		
		$this->catalog_url = "http://www.distrimagen.es/catalogo/lista.asp?pagina=1&coleccion=VAMPIRO&categoria=";
		$this->product_url = "http://www.distrimagen.es/catalogo/book.asp?id=5704&coleccion=VAMPIRO";
		$this->dominio = "http://www.distrimagen.es";

		$this->link_selector = "form>tr>td>font>b>a";
		$this->name_selector = "td>p>font";
		$this->price_selector = "td.txtpeq>font";
		$this->description_selector = "td>p>font";
		$this->image_selector = "td.txtpeq>img";		
	}

	public function set_zacatrus(){
		$this->web_name = "Zacatrus";

		$this->catalog_url = "http://zacatrus.es/juegos-de-mesa/juegos-de-rol.html?p=2";
		$this->product_url = "http://zacatrus.es/anima-carpeta-del-jugador.html";
		$this->dominio = "";

		$this->link_selector = "h2.product-name>a";
		$this->name_selector = "h1.tk-title-h1>span.fn";
		$this->price_selector = "span.regular-price>span.price";
		$this->description_selector = "div.desc";
		$this->image_selector = "div.main>img";		
	}

	public function set_redonda(){
		$this->web_name = "Juegos de la Mesa Redonda";

		$this->catalog_url = "https://juegosdelamesaredonda.com/8-juegos-de-rol#/page-2";
		$this->product_url = "https://juegosdelamesaredonda.com/5074-star-wars-el-despertar-de-la-fuerza-caja-de-inicio-8435407613737.html";
		$this->dominio = "";

		$this->link_selector = "a.product-name";
		$this->name_selector = "div.pb-center-column>h1";
		$this->price_selector = "";
		$this->description_selector = "ul.tm_productinner";
		$this->image_selector = "img#bigpic";		
	}


///////////////////////////// MÉTODOS /////////////////////////////


	public function is_404($site) {
		$exist = get_headers($site);
		if($exist[0] == 'HTTP/1.1 404 Not Found')
		{
			return false;
		}
		else
		{
			return true;
		}
	} // End function is_404

	public function get_links($url){
		global $links, $catalog_url, $link_selector;

		$get = "href";

		$this->client = new Client();
		$crawler = $this->client->request('GET', $url);

		$links = $crawler->filter($this->link_selector)->extract($get);

		if($this->web_name == "Distrimagen"){
			foreach ($links as &$value){
				$value = $this->dominio.'/catalogo/'.$value;
			}
			unset($value);
		}

		//var_dump($links);
		return $links;


		/*global $links, $catalog_url, $link_selector;

		$get = "href";

		$this->client = new Client();
		$crawler = $this->client->request('GET', $this->catalog_url);

		$links = $crawler->filter($this->link_selector)->extract($get);

		if($this->web_name == "Distrimagen"){
			foreach ($links as &$value){
				$value = $this->dominio.'/catalogo/'.$value;
			}
			unset($value);
		}

		var_dump($links);
		return $links;*/

	} // End function get_links

	public function get_product_info($url){
		global $product_info, $web_name, $product_url, $name_selector, $price_selector, $description_selector, $image_selector;

		$this->client = new Client();
		$crawler = $this->client->request('GET', $url);

		// OPTION 1: "TESOROS DE LA MARCA"
		if($this->web_name == "Tesoros de la Marca"){
			// Pattern for the description
				$pattern = '/\s*(Descripción)/';
				$replacement = '';
				$subject = $crawler->filter($this->description_selector)->extract('_text');
			
			// Get info about the IMAGE of the product
			$product_value2 = array($crawler->filter($this->image_selector)->extract('src'));
			//var_dump($product_value2);
			if (!empty($product_value2[0][0])) {
			    $product_image = $this->dominio.$product_value2[0][0];
			} else {
			    $product_image = "";
			}	

			// Information reply
			$product_info = array(
					"name" => $crawler->filter($this->name_selector)->extract('_text')[0],
					"url" => $url,	
					"description" => preg_replace($pattern, $replacement, $subject)[0],
					"image" => $product_image
			);						
		}

		// OPTION 2: "DISTRIMAGEN"
		elseif($this->web_name == "Distrimagen"){

			// Get info about the NAME and DESCRIPTION of the product
			$product_value1 = array($crawler->filter($this->name_selector)->extract('_text'));
			// Name of the product
			if (!empty($product_value1[0][0])) {
			    $product_name = $product_value1[0][0];
			} else {
			    $product_name = "";
			}

			// Description of the product
			if (!empty($product_value1[0][2])) {
			    $product_description = $product_value1[0][2];
			} else {
			    $product_description = "";
			}

			// Get info about the PRICE of the product
			$subject = $crawler->filter($this->price_selector)->extract('_text');

			// Get info about the IMAGE of the product
			$product_value2 = array($crawler->filter($this->image_selector)->extract('src'));
			//var_dump($product_value2);
			if (!empty($product_value2[0][0])) {
			    $product_image = $this->dominio.$product_value2[0][0];
			} else {
			    $product_image = "";
			}	

			// Information reply
			$product_info = array(
					"name" => $product_name,
					"url" => $url,	
					"description" => $product_description,
					"price" => $subject[0],
					"image" => $product_image	
			);
		}
		// OPTION 3: "ZACATRUS"
		elseif($this->web_name == "Zacatrus"){
			// Pattern for the description
				$pattern = '/\s*(Descripción)/';
				$replacement = '';
				$subject = $crawler->filter($this->description_selector)->extract('_text');
			
			// Get info about the IMAGE of the product
			$product_value2 = array($crawler->filter($this->image_selector)->extract('src'));
			//var_dump($product_value2);
			if (!empty($product_value2[0][0])) {
			    $product_image = $this->dominio.$product_value2[0][0];
			} else {
			    $product_image = "";
			}	

			// Get specs of the product
			$category_selector = "div.attribute-label";
			$category_value = "div.attribute-value"; //'/id#product-specs/';
			$product_value3 = array(
				"label" => $crawler->filter($category_selector)->extract('_text'),
				"value" => $crawler->filter($category_value)->extract('_text')
			);
			var_dump($product_value3);
			
			$category = array ($product_value3['label'][1] => $product_value3['value'][1]);
			$product_specs = array();

				$product_specs["categoria"] = "";
				$product_specs["BGG"] = "";
				$product_specs["estilo"] = "";
				$product_specs["edad"] = "";
				$product_specs["jugadores"] = "";
				$product_specs["tiempo"] = "";	
				$product_specs["idioma"] = "";
				$product_specs["fabricante"] = "";

			foreach($product_value3['label'] as $clave=>$valor){
				echo "El valor de ".$clave." es ".$valor." ".$product_value3['value'][$clave]."</br>";
				if(strpos($valor, 'Categoría') !==false){
					$product_specs["categoria"] = trim ( $product_value3['value'][$clave], " \t\n\r\0\x0B" );
				}
				if(strpos($valor, 'BGG') !==false){
					$product_specs["BGG"] = "https://boardgamegeek.com/boardgame/".(trim ( $product_value3['value'][$clave], " \t\n\r\0\x0B" ));
				}
				if(strpos($valor, 'estilo') !==false){
					$product_specs["estilo"] = trim ( $product_value3['value'][$clave], " \t\n\r\0\x0B" );
				}
				if(strpos($valor, 'Edad') !==false){
					$product_specs["edad"] = trim ( $product_value3['value'][$clave], " \t\n\r\0\x0B" );
				}

				if(strpos($valor, 'jugadores') !==false){
					$product_specs["jugadores"] = trim ( $product_value3['value'][$clave], " \t\n\r\0\x0B" );
				}	
				if(strpos($valor, 'Tiempo') !==false){
					$product_specs["tiempo"] = trim ( $product_value3['value'][$clave], " \t\n\r\0\x0B" );
				}				
				if(strpos($valor, 'idioma') !==false){
					$product_specs["idioma"] = trim ( $product_value3['value'][$clave], " \t\n\r\0\x0B" );
				}	
				if(strpos($valor, 'Fab') !==false){
					$product_specs["fabricante"] = trim ( $product_value3['value'][$clave], " \t\n\r\0\x0B" );
				}	

			}
			var_dump($product_specs);

			
			//var_dump($category);

			// Information reply
			$product_info = array(
					"name" => $crawler->filter($this->name_selector)->extract('_text')[0],
					"url" => $url,	
					"description" => preg_replace($pattern, $replacement, $subject)[0],
					"image" => $product_image,
					"categoria" => $product_specs["categoria"],
					"BGG" => $product_specs["BGG"],
					"estilo" => $product_specs["estilo"],
					"edad" => $product_specs["edad"],
					"jugadores" => $product_specs["jugadores"],
					"tiempo" => $product_specs["tiempo"],
					"idioma" => $product_specs["idioma"],
					"fabricante" => $product_specs["fabricante"]		
			);						
		}
		// OPTION 4: "JUEGOS DE LA MESA REDONDA"
		elseif($this->web_name == "Juegos de la Mesa Redonda"){
			// Pattern for the description
				$pattern = '/\s*(Descripción)/';
				$replacement = '';
				$subject = $crawler->filter($this->description_selector)->extract('_text');
			
			// Get info about the IMAGE of the product
			$product_value2 = array($crawler->filter($this->image_selector)->extract('src'));
			//var_dump($product_value2);
			if (!empty($product_value2[0][0])) {
			    $product_image = $this->dominio.$product_value2[0][0];
			} else {
			    $product_image = "";
			}	

			// Information reply
			$product_info = array(
					"name" => $crawler->filter($this->name_selector)->extract('_text')[0],
					"url" => $url,	
					"description" => preg_replace($pattern, $replacement, $subject)[0],
					"image" => $product_image	
			);						
		}		
		else
		{
			echo "Web no encontrada.";
		}
		
		var_dump($product_info);
		return $product_info;
	} // End function get_product_info


}


?>