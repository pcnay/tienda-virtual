<?php

	class Marcas extends Controllers
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
			getPermisos(11); // Este el Id que corresponde en la tabla de Modulos; 11 = Marcas
		}
		
		// Mandando información a las Vistas.
		public function Marcas()
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
			$data['page_tag'] = "Marcas";
			$data['page_title'] = "MARCAS <small>Control Responsivas</small>";
			$data['page_name'] = "Marcas";
			$data['page_functions_js'] = "Functions_marcas.js";

			// $this = Es equivalente "Usuarios"
			// Se llama la vista "Categorias"
			$this->views->getView($this,"Marcas",$data);
		}

		// Método para asignar Marca.
		// Se llama en "Functions_marcas.js", request.open("POST",ajaxUrl,true);
		public function setMarca()
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
							$intIdMarca = intval($_POST['idMarca']); // Convertir a Entero.
							$strDescripcion = strClean($_POST['txtDescripcion']);
							$request_marca = "";

							// Enviando la información al modelo. Este es el enlace de Controller -> Marca.
							// $request_rol = $this->marca->insertMarca($intIdMarca,$strDescripcion);
		
							// Seccion para Crear o Actualizar los Modulos.
							if($intIdMarca == 0)
							{
								// Crear Categoria
								if ($_SESSION['permisosMod']['w'])
								{
									$request_marca = $this->model->insertMarca($strDescripcion);
									$option = 1;
								}
							}
							else
							{
								// Actualizar Marca								
								if ($_SESSION['permisosMod']['u'])
								{
									// Actualizando una Marca.
									$request_marca = $this->model->updateMarca($intIdMarca,$strDescripcion);
									$option = 2;
								}
							}

							if ($request_marca > 0)
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
								$arrResponse = array('estatus'=>false,'msg'=>'La Marca Ya Existe');
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

		// Para mostrar los Marcas en pantalla.		
		public function getMarcas()
		{
			// Esta condicion se utiliza para que usuarios que no tengan sesion no pueden visualizar los Marcas
			if ($_SESSION['permisosMod']['r'])
			{
				
				$arrData = $this->model->selectMarcas(); // Obtiene las Marcas.
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
						$btnView = '<button class="btn btn-info btn-sm btnViewInfo" onClick="fntViewInfo('.$arrData[$i]['id_marca'].')" title="Ver Marca"><i class="far fa-eye"></i></button>';
					}

					if ($_SESSION['permisosMod']['u'])
					{
						// this = Significa que se enviara como parámetro todo la etiqueta "botton" 
							$btnEdit = '<button class="btn btn-primary btn-sm btnEditInfo" onClick="fntEditInfo(this,'.$arrData[$i]['id_marca'].')" title="Editar Marca"><i class="fas fa-pencil-alt"></i></button>';

					} // if ($_SESSION['permisosMod']['u'])

					// ($_SESSION['userData']['id_persona'] != $arrData[$i][id_persona])
					// Se bloquea al Usuario Super Administrador el boton de Borrar, es decir no se puede eliminarse, se tiene que realizar
					// Con la opcion "Profile"
					if ($_SESSION['permisosMod']['d'])
					{
						$btnDelete = '<button class="btn btn-danger btn-sm btnDelInfo" onClick="fntDelInfo('.$arrData[$i]['id_marca'].')" title="Eliminar Marca"><i class="fas fa-trash-alt"></i></button>';

					} // if ($_SESSION['permisosMod']['d'])

					//Son los botones, en la columna de "options".
					// Se agrega el evento "onclick" en la etiqueta "button" para evitar el error de en google de que no carga los eventos.
					$arrData[$i]['options'] = ' <div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';

				} // for ($i= 0; $i<count($arrData);$i++)
				
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);				

			} // if ($_SESSION['permisosMod']['r'])

			die(); // Finaliza el proceso.

		} // Public function getMarcas()


		// Obtener una "Marca"
		// Depende de la definicion del “.htaccess”, que se manden por valores por la URL
		public function getMarca($idMarca)
		{			
			// Validando que no pueda ver los Marcas sin Permisos.
			if ($_SESSION['permisosMod']['r'])
			{				
				$intIdMarca = intval($idMarca); // Convertilo a Entero, si tuviera letras la conveirte a 0.

				//dep($intIdrol);
				//die;

				// Si existe el idmarca
				if ($intIdMarca > 0)
				{
					$arrData = $this->model->selectMarca($intIdMarca); // Extraer una Marca
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

		// Método para borrar la Marca.
		public function delMarca()
		{
			// Esta variable superglobal se genero en "Functions_marcas.js", seccion "fntDelMarca"
			if ($_POST)
			{
				if ($_SESSION['permisosMod']['d'])
				{
					$intIdMarca = intval($_POST['idMarca']);

					// Este objeto se define en el Modelo.
					$requestDelete = $this->model->deleteMarca($intIdMarca);

					if($requestDelete == "ok")
					{
						$arrResponse = array('estatus'=> true, 'msg' => 'Se ha Eliminado La Marca');
					}
					else
					{
						$arrResponse = array('estatus'=> false, 'msg' => 'Error Al Eliminar la Marca');
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);

				} // if ($_SESSION['permisosMod']['d'])

			}
			die();
		}

	} // Class Marcas ...

	?>
