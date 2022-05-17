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
				$arrPermisosRol = $this->model->selectPermisosRol($rolid);
				//dep($arrModulos);
				//dep($arrPermisosRol);
				$arrPermisos = array('r'=>0,'w'=>0,'u'=>0,'d'=>0);
				$arrPermisoRol = array('idrol'=> $rolid);

				if (empty($arrPermisosRol))
				{
					for ($i=0;$i<count($arrModulos);$i++)
					{
						$arrModulos[$i]['permisos'] = $arrPermisos;						
					}
				}
				else
				{
					for ($i=0; $i<count($arrModulos);$i++)
					{
						$arrPermisos = array('r'=>$arrPermisosRol[$i]['r'],
																'w'=>$arrPermisosRol[$i]['w'],	
																'u'=>$arrPermisosRol[$i]['u'],																	
					
					);
					}
				}
				dep($arrModulos);


				
			}

		}

	} // class Permisos extends Controllers

?>