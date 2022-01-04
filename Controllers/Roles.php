<?php
	class Roles extends Controllers
	{
		public function __construct()
		{
			// Ejecuta el constructor padre (desde donde se hereda.)
			parent::__construct();

		}
		
		// Mandando información a las Vistas.
		public function Roles()
		{

			//echo "Mensaje desde el controlador Home ";
			// $this = Es la clase "Roles"
			// "roles" = la vista a mostrar.
			$data['page_id'] = 3;
			$data['page_tag'] = "Roles Usuarios";
			$data['page_name'] = "Rol usuario";		
			$data['page_title'] = "Roles Usuarios <small>  Tienda Virtual</small>";
			// "Dashboard" Se llama desde /Views/Dashboard/Dashboard.php"
			// Esta clase "views" método "getView" proviede de "Controllers"(Libraries/Core/Controllers.php) donde se llaman las clases y objetos 
			$this->views->getView($this,"Roles",$data);
		}

		// Obtener los Roles de Usuarios desde la Base de Datos
		public function getRoles()
		{
			//echo "Método *getRoles()*";
			$arrData = $this->model->selectRoles();
			// dep($arrData);
			// Lo convierte a Objeto JSon (Desde Arreglo)
			// JSON_UNESCAPED_UNICODE = Convierte a JSon y limpia de caracteres raros.
			// En esta pagina desplegara todos los roles en formato Json.
			// dep($arrData[0]['Status']); Para accesar al campo "Status" desde el arreglo.

			// Para colocar en color Verde o Rojo el estatus del Usuario
			for ($i= 0; $i<count($arrData);$i++)
			{
				if ($arrData[$i]['status'] == 1)
				{
					$arrData[$i]['status'] = '<span class="badge badge-success">Activo</span>';
				}
				else
				{
					$arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
				}

				$arrData[$i]['options'] = ' <div class="text-center">
					<button class="btn btn-secondary btn-sm btnPermisosRol" rl="'.$arrData[$i]['id_rol'].'" title="Permisos"><i class="fas fa-key"></i></button>
					<button class="btn btn-primary btn-sm btnEditRol" rl="'.$arrData[$i]['id_rol'].'" title="Editar"><i class="fas fa-pencil-alt"></i></button>
					<button class="btn btn-danger btn-sm btnDelRol" rl="'.$arrData[$i]['id_rol'].'" title="Eliminar"><i class="fas fa-trash-alt"></i></button>
					</div>';

			} // for ($i= 0; $i<count($arrData);$i++)
			

			// <span class="badge badge-success">Success</span>
			echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			die(); // Finaliza el proceso.
		}

} // classs home extends Controllers
?>
