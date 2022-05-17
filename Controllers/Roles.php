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
			$data['page_name'] = "Roles";		
			$data['page_title'] = "Roles Usuarios <small>  Tienda Virtual</small>";
			$data['page_functions_js'] = "Functions_roles.js";
			// "Dashboard" Se llama desde /Views/Dashboard/Dashboard.php"
			// Esta clase "views" método "getView" proviede de "Controllers"(Libraries/Core/Controllers.php) donde se llaman las clases y objetos de las Vistas.
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
				if ($arrData[$i]['estatus'] == 1)
				{
					$arrData[$i]['estatus'] = '<span class="badge badge-success">Activo</span>';
				}
				else
				{
					$arrData[$i]['estatus'] = '<span class="badge badge-danger">Inactivo</span>';
				}

				//Son los botones, en la columna de "options".
				// Se agrega el evento "onclick" en la etiqueta "button" para evitar el error de en google de que no carga los eventos.
				$arrData[$i]['options'] = ' <div class="text-center">
					<button class="btn btn-secondary btn-sm btnPermisosRol" onClick="fntPermisos('.$arrData[$i]['id_rol'].')" title="Permisos"><i class="fas fa-key"></i></button>
					<button class="btn btn-primary btn-sm btnEditRol" onClick="fntEditRol('.$arrData[$i]['id_rol'].')" title="Editar"><i class="fas fa-pencil-alt"></i></button>
					<button class="btn btn-danger btn-sm btnDelRol" onClick="fntDelRol('.$arrData[$i]['id_rol'].')" title="Eliminar"><i class="fas fa-trash-alt"></i></button>
					</div>';

			} // for ($i= 0; $i<count($arrData);$i++)
			

			// <span class="badge badge-success">Success</span>
			echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			die(); // Finaliza el proceso.
		}

		// Obtener un solo Rol
		// Depende de la definicion del “.htaccess”, que se manden por valores por la URL
		public function getRol(int $idrol)
		{			
			$intIdrol = intval(strClean($idrol)); // Convertilo a Entero, pero antes limpiar la variable.

			//dep($intIdrol);
			//die;

			// Si existe el idRol
			if ($intIdrol > 0)
			{
				$arrData = $this->model->selectRol($intIdrol); // Extraer un Rol
				if (empty($arrData)) // No existe Rol
				{
					$arrResponse = array('status'=>false,'msg'=>'Datos no encontrados');
				}
				else
				{
					$arrResponse = array('status'=>true,'data'=>$arrData);
				}
				// Envia la variable , pero antes la convierte en forma JSon, las caracteres especiales los convierte a texto
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}
		
		// Método para asignar roles.
		// Se llama en "Functions_roles.js", request.open("POST",ajaxUrl,true);
		public function setRol()
		{
			// dep($_POST); // Obtener el valor de la variable "Global". 

			// Obtener los datos que se estan enviando por Ajax 
			// "strClean" = Esta definida en "Helpers", para limpiar las cadenas.
			$intIdrol = intval($_POST['idRol']); // Convertir a Entero.
			$strRol = strClean($_POST['txtNombre']);
			$strDescripcion = strClean($_POST['txtDescripcion']);
			$intStatus = intval($_POST['listStatus']); // Conviertiendola a Entero.
			
			// Enviando la información al modelo. Este es el enlace de Controller -> Modelo.
			// $request_rol = $this->model->insertRol($strRol,$strDescripcion,$intStatus);

			// Seccion para Crear o Actualizar los Roles.
			if($intIdrol == 0)
			{
				// Crear Rol
				$request_rol = $this->model->insertRol($strRol,$strDescripcion,$intStatus);
				$option = 1;
			}
			else
			{
				// Actualizar Rol
				$request_rol = $this->model->updateRol($intIdrol,$strRol,$strDescripcion,$intStatus);
				$option = 2;
			}

			if ($request_rol > 0)
			{
				if ($option == 1)
				{
					$arrResponse = array('status' => true, 'msg' => 'Datos Guardados Correctamente');					
				}
				else
				{
					$arrResponse = array('status' => true, 'msg' => 'Datos Actualizados Correctamente');					
				}				

			}
			else if($request_rol == 'Existe')
			{
				$arrResponse = array('status'=>false,'msg'=>'El Rol Ya Existe');
			}
			else
			{
				$arrResponse = array('status'=>false,'msg'=>'NO es posible almacenar los datos');
			}
			// Corrige los datos de caracteres raros.
			// Esta información es enviada a "functions_roles.js"
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die(); // Finaliza el proceso.
		}

		// Método para borrar el Rol.
		public function delRol()
		{
			// Esta variable superglobal se genero en "Functions_roles.js", seccion "fntDelRol"
			if ($_POST)
			{
				$intIdrol = intval($_POST['idrol']);

				// Este objeto se define en el Modleo "Rol".
				$requestDelete = $this->model->deleteRol($intIdrol);

				if($requestDelete == "ok")
				{
					$arrResponse = array('status'=> true, 'msg' => 'Se ha Eliminado El Rol');
				}
				else if ($requestDelete == "existe")
				{
					$arrResponse = array('status'=> false, 'msg' => 'No es posible eliminar un Rol asociado a Usuario');			
				}
				else
				{
					$arrResponse = array('status'=> false, 'msg' => 'Error Al Eliminar el Rol');
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function getSelectRoles()
		{
			$htmlOptions = "";
			$arrData = $this->model->selectRoles();
			if (count($arrData) > 0)
			{
				for ($i=0; $i<count($arrData); $i++)
				{
					if ($arrData[$i]['estatus']==1)
					{
						$htmlOptions .= '<option value="'.$arrData[$i]['id_rol'].'">'.$arrData[$i]['nombrerol'].'</option>';
					}
				}
			}
			echo $htmlOptions;
			die();
		}

} // classs home extends Controllers
?>
