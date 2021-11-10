<?php
	class Views
	{
		//$data="" Para cuando no se envié el parámetro no muestre error.
		function getView($controller,$view,$data="")
		{
			$controller = get_class($controller);
			if ($controller == "home")
			{
				$view = "Views/".$view.".php";
			}
			else
			{
				$view = "Views/".$controller."/".$view.".php";
			}
			require_once($view);
			
		}
	}
?>