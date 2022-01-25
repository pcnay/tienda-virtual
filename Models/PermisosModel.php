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

		// Borrar los permisos que tenga asignados, antes de asignar los nuevos.		
		public function deletePermisos (int $idrol)
		{
			$this->intRolid = $idrol;
			$sql = "DELETE FROM t_Permisos WHERE  rolid = $this->intRolid";
			$request = $this->delete($sql);
			return $request;
		}
		// Insertar permisos.
		public function  insertPermisos(int $idrol, int $idmodulo, int $r, int $w, int $u, int $d)
		{			
			$this->intRolid = $idrol;
			$this->intModuloid = $idmodulo;
			$this->r = $r;
			$this->w = $w;
			$this->u = $u;
			$this->d = $d;
			$query_insert = "INSERT INTO t_Permisos (rolid,moduloid,r,w,u,d) VALUES (?,?,?,?,?,?)";
			$arrData = array($this->intRolid, $this->intModuloid, $this->r,$this->w,$this->u,$this->d);
			$request_insert = $this->insert($query_insert,$arrData);
			return $request_insert;

		}


		
	} // class homeModel
?>