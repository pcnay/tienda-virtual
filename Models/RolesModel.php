<?php
	class RolesModel extends Mysql
	{
		//Definiendo las propieadades de Roles.
		public $intIdrol;
		public $strRol;
		public $strDescripcion;
		public $intStatus;
		

		public function __construct()
		{
			// Cargar el método constructor de la clase padre "Mysql".
			// Se inicializa la Conexion a la Base De Datos.
			parent::__construct();
			//echo "<br>";
			//echo "Mensaje desde el *Capa Modelo* Home ";
		}

		/*
		// Se esta obteniendo informacion desde el "Modelo" que solicita el "Controlador"
		public function getCarrito($params)
		{
			// Se realiza un Query para obtener la información desde la Base de Datos.
			return "Datos Del Carrito ".$params;
		}
		*/
		
		public function selectRoles()
		{
			// status = 0 ; Reg. Borrados
			$sql = "SELECT * FROM t_Rol WHERE estatus != 0";
			$request = $this->select_all($sql);
			return $request;
		}

		// Obtener un Rol.
		public function selectRol(int $idrol)
		{
			$this->intIdrol = $idrol;
			$sql = "SELECT * FROM t_Rol WHERE id_rol = $this->intIdrol";
			$request = $this->select($sql);
			return $request;
		}

		// Método para insertar un registro en la tabla "t_Rol" 
		// Se envian los datos del Controller (que proviene desde la vista los datos que se capturaron) y se limpian para enviarse al Modelo.
		public function insertRol(string $rol, string $descripcion, int $status)
		{
			$return = "";
			$this->strRol = $rol;
			$this->strDescripcion = $descripcion;
			$this->intStatus = $status;

			// Verificar si existe el Rol.
			$sql = "SELECT * FROM t_Rol WHERE nombrerol = '{$this->strRol}'";
			$request = $this->select_all($sql);

			// Si no encontro el registro.
			if (empty($request))
			{
				$query_insert = "INSERT INTO t_Rol(nombrerol,descripcion,estatus) VALUES (?,?,?)";
				$arrData = array($this->strRol,$this->strDescripcion,$this->intStatus);
				$request_insert = $this->insert($query_insert,$arrData);
				$return = $request_insert;	// Retorno el ID que se inserto en la Tabla.			
			}
			else
			{
				$return = "Existe";
			}
			return $return;
		}

		// Actualizar el Rol.
		//updateRol($intIdrol,$strRol,$strDescripcion,$intStatus);
		public function updateRol (int $idrol, string $rol, string $descripcion, int $status)
		{
			$this->intIdrol = $idrol;
			$this->strRol = $rol;
			$this->strDescripcion = $descripcion;
			$this->intStatus = $status;
			// Detecta que no exista el "id_rol" y "descripcion" del Rol
			$sql = "SELECT * FROM t_Rol WHERE nombrerol = '$this->strRol' AND id_rol != $this->intIdrol";
			$request = $this->select_all($sql);

			if (empty($request))
			{
				$sql = "UPDATE t_Rol SET nombrerol = ?, descripcion = ?, estatus = ? WHERE id_rol = $this->intIdrol";
				$arrData = array($this->strRol, $this->strDescripcion,$this->intStatus);
				$request = $this->update($sql,$arrData);
			}
			else
			{
				$request = "Existe";
			}
			
			return $request;
		}

		// Borrar un Rol
		public function deleteRol(int $idrol)
		{
			// Previene la Integridad Referencial De Los Datos, se revisa que no existe el usuario en la tabla "t_Personas"
			$this->intIdrol = $idrol;
			$sql = "SELECT * FROM t_Personas WHERE rolid = $this->intIdrol";
			$request = $this->select_all($sql);
			if (empty($request))
			{
				$sql = "UPDATE t_Rol SET estatus = ? WHERE id_rol = $this->intIdrol";
				$arrData = array(0); // Se asigna valor 0
				$request = $this->update($sql,$arrData);
				if ($request)
				{
					$request = 'ok';
				}
				else
				{
					$request = 'error';
				}
			}
			else
			{
				$request = 'existe';
			}

			return $request;
		}

	} // class homeModel
?>