<?php
	class LoginModel extends Mysql
	{
		private $intIdUsuario;
		private $strUsuario;
		private $strPassword;
		private $strToken;

		public function __construct()
		{
			// Cargar el método constructor de la clase padre "Mysql".
			// Se inicializa la Conexion a la Base De Datos.
			parent::__construct();
			//echo "<br>";
			//echo "Mensaje desde el *Capa Modelo* Home ";
		}

		public function loginUser(string $usuario, string $password)
		{
			$this->strUsuario = $usuario;
			$this->strPassword = $password;
			/*
			Para que se despliege en Network -> Request el contenido de la Consula.
			echo $sql = "SELECT id_persona,estatus FROM t_Personas WHERE email_user = '$this->strUsuario' AND passwords = '$this->strPassword' AND estatus != 0";
			exit;
			*/
			$sql = "SELECT id_persona,estatus FROM t_Personas WHERE email_user = '$this->strUsuario' AND passwords = '$this->strPassword' AND estatus != 0";
			$request = $this->select($sql);
						
			return $request;
		}
		
		// Obtiene los datos de un usuario.
		public function sessionLogin(int $iduser)
		{
			$this->intIdUsuario = $iduser;
			$sql = "SELECT p.id_persona,
											p.identificacion,
											p.nombres,
											p.apellidos,
											p.telefono,
											p.email_user,
											p.nit,
											p.nombrefiscal,
											p.direccionfiscal,
											r.id_rol,r.nombrerol,
											p.estatus
							FROM t_Personas p
							INNER JOIN t_Rol r
							ON p.rolid = r.id_rol
							WHERE p.id_persona = $this->intIdUsuario";
				$request = $this->select($sql);
				$_SESSION['userData'] = $request;
				return $request;
		}

		public function getUserEmail(string $strEmail)
		{
			// Extrae el correo del usuarios.
			$this->strUsuario = $strEmail;
			$sql = "SELECT id_persona,nombres,apellidos,estatus FROM t_Personas WHERE email_user = '$this->strUsuario' and estatus = 1 ";
			$request = $this->select($sql);
			return $request;
		}

		// 
		public function setTokenUser(int $idpersona, string $token)
		{
			$this->intIdUsuario = $idpersona;
			$this->strToken = $token;
			$sql = "UPDATE t_Personas SET token = ? WHERE id_persona = $this->intIdUsuario ";

			// Para mostrar el contenido del $sql
			//echo $sql = "UPDATE t_Personas SET token = ? WHERE id_persona = $this->intIdUsuario ";
			//exit;
			$arrData = array($this->strToken);
			$request = $this->update($sql,$arrData);
			return $request;			
		}

		public function getUsuario(string $email, string $token)
		{
			$this->strUsuario = $email;
			$this->strToken = $token;
			$sql = "SELECT id_persona FROM t_Personas WHERE email_user = '$this->strUsuario' AND token = '$this->strToken' AND estatus = 1";
			$request = $this->select($sql);			
			return $request;
		}

		public function insertPassword(int $idPersona, string $password)
		{
			$this->intIdUsuario = $idPersona;
			$this->strPassword = $password;
			$sql = "UPDATE t_Personas SET passwords = ?, token = ? WHERE id_persona = $this->intIdUsuario";			
			$arrData = array($this->strPassword,"");
			$request = $this->update($sql,$arrData);
			return $request;
		}

	} // class LoginModel
?>