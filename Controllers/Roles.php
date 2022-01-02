<?php
	class Roles extends Controllers
	{
		public function __construct()
		{
			// Ejecuta el constructor padre (desde donde se hereda.)
			parent::__construct();

		}
		
		// Mandando información a las Vistas.
		public function Roles()
		{

			//echo "Mensaje desde el controlador Home ";
			// $this = Es la clase "Roles"
			// "roles" = la vista a mostrar.
			$data['page_id'] = 3;
			$data['page_tag'] = "Roles Usuarios";
			$data['page_name'] = "Rol usuario";		
			$data['page_title'] = "Roles Usuarios <small>  Tienda Virtual</small>";
			// "Dashboard" Se llama desde /Views/Dashboard/Dashboard.php"
			// Esta clase "views" método "getView" proviede de "Controllers"(Libraries/Core/Controllers.php) donde se llaman las clases y objetos 
			$this->views->getView($this,"Roles",$data);
		}

		// Obtener los Roles de Usuarios desde la Base de Datos
		public function getRoles()
		{
			echo "Método *getRoles()*";
			//$arrData = $this->model->selectRoles();
			//dep($arrData);
		}

} // classs home extends Controllers
?>
