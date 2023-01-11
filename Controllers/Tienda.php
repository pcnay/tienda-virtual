<?php
	require_once("Models/TCategoria.php");
	require_once("Models/TProducto.php");

	class Tienda extends Controllers
	{
		use TCategoria,TProducto;

		public function __construct()
		{
			// Ejecuta el constructor padre (desde donde se hereda.)
			// Para que la clase de instancie y ejecute la clase de "Modelo
			parent::__construct();

		}
		
		// Mandando información a las Vistas.
		public function tienda()
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

			//dep ($this->selectProductos());
			//die();exit;

			$data['page_tag'] = NOMBRE_EMPRESA; 
			$data['page_title'] = NOMBRE_EMPRESA; 
			$data['page_name'] = "Tienda";
			$data['productos'] = $this->getProductosT();
			//dep ($data);
			//die();exit;

			//$data['page_content'] = "Varios textos de prueba, varios textos de pruebna, nas dan dmans damnds amd, 887393839D masmnd anmds amsnd ad";
			$this->views->getView($this,"Tienda",$data);
		}

		public function categoria($params)
		{
			if (empty($params))
			{
				header("Location:".base_url());				
			}
			else
			{
				$categoria = strClean($params);
				// Muestra todas las categorias que se encuentran en los productos.
				// dep($this->getProductosCategoriaT($categoria));
				// Evita inyeccion sql (strClean)
				$data['page_tag'] = NOMBRE_EMPRESA." - ".$categoria; // Renombrar nombre del Tab del navegador.
				$data['page_title'] = $categoria;
				$data['page_name'] = "Categoria";
				$data['productos'] = $this->getProductosCategoriaT($categoria);
				$this->views->getView($this,"Categoria",$data);

			} //if (empty($params))

		} //public function categoria($params)

		// Se utiliza para el detalle del Producto en la Seccion de "Tienda"
		public function producto($params)
		{
			if (empty($params))
			{
				header("Location:".base_url());		// Retorna a la página Principal.		
			}
			else
			{
				$producto = strClean($params);
				$arrProducto = $this->getProductoT($producto);

				//dep($this->getProductoT($producto));
				//dep($this->getProductosRandom($arrProducto['categoriaid'],2,"r"));

				
				// Muestra todas los productos
				// dep($this->getProductosCategoriaT($categoria));
				// Evita inyeccion sql (strClean)
				$data['page_tag'] = NOMBRE_EMPRESA." - ".$producto; // Renombrar nombre del Tab del navegador.
				$data['page_title'] = $producto;
				$data['page_name'] = "Producto";

				// Extrae un producto de la Categoria de un producto. 
				$data['producto'] = $arrProducto;

				// Extrae todos los productos de la Categoría, se pasa omo parámetro.
				// "r" = Se mostrara en forma aleatoria.				
				$data['productos'] = $this->getProductosRandom(intval($arrProducto['categoriaid']),2,"r");
				//dep($this->getProductosRandom($arrProducto['categoriaid'],2,"r"));


				// Esta vista se crea en "Views->Tienda->Producto
				$this->views->getView($this,"Producto",$data);
			} //if (empty($params))

		}

} // classs home extends Controllers

?>
