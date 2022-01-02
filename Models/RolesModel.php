<?php
	class RolesModel extends Mysql
	{
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
			$sql = "SELECT * FROM t_Rol WHERE status != 0";
			$request = $this->select_all($sql);
			return $request;
		}

	} // class homeModel
?>