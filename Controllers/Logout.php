<?php
	class Logout
	{
		public function __construct()
		{
			session_start();
			session_unset(); // Limpia todas las variables de sesion
			session_destroy(); // Destruye todas las variables de sesion.
			header('location: '.base_url().'/Login'); // Redirecciona a una pantalla URL "Login"
		}
	}
?>
