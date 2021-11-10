<?php
	// Url = Controlador/Metodo/Parametro
	require_once("Config/Config.php");
	require_once("Helpers/Helpers.php");

	$url = !empty($_GET['url'])? $_GET['url']:'home/home';
	// Convertiendo a un arreglo, separando la cadena.
	$arrUrl = explode("/",$url);
	//echo $url;
	//print_r($arrUrl);
	$controller = $arrUrl[0];
	$method = $arrUrl[0];
	$params = "";

	if (!empty($arrUrl[1]))
	{
		if ($arrUrl[1] != "")
		{
			$method = $arrUrl[1];
		}
	}

	if (!empty($arrUrl[2]))
	{
		if ($arrUrl[2] != "")
		{
			// Se inicia desde la posicion 2, es donde se almacen los parámetos. 
			// Se utiliza el ciclo para obtener los parametros de la URL
			for ($i=2;$i<count($arrUrl); $i++)
			{
				$params .= $arrUrl[$i].',';

			}
			// Para remover el último caracter de la cadena.
			$params = trim($params,',');
			
		}
	}
	
	require_once("Libraries/Core/autoload.php");
	require_once("Libraries/Core/load.php");
	
	/*
	echo "<br>";
	echo "Controlador: ".$controller;
	echo "<br>";
	echo "Metodo: ".$method;
	echo "<br>";
	echo "Parametro: ".$params;
	//print_r($arrUrl);
*/


?>