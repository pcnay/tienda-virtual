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
			e.preventDefault();
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
				
				// console.log(request);

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
},false)