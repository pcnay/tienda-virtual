<?php
	class MarcasModel extends Mysql
	{
		public $intIdmarca;
		public $strDescripcion;

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
		// Se envian los datos del Controller (que proviene desde la vista los datos que se capturaron) y se limpian para enviarse a la Marca.
		public function insertMarca(string $descripcion)
		{
			$return = 0;
			$this->strDescripcion = $descripcion;
			
			// Verificar si existe el Modelo.
			$sql = "SELECT * FROM t_Marca WHERE descripcion = '{$this->strDescripcion}'";
			$request = $this->select($sql);

			// Si no encontro el registro.
			if (empty($request))
			{
				// "id_marca" no se contempla, porque se definio en la base datos como autoincrementable. 
				$query_insert = "INSERT INTO t_Marca(descripcion) VALUES (?)";
				$arrData = array($this->strDescripcion);

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

		// Obtener los "Marcas"
		public function selectMarcas()
		{
		
			// Para desplegar la consulta en la pantalla.
			//echo $sql = "SELECT id_persona,identificacion,nombres,apellidos,telefono,passwords,estatus,email_user
			//	FROM t_Personas WHERE rolid = 4 and estatus != 0 ".$whereAdmin;			
			// exit;

			$sql = "SELECT * FROM t_Marca";			
			
			$request = $this->select_all($sql);
			
			return $request;

		}

		// Obtener una Marca.
		public function selectMarca(int $idMarca)
		{
			$this->intIdMarca = $idMarca;
			$sql = "SELECT * FROM t_Marca WHERE id_marca = $this->intIdMarca";
			$request = $this->select($sql); // Este método se definio en MySQL
			return $request;
		}
		
		// Actualizar una Marca.
		public function updateMarca(int $idMarca,string $descripcion)
		{
			$this->intIdMarca = $idMarca;			
			$this->strDescripcion = $descripcion;
			
			// Verificando atraves del "nombre" que no exita						
			$sql = "SELECT id_marca,descripcion FROM t_Marca WHERE (descripcion = '{$this->strDescripcion}' AND id_marca != '{$this->intIdMarca}')";
			
			$request = $this->select_all($sql);
			// Si esta vacio, por lo tanto no esta duplicado el "descripcion"
			if (empty($request))
			{
					$sql = "UPDATE t_Marca SET descripcion=? WHERE id_marca = $this->intIdMarca";

					$arrData = array($this->strDescripcion);

					$request = $this->update($sql,$arrData);
			}
			else
			{
				$request = "exist";
			} // if (empty($request))

			return $request;

		} // public function updateMarca


		// Borrar una Categoria
		public function deleteMarca(int $idMarca)
		{
			// Previene la Integridad Referencial De Los Datos, se revisa que no existe el usuario en la tabla "t_Modelo"
			$this->intIdMarca = $idMarca;
				$sql = "DELETE FROM t_Marca WHERE id_marca = $this->intIdMarca";
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

			return $request;
		}
		

	} // class Modelo
?>