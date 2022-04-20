<?php

	class Usuarios extends Controllers
	{
		public function __construct()
		{
			// Ejecuta el constructor padre (desde donde se hereda.)
			// Para que la clase de instancie y ejecute la clase de "Modelo
			parent::__construct();

		}
		
		// Mandando información a las Vistas.
		public function Usuarios()
		{
			//echo "<br>";
			//echo "Mensaje desde el controlador Home ";

			// $this = Es la clase "Home", donde se define.
			// "home" = la vista a mostrar.
			// Esta información se puede obtener desde una base de datos, ya que el Controlador se comunica con el Modelo.
			
			$data['page_tag'] = "Usuarios";
			$data['page_title'] = "USUARIOS <small>Tienda Virtual</small>";
			$data['page_name'] = "Usuarios";

			// $this = Es equivalente "Usuarios"
			// Se llama la vista "Usuarios"
			$this->views->getView($this,"Usuarios",$data);
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
