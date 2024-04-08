<?php

	class Notas extends Controllers
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
			
			// "getPermisos(6)" -> Para extraer los permisos que corresponde al modulo en el momento, para este caso es el 10 (Notas)
			getPermisos(10); // Este el Id que corresponde en la tabla de Modulos; 10 = Notas
		}
		
		// Mandando información a las Vistas.
		public function Notas()
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
			$data['page_tag'] = "Notas";
			$data['page_title'] = "NOTAS <small>Control Responsivas</small>";
			$data['page_name'] = "Notas";
			$data['page_functions_js'] = "Functions_notas.js";

			// $this = Es equivalente "Notas"
			// Se llama la vista "Notas"
			$this->views->getView($this,"Notas",$data);
		}

		// Método para asignar Notas.
		// Se llama en "Functions_notas.js", request.open("POST",ajaxUrl,true);
		public function setNota()
		{
			if ($_SESSION['permisosMod']['w'])
				{
					//dep($_POST); // Obtener el valor de la variable "Global". 
					//dep($_FILES);
					//die();
					//exit();

					if ($_POST)
					{
						if (empty($_POST['txtTitulo']) || empty($_POST['txtDescripcion']) || empty($_POST['txtDuracion']) || empty($_POST['listStatus']) || empty($_POST['listPersonas']) || empty($_POST['txtFecha_Nota']))
						{
							$arrResponse = array("estatus" => false, "msg" => 'Datos Incorrectos');
						}
						else
						{
							// Obtener los datos que se estan enviando por Ajax 
							// "strClean" = Esta definida en "Helpers", para limpiar las cadenas.
							$intIdnota = intval($_POST['idNota']); // Convertir a Entero, como no se envia la convierte a "0"
							$strTitulo = strClean($_POST['txtTitulo']);
							$strDescripcion = strClean($_POST['txtDescripcion']);
							$intStatus = intval($_POST['listStatus']); // Conviertiendola a Entero.
							$intDuracion = intval($_POST['txtDuracion']); // Conviertiendola a Entero.
							// Para poder grabarlo a la tabla de la base de datos.
							$strFecha_Nota = date("Y-m-d",strtotime($_POST['txtFecha_Nota'])); 							 
							$intlistPersona = intval($_POST['listPersonas']); // Conviertiendola a Entero.
							$intId_Persona = intval($_SESSION['idUser']); // ID del usuario que inicia la sesion.
														
							// Seccion para Crear o Actualizar los Roles.
							$request_nota = Null;

							if($intIdnota == 0)
							{
								// Crear Nota
								if ($_SESSION['permisosMod']['w'])
								{									
									$request_nota = $this->model->insertNota($intId_Persona,$strTitulo,$strDescripcion,$intStatus,$intDuracion,$strFecha_Nota,$intlistPersona);
									$option = 1;
								}
							}
							else
							{
								// Actualizar Producto							
								if ($_SESSION['permisosMod']['u'])
								{
									$option = 2;
									// Actualizando la Categoria.
									$request_nota = $this->model->updateNota($intIdnota,$strTitulo,$strDescripcion,$intStatus,$intDuracion,$strFecha_Nota,$intlistPersona);									
								}
							}

							//dep($request_nota);
							//die();
							//exit();

							if ($request_nota > 0)
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
							else if($request_nota == 'Existe')
							{
								$arrResponse = array('estatus'=>false,'msg'=>'La Nota Ya Existe');
							}
							else
							{
								$arrResponse = array('estatus'=>false,'msg'=>'NO es posible almacenar los datos');
							}

						} // if (empty($_POST['txtNombre']) || empty($_POST[

						// Corrige los datos de caracteres raros.
						// Esta información es enviada a "Functions_notas.js"
						echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);

					} // 	if ($_POST)					

					die(); // Finaliza el proceso.

				} // if ($_SESSION['permisosMod']['w'])
		}

		// Para mostrar las Notas en pantalla.
		// Obteniene las "Notas" 
		public function getNotas()
		{
			// Esta condicion se utiliza para que usuarios que no tengan sesion no pueden visualizar las Notas.
			if ($_SESSION['permisosMod']['r'])
			{
				
				$arrData = $this->model->selectNotas(); // Obtiene las Notas.
				//dep($arrData);
				//exit;

				// Para colocar en color Verde o Rojo el estatus de la Categoria
				for ($i= 0; $i<count($arrData);$i++)
				{
					$btnView = '';
					$btnEdit = '';
					$btnDelete = '';

					// Cambiando el valor del "Estatus" a Colores
					if ($arrData[$i]['estatus'] == 1)
					{
						$arrData[$i]['estatus'] = '<span class="badge badge-success">Activo</span>';
					}
					else
					{
						$arrData[$i]['estatus'] = '<span class="badge badge-danger">Inactivo</span>';
					}
					

					if ($_SESSION['permisosMod']['r'])
					{
						$btnView = '<button class="btn btn-info btn-sm btnViewInfo" onClick="fntViewInfo('.$arrData[$i]['id_nota'].')" title="Ver Nota"><i class="far fa-eye"></i></button>';
					}

					if ($_SESSION['permisosMod']['u'])
					{
						// this = Significa que se enviara como parámetro todo la etiqueta "botton" 
							$btnEdit = '<button class="btn btn-primary btn-sm btnEditInfo" onClick="fntEditInfo(this,'.$arrData[$i]['id_nota'].')" title="Editar Nota"><i class="fas fa-pencil-alt"></i></button>';

					} // if ($_SESSION['permisosMod']['u'])

					// ($_SESSION['userData']['id_persona'] != $arrData[$i][id_persona])
					// Se bloquea al Usuario Super Administrador el boton de Borrar, es decir no se puede eliminarse, se tiene que realizar
					// Con la opcion "Profile"
					if ($_SESSION['permisosMod']['d'])
					{
						$btnDelete = '<button class="btn btn-danger btn-sm btnDelInfo" onClick="fntDelInfo('.$arrData[$i]['id_nota'].')" title="Eliminar Nota"><i class="fas fa-trash-alt"></i></button>';

					} // if ($_SESSION['permisosMod']['d'])

					//Son los botones, en la columna de "options".
					// Se agrega el evento "onclick" en la etiqueta "button" para evitar el error de en google de que no carga los eventos.
					$arrData[$i]['options'] = ' <div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';

				} // for ($i= 0; $i<count($arrData);$i++)
				
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);				

			} // if ($_SESSION['permisosMod']['r'])
			else
			{
				$arrData = array();		
				$arrData = Null;
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}

			die(); // Finaliza el proceso.

		} // Public function getNotas()


		// Obtener una "Nota"
		// Depende de la definicion del “.htaccess”, que se manden por valores por la URL
		public function getNota($idNota)
		{			
			// Validando que no pueda ver las Notas, sin Permisos.
			if ($_SESSION['permisosMod']['r'])
			{				
				$intIdnota = intval($idNota); // Convertilo a Entero, si tuviera letras la conveirte a 0.

				//dep($intIdrol);
				//die;

				// Si existe el idnota
				if ($intIdnota > 0)
				{
					$arrData = $this->model->selectNota($intIdnota); // Extraer la Nota
					//dep ($arrData);
					//exit;


					if (empty($arrData)) // No existe Categoria
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


		// Método para borrar la Nota.
		public function delNota()
		{
			// Esta variable superglobal se genero en "Functions_roles.js", seccion "fntDelCategoria"
			if ($_POST)
			{
				if ($_SESSION['permisosMod']['d'])
				{
					$intIdNota = intval($_POST['idNota']);

					// Este objeto se define en el Modleo "Rol".
					$requestDelete = $this->model->deleteNota($intIdNota);

					if($requestDelete == "ok")
					{
						$arrResponse = array('estatus'=> true, 'msg' => 'Se ha Eliminado La Nota');
					}
					else if ($requestDelete == "existe")
					{
						$arrResponse = array('estatus'=> false, 'msg' => 'No es posible eliminar la Nota Asociada');			
					}
					else
					{
						$arrResponse = array('estatus'=> false, 'msg' => 'Error Al Eliminar La Nota');
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);

				} // if ($_SESSION['permisosMod']['d'])

			}
			die();
		}

		// Obtiene las categorias para el combo de la pantalla de captura de los productos,
		// El que utiliza una funcion de Jquery "selectpicker", esta funcion se llama en "fntCategorias" en "Functions_productos.js"
		public function getSelectNotas()
		{
			$htmlOptions = "";
			$arrData = $this->model->selectCategorias(); // Extraer todas las Categorias, desde la tabla t_Categorias
			if (count($arrData) > 0)
			{
				for ($i=0; $i<count($arrData); $i++)
				{
					if ($arrData[$i]['estatus'] == 1) // Muestra que esten activas las "Categorias"
					{
						//$htmlOptions .= '<option value = "'.$arrData[$i]['id_categoria'].'">'.$arrData[$i]['nombre'].'</option>';
						// Se arma el "Select"
						$htmlOptions .= "<option value = '".$arrData[$i]['id_categoria']."'>".$arrData[$i]['nombre']."</option>";
					}
				}
			} // if (count($arrData) > 0)
			
			echo $htmlOptions;
			die();

		}

	} // Class Categorias ...

	?>
