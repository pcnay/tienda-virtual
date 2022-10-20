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

		// Insertar Productos a la tabla de Productos.
		function insertProducto(string $nombre, string $descripcion, int $codigo, int $categoriaid, string $precio, int $stock, int $status)		
		{
			$this->strNombre = $nombre;
			$this->strDescripcion = $descripcion;
			$this->intCodigo = $codigo;
			$this->intCategoriaId = $categoriaid;
			$this->strPrecio = $precio;
			$this->intStock = $stock;
			$this->intStatus = $status;
			$return = 0;
			$sql = "SELECT * FROM t_Productos WHERE codigo = $this->intCodigo";
			$request = $this->select_all($sql);
			
			if (empty($request))
			{
				$query_insert = "INSERT INTO t_Productos(categoriaid,codigo,nombre,descripcion,precio,stock,estatus)
				VALUES (?,?,?,?,?,?,?)"; // Evita inyeccion SQL, se utiliza con PDO

				$arrData = array($this->intCategoriaId, $this->intCodigo,$this->strNombre, $this->strDescripcion, $this->strPrecio, $this->intStock, $this->intStatus);

				$request_insert = $this->insert($query_insert,$arrData);
				$return = $request_insert;				
			}
			else
			{
				$return = "exist";
			}

			return $return;

		}


	} // class homeModel
?>