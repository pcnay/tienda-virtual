<?php
	// Configurar toda la carga de los archivos
	// Load
	$controllerFile = "Controllers/".$controller.".php";
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
			//echo "No existe El método en el Controlador ";}
			require_once ("Controllers/error.php");
		}

	} // if (method_exists($controller,$method))
	else
	{
		require_once ("Controllers/error.php");
	} // if (file_exists($controllerFile))

?>