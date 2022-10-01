<?php
	class ProductosModel extends Mysql
	{
		private $intIdProducto;
		private $strNombre;
		private $strDescripcion;
		private $intCodigo;
		private $intCategoriaId;
		private $intPrecio;
		private $intStock;
		private $intStatus;

		public function __construct()
		{
			// Cargar el método constructor de la clase padre "Mysql".
			// Se inicializa la Conexion a la Base De Datos.
			parent::__construct();
		}

		public function selectProductos()
		{
			$sql = "SELECT p.id_producto,
				p.codigo,
				p.nombre,
				p.descripcion,
				p.categoriaid,
				c.nombre AS categoria,
				p.precio,
				p.stock,
				p.estatus
				FROM t_Productos p
				INNER JOIN t_Categorias c
				ON p.categoriaid = c.id_categoria
				WHERE p.estatus != 0";
			
			$request = $this->select_all($sql);
			return $request;
			
			
		}
	} // class homeModel
?>