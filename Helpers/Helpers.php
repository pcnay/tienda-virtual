<?php
	//
	function base_url()
	{
		return BASE_URL;		
	}

	// Retorna la url de Assets
	function media()
	{
		return BASE_URL."/Assets";
	}
	
	// Este arreglo "data" viene desde el "Controllers".
	function headerAdmin($data="")
	{
		$view_header = "Views/Template/Header_admin.php";
		require_once ($view_header);		
	}
	function footerAdmin($data="")
	{
		$view_footer = "Views/Template/Footer_admin.php";
		require_once ($view_footer);		
	}

	// Este arreglo "data" viene desde el "Controllers".
	// Son los Encabezados y pie de página de la sección de Tienda Virtual
	function headerTienda($data="")
	{
		$view_header = "Views/Template/Header_tienda.php";
		require_once ($view_header);		
	}
	function footerTienda($data="")
	{
		$view_footer = "Views/Template/Footer_tienda.php";
		require_once ($view_footer);		
	}
	

	// Para formatear los datos de salida de los arreglos 
	function dep($data)
	{
		$format = print_r ('<pre>');
		$format .= print_r ($data);
		$format = print_r ('</pre>');
		return $format;
	}
	//  Se va a utilizar cada vez que se requiere Mostrar un Modal
	function getModal(string $nameModal,$data)
	{
		$view_modal = "Views/Template/Modals/{$nameModal}.php";
		require_once $view_modal;
	}
	
	// Envio de correos.
	// NO funciona en el servidor de Linux. Retorno "False"
	function sendEmail($data,$template)
	{
		$asunto = $data['asunto'];
		$emailDestino = $data['email'];
		$empresa = NOMBRE_REMITENTE;
		$remitente = EMAIL_REMITENTE;

		// Envio De Correo
		$de = 'MIME-Version: 1.0'."\r\n";
		$de .= 'Content-type: text/html; charset=UTF-8'."\r\n";
		$de .= 'From: {$empresa} <{$remitente}>'."\r\n";
		ob_start(); // Recarga en memoria lo siguiente.
		require_once("Views/Template/Email/".$template.".php");
		$mensaje = ob_get_clean(); // Obtiene el archivo "email_cambioPassword.php"  para poder ser uso de todas las variables.

		/*
		ini_set( 'display_errors', 1 );
    error_reporting( E_ALL );
    $from = "test@hostinger-tutorials.com";
    $to = "test@hostinger.com";
    $subject = "Checking PHP mail";
    $message = "PHP mail works just fine";
    $headers = "From:" . $from;
    mail($to,$subject,$message, $headers);
    echo "The email message was sent.";		
		*/


		// "mail" = Es la funcion que envie los correos.
		$send = mail($emailDestino,$asunto,$mensaje,$de);
		return $send;
	}

	// Obtiene los permsisos.
	function getPermisos(int $idmodulo)	
	{
		require_once("Models/PermisosModel.php");
		$objPermisos = new PermisosModel();
		$idrol = intval($_SESSION['userData']['id_rol']); // ID del usuario que esta logueado.

		// Obtiene los permisos que tiene guardado en la tabla
		$arrPermisos = $objPermisos->permisosModulo($idrol);	
		//$_SESSION['permisos'] = $arrPermisos;

		
		$permisos = 'NO CUMPLIO LA CONDICION';
		$permisosMod = 'NO CUMPLIO LA CONDICION';	

		if (count($arrPermisos) > 0)
		{
			$permisos = $arrPermisos;
			$permisosMod = isset($arrPermisos[$idmodulo])?$arrPermisos[$idmodulo]:"";			
			//$permisosMod = 'Cumple la condicion';
		}

		$_SESSION['permisos'] = $permisos;
		$_SESSION['permisosMod'] = $permisosMod;
	}

	// Obtiene los datos desde las tablas cuando se edita los perfiles del usuario
	// Sin necesida de cerrar la sesion para obtener los datos editados 
	function sessionUser(int $idpersona)
	{
		require_once ("Models/LoginModel.php");
		$objLogin = new LoginModel();
		$request = $objLogin->sessionLogin($idpersona);
		return $request;
	}

	// Se crea la sesion y determina el tiempo que el usuario tendrá la sesion activa del Sistema.
	function sessionStart()
	{
		session_start();
		$inactive = 10800; // Son expresados en Segundos, cuanto permanecera la sesion activo, 3 Hrs; 1 hr = 3600 seg
		if (isset($_SESSION['timeout']))
		{
			$session_in = time() - $_SESSION['inicio']; // Valores en Segundos.
			if ($session_in > $inactive)
			{
				header("Location: ".BASE_URL."/Logout");				
			}			
		}
		else
		{
			header("Location: ".BASE_URL."/Logout");
		}		
	}

	// Funcion para subir la imagen al Servidor.
	function uploadImage(array $data, string $name)
	{
		$url_temp = $data['tmp_name'];
		// Importante que se debe dar los permisos 777 a la carpeta "uploads" de lo contrario
		// muestra error y no la sube al servidor de la ruta "Assetes/images/uploads"
		$destino = 'Assets/images/uploads/'.$name;
		$move = move_uploaded_file($url_temp,$destino); // Esta es una funcion de PHP para guardar la imagen en el Servidor.
		return $move;
	}
	
	//Se utiliza para borar una foto en el servidor
	function deleteFile(string $name)
	{
		$nombreArc = trim(strClean($name));
		//echo $name;
		unlink('/var/www/html/Proyectos/tienda-virtual/Assets/images/uploads/'.$nombreArc);
		
	}

	
	// Elimina exceso de espacios entre palabras.
	function strClean($strCadena)
	{
		$string = preg_replace(['/\s+/','/^\s|\s$/'],[' ',''],$strCadena); // Elimna exceso espacios entre palabras.
		$string = trim($string); // Elimina espacios en blanco al principio y al final.
		$string = stripslashes($string); // Elimina las \ invertidas.
		// Cuando en una etiqueta input tecleen "<script>" lo reemplazara por espacio.
		// Evitar inyecciones SQL.
		$string = str_ireplace("<script>","",$string);
		$string = str_ireplace("</script>","",$string);
		$string = str_ireplace("<script src>","",$string);
		$string = str_ireplace("<script type=>","",$string);
		$string = str_ireplace("SELECT * FROM","",$string);
		$string = str_ireplace("DELETE * FROM","",$string);
		$string = str_ireplace("INSERT INTO","",$string);
		$string = str_ireplace("SELECT COUNT(*) FROM","",$string);
		$string = str_ireplace("DROP TABLE","",$string);
		$string = str_ireplace("OR '1'='1","",$string);
		$string = str_ireplace('OR "1"="1"',"",$string);
		$string = str_ireplace('OR ´1´=´1´',"",$string);
		$string = str_ireplace("is NULL; --","",$string);
		$string = str_ireplace("is NULL; --","",$string);
		$string = str_ireplace("LIKE '","",$string);
		$string = str_ireplace('LIKE "',"",$string);
		$string = str_ireplace("LIKE ´","",$string);
		$string = str_ireplace("OR 'a'='a","",$string);
		$string = str_ireplace('OR "a"="a',"",$string);
		$string = str_ireplace("OR ´a´=´a","",$string);
		$string = str_ireplace("--","",$string);
		$string = str_ireplace("^","",$string);
		$string = str_ireplace("[","",$string);
		$string = str_ireplace("]","",$string);
		$string = str_ireplace("==","",$string);
		return $string;
	}

	// Quitar Acentos, ñ, a los nombre de los productos.
	function clear_cadena(string $cadena)
	{
		//Reemplazamos la A y a
		$cadena = str_replace(
			array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
			array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
			$cadena);

			//Reemplazamos la E y e
		$cadena = str_replace(
			array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
			array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
			$cadena);

			//Reemplazamos la I y i
		$cadena = str_replace(
			array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
			array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
			$cadena);

			//Reemplazamos la O y o
		$cadena = str_replace(
			array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
			array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
			$cadena);

			//Reemplazamos la U y u
		$cadena = str_replace(
			array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
			array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
			$cadena);

			//Reemplazamos la N, n, C y c
			$cadena = str_replace(
			array('Ñ', 'ñ', 'Ç', 'ç',',','.',';',':'),
			array('N', 'n', 'C', 'c','','','',''),
			$cadena);

		return $cadena;
	}	

	// Genera una contraseña de 10 caracteres.
	function passGenerator($Length = 10)
	{
		$pass = "";
		$longitudPass=$Length;
		$cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
		$longitudCadena=strlen($cadena);
		for ($i=1; $i<=$longitudPass; $i++)
		{
			$pos = rand(0,$longitudCadena-1);
			$pass .= substr($cadena,$pos,1);
		}
		return $pass;
	}

	function token()
	{
		$r1 = bin2hex(random_bytes(10));
		$r2 = bin2hex(random_bytes(10));
		$r3 = bin2hex(random_bytes(10));
		$r4 = bin2hex(random_bytes(10));
		$token = $r1.'-'.$r2.'-'.$r3.'-'.$r4;
		return $token;		
	}

	function formatMoney($cantidad)
	{
		// SPD = Separar Decimal
		// SPM = Separar Millares se definen en el archivo Config.php
		$cantidad = number_format($cantidad,2,SPD,SPM);
		return $cantidad;
	}


?>

