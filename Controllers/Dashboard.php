<?php
	class Dashboard extends Controllers
	{
		public function __construct()
		{
			// Ejecuta el constructor padre (desde donde se hereda.)
			parent::__construct();

		}
		
		// Mandando información a las Vistas.
		public function dashboard ()
		{

			//echo "Mensaje desde el controlador Home ";
			// $this = Es la clase "home"
			// "home" = la vista a mostrar.
			$data['page_id'] = 2;
			$data['page_tag'] = "Dashboard - Tienda Virtual";
			$data['page_title'] = "Dashboard - Tienda Virtual";
			$data['page_name'] = "dashboard";			
			$this->views->getView($this,"Dashboard",$data);
		}

} // classs home extends Controllers
?>
