<?php
	class home extends Controllers
	{
		public function __construct()
		{
			// Ejecuta el constructor padre (desde donde se hereda.)
			parent::__construct();

		}
		
		// Mandando información a las Vistas.
		public function home ()
		{

			//echo "Mensaje desde el controlador Home ";
			// $this = Es la clase "home"
			// "home" = la vista a mostrar.
			$data['page_id'] = 1;
			$data['page_tag'] = "home";
			$data['page_title'] = "Pagina Principal";
			$data['page_name'] = "home";
			$data['page_content'] = "Varios textos de prueba, varios textos de pruebna, nas dan dmans damnds amd, 887393839D masmnd anmds amsnd ad";
			$this->views->getView($this,"home",$data);
		}

} // classs home extends Controllers
?>
