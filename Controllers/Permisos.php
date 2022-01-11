<?php
	class Permisos extends Controllers
	{
		public function __construct()
		{
			// Ejecuta el constructor padre (desde donde se hereda.)
			// Para que la clase de instancie y ejecute la clase de "Modelo
			parent::__construct();

		}
		
		// Mandando información a las Vistas.
		public function getPermisosRol(int $idrol)
		{
			$rolid = intval($idrol);
			if ($rolid > 0)
			{
				$arrModulos = $this->model->selectModulos();
				
			}

		}

	} // class Permisos extends Controllers

?>