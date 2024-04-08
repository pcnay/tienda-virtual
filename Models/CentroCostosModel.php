<?php
	class CentroCostosModel extends Mysql
	{
		public $intIdCentroCostos;
		public $strNumCentroCostos;
		public $strDescripcion;
		

		public function __construct()
		{		
			// Cargar el método constructor de la clase padre "Mysql".
			// Se inicializa la Conexion a la Base De Datos.
			parent::__construct();
			//echo "<br>";
			//echo "Mensaje desde el *Capa Modelo* Home ";
		}

		
		// Método para insertar un registro en la tabla "t_Centro_Costos" 
		// Se envian los datos del Controller (que proviene desde la vista los datos que se capturaron) y se limpian para enviarse al Modelo.
		public function insertCentroCostos(string $strNumCentroCostos, string $strDescripcion)
		{
			$return = 0;
			$this->strNumCentroCostos = $strNumCentroCostos;
			$this->strDescripcion = $strDescripcion;

			// Verificar si existe el Num Centro de Costos.
			$sql = "SELECT * FROM t_Centro_Costos WHERE num_centro_costos = '{$this->strNumCentroCostos}'";
			$request = $this->select($sql);

			// Si no encontro el registro.
			if (empty($request))
			{
				// "id_centro_costos" no se contempla, porque se definio en la base datos como autoincrementable. 
				$query_insert = "INSERT INTO t_Centro_Costos (num_centro_costos,descripcion) VALUES (?,?)";
				$arrData = array($this->strNumCentroCostos,$this->strDescripcion);

				// Este método ya se definio en el Framework anteriormente Mysql.
				$request_insert = $this->insert($query_insert,$arrData);
				
				$return = $request_insert;	// Retorno el ID que se inserto en la Tabla.			
			}
			else
			{
				$return = "Existe"; // Ya existe el Numero Centro de Costos
			}
			return $return;
		}

		// Obtener los Centro de Costos
		public function selectCentroCostos()
		{
		
			// Para desplegar la consulta en la pantalla.
			//echo $sql = "SELECT id_persona,identificacion,nombres,apellidos,telefono,passwords,estatus,email_user
			//	FROM t_Personas WHERE rolid = 4 and estatus != 0 ".$whereAdmin;			
			// exit;

			$sql = "SELECT * FROM t_Centro_Costos";			
			
			$request = $this->select_all($sql);
			
			//dep($request);
			//exit;

			return $request;

		}

		// Obtener un Centro De Costos.
		public function selectUnCentroCosto(int $idNumCentroCostos)
		{
			$this->intIdNumCentroCostos = $idNumCentroCostos;
			$sql = "SELECT * FROM t_Centro_Costos WHERE id_centro_costos = $this->intIdNumCentroCostos";
			$request = $this->select($sql); // Este método se definio en MySQL
			return $request;
		}
		
		// Actualizar un Centro De Costos.
		// $intIdCentroCostos,$strNumCentroCostos,$strDescripcion
		public function updateCentroCostos(int $intIdCentroCostos, string $strNumCentroCostos, string $strDescripcion)
		{
			$this->intIdCentroCostos = $intIdCentroCostos;
			$this->strNumCentroCostos = $strNumCentroCostos;
			$this->strDescripcion = $strDescripcion;

			// Verificando atraves del "num_centro_costos" que no exita						
			$sql = "SELECT id_centro_costos,num_centro_costos,descripcion FROM t_Centro_Costos WHERE (num_centro_costos = '{$this->strNumCentroCostos}' AND id_centro_costos != '{$this->$intIdCentroCostos}')";
	
			
			$request = $this->select_all($sql);
			// Si esta vacio, por lo tanto no esta duplicado el "num_centro_costos"
			if (empty($request))
			{
					$sql = "UPDATE t_Centro_Costos SET num_centro_costos=?,descripcion=? WHERE id_centro_costos = $this->intIdCentroCostos";

					$arrData = array($this->strNumCentroCostos,
						$this->strDescripcion);

				$request = $this->update($sql,$arrData);
			}
			else
			{
				$request = "exist";
			} // if (empty($request))

			return $request;

		} // public function updateCentroCostos

		// Borrar un Centro De Costos
		public function deleteCentroCostos(int $idCentroCostos)
		{
			// Previene la Integridad Referencial De Los Datos, se revisa que no existe el Centro de costos en la tabla "t_Personas"
			$this->intIdCentroCostos = $idCentroCostos;
			$sql = "SELECT id_centro_costos FROM t_Personas WHERE id_centro_costos = $this->intIdCentroCostos";
			$request = $this->select_all($sql);

			if (empty($request))
			{
				$sql = "DELETE FROM t_Centro_Costos WHERE id_centro_costos = $this->intIdCentroCostos";
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