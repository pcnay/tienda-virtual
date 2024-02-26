<?php
	class DeptosModel extends Mysql
	{
		public $intIddepto;
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

		// Método para insertar un registro en la tabla "t_Depto" 
		// Se envian los datos del Controller (que proviene desde la vista los datos que se capturaron) y se limpian para enviarse al Modelo.
		public function insertDepto(string $descripcion)
		{
			$return = 0;	
			$this->strDescripcion = $descripcion;

			// Verificar si existe la Descripcion.
			$sql = "SELECT * FROM t_Depto WHERE descripcion = '{$this->strDescripcion}'";
			$request = $this->select_all($sql);

			// Si no encontro el registro.
			if (empty($request))
			{
				// "id_depto" no se contempla, porque se definio en la base datos como autoincrementable. 
				$query_insert = "INSERT INTO t_Depto(descripcion) VALUES (?)";
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

		// Obtener los "Departamentos"
		public function selectDeptos()
		{
		
			// Para desplegar la consulta en la pantalla.
			//echo $sql = "SELECT id_persona,identificacion,nombres,apellidos,telefono,passwords,estatus,email_user
			//	FROM t_Personas WHERE rolid = 4 and estatus != 0 ".$whereAdmin;			
			// exit;

			$sql = "SELECT * FROM t_Depto";			
			
			$request = $this->select_all($sql);
			
			return $request;

		}

		// Obtener un Depto.
		public function selectDepto(int $idDepto)
		{
			$this->intIddepto = $idDepto;
			$sql = "SELECT * FROM t_Depto WHERE id_depto = $this->intIddepto";
			$request = $this->select($sql); // Este método se definio en MySQL
			return $request;
		}
		
		// Actualizar un Depto.
		public function updateDepto(int $idDepto, string $descripcion)
		{
			$this->intIddepto = $idDepto;			
			$this->strDescripcion = $descripcion;

			// Verificando atraves de la "descripcion" que no exita						
			$sql = "SELECT id_depto,descripcion FROM t_Depto WHERE (descripcion = '{$this->strDescripcion}' AND id_depto != '{$this->intIddepto}')";
			
			$request = $this->select_all($sql);
			// Si esta vacio, por lo tanto no esta duplicado la "descripcion"
			if (empty($request))
			{
					$sql = "UPDATE t_Depto SET descripcion=? WHERE id_depto = $this->intIddepto";

					$arrData = array($this->strDescripcion);

				$request = $this->update($sql,$arrData);
			}
			else
			{
				$request = "exist";
			} // if (empty($request))

			return $request;

		} // public function updateDepto

		// Borrar un Departamento
		public function deleteDepto(int $idDepto)
		{
			// Previene la Integridad Referencial De Los Datos, se revisa que no existe el Departmaento en la tabla "t_Personas"
			$this->intIddepto = $idDepto;
			$sql = "SELECT id_depto FROM t_Personas WHERE id_depto = $this->intIddepto";
			$request = $this->select_all($sql);

			if (empty($request))
			{				
				$sql = "DELETE FROM t_Depto WHERE id_depto = $this->intIddepto";
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