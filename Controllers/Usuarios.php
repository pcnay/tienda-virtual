<?php

	class Usuarios extends Controllers
	{
		public function __construct()
		{
			// Ejecuta el constructor padre (desde donde se hereda.)
			// Para que la clase de instancie y ejecute la clase de "Modelo
			parent::__construct();

		}
		
		// Mandando información a las Vistas.
		public function Usuarios()
		{
			//echo "<br>";
			//echo "Mensaje desde el controlador Home ";

			// $this = Es la clase "Home", donde se define.
			// "home" = la vista a mostrar.
			// Esta información se puede obtener desde una base de datos, ya que el Controlador se comunica con el Modelo.
			
			$data['page_tag'] = "Usuarios";
			$data['page_title'] = "USUARIOS <small>Tienda Virtual</small>";
			$data['page_name'] = "Usuarios";

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
				if (empty($_POST['txtIdentificacion']) || empty($_POST['txtNombre']) || empty($_POST['txtApellido']) || empty($_POST['txtTelefono']) || empty($_POST['txtEmail']) || empty($_POST['listRolid']) || empty($_POST['listStatus']))
				{
					$arrResponse = array("status" => false, "msg" => 'Datos Incorrectos');
				}
				else
				{
					$strIdentificacion = strClean($_POST['txtIdentificacion']);
					// Convierte la letras inicial de cada palabra.
					$strNombre = ucwords(strClean($_POST['txtNombre']));
					$strApellido = ucwords(strClean($_POST['txtApellido']));
					$strTelefono = strClean($_POST['txtTelefono']);
					$strEmail = strtolower(strClean($_POST['txtEmail']));
					$intTipoId = intval(strClean($_POST['listRolid']));
					$intStatus = intval(strClean($_POST['listStatus']));

					// hash("SHA256",passGenerator())); Encripta la contraseña.
					$strPassword = empty($_POST['txtPassword'])?hash("SHA256",passGenerator()):hash("SHA256",$_POST['txtPassword']);
					
					$request_user = $this->model->insertUsuario($strIdentificacion,$strNombre,$strApellido,$strTelefono,$strEmail,$strPassword,$intTipoId,$intStatus);

					// Si se inserto el registro en la tabla.
					if ($request_user > 0)
					{
						$arrResponse = array ('status' => true, 'msg' => 'Datos Guardados Correctamente');
					}
					elseif ($request_user == 'exist')
					{
						$arrResponse = array ('status' => false, 'msg' => 'Registro Existente ');
					}
					else
					{
						$arrResponse = array ('status' => false, 'msg' => 'NO es posible Almacenar Los Registros ');
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
					<button class="btn btn-info btn-sm btnViewUsuario" onClick="fntViewUsuario('.$arrData[$i]['id_persona'].')" title="Ver Usuario"><i class="far fa-eye"></i></button>
					<button class="btn btn-primary btn-sm btnEditUsuario" onClick="fntEditUsuarios('.$arrData[$i]['id_persona'].')" title="Editar Usuario"><i class="fas fa-pencil-alt"></i></button>
					<button class="btn btn-danger btn-sm btnDelUsuario" onClick="fntDelUsuario('.$arrData[$i]['id_persona'].')" title="Eliminar Usuario"><i class="fas fa-trash-alt"></i></button>
					</div>';

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


} // classs home extends Controllers

?>
