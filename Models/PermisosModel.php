<?php
	class PermisosModel extends Mysql
	{
		public $intIdpermisos;
		public $intRolid;
		public $intModuloid;
		public $r;
		public $w;
		public $u;
		public $d;
		
		public function __construct()
		{
			// Cargar el método constructor de la clase padre "Mysql".
			// Se inicializa la Conexion a la Base De Datos.
			parent::__construct();
			//echo "<br>";
			//echo "Mensaje desde el *Capa Modelo* Home ";
		}

		// Para seleccionar los módulos del Sistema.
		public function selectModulos()
		{
			$sql = "SELECT * FROM t_Modulos WHERE estatus != 0";
			$request = $this->select_all($sql);
			return $request;
		}

		// Seleccionar Rol
		public function selectPermisosRol(int $idrol)
		{
			$this->intRolid = $idrol;
			$sql = "SELECT * FROM t_Permisos WHERE rolid = $this->intRolid";
			$request = $this->select_all($sql);
			return $request;
			
		}

		
	} // class homeModel
?>