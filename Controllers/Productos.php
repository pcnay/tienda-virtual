<?php
	class Productos extends Controllers
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
			getPermisos(6); // Este el Id que corresponde en la tabla de Productos; 4 = Productos
		}
		
		// Mandando información a las Vistas.
		public function Productos()
		{
			//echo "<br>";
			//echo "Mensaje desde el controlador Home ";
			// Si no tiene el rol de "Lectura" no se podra mostrar la vista de "Productos".
			if (empty($_SESSION['permisosMod']['r']))
			{
				header('Location: '.base_url().'/Dashboard');	
			}

			// $this = Es la clase "Home", donde se define.
			// "home" = la vista a mostrar.
			// Esta información se puede obtener desde una base de datos, ya que el Controlador se comunica con el Modelo.			
			$data['page_tag'] = "Productos";
			$data['page_title'] = "PRODUCTOS <small>Tienda Virtual</small>";
			$data['page_name'] = "Productos";
			$data['page_functions_js'] = "Functions_productos.js";

			// $this = Es equivalente "Usuarios"
			// Se llama la vista "Usuarios"
			$this->views->getView($this,"Productos",$data);

		} // public function Productos()

		// Para mostrar los Productos en pantalla.
		// Obtiene los "Productos" 
		public function getProductos()
		{
			// Esta condicion se utiliza para que usuarios que no tengan sesion no pueden visualizar los Productos.
//			if ($_SESSION['permisosMod']['r'])
//			{				
				$arrData = $this->model->selectProductos();
				//dep($arrData);
				//die();
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

					$arrData[$i]['precio'] = MONEY.' '.formatMoney($arrData[$i]['precio']);
					

					if ($_SESSION['permisosMod']['r'])
					{
						$btnView = '<button class="btn btn-info btn-sm btnViewInfo" onClick="fntViewInfo('.$arrData[$i]['id_producto'].')" title="Ver Producto"><i class="far fa-eye"></i></button>';
					}

					if ($_SESSION['permisosMod']['u'])
					{
						// this = Significa que se enviara como parámetro todo la etiqueta "botton" 
							$btnEdit = '<button class="btn btn-primary btn-sm btnEditInfo" onClick="fntEditInfo(this,'.$arrData[$i]['id_producto'].')" title="Editar Producto"><i class="fas fa-pencil-alt"></i></button>';

					} // if ($_SESSION['permisosMod']['u'])

					// ($_SESSION['userData']['id_persona'] != $arrData[$i][id_persona])
					// Se bloquea al Usuario Super Administrador el boton de Borrar, es decir no se puede eliminarse, se tiene que realizar
					// Con la opcion "Profile"
					if ($_SESSION['permisosMod']['d'])
					{
						$btnDelete = '<button class="btn btn-danger btn-sm btnDelInfo" onClick="fntDelProd('.$arrData[$i]['id_producto'].')" title="Eliminar Producto"><i class="fas fa-trash-alt"></i></button>';

					} // if ($_SESSION['permisosMod']['d'])

					//Son los botones, en la columna de "options".
					// Se agrega el evento "onclick" en la etiqueta "button" para evitar el error de en google de que no carga los eventos.
					$arrData[$i]['options'] = ' <div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';

				} // for ($i= 0; $i<count($arrData);$i++)
				
				// Devuelve en formato JSon al archivo "Funcions_productos.js"
				//dep($arrData);
				//die();exit;
				// Devuelve en formato JSon al archivo "Funcions_productos.js"
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);				
				die(); // Finaliza el proceso.

//			} // if ($_SESSION['permisosMod']['r'])

		} // Public function getProductos()

		// Grabar la imagen en la tabla 
		public function setImage()
		{
			//dep($_POST);
			//dep($_FILES);	
			//die();
			//exit;		
			//$arrrespose = array('estatus' => true,'imgname' => "img_65wqwqaasa.jpg");
			//echo json_encode ($arrrespose,JSON_UNESCAPED_UNICODE);
			//die();

			if($_POST)
			{
				if (empty($_POST['idproducto']))
				{
					$arrResponse = array('estatus' => false, 'msg' => 'Error De Carga No existe Id Producto');					
				}
				else
				{
					$idProducto = intval($_POST['idproducto']);
					//$idProducto = 7;
					$foto = $_FILES['foto']; // Accesa a todos los elementos de la imagen.
					$imgNombre = 'pro_'.md5(date('d-m-Y H:m:s')).'.jpg'; // Asigna el nombre a la Imágen
					$request_image = $this->model->insertImage($idProducto,$imgNombre); // Graba la imagen en el modelo.
					
					if ($request_image)
					{
						$uploadImage = uploadImage($foto,$imgNombre);
						$arrResponse = array('estatus' => true, 'imgname' => $imgNombre, 'msg' => 'Archivo cargado ');
					}
					else
					{
						$arrResponse = array('estatus' => false, 'msg' => 'Error De Carga Imagen ');
					} // if ($request_image)					
					
				} //if (empty($_POST['idproducto']))
				
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				die();

			} //	if($_POST)

			//exit();
			
		} // public function setImage()

		// Se define la funcion para llamar el método que graba información.
		// Método para asignar Categorias.
		// Se llama en "Functions_categorias.js", request.open("POST",ajaxUrl,true);
		public function setProducto()
		{
			if ($_SESSION['permisosMod']['w'])
				{
					//dep($_POST); // Obtener el valor de la variable "Global". 					
					//die();
					//exit();

					if ($_POST)
					{
						//dep($_POST); // Obtener el valor de la variable "Global". 					
						//die();
						//exit();

						if (empty($_POST['txtNombre']) || empty($_POST['txtCodigo']) || empty($_POST['listCategoria']) || empty($_POST['txtPrecio']) || empty($_POST['listStatus']))
						{
							$arrResponse = array("estatus" => false, "msg" => 'Datos Incorrectos');
						}
						else
						{
							// Obtener los datos que se estan enviando por Ajax 
							// "strClean" = Esta definida en "Helpers", para limpiar las cadenas.
							$idProducto= intval($_POST['idProducto']); // Convertir a Entero, si esta vacia la convierte 0
							$strNombre = strClean($_POST['txtNombre']);
							$strDescripcion = strClean($_POST['txtDescripcion']);
							$strCodigo  = strClean($_POST['txtCodigo']);
							$intCategoriaId  = intval($_POST['listCategoria']);
							$intPrecio  = strClean($_POST['txtPrecio']);
							$intStock  = intval($_POST['txtStock']);
							$intStatus = intval($_POST['listStatus']); // Conviertiendola a Entero.
							$request_producto = "";

							if ($idProducto == 0) // Es un nuevo producto
							{
								$option = 1;
								// $request_producto = Es el ID que retorna cuando se inserta en la base de datos.
								if ($_SESSION['permisosMod']['w'])
								{
									$request_producto = $this->model->insertProducto($strNombre,$strDescripcion,$strCodigo,$intCategoriaId,$intPrecio,$intStock,$intStatus);
								}
							}
							else // Actualizar
							{
								$option = 2;
								if ($_SESSION['permisosMod']['u'])
								{
									$request_producto = $this->model->updateProducto($idProducto,$strNombre,$strDescripcion,$strCodigo,$intCategoriaId,$intPrecio,$intStock,$intStatus);
								}

							}
							//dep($request_producto);
							//die();exit;
							
							// Si se inserto un registro 
							if ($request_producto > 0)
							{
								if ($option == 1) // Se inserto un registro.
								{
									$arrResponse = array('estatus'=> true, 'id_producto'=> $request_producto, 'msg'=> 'Datos Guardados Correctamente');
								} // if ($option == 1)
								else
								{									
									// Seccion para actualizar el Producto.
									$arrResponse = array('estatus'=> true, 'id_producto'=> $idProducto, 'msg'=> 'Datos Actualizados Correctamente');
								} //if ($option == 1)

							} // if ($request_producto > 0)
							else if ($request_producto == 'exist')
							{
								$arrResponse = array('estatus'=> false, 'msg'=>'Atencion! Ya Existe El Producto');
							}
							else
							{
								$arrResponse = array('estatus'=> false, 'msg'=>'NO es posible Almacenar el Reg.');
							}							

						} // if (empty($_POST['txtNombre']) || empty($_POST[

						// Corrige los datos de caracteres raros.
						// Esta información es enviada a "Functions_producto.js"
						echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);

					} // 	if ($_POST)					

					die(); // Finaliza el proceso.

				} // if ($_SESSION['permisosMod']['w'])
				
		} // public function setProducto()

	} // class Categorias extends Controllers
?>