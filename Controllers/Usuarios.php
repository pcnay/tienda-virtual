<?php

	class Usuarios extends Controllers
	{
		public function __construct()
		{
			parent::__construct();
			// Verifica si la variable de SESSION["login"] esta en Verdadero, sigfica que esta una sesion iniciada.
			session_start();
			if (empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/Login');
			}

			// Ejecuta el constructor padre (desde donde se hereda.)
			// Para que la clase de instancie y ejecute la clase de "Modelo
			getPermisos(2);
		}
		
		// Mandando información a las Vistas.
		public function Usuarios()
		{
			//echo "<br>";
			//echo "Mensaje desde el controlador Home ";
			// Si no tiene el rol de "Lectura" no se podra mostrar la vista de "Usuarios".
			if (empty($_SESSION['permisosMod']['r']))
			{
				header('Location: '.base_url().'/Dashboard');	
			}

			// $this = Es la clase "Home", donde se define.
			// "home" = la vista a mostrar.
			// Esta información se puede obtener desde una base de datos, ya que el Controlador se comunica con el Modelo.			
			$data['page_tag'] = "Usuarios";
			$data['page_title'] = "USUARIOS <small>Tienda Virtual</small>";
			$data['page_name'] = "Usuarios";
			$data['page_functions_js'] = "Functions_usuarios.js";

			// $this = Es equivalente "Usuarios"
			// Se llama la vista "Usuarios"
			$this->views->getView($this,"Usuarios",$data);
		}

		// Método utilizado solo para capturar el valor "Params"
		// comunicandose con los "Controladores".
		public function datos($params)
		{
			echo "Datos Recibidos ".$params;
		}

		public function setUsuario()
		{
			//dep($_POST); // Revisando el contenido de $_POST
			//die(); // Finaliza el proceso

			// Esta validando si los datos esta vacios.
			if ($_POST)
			{
				//dep($_POST);
				//die();

				if (empty($_POST['txtIdentificacion']) || empty($_POST['txtNombre']) || empty($_POST['txtApellido']) || empty($_POST['txtTelefono']) || empty($_POST['txtEmail']) || empty($_POST['listRolid']) || empty($_POST['listStatus']))
				{
					$arrResponse = array("status" => false, "msg" => 'Datos Incorrectos');
				}
				else
				{
					$idUsuario = intval($_POST['idUsuario']);
					$strIdentificacion = strClean($_POST['txtIdentificacion']);
					// Convierte la letras inicial de cada palabra.
					$strNombre = ucwords(strClean($_POST['txtNombre']));
					$strApellido = ucwords(strClean($_POST['txtApellido']));
					$strTelefono = strClean($_POST['txtTelefono']);
					$strEmail = strtolower(strClean($_POST['txtEmail']));
					$intTipoId = intval($_POST['listRolid']);
					$intStatus = intval($_POST['listStatus']);

					// Si no se envia un "id_persona" significa que s eesta crean el Usuario
					if ($idUsuario == 0)
					{
						$option = 1;
						// hash("SHA256",passGenerator())); Encripta la contraseña.
						$strPassword = empty($_POST['txtPassword'])?hash("SHA256",passGenerator()):hash("SHA256",$_POST['txtPassword']);
						
						$request_user = $this->model->insertUsuario($strIdentificacion,$strNombre,$strApellido,$strTelefono,$strEmail,$strPassword,$intTipoId,$intStatus);
					}
					else
					{
						$option = 2;
						// hash("SHA256",passGenerator())); Encripta la contraseña.
						$strPassword = empty($_POST['txtPassword'])?"":hash("SHA256",$_POST['txtPassword']);
						
						$request_user = $this->model->updateUsuario($idUsuario,$strIdentificacion,$strNombre,$strApellido,$strTelefono,$strEmail,$strPassword,$intTipoId,$intStatus);

					}

					// Si se inserto el registro en la tabla.
					if ($request_user > 0)
					{
						if ($option == 1)
						{
							$arrResponse = array ('estatus' => true, 'msg' => 'Datos Guardados Correctamente');
						}
						else
						{
							$arrResponse = array ('estatus' => true, 'msg' => 'Datos Actualizados Correctamente');
						}

					}
						elseif ($request_user == 'exist')
						{
							$arrResponse = array ('estatus' => false, 'msg' => 'Registro Existente ');
						}
					else
					{
						$arrResponse = array ('estatus' => false, 'msg' => 'NO es posible Almacenar Los Registros ');
					}
					
				} // else
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die(); // Detiene el proceso.
		}

		// Obteniene los "Usuarios" con el "Rol"
		public function getUsuarios()
		{
			$arrData = $this->model->selectUsuarios();
			// dep($arrData);

			// Para colocar en color Verde o Rojo el estatus del Usuario
			for ($i= 0; $i<count($arrData);$i++)
			{
				$btnView = '';
				$btnEdit = '';
				$btnDelete = '';

				if ($arrData[$i]['estatus'] == 1)
				{
					$arrData[$i]['estatus'] = '<span class="badge badge-success">Activo</span>';
				}
				else
				{
					$arrData[$i]['estatus'] = '<span class="badge badge-danger">Inactivo</span>';
				}

				if ($_SESSION['permisosMod']['r'])
				{
					$btnView = '<button class="btn btn-info btn-sm btnViewUsuario" onClick="fntViewUsuario('.$arrData[$i]['id_persona'].')" title="Ver Usuario"><i class="far fa-eye"></i></button>';
				}

				if ($_SESSION['permisosMod']['u'])
				{
					$btnEdit = '<button class="btn btn-primary btn-sm btnEditUsuario" onClick="fntEditUsuario('.$arrData[$i]['id_persona'].')" title="Editar Usuario"><i class="fas fa-pencil-alt"></i></button>';
				}

				if ($_SESSION['permisosMod']['d'])
				{
					$btnDelete = '<button class="btn btn-danger btn-sm btnDelUsuario" onClick="fntDelUsuario('.$arrData[$i]['id_persona'].')" title="Eliminar Usuario"><i class="fas fa-trash-alt"></i></button>';
				}

				//Son los botones, en la columna de "options".
				// Se agrega el evento "onclick" en la etiqueta "button" para evitar el error de en google de que no carga los eventos.
				$arrData[$i]['options'] = ' <div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';

			} // for ($i= 0; $i<count($arrData);$i++)
			

			// <span class="badge badge-success">Success</span>
			echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			die(); // Finaliza el proceso.

		}

		public function getUsuario(int $idpersona)
		{
			//echo $idpersona;
			$idusuario = intval($idpersona);
			if ($idusuario > 0)
			{
				$arrData = $this->model->selectUsuario($idusuario);
				//dep($arrData);
				if (empty($arrData))
				{
					$arrResponse = array('estatus' =>false,'msg'=> 'Datos No Encontrado');
				}
				else
				{
					$arrResponse = array('estatus' =>true,'data'=> $arrData);
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				
			}
			die();
		}

		// Método para borrar un Usuario.
		public function delUsuario()
		{
			// Esta variable superglobal se genero en "Functions_roles.js", seccion "fntDelRol"
			if ($_POST)
			{
				$intIdpersona = intval($_POST['idUsuario']);

				// Este objeto se define en el Modleo "Rol".
				$requestDelete = $this->model->deleteUsuario($intIdpersona);

				if($requestDelete)
				{
					$arrResponse = array('estatus'=> true, 'msg' => 'Se Ha Eliminado El Usuario');
				}
				else
				{
					$arrResponse = array('estatus'=> false, 'msg' => 'Error Al Eliminar el Usuario');
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}
		


} // classs home extends Controllers

?>
