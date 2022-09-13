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
			getPermisos(4); // Este el Id que corresponde en la tabla de Modulos; 4 = Productos
		}
		
		// Mandando información a las Vistas.
		public function Productos()
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
			$data['page_tag'] = "Productos";
			$data['page_title'] = "PRODUCTOS <small>Tienda Virtual</small>";
			$data['page_name'] = "Productos";
			$data['page_functions_js'] = "Functions_productos.js";

			// $this = Es equivalente "Usuarios"
			// Se llama la vista "Usuarios"
			$this->views->getView($this,"Productos",$data);
		}

		// Para mostrar los Productos en pantalla.
		// Obtiene los "Productos" 
		public function getProductos()
		{
			// Esta condicion se utiliza para que usuarios que no tengan sesion no pueden visualizar las Categorias.
			if ($_SESSION['permisosMod']['r'])
			{				
				$arrData = $this->model->selectProductos();
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
						$btnDelete = '<button class="btn btn-danger btn-sm btnDelInfo" onClick="fntDelInfo('.$arrData[$i]['id_producto'].')" title="Eliminar Producto"><i class="fas fa-trash-alt"></i></button>';

					} // if ($_SESSION['permisosMod']['d'])

					//Son los botones, en la columna de "options".
					// Se agrega el evento "onclick" en la etiqueta "button" para evitar el error de en google de que no carga los eventos.
					$arrData[$i]['options'] = ' <div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';

				} // for ($i= 0; $i<count($arrData);$i++)
				
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);				
				die(); // Finaliza el proceso.

			} // if ($_SESSION['permisosMod']['r'])

		} // Public function getProductos()

	} //class Productos extends Controllers

?>
