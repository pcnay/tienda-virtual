<?php
	class Mysql extends Conexion
	{
		// Definiendo las propiedades:
		private $conexion;
		private $strquery;
		private $arrVAlues;
		
		function __construct()
		{
			// Instancia de la clase Conexion()
			$this->conexion = new Conexion();
			$this->conexion = $this->conexion->conect();			
		}

		// Insertar un registro.
		public function insert(string $query, array $arrValues)
		{
			$this->strquery = $query;
			$this->arrVAlues = $arrValues;

			// Preparar el "query"
			$insert = $this->conexion->prepare($this->strquery);
			$resInsert = $insert->execute($this->arrVAlues);

			if ($resInsert)
			{
				// El últmo "Id" insertado .
				$lastInsert = $this->conexion->lastInsertId();				
			}
			else
			{
				$lastInsert = 0;
			}
			$insert->closeCursor();
			$insert=null;

			return $lastInsert;
		}

		// Buscar un registro.
		public function select (string $query)
		{
			$this->strquery = $query;
			$result = $this->conexion->prepare($this->strquery);
			$result->execute();
			// Se va obtener un registro.
			$data = $result->fetch(PDO::FETCH_ASSOC);

			$result->closeCursor();
			$result=null;

			return $data;

		}

		// Devolver todos los registros.
		public function select_all (string $query)
		{
			$this->strquery = $query;
			$result = $this->conexion->prepare($this->strquery);
			$result->execute();
			// Obtener varios registro.
			$data = $result->fetchall(PDO::FETCH_ASSOC);
			$result->closeCursor();
			$result=null;
			return $data;

		}

		// Actualizar registro.
		public function update(string $query, array $arrValues)
		{
			$this->strquery = $query;
			$this->arrVAlues = $arrValues;
			$update = $this->conexion->prepare($this->strquery);
			$resExecute = $update->execute($this->arrVAlues);
			$update->closeCursor();
			$update=null;

			return $resExecute;			
		}

		public function delete(string $query)
		{
			$this->strquery = $query;
			$result = $this->conexion->prepare($this->strquery);
			$del = $result->execute();

			$result->closeCursor();
			$result=null;

			return $del;
		}

	} //class Mysql extends Conexion
?>