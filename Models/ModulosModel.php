<?php
	class ModulosModel extends Mysql
	{
		public $intIdmodulo;
		public $strNOmbre;
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
		public function insertModulo(string $nombre, string $descripcion, int $status)
		{
			$return = 0;
			$this->strModulo = $nombre;
			$this->strDescripcion = $descripcion;
			$this->intStatus = $status;

			// Verificar si existe el Modulo.
			$sql = "SELECT * FROM t_Modulos WHERE titulo = '{$this->strModulo}'";
			$request = $this->select_all($sql);

			// Si no encontro el registro.
			if (empty($request))
			{
				// "id_modulo" no se contempla, porque se definio en la base datos como autoincrementable. 
				$query_insert = "INSERT INTO t_Modulos(titulo,descripcion,estatus) VALUES (?,?,?)";
				$arrData = array($this->strModulo,$this->strDescripcion,$this->intStatus);

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

		// Obtener los "Modulos"
		public function selectModulos()
		{
		
			// Para desplegar la consulta en la pantalla.
			//echo $sql = "SELECT id_persona,identificacion,nombres,apellidos,telefono,passwords,estatus,email_user
			//	FROM t_Personas WHERE rolid = 4 and estatus != 0 ".$whereAdmin;			
			// exit;

			$sql = "SELECT * FROM t_Modulos WHERE estatus != 0";			
			
			$request = $this->select_all($sql);
			
			return $request;

		}

		// Obtener un Modulo.
		public function selectModulo(int $idModulo)
		{
			$this->intIdModulo = $idModulo;
			$sql = "SELECT * FROM t_Modulos WHERE id_modulo = $this->intIdModulo";
			$request = $this->select($sql); // Este método se definio en MySQL
			return $request;
		}
		
		// Actualizar un Modulo.
		public function updateModulo(int $idModulo, string $nombre, string $descripcion, int $status)
		{
			$this->intIdModulo = $idModulo;
			$this->strNombre = $nombre;
			$this->strDescripcion = $descripcion;
			$this->intStatus = $status;

			// Verificando atraves del "nombre" que no exita						
			$sql = "SELECT id_modulo,titulo FROM t_Modulos WHERE (titulo = '{$this->strNombre}' AND id_modulo != '{$this->intIdModulo}')";
			
			$request = $this->select_all($sql);
			// Si esta vacio, por lo tanto no esta duplicado el "nombre"
			if (empty($request))
			{
					$sql = "UPDATE t_Modulos SET titulo=?,descripcion=?,estatus=? WHERE id_modulo = $this->intIdModulo";

					$arrData = array($this->strNombre,
					$this->strDescripcion,
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
		public function deleteModulo(int $idModulo)
		{
			// Previene la Integridad Referencial De Los Datos, se revisa que no existe el usuario en la tabla "t_Categorias"
			$this->intIdModulo = $idModulo;
				$sql = "DELETE FROM t_Modulos WHERE id_modulo = $this->intIdModulo";
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
		

	} // class homeModel
?>