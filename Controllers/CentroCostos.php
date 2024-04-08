<?php

	class CentroCostos extends Controllers
	{
		public function __construct()
		{
			// Para que deje la sesion abierta en PHP desde la aplicacion y no desde la configuracion del servidor
			// sessionStart();
			// Se debe llamar desde esta posicion para evitar el problema de algunos "Hosting" que cuando se inicia sesion NO muestra nada en la pantalla
			// Se soluciona agregando la linea

			// Para que deje la sesion abierta en PHP desde la aplicacion y no desde la configuracion del servidor
			sessionStart();
			session_regenerate_id(true); // Regenere el Id de la sesion es para mayor seguridad. NO puede usar la ID se la sesion y ingresen al sistema.
 
			parent::__construct();
			// Verifica si la variable de SESSION["login"] esta en Verdadero, sigfica que esta una sesion iniciada.
			//session_start();

			// Evitar que ingresen en otro navegador utilizando el PHPSESSID
			// Elimina las ID Anteriores.
			//session_regenerate_id(true);
			
			if (empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/Login');
			}

			// Ejecuta el constructor padre (desde donde se hereda.)
			// Para que la clase de instancie y ejecute la clase de "Modelo"
			
			// "getPermisos(6)" -> Para extraer los permisos que corresponde al modulo en el momento, para este caso es el 6 (Categorias)
			getPermisos(13); // Este el Id que corresponde en la tabla de Modulos; 13 = Centro Costos
		}
		
		// Mandando información a las Vistas.
		public function CentroCostos()
		{
			//echo "<br>";
			//echo "Mensaje desde el controlador Home ";
			// Si no tiene el rol de "Lectura" no se podra mostrar la vista de "Categorias".
			if (empty($_SESSION['permisosMod']['r']))
			{
				header('Location: '.base_url().'/Dashboard');	
			}

			// $this = Es la clase "Home", donde se define.
			// "home" = la vista a mostrar.
			// Esta información se puede obtener desde una base de datos, ya que el Controlador se comunica con el Modelo.			
			$data['page_tag'] = "Centro Costos";
			$data['page_title'] = "CENTRO DE COSTOS <small>Control Responsivas</small>";
			$data['page_name'] = "Centro Costos";
			$data['page_functions_js'] = "Functions_CentroCostos.js";

			// $this = Es equivalente "Usuarios"
			// Se llama la vista "Centro Costos"
			$this->views->getView($this,"CentroCostos",$data);
		}

		// Método para asignar Centro De Costos.
		// Se llama en "Functions_CentroCostos.js", request.open("POST",ajaxUrl,true);
		public function setCentroCostos()
		{
			if ($_SESSION['permisosMod']['w'])
				{
					//dep($_POST); // Obtener el valor de la variable "Global". 					
					//exit();

					if ($_POST)
					{
						if (empty($_POST['txtDescripcion']) || empty($_POST['txtNumCentroCostos']))
						{
							$arrResponse = array("estatus" => false, "msg" => 'Datos Incorrectos');
						}
						else
						{
							// Obtener los datos que se estan enviando por Ajax 
							// "strClean" = Esta definida en "Helpers", para limpiar las cadenas.
							$intIdCentroCostos = intval($_POST['idCentroCostos']); // Convertir a Entero.							
							// clear_cadena = Es una funcion que se crea para quitar los acentos en los nombres de los productos.							
							$strDescripcion = strClean($_POST['txtDescripcion']);
							$strNumCentroCostos = strClean($_POST['txtNumCentroCostos']);
		
							//dep($intIdCentroCostos);
							//exit;

							// Seccion para Crear o Actualizar los Centro De Costos.
							if($intIdCentroCostos == 0)
							{
								// Crear un Centro de Costos
								if ($_SESSION['permisosMod']['w'])
								{
									$request_CentroCostos = $this->model->insertCentroCostos($strNumCentroCostos,$strDescripcion);
									$option = 1;
								}
							}
							else
							{
								// Actualizar Centro De Costos								
								if ($_SESSION['permisosMod']['u'])
								{
									// Actualizando de Centro De Costos
									$request_CentroCostos = $this->model->updateCentroCostos($intIdCentroCostos,$strNumCentroCostos,$strDescripcion);
									$option = 2;
								}
							}

							if ($request_CentroCostos > 0)
							{
								if ($option == 1)
								{
									$arrResponse = array('estatus' => true, 'msg' => 'Datos Guardados Correctamente');					
								}
								else
								{
									$arrResponse = array('estatus' => true, 'msg' => 'Datos Actualizados Correctamente');					
								}				
		
							}
							else if($request_depto == 'Existe')
							{
								$arrResponse = array('estatus'=>false,'msg'=>'El Numero o Descripcion del Centro de Costos Ya Existe');
							}
							else
							{
								$arrResponse = array('estatus'=>false,'msg'=>'NO es posible almacenar los datos');
							}

						} // if (empty($_POST['txtNombre']) || empty($_POST[

						// Corrige los datos de caracteres raros.
						// Esta información es enviada a "Functions_categorias.js"
						echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);

					} // 	if ($_POST)					

					die(); // Finaliza el proceso.

				} // if ($_SESSION['permisosMod']['w'])
		}

		// Para mostrar los Centros De Costos en pantalla.
		// Obteniene los "Centro De Costos" 
		public function getCentroCostos()
		{
			// Esta condicion se utiliza para el usuario que no tengan sesion no pueden visualizar los Centro De Costos ..
			if ($_SESSION['permisosMod']['r'])
			{
				
				$arrData = $this->model->selectCentroCostos(); // Obtiene los Centro De Costos.
				//dep($arrData);
				//exit;

				// Para colocar en color Verde o Rojo el estatus de los Centros De Costos
				for ($i= 0; $i<count($arrData);$i++)
				{
					$btnView = '';
					$btnEdit = '';
					$btnDelete = '';	

					if ($_SESSION['permisosMod']['r'])
					{
						$btnView = '<button class="btn btn-info btn-sm btnViewInfo" onClick="fntViewInfo('.$arrData[$i]['id_centro_costos'].')" title="Ver Centro Costos"><i class="far fa-eye"></i></button>';
					}

					if ($_SESSION['permisosMod']['u'])
					{
						// this = Significa que se enviara como parámetro todo la etiqueta "botton" 
							$btnEdit = '<button class="btn btn-primary btn-sm btnEditInfo" onClick="fntEditInfo(this,'.$arrData[$i]['id_centro_costos'].')" title="Editar Centro Costos"><i class="fas fa-pencil-alt"></i></button>';

					} // if ($_SESSION['permisosMod']['u'])			

					// Con la opcion "Profile"
					if ($_SESSION['permisosMod']['d'])
					{
						$btnDelete = '<button class="btn btn-danger btn-sm btnDelInfo" onClick="fntDelInfo('.$arrData[$i]['id_centro_costos'].')" title="Eliminar Centro Costos"><i class="fas fa-trash-alt"></i></button>';

					} // if ($_SESSION['permisosMod']['d'])

					//Son los botones, en la columna de "options".
					$arrData[$i]['options'] = ' <div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';

				} // for ($i= 0; $i<count($arrData);$i++)
				
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);				

			} // if ($_SESSION['permisosMod']['r'])

			die(); // Finaliza el proceso.

		} // Public function getDeptos()

		// Obtener un "Centro De Costos"
		// Depende de la definicion del “.htaccess”, que se manden por valores por la URL
		public function get_Un_CentroCostos($idCentroCostos)
		{			
			// Validando que no pueda ver el Centro De Costos, sin Permisos.
			if ($_SESSION['permisosMod']['r'])
			{				
				$intIdCentroCostos = intval($idCentroCostos); // Convertilo a Entero, si tuviera letras la conveirte a 0.

				//dep($intIdrol);
				//die;

				// Si existe el idcategoria
				if ($intIdCentroCostos > 0)
				{
					$arrData = $this->model->selectUnCentroCosto($intIdCentroCostos); // Extraer un Centro De Costos
					//dep ($arrData);
					//exit;
					if (empty($arrData)) // No existe el Centro De Costos
					{
						$arrResponse = array('estatus'=>false,'msg'=>'Datos no encontrados');
					}
					else
					{
						$arrResponse = array('estatus'=>true,'data'=>$arrData);
					}

					// Envia la variable , pero antes la convierte en forma JSon, las caracteres especiales los convierte a texto
					//dep($arrData);
					//exit;
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}

			} // if ($_SESSION['permisosMod']['r'])		

			die();
		}

		// Método para borrar un Centro De Costos.
		public function delCentroCostos()
		{
			// Esta variable superglobal se genero en "Functions_CentroCostos.js", seccion "fntDelCentroCostos"
			if ($_POST)
			{
				if ($_SESSION['permisosMod']['d'])
				{
					// Este valor se definio en "Functions_depto.js"
					// let strData = "idDepto="+idDepto;
					//request.open("POST",ajaxDelDepto,true);
					$intIdCentroCostos = intval($_POST['idCentroCostos']); 

					// Este objeto se define en el Modulo "CentroCostos".
					$requestDelete = $this->model->deleteCentroCostos($intIdCentroCostos);

					if($requestDelete == "ok")
					{
						$arrResponse = array('estatus'=> true, 'msg' => 'Se ha Eliminado El Centro De Costos');
					}
					else if ($requestDelete == "existe")
					{
						$arrResponse = array('estatus'=> false, 'msg' => 'No es posible eliminar un Centro De Costos con productos Asociados');			
					}
					else
					{
						$arrResponse = array('estatus'=> false, 'msg' => 'Error Al Eliminar el Centro De Costos');
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);

				} // if ($_SESSION['permisosMod']['d'])

			}
			die();
		}
		


	} // class CentroCostos extends Controllers

?>
