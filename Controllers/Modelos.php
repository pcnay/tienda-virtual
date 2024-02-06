<?php

	class Modelos extends Controllers
	{
		public function __construct()
		{
			// Para que deje la sesion abierta en PHP desde la aplicacion y no desde la configuracion del servidor
			// sessionStart();
			// Se debe llamar desde esta posicion para evitar el problema de algunos "Hosting" que cuando se inicia sesion NO muestra nada en la pantalla
			// Se soluciona agregando la linea

			// Para que deje la sesion abierta en PHP desde la aplicacion y no desde la configuracion del servidor
			sessionStart();

			// Evitar que ingresen en otro navegador utilizando el PHPSESSID
			// Elimina las ID Anteriores.
			//session_regenerate_id(true);
			session_regenerate_id(true); // Regenere el Id de la sesion es para mayor seguridad. NO puede usar la ID se la sesion y ingresen al sistema.
 
			parent::__construct();
			// Verifica si la variable de SESSION["login"] esta en Verdadero, sigfica que esta una sesion iniciada.
			//session_start();
			
			if (empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/Login');
			}

			// Ejecuta el constructor padre (desde donde se hereda.)
			// Para que la clase de instancie y ejecute la clase de "Modelo"
			
			// "getPermisos(6)" -> Para extraer los permisos que corresponde al modulo en el momento, para este caso es el 5 (Modulos)
			getPermisos(5); // Este el Id que corresponde en la tabla de Modulos; 6 = Modulos
		}
		
		// Mandando información a las Vistas.
		public function Modelos()
		{
			//echo "<br>";
			//echo "Mensaje desde el controlador Home ";
			// Si no tiene el rol de "Lectura" no se podra mostrar la vista de "Modulos".
			if (empty($_SESSION['permisosMod']['r']))
			{
				header('Location: '.base_url().'/Dashboard');	
			}

			// $this = Es la clase "Home", donde se define.
			// "home" = la vista a mostrar.
			// Esta información se puede obtener desde una base de datos, ya que el Controlador se comunica con el Modelo.			
			$data['page_tag'] = "Modelos";
			$data['page_title'] = "MODELOS <small>Control Responsivas</small>";
			$data['page_name'] = "Modelos";
			$data['page_functions_js'] = "Functions_modelos.js";

			// $this = Es equivalente "Usuarios"
			// Se llama la vista "Categorias"
			$this->views->getView($this,"Modelos",$data);
		}

		// Método para asignar Modelo.
		// Se llama en "Functions_modelos.js", request.open("POST",ajaxUrl,true);
		public function setModelo()
		{
			if ($_SESSION['permisosMod']['w'])
				{
					//dep($_POST); // Obtener el valor de la variable "Global". 
					//dep($_FILES);
					//exit();

					if ($_POST)
					{
						if (empty($_POST['txtDescripcion']))
						{
							$arrResponse = array("estatus" => false, "msg" => 'Datos Incorrectos');
						}
						else
						{
							// Obtener los datos que se estan enviando por Ajax 
							// "strClean" = Esta definida en "Helpers", para limpiar las cadenas.
							$intIdModelo = intval($_POST['idModelo']); // Convertir a Entero.
							$strDescripcion = strClean($_POST['txtDescripcion']);
							$request_modelo = "";

							// Enviando la información al modelo. Este es el enlace de Controller -> Modelo.
							// $request_rol = $this->model->insertModelo($strRol,$strDescripcion);
		
							// Seccion para Crear o Actualizar los Modulos.
							if($intIdModelo == 0)
							{
								// Crear Categoria
								if ($_SESSION['permisosMod']['w'])
								{
									$request_modelo = $this->model->insertModelo($strDescripcion);
									$option = 1;
								}
							}
							else
							{
								// Actualizar Modulo								
								if ($_SESSION['permisosMod']['u'])
								{
									// Actualizando el Modulo.
									$request_modelo = $this->model->updateModelo($intIdModelo,$strDescripcion);
									$option = 2;
								}
							}

							if ($request_modelo > 0)
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
							else if($request_modelo == 'Existe')
							{
								$arrResponse = array('estatus'=>false,'msg'=>'El Modulo Ya Existe');
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

		// Para mostrar los Modulos en pantalla.		
		public function getModelos()
		{
			// Esta condicion se utiliza para que usuarios que no tengan sesion no pueden visualizar los Modulos
			if ($_SESSION['permisosMod']['r'])
			{
				
				$arrData = $this->model->selectModelos(); // Obtiene loss Modulos.
				//dep($arrData);
				//exit;

				// Para colocar en color Verde o Rojo el estatus de la Categoria
				for ($i= 0; $i<count($arrData);$i++)
				{
					$btnView = '';
					$btnEdit = '';
					$btnDelete = '';
				

					if ($_SESSION['permisosMod']['r'])
					{
						$btnView = '<button class="btn btn-info btn-sm btnViewInfo" onClick="fntViewInfo('.$arrData[$i]['id_modelo'].')" title="Ver Modelo"><i class="far fa-eye"></i></button>';
					}

					if ($_SESSION['permisosMod']['u'])
					{
						// this = Significa que se enviara como parámetro todo la etiqueta "botton" 
							$btnEdit = '<button class="btn btn-primary btn-sm btnEditInfo" onClick="fntEditInfo(this,'.$arrData[$i]['id_modelo'].')" title="Editar Modelo"><i class="fas fa-pencil-alt"></i></button>';

					} // if ($_SESSION['permisosMod']['u'])

					// ($_SESSION['userData']['id_persona'] != $arrData[$i][id_persona])
					// Se bloquea al Usuario Super Administrador el boton de Borrar, es decir no se puede eliminarse, se tiene que realizar
					// Con la opcion "Profile"
					if ($_SESSION['permisosMod']['d'])
					{
						$btnDelete = '<button class="btn btn-danger btn-sm btnDelInfo" onClick="fntDelInfo('.$arrData[$i]['id_modelo'].')" title="Eliminar Modelo"><i class="fas fa-trash-alt"></i></button>';

					} // if ($_SESSION['permisosMod']['d'])

					//Son los botones, en la columna de "options".
					// Se agrega el evento "onclick" en la etiqueta "button" para evitar el error de en google de que no carga los eventos.
					$arrData[$i]['options'] = ' <div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';

				} // for ($i= 0; $i<count($arrData);$i++)
				
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);				

			} // if ($_SESSION['permisosMod']['r'])

			die(); // Finaliza el proceso.

		} // Public function getModelos()


		// Obtener un "Modulo"
		// Depende de la definicion del “.htaccess”, que se manden por valores por la URL
		public function getModelo($idModelo)
		{			
			// Validando que no pueda ver los Modelos sin Permisos.
			if ($_SESSION['permisosMod']['r'])
			{				
				$intIdModelo = intval($idModelo); // Convertilo a Entero, si tuviera letras la conveirte a 0.

				//dep($intIdrol);
				//die;

				// Si existe el idcategoria
				if ($intIdModelo > 0)
				{
					$arrData = $this->model->selectModelo($intIdModelo); // Extraer el Modulo
					//dep ($arrData);
					//exit;


					if (empty($arrData)) // No existe el Modulo
					{
						$arrResponse = array('estatus'=>false,'msg'=>'Dato no encontrados');
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

		// Método para borrar el Modelo.
		public function delModelo()
		{
			// Esta variable superglobal se genero en "Functions_modelos.js", seccion "fntDelModelo"
			if ($_POST)
			{
				if ($_SESSION['permisosMod']['d'])
				{
					$intIdModelo = intval($_POST['idModelo']);

					// Este objeto se define en el Modelo "Modelo".
					$requestDelete = $this->model->deleteModelo($intIdModelo);

					if($requestDelete == "ok")
					{
						$arrResponse = array('estatus'=> true, 'msg' => 'Se ha Eliminado El Modulo');
					}
					else
					{
						$arrResponse = array('estatus'=> false, 'msg' => 'Error Al Eliminar el Modelo');
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);

				} // if ($_SESSION['permisosMod']['d'])

			}
			die();
		}

	} // Class Marcas ...

	?>
