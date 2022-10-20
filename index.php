<?php
	// Url = Controlador/Metodo/Parametro
	require_once("Config/Config.php");
	require_once("Helpers/Helpers.php");

	$url = !empty($_GET['url'])? $_GET['url']:'Home/home';
	//echo $url;
	
	// Convertiendo a un arreglo, separando la cadena.
	// Controlador/Metodo/Parametro
	
	$arrUrl = explode("/",$url);
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

	// Se van a desgloasar los parámetros(Después del método) en la URL.
	//Apartir de la posicion "2" se almacenan los parámetros.
	if (!empty($arrUrl[2]))
	{
		if ($arrUrl[2] != "")
		{
			for ($i=2;$i<count($arrUrl);$i++)
			{
				$params .= $arrUrl[$i].',';
			}
			$params = trim($params,',');

		}
	}

	//dep($controller);
	//dep($method);
	//exit;

/*
<?php
	// Cargar las clases de forma automatica.
	// $class = Es la calse que se cargara de forma automática 
	spl_autoload_register(function($class)
	{
		if (file_exists("Libraries/".'Core/'.$class.".php"))
		{
			//echo "Revisando contenido de -controlllerFile- ".LIBS.'Core/'.$class.".php";
			//exit;
			require_once("Libraries/".'Core/'.$class.".php");
		}
		else
		{
			echo "NO existe la clase";
		}
	}); // spl_autoload_register(function($class)


?>

<?php
	// Configurar toda la carga de los archivos
	// Load
	// $Para convertir la primera letra de los nombres de los controladores, la razon es por los servidores que son sensibles a las Minusculas y Mayusculas.
	//$controller = ucwords($controller);
	$controllerFile = "Controllers/".$controller.".php";
	//echo $controllerFile;
	
	if (file_exists($controllerFile))
	{
		//echo "Controlador Encontrado";
		require_once($controllerFile);
		$controller = new $controller();

		// Valida si existe el método en el Controlador.
		if (method_exists($controller,$method))
		{
			$controller->{$method}($params);
		}
		else
		{
			//echo "No existe El método en el Controlador ";
			require_once ("Controllers/Errors.php");
		}

	} // if (method_exists($controller,$method))
	else
	{
		require_once ("Controllers/Errors.php");
	} // if (file_exists($controllerFile))

?>


*/


	// Cargar las funciones automaticamente.
	require_once(LIBS."Core/Autoload.php");
	require_once(LIBS."Core/Load.php");
	

/*	
	echo "Controlador : ".$controller;
	echo "<br>";
	echo "Método : ".$method;
	echo "<br>";
	echo "Parametros :".$params;
	echo "<br>";
*/






	//print_r($arrUrl); // Porque es arreglo.



/*
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