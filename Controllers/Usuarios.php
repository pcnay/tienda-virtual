<?php
	class Usuarios extends Controllers
	{
		public function __construct()
		{
			// Para que deje la sesion abierta en PHP desde la aplicacion y no desde la configuracion del servidor
			// sessionStart();
			// Se debe llamar desde esta posicion para evitar el problema de algunos "Hosting" que cuando se inicia sesion NO muestra nada en la pantalla
			// Se soluciona agregando la linea

			// Para que deje la sesion abierta en PHP desde la aplicacion y no desde la configuracion del servidor
			sessionStart();
			// Evitar que ingresen en otro navegador utilizando el PHPSESSID
			// Elimina las ID Anteriores.
			//session_regenerate_id(true);
			session_regenerate_id(true); // Regenere el Id de la sesion es para mayor seguridad.
			
			// Verifica si la variable de SESSION["login"] esta en Verdadero, sigfica que esta una sesion iniciada.
			//session_start();
			// Evita la entrada a usuarios que no estan "Logueados"		
			if (empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/Login');
			}
			parent::__construct(); // Constructor.


			// Ejecuta el constructor padre (desde donde se hereda.)
			// Para que la clase de instancie y ejecute la clase de "Modelo
			getPermisos(2);
		}

		// Mandando información a las Vistas.
		public function Usuarios()
		{
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
		
		public function setUsuario()
		{
			//dep($_POST); // Revisando el contenido de $_POST
			//die(); // Finaliza el proceso

			// Esta validando si los datos esta vacios.
			if ($_POST)
			{
				// Se revive informacion en la variable Global "$_POST"
				//dep($_POST);
				//die(); exit;

				if (empty($_POST['txtIdentificacion']) || empty($_POST['txtNombre']) || empty($_POST['txtApellido']) || empty($_POST['txtTelefono']) || empty($_POST['txtEmail']) || empty($_POST['listaRoles']) || empty($_POST['listStatus']))
				{
					$arrResponse = array("estatus" => false, "msg" => 'Datos Incorrectos');
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
					$intTipoId = intval($_POST['listaRoles']);
					$intStatus = intval($_POST['listStatus']);
					$request_user = "";

					// Si no se envia un "id_persona" significa que se esta crean el Usuario
					if ($idUsuario == 0)
					{
						$option = 1;
						// hash("SHA256",passGenerator())); Encripta la contraseña.
						// passGenerator = Esta definida en "Helpers.php"
						$strPassword = empty($_POST['txtPassword'])?hash("SHA256",passGenerator()):hash("SHA256",$_POST['txtPassword']);

						// Valida que solo inserte un nuevo usuario si tiene el permiso de Grabar Usuario.
						if ($_SESSION['permisosMod']['w'])
						{
							$request_user = $this->model->insertUsuario($strIdentificacion,$strNombre,$strApellido,$strTelefono,$strEmail,$strPassword,$intTipoId,$intStatus);							
						}
					}
					else  // Actualizar Usuario
					{
						$option = 2;
						// hash("SHA256",$_POST['txtPassword']; Encripta la contraseña.
						// Esta condicion se utiliza para evitar que se vuelva a encriptar la contraseña que ya estaba encriptada, por esta razon se determina si la contraña tiene mas de 40 caracteres (estan encriptada), ya que para teclar una clave de 40!!!
						if (strlen($_POST['txtPassword']) > 40)
						{
							$strPassword = empty($_POST['txtPassword'])?"":$_POST['txtPassword'];
						}
						else
						{
							$strPassword = empty($_POST['txtPassword'])?"":hash("SHA256",$_POST['txtPassword']);
						}
						//var_dump($_POST['txtPassword']);// no funciona el boton de grabar en Actualizar 
						//return false;
						//exit;

						// Valida que solo inserte un nuevo usuario si tiene el permiso de Grabar Usuario.
						if ($_SESSION['permisosMod']['u'])
						{			
							// Verificando que los campos "Identificacion" y "Correo electronico			
							$request_user = $this->model->updateUsuario($idUsuario,$strIdentificacion,$strNombre,$strApellido,$strTelefono,$strEmail,$strPassword,$intTipoId,$intStatus);
						}					

					} // if ($idUsuario == 0)

					// Si el registro ya existe.
					if ($request_user == 'exist')
					{
						if ($option == 1 ) //|| $option == 2)
						{
							$arrResponse = array ('estatus' => false, 'msg' => 'Registro Existente, Correo Electronico ó Identificacion ');
						}
						else
						{
							$arrResponse = array ('estatus' => true, 'msg' => 'Datos Actualizados Correctamente');
						}

					} // if ($request_user > 0)					
					else if ($request_user > 0)
					{
						$arrResponse = array ('estatus' => true, 'msg' => 'Registro Guardado ');
					}
					else
					{
						$arrResponse = array ('estatus' => false, 'msg' => 'NO es posible Almacenar Los Registros ');
					}
					
				} // else

				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}

			die(); // Detiene el proceso.

		} // function setUsuario

		// Obteniene los "Usuarios" con el "Rol"
		public function getUsuarios()
		{
			// Esta condicion se utiliza para que usuarios que no tengan sesion no pueden visualizar los usuarios.
			if ($_SESSION['permisosMod']['r'])
			{
				// Se estan obteniendo los usuarios desde la base de datos				
				$arrData = $this->model->selectUsuarios();
				 //dep($arrData);
				 //die();exit;

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
						// Se agrega la condicion para que solo el Super Usuario y que sea Administrador
						// idUser = 1; Usuario Super Administrador.
						// y este mismo usuario tiene el Rol 1 Administrador.

						// $_SESSION['userData']['id_rol'] = 1 Administrador
						// $_SESSION['idUser'] = 1 Super Administrador
						//  $_SESSION['userData']['id_rol'] == 1) and ($arrData[$i]['id_rol'] != 1 : NO es un Usuario Administrador.
						// this = Significa que se enviara como parámetro todo la etiqueta "botton" 
						if ((($_SESSION['idUser'] == 1) and ($_SESSION['userData']['id_rol'] == 1)) || (($_SESSION['userData']['id_rol'] == 1) and ($arrData[$i]['id_rol'] != 1)))
						{
							$btnEdit = '<button class="btn btn-primary btn-sm btnEditUsuario" onClick="fntEditUsuario(this,'.$arrData[$i]['id_persona'].')" title="Editar Usuario"><i class="fas fa-pencil-alt"></i></button>';
						}
						else
						{
							$btnEdit = '<button class="btn btn-secondary btn-sm" disabled><i class="fas fa-pencil-alt"></i></button>';
						}

					} // if ($_SESSION['permisosMod']['u'])

					// ($_SESSION['userData']['id_persona'] != $arrData[$i][id_persona])
					// Se bloquea al Usuario Super Administrador el boton de Borrar, es decir no se puede eliminarse, se tiene que realizar
					// Con la opcion "Profile"
					if ($_SESSION['permisosMod']['d'])
					{
						if ((($_SESSION['idUser'] == 1) and ($_SESSION['userData']['id_rol'] == 1)) || (($_SESSION['userData']['id_rol'] == 1) and ($arrData[$i]['id_rol'] != 1)) and ($_SESSION['userData']['id_persona'] != $arrData[$i]['id_persona']))
						{
							$btnDelete = '<button class="btn btn-danger btn-sm btnDelUsuario" onClick="fntDelUsuario('.$arrData[$i]['id_persona'].')" title="Eliminar Usuario"><i class="fas fa-trash-alt"></i></button>';
						}
						else
						{
							$btnDelete = '<button class="btn btn-secondary btn-sm" disabled><i class="far fa-trash-alt"></i></button>';
						}

					} // if ($_SESSION['permisosMod']['d'])

					//Son los botones, en la columna de "options".
					// Se agrega el evento "onclick" en la etiqueta "button" para evitar el error de en google de que no carga los eventos.
					$arrData[$i]['options'] = ' <div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';

				} // for ($i= 0; $i<count($arrData);$i++)
				

				// <span class="badge badge-success">Success</span>
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);				

			} // if ($_SESSION['permisosMod']['r'])

			die(); // Finaliza el proceso.

		} // public function getUsuarios()

		//Se obtiene un Usuario.
		public function getUsuario($idpersona)
		{
			// Esta condicion se utiliza para que usuarios que no tengan sesion no pueden visualizar los usuarios.
			if ($_SESSION['permisosMod']['r'])
			{
				//echo $idpersona;
				$idusuario = intval($idpersona);
				if ($idusuario > 0)
				{
					$arrData = $this->model->selectUsuario($idusuario);
					//dep($arrData);
					if (empty($arrData)) // Si esta vacia
					{
						$arrResponse = array('estatus' =>false,'msg'=> 'Datos No Encontrado');
					}
					else
					{
						$arrResponse = array('estatus' =>true,'data'=> $arrData);
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);					
				} 

			} // if ($_SESSION['permisosMod']['r'])

			die();
			
		} // public function getUsuario($idpersona)

		// Método para borrar un Usuario.
		public function delUsuario()
		{
			// Esta variable superglobal se genero en "Functions_roles.js", seccion "fntDelRol"
			if ($_POST)
			{
				// Valida que solo inserte un nuevo usuario si tiene el permiso de Grabar Usuario.
				if ($_SESSION['permisosMod']['d'])
				{
					$intIdpersona = intval($_POST['idUsuario']);

					// Este objeto se define en el Modleo "Rol".
					$requestDelete = $this->model->deleteUsuario($intIdpersona);
				}
				

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

	} // Class Usuarios ..





/* 
	class Usuarios extends Controllers
	{
		public function __construct()
		{
			// Para que deje la sesion abierta en PHP desde la aplicacion y no desde la configuracion del servidor
			// sessionStart();
			// Se debe llamar desde esta posicion para evitar el problema de algunos "Hosting" que cuando se inicia sesion NO muestra nada en la pantalla
			// Se soluciona agregando la linea

			// Para que deje la sesion abierta en PHP desde la aplicacion y no desde la configuracion del servidor
			sessionStart();
			session_regenerate_id(true); // Regenere el Id de la sesion es para mayor seguridad.

			parent::__construct();
			// Verifica si la variable de SESSION["login"] esta en Verdadero, sigfica que esta una sesion iniciada.
			//session_start();

			// Evitar que ingresen en otro navegador utilizando el PHPSESSID
			// Elimina las ID Anteriores.
			//session_regenerate_id(true);
			
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


		

		// La vista para el perfil del usuario 
		public function Perfil()
		{
			// Esta información se puede obtener desde una base de datos, ya que el Controlador se comunica con el Modelo.			
			$data['page_tag'] = "Perfil";
			$data['page_title'] = "Perfil De Usuario";
			$data['page_name'] = "Perfil";
			$data['page_functions_js'] = "Functions_usuarios.js";
			// $this = Es equivalente "Usuarios"
			// Se llama la vista "Usuarios"
			$this->views->getView($this,"Perfil",$data);

		}

		// Grabar los datos del perfil de usuario.
		public function putPerfil()
		{
			// dep($_POST);
			// Verifica que no esten vacios los campos.
			if ($_POST)
			{
				if ( empty($_POST['txtIdentificacion']) || empty($_POST['txtNombre']) || empty($_POST['txtApellido']) || empty($_POST['txtTelefono']) )
				{
					$arrResponse = array("estatus" => false, "msg" => "Datos Incorrectos");
				}
				else
				{
					$idUsuario = $_SESSION['idUser'];
					$strIdentificacion = strClean($_POST['txtIdentificacion']);
					$strNombre = strClean($_POST['txtNombre']);
					$strApellido = strClean($_POST['txtApellido']);
					$intTelefono = strClean($_POST['txtTelefono']);
					$strPassword = "";
					if (!empty($_POST['txtPassword']))
					{
						// Esta Encriptando la nueva clave.
						$strPassword = hash("SHA256",$_POST['txtPassword']);
					}

					// Actualiza los datos del usuario en la tabla.
					$request_user = $this->model->updatePerfil($idUsuario,
																				$strIdentificacion,
																				$strNombre,
																				$strApellido,
																				$intTelefono,
																				$strPassword);
					
					if ($request_user)
					{
						sessionUser($_SESSION['idUser']); // Se define en el "Helpers.php"
						$arrResponse = array ('estatus' => true,'msg' => 'Datos Actualizados Correctamente ');
					}
					else
					{
						$arrResponse = array ('estatus' => false,'msg' => 'No es posible Almacenar los datos ');
					}

				} // else - if ( empty($_POST['txtIdentification']) || empty

				// Retorna el formato JSon el arreglo.
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);

			} // if ($_POST)

			die();
		}

		// Para grabar los datos Fiscales que se editaron.
		public function putDFiscal()
		{
			// Valida si se esta recibiendo una variable POST
			if ($_POST)
			{
				// dep($_POST);
				if (empty($_POST['txtNit']) || empty($_POST['txtNombreFiscal']) || empty($_POST['txtDirFiscal']))
				{
					$arrResponse = array("estatus" => false, "msg" =>"Datos Incorrectos");
				}
				else
				{
					$idUsuario = $_SESSION['idUser'];
					$strNit = strClean($_POST['txtNit']);
					$strNomFiscal = strClean($_POST['txtNombreFiscal']);
					$strDirFiscal = strClean($_POST['txtDirFiscal']);

					$request_datafiscal = $this->model->updateDataFiscal($idUsuario,$strNit,$strNomFiscal,$strDirFiscal);

					if($request_datafiscal)
					{
						sessionUser($_SESSION['idUser']);
						$arrResponse = array("estatus" => true, "msg" =>"Datos Actualizados Correctamente");
					}
					else
					{
						$arrResponse = array("estatus" => false, "msg" =>"NO es posible almacenar los datos");
					}
				} // if (empty($_POST['txtNit']) || empty($_POST['txtNombreFiscal']) || empty($_POST

				// Retorna el formato JSon el arreglo.
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);

			}// if ($_POST)
			die();
		}

} // classs home extends Controllers

?>
*/
