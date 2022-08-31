<?php

	class Categorias extends Controllers
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
			// Para que la clase de instancie y ejecute la clase de "Modelo
			getPermisos(6); // Este el Id que corresponde en la tabla de Modulos; 6 = Categorias
		}
		
		// Mandando información a las Vistas.
		public function Categorias()
		{
			//echo "<br>";
			//echo "Mensaje desde el controlador Home ";
			// Si no tiene el rol de "Lectura" no se podra mostrar la vista de "Usuarios".
			if (empty($_SESSION['permisosMod']['r']))
			{
				header('Location: '.base_url().'/Dashboard');	
			}

			// $this = Es la clase "Home", donde se define.
			// "home" = la vista a mostrar.
			// Esta información se puede obtener desde una base de datos, ya que el Controlador se comunica con el Modelo.			
			$data['page_tag'] = "Categorias";
			$data['page_title'] = "CATEGORIAS <small>Tienda Virtual</small>";
			$data['page_name'] = "Categorias";
			$data['page_functions_js'] = "Functions_categorias.js";

			// $this = Es equivalente "Usuarios"
			// Se llama la vista "Usuarios"
			$this->views->getView($this,"Categorias",$data);
		}

		// Método para asignar Categorias.
		// Se llama en "Functions_categorias.js", request.open("POST",ajaxUrl,true);
		public function setCategoria()
		{
			if ($_SESSION['permisosMod']['w'])
				{
					//dep($_POST); // Obtener el valor de la variable "Global". 
					//dep($_FILES);
					//exit();

					if ($_POST)
					{
						if (empty($_POST['txtNombre']) || empty($_POST['txtDescripcion']) || empty($_POST['listStatus']))
						{
							$arrResponse = array("estatus" => false, "msg" => 'Datos Incorrectos');
						}
						else
						{
							// Obtener los datos que se estan enviando por Ajax 
							// "strClean" = Esta definida en "Helpers", para limpiar las cadenas.
							$intIdcategoria= intval($_POST['idCategoria']); // Convertir a Entero.
							$strCategoria = strClean($_POST['txtNombre']);
							$strDescripcion = strClean($_POST['txtDescripcion']);
							$intStatus = intval($_POST['listStatus']); // Conviertiendola a Entero.

							// Obteniendo los datos de la foto en Categoria
							$foto = $_FILES['foto'];
							$nombre_foto = $foto['name'];
							$type = $foto['type'];
							$url_temp = $foto['tmp_name'];
							//$fecha = date('ymd');
							//$hora = date('Hms');
							$imgPortada = 'portada_categoria.jpg';
							$request_categoria = "";

							if ($nombre_foto != '')
							{
								// md5 = Encripta, para nombre aleatorio para  que no se repita.
								$imgPortada = 'img_'.md5(date('m-d-Y H:m:s')).'.jpg';
							}
							// Enviando la información al modelo. Este es el enlace de Controller -> Modelo.
							// $request_rol = $this->model->insertRol($strRol,$strDescripcion,$intStatus);
		
							// Seccion para Crear o Actualizar los Roles.
							if($intIdcategoria == 0)
							{
								// Crear Categoria
								if ($_SESSION['permisosMod']['w'])
								{
									$request_categoria = $this->model->insertCategoria($strCategoria,$strDescripcion,$imgPortada,$intStatus);
									$option = 1;
								}
							}
							else
							{
								// Actualizar Categoria
								// Validar cuando no se actualiza la foto.
								// Crear Categoria
								if ($_SESSION['permisosMod']['u'])
								{
									if ($nombre_foto == '')
									{
										if (($_POST['foto_actual'] != 'portada_categoria.png') && ($_POST['foto_remove'] == 0))
										{
											$imgPortada = $_POST['foto_actual'];
										}
									}
									$request_categoria = $this->model->updateCategoria($intIdcategoria,$strCategoria,$strDescripcion,$imgPortada,$intStatus);
									$option = 2;
								}
							}

							if ($request_categoria > 0)
							{
								if ($option == 1)
								{
									$arrResponse = array('estatus' => true, 'msg' => 'Datos Guardados Correctamente');					
									// Grabar la foto en el servidor.
									if ($nombre_foto != '')
									{
										uploadImage($foto,$imgPortada);
									}
								}
								else
								{
									$arrResponse = array('estatus' => true, 'msg' => 'Datos Actualizados Correctamente');					
									// Grabar la foto en el servidor.
									if ($nombre_foto != '')
									{
										uploadImage($foto,$imgPortada);
									}
									if (($nombre_foto == '' && $_POST['foto_remove'] == 1 && $_POST['foto_actual'] != 'portada_categoria.png') || ($nombre_foto == '' && $_POST['foto_actual'] != 'portada_categoria.png'))
									{
										deleteFile($_POST['foto_actual']); // Se crea la funcion en el "Helpers.php"
									}
								}				
		
							}
							else if($request_categoria == 'Existe')
							{
								$arrResponse = array('estatus'=>false,'msg'=>'La Categoria Ya Existe');
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
		public function getCategorias()
		{
			// Esta condicion se utiliza para que usuarios que no tengan sesion no pueden visualizar las Categorias.
			if ($_SESSION['permisosMod']['r'])
			{
				
				$arrData = $this->model->selectCategorias();
				//dep($arrData);
				//exit;

				// Para colocar en color Verde o Rojo el estatus del Usuario
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
						$btnView = '<button class="btn btn-info btn-sm btnViewInfo" onClick="fntViewInfo('.$arrData[$i]['id_categoria'].')" title="Ver Categoria"><i class="far fa-eye"></i></button>';
					}

					if ($_SESSION['permisosMod']['u'])
					{
						// this = Significa que se enviara como parámetro todo la etiqueta "botton" 
							$btnEdit = '<button class="btn btn-primary btn-sm btnEditInfo" onClick="fntEditInfo(this,'.$arrData[$i]['id_categoria'].')" title="Editar Categoria"><i class="fas fa-pencil-alt"></i></button>';

					} // if ($_SESSION['permisosMod']['u'])

					// ($_SESSION['userData']['id_persona'] != $arrData[$i][id_persona])
					// Se bloquea al Usuario Super Administrador el boton de Borrar, es decir no se puede eliminarse, se tiene que realizar
					// Con la opcion "Profile"
					if ($_SESSION['permisosMod']['d'])
					{
						$btnDelete = '<button class="btn btn-danger btn-sm btnDelInfo" onClick="fntDelInfo('.$arrData[$i]['id_categoria'].')" title="Eliminar Categoria"><i class="fas fa-trash-alt"></i></button>';

					} // if ($_SESSION['permisosMod']['d'])

					//Son los botones, en la columna de "options".
					// Se agrega el evento "onclick" en la etiqueta "button" para evitar el error de en google de que no carga los eventos.
					$arrData[$i]['options'] = ' <div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';

				} // for ($i= 0; $i<count($arrData);$i++)
				
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);				

			} // if ($_SESSION['permisosMod']['r'])

			die(); // Finaliza el proceso.

		} // Public function getCategorias()


		// Obtener una "Categoria"
		// Depende de la definicion del “.htaccess”, que se manden por valores por la URL
		public function getCategoria($idcategoria)
		{			
			// Validando que no pueda ver las Categorias, sin Permisos.
			if ($_SESSION['permisosMod']['r'])
			{				
				$intIdcategoria = intval($idcategoria); // Convertilo a Entero, si tuviera letras la conveirte a 0.

				//dep($intIdrol);
				//die;

				// Si existe el idcategoria
				if ($intIdcategoria > 0)
				{
					$arrData = $this->model->selectCategoria($intIdcategoria); // Extraer la Categoria
					//dep ($arrData);
					//exit;


					if (empty($arrData)) // No existe Rol
					{
						$arrResponse = array('estatus'=>false,'msg'=>'Datos no encontrados');
					}
					else
					{
						// Obtener la URL de la ubicación del archivo.
						$arrData['url_portada'] = media().'/images/uploads/'.$arrData['portada'];
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


		// Método para borrar la Categoria.
		public function delCategoria()
		{
			// Esta variable superglobal se genero en "Functions_roles.js", seccion "fntDelCategoria"
			if ($_POST)
			{
				if ($_SESSION['permisosMod']['d'])
				{
					$intIdcategoria = intval($_POST['idCategoria']);

					// Este objeto se define en el Modleo "Rol".
					$requestDelete = $this->model->deleteCategoria($intIdcategoria);

					if($requestDelete == "ok")
					{
						$arrResponse = array('estatus'=> true, 'msg' => 'Se ha Eliminado La Categoria');
					}
					else if ($requestDelete == "existe")
					{
						$arrResponse = array('estatus'=> false, 'msg' => 'No es posible eliminar una Categoria con productos Asociados');			
					}
					else
					{
						$arrResponse = array('estatus'=> false, 'msg' => 'Error Al Eliminar la Categoria');
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);

				} // if ($_SESSION['permisosMod']['d'])

			}
			die();
		}


	} // Class Categorias ...

	?>
