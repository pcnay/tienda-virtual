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