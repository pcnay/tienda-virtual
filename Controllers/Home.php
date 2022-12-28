<?php
	require_once("Models/TCategoria.php");

	class Home extends Controllers
	{
		use TCategoria;

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
			//$data['page_id'] = 1;

			// En esta seccion se extraera las categorias desde la base de datos.
			//dep ($this->getCategoriasT(CAT_SLIDER));
			//die();exit;

			$data['page_tag'] = NOMBRE_EMPRESA; 
			$data['page_title'] = NOMBRE_EMPRESA; 
			$data['page_name'] = "tienda_virtual";
			$data['slider'] = $this->getCategoriasT(CAT_SLIDER);
			$data['banner'] = $this->getCategoriasT(CAT_BANNER);
			//dep ($data);
			//die();exit;

			//$data['page_content'] = "Varios textos de prueba, varios textos de pruebna, nas dan dmans damnds amd, 887393839D masmnd anmds amsnd ad";

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
