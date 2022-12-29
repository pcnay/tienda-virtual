<?php
	require_once("Libraries/Core/Mysql.php");

	trait TCategoria
	{
		public $con;
		public function getCategoriasT(string $categorias)
		{
			// string $categorias = se utiliza para seleccionar la categoria en la Tienda 
			$this->con = new Mysql();
			$sql = "SELECT id_categoria,nombre,descripcion,portada FROM t_Categorias WHERE estatus != 0 AND id_categoria IN ($categorias) ";
			$request = $this->con->select_all($sql);
			if (count($request) > 0)
			{
				// Asignan todas las imagenes que corresponden de la "Categoria"
				for ($c=0; $c < count($request); $c++)
				{
					$request[$c]['portada'] = BASE_URL.'/Assets/images/uploads/'.$request[$c]['portada'];
				}
			}
			return $request;

		}
	}
?>