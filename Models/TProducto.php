<?php
	require_once("Libraries/Core/Mysql.php");

	trait TProducto		
	{
		private $con;
		private $strCategoria;
		private $intIdcategoria;
		private $strProducto;
		private $cant;
		private $options;


		public function getProductosT()
		{
			$this->con = new Mysql();
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

			$request = $this->con->select_all($sql); // Obtendrá mas de un registro.						
			$num_reg = count($request);
			if ( $num_reg > 0)
			{
				for ($c=0;$c<$num_reg;$c++)				
				{
					$intIdProducto = $request[$c]['id_producto'];
					$sqlImg = "SELECT img FROM t_Imagen WHERE productoid = $intIdProducto";
					$arrImg = $this->con->select_all($sqlImg); // Obtendrá mas de un registro.						

					if (count($arrImg)>0)
					{
						for ($i=0;$i<count($arrImg);$i++)
						{
							// Se crea un arreglo bidimencional.
							$arrImg[$i]['url_image'] = media().'/images/uploads/'.$arrImg[$i]['img'];
						} //for ($i=0;$i<count($arrImg);$i++)

					} // if (count($arrImg)>0)

					$request[$c]['images'] = $arrImg;

				} // for ($c=0;$c$num_reg;$c++)

			}	// if ( $num_reg > 0)		
			return $request;			

		} //public function selectProductos()

		public function getProductosCategoriaT(string $categoria)
		{
			$this->strCategoria = $categoria;
			$this->con = new Mysql();
			$sql_cat = "SELECT id_categoria FROM t_Categorias WHERE nombre = '{$this->strCategoria}'";
			$request = $this->con->select($sql_cat); // Extraer un registro

			if (!empty($request))
			{
				$this->intIdcategoria = $request['id_categoria'];

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
				WHERE p.estatus != 0 AND p.categoriaid = $this->intIdcategoria";

				$request = $this->con->select_all($sql); // Obtendrá mas de un registro.						
				$num_reg = count($request);
				if ( $num_reg > 0)
				{
					for ($c=0;$c<$num_reg;$c++)				
					{
						$intIdProducto = $request[$c]['id_producto'];
						$sqlImg = "SELECT img FROM t_Imagen WHERE productoid = $intIdProducto";
						$arrImg = $this->con->select_all($sqlImg); // Obtendrá mas de un registro.						

						if (count($arrImg)>0)
						{
							for ($i=0;$i<count($arrImg);$i++)
							{
								// Se crea un arreglo bidimencional.
								$arrImg[$i]['url_image'] = media().'/images/uploads/'.$arrImg[$i]['img'];
							} //for ($i=0;$i<count($arrImg);$i++)

						} // if (count($arrImg)>0)

						$request[c]['images'] = $arrImg;

					} // for ($c=0;$c$num_reg;$c++)

				}	// if ( $num_reg > 0)	

			} //	if (!empty($request))
	
			return $request;			

		} //public function getProductosCategoriaT()

		public function getProductoT(string $producto)
		{
			$this->con = new Mysql();
			$this->strProducto = $producto;

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
				WHERE p.estatus != 0 AND p.nombre = '{$this->strProducto}'";

			$request = $this->con->select($sql); // Obtendrá mas de un registro.						
			//dep($request);

			$num_reg = count($request);
			if (!empty($num_reg))
			{
				// Se quita el "for" porque solo es solo una imagen.

				$intIdProducto = $request['id_producto'];
				$sqlImg = "SELECT img FROM t_Imagen WHERE productoid = $intIdProducto";
				$arrImg = $this->con->select_all($sqlImg); // Obtendrá mas de un registro.						

				if (count($arrImg)>0)
				{
					for ($i=0;$i<count($arrImg);$i++)
					{
						// Se crea un arreglo bidimencional.
						$arrImg[$i]['url_image'] = media().'/images/uploads/'.$arrImg[$i]['img'];
					} //for ($i=0;$i<count($arrImg);$i++)

				} // if (count($arrImg)>0)

				$request['images'] = $arrImg;

			}	// if ( $num_reg > 0)		
	
			return $request;			

		} //		public function getProductoT()

		//  getProductosRandom($arrProducto['categoriaid'],8,"r");
		public function getProductosRandom(int $idcategoria, int $cant, string $option)
		{
			$this->intIdcategoria = $idcategoria;
			$this->cant = $cant;
			$this->option = $option;

			if ($option == "r")
			{
				$this->option = "RAND() ";
			}
			else if ($option == "a")
			{
				$this->option = "id_producto ASC";
			}
			else
			{
				$this->option = "id_producto DESC";
			}

			$this->con = new Mysql();
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
				WHERE p.estatus != 0 AND p.categoriaid = $this->intIdcategoria ORDER BY $this->option LIMIT $this->cant";

				//echo $sql;
				//die();
				//exit();

				$request = $this->con->select_all($sql); // Obtendrá mas de un registro.						
				$num_reg = count($request);
				if ( $num_reg > 0)
				{
					for ($c=0;$c<$num_reg;$c++)				
					{
						$intIdProducto = $request[$c]['id_producto'];
						$sqlImg = "SELECT img FROM t_Imagen WHERE productoid = $intIdProducto";
						$arrImg = $this->con->select_all($sqlImg); // Obtendrá mas de un registro.						

						if (count($arrImg)>0)
						{
							for ($i=0;$i<count($arrImg);$i++)
							{
								// Se crea un arreglo bidimencional.
								$arrImg[$i]['url_image'] = media().'/images/uploads/'.$arrImg[$i]['img'];
							} //for ($i=0;$i<count($arrImg);$i++)

						} // if (count($arrImg)>0)

						$request[c]['images'] = $arrImg;

					} // for ($c=0;$c$num_reg;$c++)

				}	// if ( $num_reg > 0)				
	
			return $request;			

		}


	} // trait TProducto
?>
