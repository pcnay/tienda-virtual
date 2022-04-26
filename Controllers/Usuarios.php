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
					$intTelefono = intval(strClean($_POST['txtTelefono']));
					$strEmail = strtolower(strClean($_POST['txtEmail']));
					$intTipoId = intval(strClean($_POST['listRolid']));
					$intStatus = intval(strClean($_POST['listStatus']));

					// hash("SHA256",passGenerator())); Encripta la contraseña.
					$strPassword = empty($_POST['txtPassword'])?hash("SHA256",passGenerator()):hash("SHA256",$_POST['txtPassword']);
					
					$request_user = $this->model->insertUsuario($strIdentificacion,$strNombre,$strApellido,$intTelefono,$strEmail,$strPassword,$intTipoId,$intStatus);

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
/*
		// Método utilizado solo para capturar el valor "Params"
		// comunicandose con los "Controladores".
		public function carrito($params)
		{
			// Se esta accesando a un método del Módelo, desde el "Controlador".
			$carrito = $this->model->getCarrito($params);
			echo "<br>";
			echo $carrito;
		}

		public function insertar()
		{
			$data = $this->modelo->setUser();
			print_r($data);
		}
*/

} // classs home extends Controllers

?>
