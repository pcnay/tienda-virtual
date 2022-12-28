<?php

	// Se agrega para poder reutulizar los metodos de "Categorias"	
	// Se comenta ya que se utilizara los "Trails"
	// require_once("CategoriasModel.php");

	class HomeModel extends Mysql
	{
		// Se comenta ya que se utilizara los "Trails"
		//private $objCategoria;

		public function __construct()
		{

			// Cargar el método constructor de la clase padre "Mysql".
			// Se inicializa la Conexion a la Base De Datos.
			parent::__construct();
			//echo "<br>";
			//echo "Mensaje desde el *Capa Modelo* Home ";

			// Se crea la instancia del objeto Categorias para  usar los métodos.
			// Se comenta ya que se utilizara los "Trails"
			//$this->objCategoria = new CategoriasModel();

		}

		/*
		// Se esta obteniendo informacion desde el "Modelo" que solicita el "Controlador"
		public function getCarrito($params)
		{
			// Se realiza un Query para obtener la información desde la Base de Datos.
			return "Datos Del Carrito ".$params;
		}
		*/

		// Se comenta ya que se utilizara los "Trails"
		/*
		public function getCategoriasT()
		{
			// Se llama al método para obtener todas las "Categorias"
			return $this->objCategoria->selectCategorias();
		}
		*/

	} // class homeModel
?>