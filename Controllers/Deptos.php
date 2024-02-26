<?php

	class Deptos extends Controllers
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
			getPermisos(12); // Este el Id que corresponde en la tabla de Modulos; 12 = Deptos
		}
		
		// Mandando información a las Vistas.
		public function Deptos()
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
			$data['page_tag'] = "Departamentos";
			$data['page_title'] = "DEPARTAMENTOS <small>Control Responsivas</small>";
			$data['page_name'] = "Departamentos";
			$data['page_functions_js'] = "Functions_deptos.js";

			// $this = Es equivalente "Usuarios"
			// Se llama la vista "Categorias"
			$this->views->getView($this,"Deptos",$data);
		}

		// Método para asignar Deptos.
		// Se llama en "Functions_deptos.js", request.open("POST",ajaxUrl,true);
		public function setDepto()
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
							$intIddepto= intval($_POST['idDepto']); // Convertir a Entero.							
							// clear_cadena = Es una funcion que se crea para quitar los acentos en los nombres de los productos.							
							$strDescripcion = strClean($_POST['txtDescripcion']);
		
							// Seccion para Crear o Actualizar los Departamentos.
							if($intIddepto == 0)
							{
								// Crear Depto
								if ($_SESSION['permisosMod']['w'])
								{
									$request_depto = $this->model->insertDepto($strDescripcion);
									$option = 1;
								}
							}
							else
							{
								// Actualizar Depto
								// Validar cuando no se actualiza la foto.
								
								if ($_SESSION['permisosMod']['u'])
								{
									// Actualizando un Depto.
									$request_depto = $this->model->updateDepto($intIddepto,$strDescripcion);
									$option = 2;
								}
							}

							if ($request_depto > 0)
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
								$arrResponse = array('estatus'=>false,'msg'=>'La Descripcion Ya Existe');
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

		// Para mostrar las Categorias en pantalla.
		// Obteniene las "Categorias" 
		public function getDeptos()
		{
			// Esta condicion se utiliza para que usuarios que no tengan sesion no pueden visualizar los Deptos..
			if ($_SESSION['permisosMod']['r'])
			{
				
				$arrData = $this->model->selectDeptos(); // Obtiene los Deptos.
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
						$btnView = '<button class="btn btn-info btn-sm btnViewInfo" onClick="fntViewInfo('.$arrData[$i]['id_depto'].')" title="Ver Deptos"><i class="far fa-eye"></i></button>';
					}

					if ($_SESSION['permisosMod']['u'])
					{
						// this = Significa que se enviara como parámetro todo la etiqueta "botton" 
							$btnEdit = '<button class="btn btn-primary btn-sm btnEditInfo" onClick="fntEditInfo(this,'.$arrData[$i]['id_depto'].')" title="Editar Depto"><i class="fas fa-pencil-alt"></i></button>';

					} // if ($_SESSION['permisosMod']['u'])

					// ($_SESSION['userData']['id_persona'] != $arrData[$i][id_persona])
					// Se bloquea al Usuario Super Administrador el boton de Borrar, es decir no se puede eliminarse, se tiene que realizar
					// Con la opcion "Profile"
					if ($_SESSION['permisosMod']['d'])
					{
						$btnDelete = '<button class="btn btn-danger btn-sm btnDelInfo" onClick="fntDelInfo('.$arrData[$i]['id_depto'].')" title="Eliminar Depto"><i class="fas fa-trash-alt"></i></button>';

					} // if ($_SESSION['permisosMod']['d'])

					//Son los botones, en la columna de "options".
					// Se agrega el evento "onclick" en la etiqueta "button" para evitar el error de en google de que no carga los eventos.
					$arrData[$i]['options'] = ' <div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';

				} // for ($i= 0; $i<count($arrData);$i++)
				
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);				

			} // if ($_SESSION['permisosMod']['r'])

			die(); // Finaliza el proceso.

		} // Public function getDeptos()


		// Obtener un "Departamento"
		// Depende de la definicion del “.htaccess”, que se manden por valores por la URL
		public function getDepto($idDepto)
		{			
			// Validando que no pueda ver las Categorias, sin Permisos.
			if ($_SESSION['permisosMod']['r'])
			{				
				$intIdDepto = intval($idDepto); // Convertilo a Entero, si tuviera letras la conveirte a 0.

				//dep($intIdrol);
				//die;

				// Si existe el idcategoria
				if ($intIdDepto > 0)
				{
					$arrData = $this->model->selectDepto($intIdDepto); // Extraer un Departamento
					//dep ($arrData);
					//exit;
					if (empty($arrData)) // No existe el Departamento
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


		// Método para borrar el Departamento.
		public function delDepto()
		{
			// Esta variable superglobal se genero en "Functions_depto.js", seccion "fntDelDepto"
			if ($_POST)
			{
				if ($_SESSION['permisosMod']['d'])
				{
					// Este valor se definio en "Functions_depto.js"
					// let strData = "idDepto="+idDepto;
					//request.open("POST",ajaxDelDepto,true);
					$intIdDepto = intval($_POST['idDepto']); 

					// Este objeto se define en el Modleo "Rol".
					$requestDelete = $this->model->deleteDepto($intIdDepto);

					if($requestDelete == "ok")
					{
						$arrResponse = array('estatus'=> true, 'msg' => 'Se ha Eliminado El Departamento');
					}
					else if ($requestDelete == "existe")
					{
						$arrResponse = array('estatus'=> false, 'msg' => 'No es posible eliminar un Departamento con productos Asociados');			
					}
					else
					{
						$arrResponse = array('estatus'=> false, 'msg' => 'Error Al Eliminar el Departamento');
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);

				} // if ($_SESSION['permisosMod']['d'])

			}
			die();
		}

		// Obtiene las categorias para el combo de la pantalla de captura de los productos,
		// El que utiliza una funcion de Jquery "selectpicker", esta funcion se llama en "fntCategorias" en "Functions_productos.js"
		public function getSelectCategorias()
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
