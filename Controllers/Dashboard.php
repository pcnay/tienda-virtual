<?php
	class Dashboard extends Controllers
	{
		public function __construct()
		{
			// Para que deje la sesion abierta en PHP desde la aplicacion y no desde la configuracion del servidor
			// sessionStart();
			// Se debe llamar desde esta posicion para evitar el problema de algunos "Hosting" que cuando se inicia sesion NO muestra nada en la pantalla
			// Se soluciona agregando la linea

			// Para que deje la sesion abierta en PHP desde la aplicacion y no desde la configuracion del servidor
			sessionStart();

			// Ejecuta el constructor padre (desde donde se hereda.)
			parent::__construct();
			
			// Verifica si la variable de SESSION["login"] esta en Verdadero, sigfica que esta una sesion iniciada.
			//session_start();
			
			// Evitar que ingresen en otro navegador utilizando el PHPSESSID
			// Elimina las ID Anteriores.
			//session_regenerate_id(true);

			// Para que deje la sesion abierta en PHP desde la aplicacion y no desde la configuracion del servidor
			// sessionStart();

			if (empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/Login');
			}
			getPermisos(1);
			
		}
		
		// Mandando información a las Vistas.
		public function dashboard ()
		{
			//echo "Mensaje desde el controlador Home ";
			// $this = Es la clase "home"
			// "home" = la vista a mostrar.
			$data['page_id'] = 2;
			$data['page_tag'] = "Dashboard - Tienda Virtual";
			$data['page_title'] = "Dashboard - Tienda Virtual";
			$data['page_name'] = "dashboard";		
			$data['page_functions_js'] = "Functions_dashboard.js";
			// "Dashboard" Se llama desde /Views/Dashboard/Dashboard.php"
			// Esta clase "views" método "getView" proviede de "Controllers"(Libraries/Core/Controllers.php) donde se llaman las clases y objetos 
			$this->views->getView($this,"Dashboard",$data);
		}

} // classs home extends Controllers
?>
