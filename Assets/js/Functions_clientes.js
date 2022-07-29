// Agrega el evento de Escucha al cargar el documento.

document.addEventListener('DOMContentLoaded',function(){

	if (document.querySelector("#formUsuario"))
	{
		var formUsuario = document.querySelector("#formUsuario");
		// Acivando el evento "onsubmit" a la variable "formUsuario" es donde esta el formulario.
		formUsuario.onsubmit = function(e){
			e.preventDefault();
			// Obtiene el contenido de las etiquetas de las capturas de Usuarios.
			let strIdentificacion = document.querySelector('#txtIdentificacion').value;		
			let strNombre = document.querySelector('#txtNombre').value;		
			let strApellido = document.querySelector('#txtApellido').value;		
			let strEmail = document.querySelector('#txtEmail').value;		
			let strTelefono = document.querySelector('#txtTelefono').value;		
			let strTipousuario = document.querySelector('#listRolid').value;		
			let strPassword = document.querySelector('#txtPassword').value;	
			let intStatus = document.querySelector('#listStatus').value;		
		
			if ((strIdentificacion == '')|| strApellido == '' || strNombre == '' || strEmail == '' || strTelefono == '' || strTipousuario == '' || strPassword == '')
			{
				swal ("Atencion", "Todos los campos son obligatorio","error");
				return false;
			}

			// Obtiene todos las etiquetas que tienen la clase "valid" del formulario de captura.
			let elementsValid = document.getElementsByClassName("valid");
			for (let b=0; b<elementsValid.length;b++)
			{
				if (elementsValid[b].classList.contains('is-invalid'))
				{
					swal ("Atencion", "Por Favor verifique los campos en Rojo","error");
					return false;
				}
			}

			// Detecta en que navegador se encuentra activo. Google Chrome, Firefox o Internet Explorer. 
			let request = (window.XMLHttpRequest) ? new XMLHttpRequest():new ActiveXObject('Microsoft.XMLHTTP');

			let ajaxUrl = base_url+'/Usuarios/setUsuario';
			let formData = new FormData(formUsuario); // Se obtiene el formulario
			request.open("POST",ajaxUrl,true); // Se abre la conexion, y se pasa por "GET"
			request.send(formData); // Se envia la petición (ejecutar el archivo "getRol/XXX")
			// Lo que retorne (echo Json.... el Controllers/Roles/getRol)

			request.onreadystatechange = function(){
				if (request.readyState == 4 && request.status == 200)
				{
					let objData = JSON.parse(request.responseText);
					if (objData.estatus)
					{
						if (rowTable == "") // Creando un nuevo usuario.
						{
						// Mostrar los datos en el "dataTable"
						tableUsuarios.api().ajax.reload(function(){});
						}
						else // Cuando se esta editado.
						{
							htmlStatus = intStatus == 1 ? '<span class="badge badge-success">Activos</span>':
							'<span class="badge badge-danger">Inactivos</span>';

							rowTable.cells[1].textContent = strNombre;
							rowTable.cells[2].textContent = strApellido;
							rowTable.cells[3].textContent = strEmail;
							rowTable.cells[4].textContent = strTelefono;
							// Obtiene el nombre que le corresponde al rol asignado, es decir "Administrador", "Vendedor", etc.
							rowTable.cells[5].textContent = document.querySelector("#listRolid").selectedOptions[0].text;
							rowTable.cells[6].innerHTML = htmlStatus; //Incrusta código HTML en la etiqueta del DataTable.
						}

						$('#modalFormUsuario').modal("hide");
						formUsuario.reset();
						swal("Usuarios",objData.msg,"success");
					}
					else
					{
						swal("Error",objData.msg,"error");
					}
				}
			}
		
		} // formUsuario.onsubmit = function(e){

	} // if (document.querySelector("#formUsuario"))


}, false);



// Para mostrar la ventana Modal de Clientes.
function openModal()
{
	rowTable = "";

	//alert("OpenModal");
	// Se actualizan los datos de la ventana modal a Mostrar, se agregan estos valores para que se pueda actualiar la ventana modal de "Agregar" y "Actualizar" Usuarios.

	// Estes lineas de definieron en "fntEditUsario()"
	// Es el Input "hidden" que se encuentra : /Views/Templetes/Modals/ModalUsuarios.php
	document.querySelector('#idUsuario').value = "";	
	// Cambiando los colores de la franja de la ventana.
	// Estas definidos en "ModalUsuarios.php"
	document.querySelector('.modal-header').classList.replace("headerUpdate","headerRegister");
	// Cambiando la clase de los botones (Colores)
	document.querySelector('#btnActionForm').classList.replace("btn-info","btn-primary");
	document.querySelector('#btnText').innerHTML = "Guardar";
	document.querySelector('#titleModal').innerHTML = "Nuevo Cliente";
	// Resetear el Formulario, limpia todos los campos.
	document.querySelector('#formCliente').reset();

	$('#modalFormCliente').modal('show');
}
