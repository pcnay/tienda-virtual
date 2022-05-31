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
		$data['page_tag'] = "Cambiar Constraseña";
		$data['page_title'] = "Cambiar Contraseña";
		$data['page_name'] = "Cambiar Constraseña";
		$data['id_persona'] = 1;
		//$data['page_functions_js'] = "Functions_login.js";
		$this->views->getView($this,"Cambiar_Passwords",$data);		
	}

} // classs home extends Controllers

?>
