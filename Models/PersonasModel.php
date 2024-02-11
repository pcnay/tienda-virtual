<?php
	class PersonasModel extends Mysql
	{
		private $intIdPersona;
		private $strIdentificacion;
		private $strNombre;
		private $strApellido;
		private $intTelefono;
		private $strEmail;
		private $strPassword;
		private $strToken;
		private $intTipoId;
		private $intStatus;
		private $strNit;
		private $stNomFiscal;
		private $strDirFiscal;

		public function __construct()
		{
			
			// Cargar el método constructor de la clase padre "Mysql".
			// Se inicializa la Conexion a la Base De Datos.
			parent::__construct();
			//echo "<br>";
			//echo "Mensaje desde el *Capa Modelo* Home ";
		}

		public function insertPersona(string $identificacion, string $nombre, string $apellido, string $telefono, string $email, string $passwords, int $tipoid, int $status)
		{
			$this->strIdentificacion = $identificacion;
			$this->strNombre = $nombre;
			$this->strApellido = $apellido;
			$this->strTelefono = $telefono;
			$this->strEmail = $email;
			$this->strPassword = $passwords;
			$this->intTipoId = $tipoid;
			$this->intStatus = $status;
			$return = 0;

			// Verifica que no esten duplicados el correo electronico o la identificacion.
			$sql = "SELECT * FROM t_Personas WHERE email_user = '{$this->strEmail}' or identificacion = '{$this->strIdentificacion}'";
			
			$request = $this->select_all($sql);
			//dep($sql);			
			//dep($request);			

			if (empty($request))
			{
				$query_insert = "INSERT INTO t_Personas (identificacion,nombres,apellidos,telefono,email_user,passwords,rolid,estatus) VALUES(?,?,?,?,?,?,?,?)";
				
				$arrData = array ($this->strIdentificacion,
					$this->strNombre,
					$this->strApellido,
					$this->strTelefono,
					$this->strEmail,
					$this->strPassword,
					$this->intTipoId,
					$this->intStatus);
				
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

			//dep($return);			
			//die();exit();


			return $return;
		}

		// Obtener los "Personas" con su respectivo "Rol"
		public function selectPersonas()
		{
			$whereAdmin = "";			
			if ($_SESSION['idUser'] != 1) // No es el usuario "super Administrador"
			{
				// Para no mostrar al Super Usuario.
				$whereAdmin = " AND id_persona != 1 ";
			}
		
			$sql = "SELECT id_persona,nombre_completo,estatus	FROM t_Personas	WHERE estatus != 0 ".$whereAdmin;
			$request = $this->select_all($sql);
			return $request;

		}

		// Obtiene la informacion de un sola Persona.
		public function selectPersona(int $idpersona)
		{
			// Se utiliza DAE_FORMAT = para mostrar fecha "dd-mmm-aaaa"
			$this->intIdUsuario = $idpersona;
			$sql = "SELECT p.id_persona,p.identificacion,p.nombres,p.apellidos,p.telefono,p.email_user,p.nit,p.nombrefiscal,p.direccionfiscal,p.passwords,p.rolid,r.id_rol,r.nombrerol,p.estatus,DATE_FORMAT(p.datecreated,'%d-%m-%Y') as fechaRegistro
				FROM t_Personas p
				INNER JOIN t_Rol r
				ON p.rolid = r.id_rol
				WHERE p.id_persona = $this->intIdUsuario";

			 //echo $sql;exit; //se utiliza "Network" para seleccionar "Request" y se muetra el Echo.
			
			$request = $this->select($sql);
			return $request;
		}

		// Actualizar un registro de una Persona.
		public function updatePersona(int $idUsuario, string $identificacion, string $nombre, string $apellido, string $telefono, string $email, string $password, int $tipoid, int $status)
		{
			$this->intIdUsuario = $idUsuario;
			$this->strIdentificacion = $identificacion;
			$this->strNombre = $nombre;
			$this->strApellido = $apellido;
			$this->strTelefono = $telefono;
			$this->strEmail = $email;
			$this->strPassword = $password;
			$this->intTipoId = $tipoid;
			$this->intStatus = $status;

			// Verificando atraves de la "identificacion" o "Email" que no exista el Usuario.
			// para que no se grabe un mismo correo dos personas diferentes
			// Igual se aplica para la "Identificacion"
			$sql = "SELECT * FROM t_Personas WHERE (email_user = '{$this->strEmail}' AND id_persona != '{$this->intIdUsuario}') OR (identificacion = '{$this->strIdentificacion}' AND id_persona != '{$this->intIdUsuario}')";
			
			$request = $this->select_all($sql);
			// Si esta vacia, por lo tanto no esta duplicado el correo electronico y la "Identificacion"
			if (empty($request))
			{
				// Si es diferente de Vacio se va "Actualizar" el Password
				if ($this->strPassword != "")
				{
					$sql = "UPDATE t_Personas SET identificacion=?,nombres=?,apellidos=?,telefono=?,email_user=?,passwords=?,rolid=?,estatus=? WHERE id_persona = $this->intIdUsuario";
					$arrData = array($this->strIdentificacion,
					$this->strNombre,
					$this->strApellido,
					$this->strTelefono,
					$this->strEmail,
					$this->strPassword,
					$this->intTipoId,
					$this->intStatus);
				}
				else // Para no actualizar el Password.
				{
					$sql = "UPDATE t_Personas SET identificacion=?,nombres=?,apellidos=?,telefono=?,email_user=?,rolid=?,estatus=? WHERE id_persona = $this->intIdUsuario";
					$arrData = array($this->strIdentificacion,
					$this->strNombre,
					$this->strApellido,
					$this->strTelefono,
					$this->strEmail,					
					$this->intTipoId,
					$this->intStatus);
				} // if ($this->strPassword != "")

				$request = $this->update($sql,$arrData);

			}
			else
			{
				$request = "exist";
			} // if (empty($request))

			return $request;
		}

		// Borrar una Persona.
		public function deletePersona(int $IdTipoPersona)
		{
			// Previene la Integridad Referencial De Los Datos, se revisa que no existe el usuario en la tabla "t_Personas"
			$this->intIdUsuario = $IdTipoUsuario;
				$sql = "UPDATE t_Personas SET estatus = ? WHERE id_persona = $this->intIdUsuario";
				$arrData = array(0); // Se asigna valor 0
				$request = $this->update($sql,$arrData);
				
			return $request;
		}

		// Grabar los datos que se actualizaron del usuario.
		public function updatePerfil(int $idUsuario, string $identificacion, string $nombre, string $apellido, string $telefono, string $Password)
		{
			$this->intIdUsuario = $idUsuario;
			$this->strIdentificacion = $identificacion;
			$this->strNombre = $nombre;
			$this->strApellido = $apellido;
			$this->strTelefono = $telefono;
			$this->strPassword = $Password;

			if ($this->strPassword != "")
			{
				$sql = "UPDATE t_Personas SET identificacion =?, nombres=?, apellidos=?, telefono=?, passwords=? WHERE id_persona = $this->intIdUsuario";
				$arrData = array($this->strIdentificacion,
													$this->strNombre,
													$this->strApellido,
													$this->strTelefono,
													$this->strPassword);
			}
			else
			{
				$sql = "UPDATE t_Personas SET identificacion =?, nombres=?, apellidos=?, telefono=? WHERE id_persona = $this->intIdUsuario";
				$arrData = array($this->strIdentificacion,
													$this->strNombre,
													$this->strApellido,
													$this->strTelefono);													

			}
			$request = $this->update($sql,$arrData);
			return $request;
		}

		// Grabar los datos que se actualizaron de los datos fiscales.
		public function updateDataFiscal(int $idUsuario, string $strNit, string $strNomFiscal, string $strDirFiscal)
		{
			$this->intIdUsuario = $idUsuario;
			$this->strNit = $strNit;
			$this->strNomFiscal = $strNomFiscal;
			$this->strDirFiscal = $strDirFiscal;		
			$sql = "UPDATE t_Personas SET nit=?, nombrefiscal=?, direccionfiscal=? WHERE id_persona = $this->intIdUsuario";
			$arrData = array($this->strNit,$this->strNomFiscal, $this->strDirFiscal);
			$request = $this->update($sql,$arrData);
			return $request;


		}

			
		
	} // class homeModel
?>