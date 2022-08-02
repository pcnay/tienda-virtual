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


	} // Class 

?>