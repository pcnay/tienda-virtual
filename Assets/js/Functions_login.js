$('.login-content [data-toggle="flip"]').click(function() {
	$('.login-box').toggleClass('flipped');
	return false;
});

// En este archivo se capturan los campos para Grabar con el Ajax.
// Cargara todo los eventos que iran dentro de esta funcion.
document.addEventListener('DOMContentLoaded',function(){
	if (document.querySelector("#formLogin"))
	{
		//console.log("Formulario Login ");
		let formLogin = (document.querySelector("#formLogin"));
		formLogin.onsubmit = function(e){
			e.preventDefault(); // Previene que se recargue la pagina
			let strEmail = document.querySelector("#txtEmail").value;
			let strPassword = document.querySelector("#txtPassword").value;

			if (strEmail == "" || strPassword == "")
			{
				swal("Ingresa ", "Escribe usuario y contraseña","error");
				return false; // Para que no continue
			}
			else
			{
				// Envia los datos al controlador.
				// Determina cual navegador esta usandose.
				let request = (window.XMLHttpRequest) ? new XMLHttpRequest():new ActiveXObject('Microsoft.XMLHTTP');
				// Se pasan como parametro al método definido en "loginUser.php -> Controllers" desde el Ajax
				// "base_url" = Se definio en el archivo "Footer_admin.php" parte superior
				let ajaxUrl = base_url+'/Login/loginUser';
				var formData = new FormData(formLogin); // Obtiene todos los campos del formulario
				// Se abre la conexion 
				request.open("POST",ajaxUrl,true); // Abre el archivo con peticion "POST"
				// Se envian los campos del formulario.
				request.send(formData);
				
				//console.log(request);

				request.onreadystatechange = function()
				{
					if (request.readyState != 4 ) return; // Si no se cumple no realiza nada
					if (request.status == 200) // Fue exitoso el enlace con el servidor
					{
						// Convierte a un objeto JSon lo que retorno el Ajax.
						let objData = JSON.parse(request.responseText); 
						// Viene desde el Ajax "responseText": "\n\n{\"estatus\":true,\"msg\":\"ok\"}"

						// Si hizo "Login" de forma correcta.
						if (objData.estatus)
						{
							window.location = base_url+'/Dashboard';
						}
						else
						{
							swal("Atencion",objData.msg,"error");
							// Se limpia ese campo.
							document.querySelector("#txtPassword").value = "";
						}					
					}
					else
					{
						swal("Atencion","Error En El Proceso","error");
					}
					return false;

				} // request.onreadystatechange = function()

			}

		}
	}
	
	// Asigna el Evento Submit a la ventana para recuperar la contraseña
	if (document.querySelector("#formRecetPass"))
	{
		//console.log ("Accede a Formulario de Resetear Password ");
		let formRecetPass = document.querySelector("#formRecetPass");
		formRecetPass.onsubmit = function(e){
			// Previene que se recargue la pagina.
			e.preventDefault();
			let strEmail = document.querySelector('#txtEmailReset').value;
			if (strEmail == "")
			{
				swal("Por favor","Escribe tu correo electronico ","error");
				return false;				
			}	
			else
			{
				// Va accesar a la base de datos para extraer la informacion del usuario.
				// Detecta en que navegador se encuentra activo. Google Chrome, Firefox o Internet Explorer. 
				let request = (window.XMLHttpRequest) ? new XMLHttpRequest():new ActiveXObject('Microsoft.XMLHTTP');
				// Accesa al Controlador para accesar al método
				let ajaxUrl = base_url+'/Login/resetPass';
				// Se envía el formulario.
				let formData = new FormData(formRecetPass);
				request.open("POST",ajaxUrl,true);
				request.send(formData); // Envía todo la información.
				request.onreadystatechange = function(){
					//console.log(request);

					if (request.readyState != 4) return; // No regresa valor 

					// Si se ejecuta correctamente en el servidor.
					if (request.status == 200)
					{
						// Convertir a un Objeto lo que regresa el Ajax
						let objData = JSON.parse(request.responseText);
						if (objData.estatus)
						{
							swal({
								title:"",
								text:objData.msg,
								type:"success",
								confirmButtonText:"Aceptar",
								closeOnConfirm:false,
							},function (isConfirm){
								if (isConfirm){
									window.location = base_url;
								}
							});
						}
						else
						{
							swal ("Atencion",objData.msg,"error");
						}
					}
					else
					{
						swal ("Atencion","Error en el Proceso","error");
					}
					return false
				}
				
			}
		}

	} // if (document.querySelector("#formRecetPass"))

	// Determina si existe el formulario con el nombre "formCambiarPass" que se encuentra en la vista "CambiarContraseña"
	//if (document.querySelector("#formRecetPass"))
	if (document.querySelector("#formCambiarPass"))
	{
		//console.log ("Accede a Formulario de Cambiar Password ");
		let formCambiarPass = document.querySelector("#formCambiarPass");
		//console.log (formCambiarPass);
		
		// Se le asigna al formulario que se encuentra en vista Login Cambiar_Password
		formCambiarPass.onsubmit = function(e){
			e.preventDefault();// Previene que se recargue cuando se oprime el boton "Reinciiar"
			
			// Obtener los valores del formulario "forCambiarPass", vista "Cambiar_Password"
			let strPassword = document.querySelector('#txtPassword').value;
			let strPasswordConfirm = document.querySelector('#txtPasswordConfirm').value;
			let idUsuario = document.querySelector('#idUsuario').value;

			//console.log ("Contenido strPasswpord ",strPassword);
			//console.log ("Contenido strPasswordConfirm ",strPasswordConfirm);
			// return false;			

			if ((strPassword === "") || (strPasswordConfirm === ""))
			{
				swal("Por Favor","Escribe la nueva contraseña","error");
				return false;
			}
			else
			{
				if (strPassword.length < 5)
				{
					swal("Atencion","La Contraseña debe tener un mínimo de 5 caracteres","info");
					return false;
				}
				
				// Verificando que las contraseñas coincidan
				if (strPassword != strPasswordConfirm)
				{
					swal("Atencion","La contraseña NO son iguales","error");
					return false;
				}

				// Va accesar a la base de datos para extraer la informacion del usuario.
				// Detecta en que navegador se encuentra activo. Google Chrome, Firefox o Internet Explorer. 
				let request = (window.XMLHttpRequest) ? new XMLHttpRequest():new ActiveXObject('Microsoft.XMLHTTP');
				// Accesa al Controlador para accesar al método
				let ajaxUrl = base_url+'/Login/setPassword';
				// Se envía el formulario.
				let formData = new FormData(formCambiarPass); // Encapsula todos los datos para ser enviado por Ajax
				request.open("POST",ajaxUrl,true);
				request.send(formData); // Envía todo la información.
				request.onreadystatechange = function()
				{
					if (request.readyState != 4) return; // No regresa valor 
					
					if (request.status == 200) // El servidor se conecto correctamente
					{
						console.log(request.responseText);
						// Convirtiendo a un objeto "arreglo" para JaveScritp
						let objData = JSON.parse(request.responseText);
						if (objData.estatus)
						{							
							swal({
								title:"",
								text:objData.msg,
								type:"success",
								confirmButtonText:"Iniciar session",
								closeOnConfirm:false,
							}, function(isConfirm)
							{
								if (isConfirm)
								{
									window.location = base_url+'/Login';
								}
							
							});
						}
						else
						{
							swal("Atencion",objData.msg,"error");
						}
					} // if (request.status == 200)
					else
					{
						swal("Atencion","Error En el Proceso","error");
					}
				} //request.onreadystatechange = function(){
			} //if (strPassword == "" || strPasswordConfirm == "")
		} // formCambiarPass.onsubmit = function(e)
	} // if (document.querySelector("#formCambiarPass"))
	else
	{
		console.log ("No existe Cambiar Password");
	}


},false) // document.addEventListener('DOMContentLoaded',function(){