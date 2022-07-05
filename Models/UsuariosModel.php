<?php
	class UsuariosModel extends Mysql
	{
		private $intIdUsuario;
		private $strIdentificacion;
		private $strNombre;
		private $strApellido;
		private $intTelefono;
		private $strEmail;
		private $strPassword;
		private $strToken;
		private $intTipoId;
		private $intStatus;
	
		public function __construct()
		{
			
			// Cargar el método constructor de la clase padre "Mysql".
			// Se inicializa la Conexion a la Base De Datos.
			parent::__construct();
			//echo "<br>";
			//echo "Mensaje desde el *Capa Modelo* Home ";
		}

		public function insertUsuario(string $identificacion, string $nombre, string $apellido, string $telefono, string $email, string $passwords, int $tipoid, int $status)
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

			return $return;
		}

		// Obtener los "Usuarios" con su respectivo "Rol"
		public function selectUsuarios()
		{
			$whereAdmin = "";			
			if ($_SESSION['idUser'] != 1)
			{
				// Para no mostrar al Super Usuario.
				$whereAdmin = " AND p.id_persona != 1 ";
			}
		
			$sql = "SELECT p.id_persona,p.identificacion,p.nombres,p.apellidos,p.telefono,p.passwords,p.estatus,p.email_user,r.id_rol,r.nombrerol
				FROM t_Personas p
				INNER JOIN t_Rol r
				ON p.rolid = r.id_rol
				WHERE p.estatus != 0 ".$whereAdmin;			
			$request = $this->select_all($sql);
			return $request;

		}

		// Obtiene la informacion de un solo usuario.
		public function selectUsuario(int $idpersona)
		{
			$this->intIdUsuario = $idpersona;
			$sql = "SELECT p.id_persona,p.identificacion,p.nombres,p.apellidos,p.telefono,p.email_user,p.nit,p.nombrefiscal,p.direccionfiscal,p.passwords,r.id_rol,r.nombrerol,p.estatus,DATE_FORMAT(p.datecreated,'%d-%m-%Y') as fechaRegistro
				FROM t_Personas p
				INNER JOIN t_Rol r
				ON p.rolid = r.id_rol
				WHERE p.id_persona = $this->intIdUsuario";

			// echo $sql;exit;, se utiliza "Network" para seleccionar "Request" y se muetra el Echo.
			
			$request = $this->select($sql);
			return $request;
		}

		// Actualizar un registro.
		public function updateUsuario(int $idUsuario, string $identificacion, string $nombre, string $apellido, string $telefono, string $email, string $password, int $tipoid, int $status)
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
				// Si es diferente de Vacio se va "Actualizar" el Correo electrónico.
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
				else // Existe el Correo Electronico o la Identificación.
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

		// Borrar un Usuario
		public function deleteUsuario(int $IdTipoUsuario)
		{
			// Previene la Integridad Referencial De Los Datos, se revisa que no existe el usuario en la tabla "t_Personas"
			$this->intIdUsuario = $IdTipoUsuario;
				$sql = "UPDATE t_Personas SET estatus = ? WHERE id_persona = $this->intIdUsuario";
				$arrData = array(0); // Se asigna valor 0
				$request = $this->update($sql,$arrData);
				
			return $request;
		}


		
	} // class homeModel
?>