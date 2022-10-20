<?php
	class Views
	{
		//$data="" Para cuando no se envié el parámetro no muestre error.
		// Obtener las vistas
		function getView($controller,$view,$data="")
		{
			$controller = get_class($controller);
			if ($controller == "Home")
			{
				$view = VIEWS.$view.".php";
			}
			else
			{
				$view = VIEWS.$controller."/".$view.".php";
			}
			//dep($view);
			//die;

			require_once($view);
			
		}
	}
?>