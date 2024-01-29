<?php
	class CategoriasModel extends Mysql
	{
		public $intIdcategoria;
		public $strCategoria;
		public $strDescripcion;
		public $intStatus;
		public $strRuta;
		public $strPortada;

		public function __construct()
		{		
			// Cargar el método constructor de la clase padre "Mysql".
			// Se inicializa la Conexion a la Base De Datos.
			parent::__construct();
			//echo "<br>";
			//echo "Mensaje desde el *Capa Modelo* Home ";
		}

		/*
		// Se esta obteniendo informacion desde el "Modelo" que solicita el "Controlador"
		public function getCarrito($params)
		{
			// Se realiza un Query para obtener la información desde la Base de Datos.
			return "Datos Del Carrito ".$params;
		}
		*/

		// Método para insertar un registro en la tabla "t_Rol" 
		// Se envian los datos del Controller (que proviene desde la vista los datos que se capturaron) y se limpian para enviarse al Modelo.
		public function insertCategoria(string $nombre, string $descripcion, string $portada, string $ruta, int $status)
		{
			$return = 0;
			$this->strCategoria = $nombre;
			$this->strDescripcion = $descripcion;
			$this->strPortada = $portada;
			$this->strRuta = $ruta;
			$this->intStatus = $status;

			// Verificar si existe la Categoria.
			$sql = "SELECT * FROM t_Categorias WHERE nombre = '{$this->strCategoria}'";
			$request = $this->select_all($sql);

			// Si no encontro el registro.
			if (empty($request))
			{
				// "id_rol" no se contempla, porque se definio en la base datos como autoincrementable. 
				$query_insert = "INSERT INTO t_Categorias(nombre,descripcion,portada,ruta,estatus) VALUES (?,?,?,?,?)";
				$arrData = array($this->strCategoria,$this->strDescripcion,$this->strPortada,$this->strRuta, $this->intStatus);

				// Este método ya se definio en el Framework anteriormente Mysql.
				$request_insert = $this->insert($query_insert,$arrData);
				
				$return = $request_insert;	// Retorno el ID que se inserto en la Tabla.			
			}
			else
			{
				$return = "Existe"; // Ya existe la categoria
			}
			return $return;
		}

		// Obtener los "Categorias"
		public function selectCategorias()
		{
		
			// Para desplegar la consulta en la pantalla.
			//echo $sql = "SELECT id_persona,identificacion,nombres,apellidos,telefono,passwords,estatus,email_user
			//	FROM t_Personas WHERE rolid = 4 and estatus != 0 ".$whereAdmin;			
			// exit;

			$sql = "SELECT * FROM t_Categorias WHERE estatus != 0";			
			
			$request = $this->select_all($sql);
			
			return $request;

		}

		// Obtener una Categoria.
		public function selectCategoria(int $idcategoria)
		{
			$this->intIdcategoria = $idcategoria;
			$sql = "SELECT * FROM t_Categorias WHERE id_categoria = $this->intIdcategoria";
			$request = $this->select($sql); // Este método se definio en MySQL
			return $request;
		}
		
		// Actualizar una Categoria.
		public function updateCategoria(int $idCategoria, string $categoria, string $descripcion, string $portada, string $ruta, int $status)
		{
			$this->intIdcategoria = $idCategoria;
			$this->strCategoria = $categoria;
			$this->strDescripcion = $descripcion;
			$this->strPortada = $portada;
			$this->strRuta = $ruta;
			$this->intStatus = $status;

			// Verificando atraves del "nombre" que no exita						
			$sql = "SELECT id_categoria,nombre FROM t_Categorias WHERE (nombre = '{$this->strCategoria}' AND id_categoria != '{$this->intIdcategoria}')";
			
			$request = $this->select_all($sql);
			// Si esta vacio, por lo tanto no esta duplicado el "nombre"
			if (empty($request))
			{
					$sql = "UPDATE t_Categorias SET nombre=?,descripcion=?,portada=?,ruta=?,estatus=? WHERE id_categoria = $this->intIdcategoria";

					$arrData = array($this->strCategoria,
					$this->strDescripcion,
					$this->strPortada,
					$this->strRuta,
					$this->intStatus);

				$request = $this->update($sql,$arrData);
			}
			else
			{
				$request = "exist";
			} // if (empty($request))

			return $request;

		} // public function updateCategoria

		// Borrar una Categoria
		public function deleteCategoria(int $idcategoria)
		{
			// Previene la Integridad Referencial De Los Datos, se revisa que no existe el usuario en la tabla "t_Categorias"
			$this->intIdcategoria = $idcategoria;
			$sql = "SELECT categoriaid FROM t_Productos WHERE categoriaid = $this->intIdcategoria";
			$request = $this->select_all($sql);

			if (empty($request))
			{
				$sql = "DELETE FROM t_Categorias WHERE id_categoria = $this->intIdcategoria";
				//$sql = "UPDATE t_Categorias SET estatus = ? WHERE id_categoria = $this->intIdcategoria";
				//$arrData = array(0); // Se asigna valor 0
				//$request = $this->update($sql,$arrData);
				$request = $this->delete($sql);
				if ($request)
				{
					$request = 'ok';
				}
				else
				{
					$request = 'error';
				}
			}
			else
			{
				$request = 'existe';
			}

			return $request;
		}
		

	} // class homeModel
?>