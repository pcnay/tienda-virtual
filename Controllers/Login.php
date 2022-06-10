<?php

class Login extends Controllers
{
	public function __construct()
	{
		// Para iniciar sesion, crear variables de sesion.
		session_start();
		// Verifica si la variable de SESSION["login"] esta en Verdadero, sigfica que esta una sesion iniciada.
		
		if (isset($_SESSION['login']))
		{
			header('Location: '.base_url().'/Dashboard');
		}

		// Ejecuta el constructor padre (desde donde se hereda.)
		// Para que la clase de instancie y ejecute la clase de "Modelo
		parent::__construct();

	}
	
	// Mandando información a las Vistas.
	public function Login()
	{
		
		$data['page_tag'] = "Login";
		$data['page_title'] = "Tienda Virtual";
		$data['page_name'] = "login";
		$data['page_functions_js'] = "Functions_login.js";

		$this->views->getView($this,"Login",$data);
	}

	public function loginUser()
	{
		//dep($_POST);
		if ($_POST)
		{
			if (empty($_POST['txtEmail']) || empty($_POST['txtPassword']))
			{
				$arrResponse = array ('estatus' => false, 'msg' => 'Error De Datos');

			} // if (empty($_POST['txtEmail']) || em
			else
			{
				$strUsuario = strtolower(strClean($_POST['txtEmail']));
				$strPassword = hash("SHA256",$_POST['txtPassword']);
				// Se crea esta funcion en Models, para buscar el correo electronico
				$requestUser = $this->model->loginUser($strUsuario,$strPassword);
				//dep($requestUser);
				if (empty($requestUser))
				{
					$arrResponse = array ('estatus' =>false, 'msg' => 'El Usuario o Contraseña Es Incorrecto ');
				}
				else
				{
					$arrData = $requestUser;
					if ($arrData['estatus'] == 1)
					{
						// Iniciar sesion del usuario.
						$_SESSION['idUser'] = $arrData['id_persona'];
						$_SESSION['login'] = true;
						// Obtener todos los datos del usuario.
						$arrData = $this->model->sessionLogin($_SESSION['idUser']);
						$_SESSION['userData'] = $arrData;
						$arrResponse = array('estatus' => true, 'msg' =>'ok');
					}
					else
					{
						$arrResponse = array('estatus' => false, 'msg' => 'Usuario Inactivo');
					}
				}
			}
			// Convirtiendo a formato JSon el arreglo "$arrReponse"
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);

		} //if ($_POST)

		die(); // Detiene el proceso.
	}

	public function resetPass()
	{	
		// Valida si se ha realizado una petición POST
		//dep($_POST);
		//die();
		if ($_POST)
		{			
			if (empty($_POST['txtEmailReset']))
			{
				$arrResponse = array('estatus' => false, 'msg' => 'Error de datos');
			}
			else
			{
				//dep($_POST);
				//die();

				$token = token(); // Esta función se encuentra en el Helper.php
				$strEmail = strtolower(strClean($_POST['txtEmailReset']));

				// Realiza la consulta a la Tabla de "t_Personas"
				// Este método se define en el modelo.
				$arrData = $this->model->getUserEmail($strEmail);

				// Si no encontro al usuario
				if (empty($arrData))
				{
					$arrResponse = array('estatus' => false, 'msg' => 'Usuario NO Encontrado');
				}
				else
				{
					$idpersona = $arrData['id_persona'];
					$nombreUsuario = $arrData['nombres'].' '.$arrData['apellidos'];

					// La ruta para restablecer la contraseña.
					$url_recovery = base_url().'/Login/confirmUser/'.$strEmail.'/'.$token;

					// Actualiza el Token que se ha generado.
					$requestUpdate = $this->model->setTokenUser($idpersona,$token);
					//dep($requestUpdate);
					

					if($requestUpdate)
					{
						$arrResponse = array('estatus' => true, 'msg' =>'Se ha enviado un email a tu cuenta de correo para cambiar tu contraseña');						
					}
					else
					{
						$arrResponse = array('estatus' => false, 'msg' =>'No es posible realizar el proceso, intenta mas tarde');						
					}
				}
			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
		}
		die();	// Termina el proceso y no retorna nada.

	}

	public function confirmUser(string $params)
	{
		// Valida que exista la url completa para cuando se envia
		if (empty($params))
		{
			header ('Location: '.base_url());
		}
		else
		{
			// Para mostrar todos los parametros que se envian en la URL.
			// echo $params;
			$arrParams = explode(',',$params);			
			//dep($arrParams);
			$strEmail = strClean($arrParams[0]);
			$strToken = strClean($arrParams[1]);

			// Va a realizar una consulta a la base de datos.
			$arrResponse = $this->model->getUsuario($strEmail, $strToken);
			if (empty($arrResponse))
			{
				// Direcciona al directorio raíz
				header ("Location:".base_url());
			}
			else
			{
				$data['page_tag'] = "Cambiar Constraseña";
				$data['page_title'] = "Cambiar Contraseña";
				$data['page_name'] = "Cambiar Constraseña";
				// Estos dos campos se enviaron a la vista "Cambiar_Password"
				$data['email'] = $strEmail;
				$data['token'] = $strToken;
				$data['id_persona'] = $arrResponse['id_persona'];
				$data['page_functions_js'] = "Functions_login.js";				
				$this->views->getView($this,"Cambiar_Passwords",$data);				
			}

		} // 		if (empty($params))

		die();

	} // public function confirmUser(string $params)

	// Guardar el nuevo password
	public function setPassword()
	{
		// Verificando que se obtiene con la Variable Global POST
		 //dep($_POST);		
		 //exit; die(); // Finaliza el proceso.
		if (empty($_POST['idUsuario']) || empty($_POST['txtToken']) || empty($_POST['txtEmail']) || empty($_POST['txtPassword']) || empty($_POST['txtPasswordConfirm']))
		{
			$arrResponse = array('estatus' => false,'msg' => 'Error Campos en Blanco');
		}
		else
		{
			$intIdpersona = intval($_POST['idUsuario']);
			$strPassword = $_POST['txtPassword'];
			$strPasswordConfirm = $_POST['txtPasswordConfirm'];
			$strEmail = strClean($_POST['txtEmail']);
			$strToken = strClean($_POST['txtToken']);

			if ($strPassword != $strPasswordConfirm)
			{
				$arrResponse = array('estatus' => false, 'msg' => 'Las contraseña no son iguales');				
			}
			else
			{
				// Va a realizar una consulta a la base de datos.
				$arrResponseUser = $this->model->getUsuario($strEmail, $strToken);
				if (empty($arrResponseUser))
				{
					$arrResponse = array('estatus' => false, 'msg' => 'Error De Datos');				
				}
				else
				{
					$strPassword = hash("SHA256",$strPassword); // Encriptando la contraseña
					// Guardar la contraseña encriptada.
					$requestPass = $this->model->insertPassword($intIdpersona,$strPassword);
					if ($requestPass)
					{
						$arrResponse = array('estatus' => true, 'msg' => 'Contraseña actualizada con éxito');
					}
					else
					{
						$arrResponse = array('estatus' => false, 'msg' => 'No es posible realizar el proceso');
					}
				}
			}
		} // if (empty($_POST['idUsuario']) || empty($_POST['txtToken'])
		echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
		die(); // Finaliza el proceso.

	} // public function setPassword()

} // classs home extends Controllers

?>
