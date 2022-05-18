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
				return $request;
		}
		
	} // class homeModel
?>