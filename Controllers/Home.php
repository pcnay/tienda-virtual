<?php

	class Home extends Controllers
	{
		public function __construct()
		{
			// Ejecuta el constructor padre (desde donde se hereda.)
			// Para que la clase de instancie y ejecute la clase de "Modelo
			parent::__construct();

		}
		
		// Mandando información a las Vistas.
		public function home()
		{
			//echo "<br>";
			//echo "Mensaje desde el controlador Home ";

			// $this = Es la clase "Home", donde se define.
			// "home" = la vista a mostrar.
			// Esta información se puede obtener desde una base de datos, ya que el Controlador se comunica con el Modelo.
			$data['page_id'] = 1;
			$data['page_tag'] = "home";
			$data['page_title'] = "Pagina Principal";
			$data['page_name'] = "home";
			$data['page_content'] = "Varios textos de prueba, varios textos de pruebna, nas dan dmans damnds amd, 887393839D masmnd anmds amsnd ad";

			$this->views->getView($this,"home",$data);

		}

		// Método utilizado solo para capturar el valor "Params"
		// comunicandose con los "Controladores".
		public function datos($params)
		{
			echo "Datos Recibidos ".$params;
		}
/*
		// Método utilizado solo para capturar el valor "Params"
		// comunicandose con los "Controladores".
		public function carrito($params)
		{
			// Se esta accesando a un método del Módelo, desde el "Controlador".
			$carrito = $this->model->getCarrito($params);
			echo "<br>";
			echo $carrito;
		}

		public function insertar()
		{
			$data = $this->modelo->setUser();
			print_r($data);
		}
*/

} // classs home extends Controllers

?>
