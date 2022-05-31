$('.login-content [data-toggle="flip"]').click(function() {
	$('.login-box').toggleClass('flipped');
	return false;
});

// En este archivo se capturan los campos para Grabar con el Ajax.
// Cargara todo los eventos que iran dentro de esta funcion.
document.addEventListener('DOMContentLoaded',function(){
	if (document.querySelector("#formLogin"))
	{
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

},false)