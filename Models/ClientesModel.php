<?php
	class ClientesModel extends Mysql
	{
		private $intIdUsuario;
		private $strIdentificacion;
		private $strNombre;
		private $strApellido;
		private $intTelefono;
		private $strEmail;
		private $strPassword;
		private $strToken;
		private $strNit;
		private $stNomFiscal;
		private $strDirFiscal;
		private $intTipoId;

		public function __construct()
		{
			
			// Cargar el método constructor de la clase padre "Mysql".
			// Se inicializa la Conexion a la Base De Datos.
			parent::__construct();
			//echo "<br>";
			//echo "Mensaje desde el *Capa Modelo* Home ";
		}

		public function insertCliente(string $identificacion, string $nombre, string $apellido, string $telefono, string $email, string $passwords, int $tipoid, string $nit, string $nomFiscal, string $dirFiscal)		
		{
			$this->strIdentificacion = $identificacion;
			$this->strNombre = $nombre;
			$this->strApellido = $apellido;
			$this->strTelefono = $telefono;
			$this->strEmail = $email;
			$this->strPassword = $passwords;
			$this->intTipoId = $tipoid;
			$this->strNit = $nit;
			$this->strNomFiscal = $nomFiscal;
			$this->strDirFiscal = $dirFiscal;
			$return = 0;

			// Verifica que no esten duplicados el correo electronico o la identificacion.
			$sql = "SELECT * FROM t_Personas WHERE email_user = '{$this->strEmail}' or identificacion = '{$this->strIdentificacion}'";

			$request = $this->select_all($sql);

			if (empty($request))
			{
				$query_insert = "INSERT INTO t_Personas (identificacion,nombres,apellidos,telefono,email_user,passwords,rolid,nit,nombrefiscal,direccionfiscal) VALUES(?,?,?,?,?,?,?,?,?,?)";
				
				$arrData = array ($this->strIdentificacion,
					$this->strNombre,
					$this->strApellido,
					$this->strTelefono,
					$this->strEmail,
					$this->strPassword,
					$this->intTipoId,
					$this->strNit,
					$this->strNomFiscal,
					$this->strDirFiscal
				);
				
					// Verificando que esta enviando el arreglo, se utiliza la funcion "Network" y el boton request para revisar los resultados
					//dep ($arrData); 
					//dep ($query_insert); 
					//die();

					$request_insert = $this->insert($query_insert,$arrData);
					$return = $request_insert;					
			}
			else
			{
				$return = "exist";
			}

			return $return;

		} // public function insertUsuario(string $i

		// Obtener los "Clientes"
		public function selectClientes()
		{
			$whereAdmin = "";			
			if ($_SESSION['idUser'] != 1) // No es el usuario "super Administrador"
			{
				// Para no mostrar al Super Usuario.
				$whereAdmin = " AND id_persona != 1 ";
			}
		
			// Para desplegar la consulta en la pantalla.
			//echo $sql = "SELECT id_persona,identificacion,nombres,apellidos,telefono,passwords,estatus,email_user
			//	FROM t_Personas WHERE rolid = 4 and estatus != 0 ".$whereAdmin;			
			// exit;

			$sql = "SELECT id_persona,identificacion,nombres,apellidos,telefono,passwords,estatus,email_user
			FROM t_Personas WHERE rolid = 4 and estatus != 0 ".$whereAdmin;			
			
			$request = $this->select_all($sql);
			return $request;

		}

		// Obtiene la informacion de un solo Cliente.
		public function selectCliente(int $idpersona)
		{
			// rolid = 4 Es el ID que esta grabado en la tabla "t_Rol"
			
			$this->intIdUsuario = $idpersona;
			$sql = "SELECT id_persona,identificacion,nombres,apellidos,telefono,email_user,nit,nombrefiscal,direccionfiscal,estatus,DATE_FORMAT(datecreated,'%d-%m-%Y') as fechaRegistro
				FROM t_Personas
				WHERE id_persona = $this->intIdUsuario AND rolid = 4 ";

			// echo $sql;exit;, se utiliza "Network" para seleccionar "Request" y se muetra el Echo.
			
			$request = $this->select($sql);
			return $request;

		} // public function selectCliente(int $idpersona)


		// Actualizar los datos del Cliente.
		public function updateCliente(int $idUsuario, string $identificacion, string $nombre, string $apellido, string $telefono, string $email, string $password, string $nit, string $nomFiscal, string $dirFiscal)
		{
			$this->intIdUsuario = $idUsuario;
			$this->strIdentificacion = $identificacion;
			$this->strNombre = $nombre;
			$this->strApellido = $apellido;
			$this->strTelefono = $telefono;
			$this->strEmail = $email;
			$this->strPassword = $password;
			$this->strNit = $nit;
			$this->strNomFiscal = $nomFiscal;
			$this->strDirFiscal = $dirFiscal;

			// Verificando atraves de la "identificacion" o "Email" que no exista el Usuario.
			// para que no se grabe un mismo correo dos personas diferentes
			// Igual se aplica para la "Identificacion"
			$sql = "SELECT * FROM t_Personas WHERE (email_user = '{$this->strEmail}' AND id_persona != '{$this->intIdUsuario}') OR (identificacion = '{$this->strIdentificacion}' AND id_persona != '{$this->intIdUsuario}')";
			
			$request = $this->select_all($sql);
			// Si esta vacia, por lo tanto no esta duplicado el correo electronico y la "Identificacion"
			if (empty($request))
			{
				// Si es diferente de Vacio se va "Actualizar" el Correo electrónico.
				if ($this->strPassword != "")
				{
					$sql = "UPDATE t_Personas SET identificacion=?,nombres=?,apellidos=?,telefono=?,email_user=?,passwords=?,nit=?,nombrefiscal=?,direccionfiscal=? WHERE id_persona = $this->intIdUsuario";

					$arrData = array($this->strIdentificacion,
					$this->strNombre,
					$this->strApellido,
					$this->strTelefono,
					$this->strEmail,
					$this->strPassword,
					$this->strNit,
					$this->strNomFiscal,
					$this->strDirFiscal);
				}
				else // Existe el Correo Electronico o la Identificación.
				{
					$sql = "UPDATE t_Personas SET identificacion=?,nombres=?,apellidos=?,telefono=?,email_user=?,nit=?,nombrefiscal=?,direccionfiscal=? WHERE id_persona = $this->intIdUsuario";

					$arrData = array($this->strIdentificacion,
					$this->strNombre,
					$this->strApellido,
					$this->strTelefono,
					$this->strEmail,
					$this->strNit,
					$this->strNomFiscal,
					$this->strDirFiscal);
				} // if ($this->strPassword != "")

				$request = $this->update($sql,$arrData);

			}
			else
			{
				$request = "exist";
			} // if (empty($request))

			return $request;

		} // public function updateCliente



	} // Class 

?>