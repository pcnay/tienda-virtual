
<?php

class Login extends Controllers
{
	public function __construct()
	{
		// Para iniciar sesion, crear variables de sesion.
		session_start();
		// Verifica si la variable de SESSION["login"] esta en Verdadero, sigfica que esta una sesion iniciada.
		session_start();
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
						$arrResponse = array('estatus' => true, 'msg' =>'ok');
					}
					else
					{
						$arrResponse = array('estatus' => false, 'msg' => 'Usarios Inactivo');
					}
				}
			}
			// Convirtiendo a formato JSon el arreglo "$arrReponse"
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);

		} //if ($_POST)

		die(); // Detiene el proceso.

	}


} // classs home extends Controllers

?>
