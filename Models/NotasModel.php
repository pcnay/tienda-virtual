<?php
	class NotasModel extends Mysql
	{		
		public $intId_persona;
		public $intIdnota;		
		public $intIdNotas;		
		public $strDescripcion;
		public $intStatus;
		public $strTitulo;
		public $intDuracion;
		public $strFecha_Nota;
		public $intlistPersona;
	

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



		// Obtener las "Notas"
		public function selectNotas()
		{
		
			// Para desplegar la consulta en la pantalla.
			//echo $sql = "SELECT id_persona,identificacion,nombres,apellidos,telefono,passwords,estatus,email_user
			//	FROM t_Personas WHERE rolid = 4 and estatus != 0 ".$whereAdmin;			
			// exit;

			// $sql = "SELECT * FROM t_Notas WHERE estatus != 0";			
			$sql = "SELECT t_Notas.id_nota AS id_nota,t_Notas.titulo_nota AS titulo_nota,t_Personas.nombre_completo AS nombre_completo,t_Notas.duracion_nota AS duracion_nota,DATE_FORMAT(t_Notas.fecha_nota,'%d-%m-%Y') as Fecha_Asignado,t_Notas.estatus AS estatus FROM t_Notas INNER JOIN t_Personas ON t_Notas.persona_asignada = t_Personas.id_persona WHERE t_Notas.estatus != 0";			
			
			$request = $this->select_all($sql);
			
			return $request;

		}

		// Método para insertar un registro en la tabla "t_Notas" 
		// Se envian los datos del Controller (que proviene desde la vista los datos que se capturaron) y se limpian para enviarse al Modelo.
		// $strTitulo,$strDescripcion,$intStatus,$intDuracion,$strFecha_Nota,$intlistPersona
		public function insertNota(int $id_persona, string $titulo, string $descripcion, int $status, int $duracion, string $fecha_nota, int $listPersona)
		{
			$return = 0;
			$this->intId_persona = $id_persona;			
			$this->strTitulo = $titulo;
			$this->strDescripcion = $descripcion;
			$this->intStatus = $status;
			$this->intDuracion = $duracion;
			$this->strFecha_Nota = $fecha_nota;
			$this->intlistPersona = $listPersona;


			// Verificar si existe la nota.
			$sql = "SELECT * FROM t_Notas WHERE titulo_nota = '{$this->strTitulo}'";
			$request = $this->select_all($sql);

			// Si no encontro el registro.
			if (empty($request))
			{
				// "id_nota" no se contempla, porque se definio en la base datos como autoincrementable. 
				$query_insert = "INSERT INTO t_Notas(id_persona,titulo_nota,descripcion_nota,persona_asignada,estatus,duracion_nota,fecha_nota) VALUES (?,?,?,?,?,?,?)";
				$arrData = array($this->intId_persona,$this->strTitulo,$this->strDescripcion,$this->intlistPersona,$this->intStatus,$this->intDuracion,$this->strFecha_Nota);

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

		// Obtener una Nota.
		public function selectNota(int $idNota)
		{			
			$this->intIdNotas = $idNota;
			
			$sql = "SELECT t_Notas.id_nota AS id_nota,t_Notas.titulo_nota AS titulo_nota,t_Notas.descripcion_nota AS descripcion,t_Personas.nombre_completo AS nombre_completo,t_Notas.persona_asignada AS idPersona,t_Notas.duracion_nota AS duracion_nota,DATE_FORMAT(t_Notas.fecha_nota,'%d-%m-%Y') as Fecha_Asignado,t_Notas.estatus AS estatus FROM t_Notas INNER JOIN t_Personas ON t_Notas.persona_asignada = t_Personas.id_persona WHERE (t_Notas.id_nota = '{$this->intIdNotas}' AND t_Notas.estatus != 0)";
			$request = $this->select($sql); // Este método se definio en MySQL
			return $request;
		}
		
		// Actualizar un Nota.
		public function updateNota(int $IdNota, string $Titulo, string $Descripcion, int $Status, int $Duracion,$Fecha_Nota,$listPersona)
		{
			$this->intIdnota = $IdNota;		
			$this->strTitulo = $Titulo;
			$this->strDescripcion = $Descripcion;
			$this->intStatus = $Status;			
			$this->intDuracion = $Duracion;
			$this->strFecha_Nota = $Fecha_Nota;
			$this->intlistPersona = $listPersona;
	
			$request = Null;		
			$sql = "UPDATE t_Notas SET titulo_nota=?,descripcion_nota=?,persona_asignada=?,estatus=?,duracion_nota=?,fecha_nota=? WHERE id_nota = $this->intIdnota";

			$arrData = array($this->strTitulo,
			$this->strDescripcion,$this->intlistPersona,$this->intStatus,$this->intDuracion,$this->strFecha_Nota);

			$request = $this->update($sql,$arrData);
	
			return $request;

		} // public function updateCategoria

		// Borrar una Categoria
		public function deleteNota(int $idNota)
		{
			// Previene la Integridad Referencial De Los Datos, se revisa que no existe el usuario en la tabla "t_Categorias"
			$this->intIdnota = $idNota;
				$sql = "DELETE FROM t_Notas WHERE id_nota = $this->intIdnota";
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