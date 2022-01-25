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
						// Obteniendo los permisos que tenga asignado el módulo.
						$arrPermisos = array('r'=>$arrPermisosRol[$i]['r'],
																'w'=>$arrPermisosRol[$i]['w'],
																'u'=>$arrPermisosRol[$i]['u'],
																'd'=>$arrPermisosRol[$i]['d']);
						if ($arrModulos[$i]['idmodulo'] == $arrPermisosRol[$i]['moduloid'])
						{
							$arrModulos[$i]['permisos'] = $arrPermisos;

						}
					}
				} // 	if (empty($arrPermisosRol))

				// Se anexa la posicion "modulos" y se le asigna el contenido del arreglo "arrModulos"
				$arrPermisoRol['modulos'] = $arrModulos;

				$html = getModal("ModalPermisos",$arrPermisoRol);

				//dep($arrPermisoRol);
			
			}
			
			die();

		}

		// Para Administrar los permisos.
		public function setPermisos()
		{
			// dep($_POST);
			// die();
			// Desde el "Ajax" se genera este variable Super Global "$_POST".
			if ($_POST)
			{
				$intIdrol = intval($_POST['idrol']);
				$modulos = $_POST['modulos'];
				
				//var_dump ($modulos);

				// Se crea el método en Modelo de Permisos para borrar el permiso.
				$this->model->deletePermisos($intIdrol);
				
				foreach ($modulos as $modulos)
				{
					$idModulo = $modulos['id_modulo'];
					$r = empty($modulos['r'])? 0:1;
					$w = empty($modulos['w'])? 0:1;
					$u = empty($modulos['u'])? 0:1;
					$d = empty($modulos['d'])? 0:1;
					//dep($idModulo);
					//dep($r);
					//exit;

					$requestPermiso = $this->model->insertPermisos($intIdrol,$idModulo,$r,$w,$u,$d);					
				}
				// Si es mayor a 0, se inserto el registro.
				if ($requestPermiso > 0)
				{
					$arrResponse = array('status' => true, 'msg' => 'Permisos asignados correctamente');					
				}
				else
				{
					$arrResponse = array('status' => false, 'msg' => 'No es posible asignar los Permisos');					
				}
				// Retorna en formato "JSon"
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);				
			}
			die();
		}

	} // class Permisos extends Controllers

?>