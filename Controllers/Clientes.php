<?php

	class Clientes extends Controllers
	{
		public function __construct()
		{
			// Para que deje la sesion abierta en PHP desde la aplicacion y no desde la configuracion del servidor
			// sessionStart();
			// Se debe llamar desde esta posicion para evitar el problema de algunos "Hosting" que cuando se inicia sesion NO muestra nada en la pantalla
			// Se soluciona agregando la linea

			// Para que deje la sesion abierta en PHP desde la aplicacion y no desde la configuracion del servidor
			sessionStart();

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
			getPermisos(4); // Este el Id que corresponde en la tabla de Modulos.
		}
		
		// Mandando información a las Vistas.
		public function Clientes()
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
			$data['page_tag'] = "Clientes";
			$data['page_title'] = "CLIENTES <small>Tienda Virtual</small>";
			$data['page_name'] = "Clientes";
			$data['page_functions_js'] = "Functions_clientes.js";

			// $this = Es equivalente "Usuarios"
			// Se llama la vista "Usuarios"
			$this->views->getView($this,"Clientes",$data);
		}

		// Para Grabar los datos en la tabla de Clientes
		public function setCliente()
		{
			//dep($_POST); // Revisando el contenido de $_POST
			//die(); // Finaliza el proceso

			// Esta validando si los datos esta vacios.
			if ($_POST)
			{
				//dep($_POST);
				//die(); exit;

				if (empty($_POST['txtIdentificacion']) || empty($_POST['txtNombre']) || empty($_POST['txtApellido']) || empty($_POST['txtTelefono']) || empty($_POST['txtEmail']) || empty($_POST['txtNit']) || empty($_POST['txtNombreFiscal']) || empty($_POST['txtDirFiscal']))
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
					$strNit = strClean($_POST['txtNit']);
					$strNomFiscal = strClean($_POST['txtNombreFiscal']);
					$strDirFiscal = strClean($_POST['txtDirFiscal']);
					$intTipoId = 4; // ID que esta en la tabla de Roles, para clientes.

					$request_user = "";

					// Si no se envia un "id_persona" significa que se esta crean el Usuario
					if ($idUsuario == 0)
					{
						$option = 1;
						// hash("SHA256",passGenerator())); Encripta la contraseña. Genera un password Aleatorio
						$strPassword = empty($_POST['txtPassword'])?hash("SHA256",passGenerator()):hash("SHA256",$_POST['txtPassword']);

						// Valida que solo inserte un nuevo usuario si tiene el permiso de Grabar Usuario.
						if ($_SESSION['permisosMod']['w'])
						{
							$request_user = $this->model->insertCliente($strIdentificacion,$strNombre,$strApellido,$strTelefono,$strEmail,$strPassword,$intTipoId,$strNit,$strNomFiscal,$strDirFiscal);
						}
					}
					else  // Actualizar Usuario
					{
						/*
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
							$request_user = $this->model->updateUsuario($idUsuario,$strIdentificacion,$strNombre,$strApellido,$strTelefono,$strEmail,$strPassword,$intTipoId,$intStatus);
						}					
						*/

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

		// Para mostrar los clientes en pantalla.
		// Obteniene los "Clientes" 
		public function getClientes()
		{
			// Esta condicion se utiliza para que usuarios que no tengan sesion no pueden visualizar los usuarios.
			if ($_SESSION['permisosMod']['r'])
			{
				
				$arrData = $this->model->selectClientes();
				//dep($arrData);
				//exit;

				// Para colocar en color Verde o Rojo el estatus del Usuario
				for ($i= 0; $i<count($arrData);$i++)
				{
					$btnView = '';
					$btnEdit = '';
					$btnDelete = '';

					if ($_SESSION['permisosMod']['r'])
					{
						$btnView = '<button class="btn btn-info btn-sm btnViewInfo" onClick="fntViewInfo('.$arrData[$i]['id_persona'].')" title="Ver Cliente"><i class="far fa-eye"></i></button>';
					}

					if ($_SESSION['permisosMod']['u'])
					{
						// this = Significa que se enviara como parámetro todo la etiqueta "botton" 
							$btnEdit = '<button class="btn btn-primary btn-sm btnEditInfo" onClick="fntEditInfo(this,'.$arrData[$i]['id_persona'].')" title="Editar Cliente"><i class="fas fa-pencil-alt"></i></button>';

					} // if ($_SESSION['permisosMod']['u'])

					// ($_SESSION['userData']['id_persona'] != $arrData[$i][id_persona])
					// Se bloquea al Usuario Super Administrador el boton de Borrar, es decir no se puede eliminarse, se tiene que realizar
					// Con la opcion "Profile"
					if ($_SESSION['permisosMod']['d'])
					{
						$btnDelete = '<button class="btn btn-danger btn-sm btnDelInfo" onClick="fntDelInfo('.$arrData[$i]['id_persona'].')" title="Eliminar Cliente"><i class="fas fa-trash-alt"></i></button>';

					} // if ($_SESSION['permisosMod']['d'])

					//Son los botones, en la columna de "options".
					// Se agrega el evento "onclick" en la etiqueta "button" para evitar el error de en google de que no carga los eventos.
					$arrData[$i]['options'] = ' <div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';

				} // for ($i= 0; $i<count($arrData);$i++)
				

				// <span class="badge badge-success">Success</span>
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);				

			} // if ($_SESSION['permisosMod']['r'])

			die(); // Finaliza el proceso.

		} // Public function getClientes()


	} // class Usuarios extends Controllers

?>
