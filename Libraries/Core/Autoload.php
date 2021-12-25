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