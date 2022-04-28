var tableUsuarios;
// Al terminar de cargar la vista de la captura de Usuario se ejecutara la funcion
document.addEventListener('DOMContentLoaded',function(){
	
	// Es el dataTable para desplegar los "Usuarios".
	tableUsuarios = $('#tableUsuarios').dataTable({
		"aProcessing":true,
		"aServerside":true,
		"language": {
			"url":"//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
		},
		"ajax":{
			"url":" "+base_url+"/Usuarios/getUsuarios",
			"dataSrc":""
		},
		"columns":[
			{"data":"id_persona"},
			{"data":"nombres"},
			{"data":"apellidos"},
			{"data":"email_user"},
			{"data":"telefono"},	
			{"data":"nombrerol"},		
			{"data":"estatus"},
			{"data":"options"}
		],
		"resonsieve":"true",
		"bDestroy":true,
		"iDisplayLength":10,
		"order":[[0,"desc"]]
	});

	let formUsuario = document.querySelector("#formUsuario");
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
	
		if ((strIdentificacion == '')|| strApellido == '' || strNombre == '' || strEmail == '' || strTelefono == '' || strTipousuario == '' || strPassword == '')
		{
			swal ("Atencion", "Todos los campos son obligatorio","error");
			return false;
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
				if (objData.status)
				{
					$('#modalFormUsuario').modal("hide");
					formUsuario.reset();
					swal("Usuarios",objData.msg,"success");
					// Mostrar los datos en el "dataTable"
					tableUsuarios.api().ajax.reload(function(){

					});
				}
				else
				{
					swal("Error",objData.msg,"error");
				}
			}
		}
	
	} // formUsuario.onsubmit = function(e){

},false);

// Cuando se cargue la ventana obtendra los "Roles"
window.addEventListener('load',function(){
	fntRolesUsuarios();
},false);

// Para extraer los "Roles" y vaciarla al "Select"
function fntRolesUsuarios()
{
	// Se pasan como parametro al método definido en "Roles.php -> Controllers" desde el Ajax
	let ajaxUrl = base_url+'/Roles/getSelectRoles';

	// Detecta en que navegador se encuentra activo. Google Chrome, Firefox o Internet Explorer. 
	let request = (window.XMLHttpRequest) ? new XMLHttpRequest():new ActiveXObject('Microsoft.XMLHTTP');

	request.open("GET",ajaxUrl,true); // Se abre la conexion, y se pasa por "GET"
	request.send(); // Se envia la petición (ejecutar el archivo "getRol/XXX")
	// Lo que retorne (echo Json.... el Controllers/Roles/getRol)

	// Agregando al "Select"
	request.onreadystatechange = function(){
		if (request.readyState == 4 && request.status == 200) // Vaiida si llego correctamente la respuesta.
		{
			document.querySelector('#listRolid').innerHTML = request.responseText;
			document.querySelector('#listRolid').value = 1;
			$('#listRolid').selectpicker('render'); // Para que se refresque el Select.
			//$('#listRolid').selectpicker('refresh'); // Para que se refresque el Select.
		}
	}

}


// Para mostrar la ventana Modal de Roles.
function openModal()
{
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
	document.querySelector('#titleModal').innerHTML = "Nuevo Usuario";
	// Resetear el Formulario, limpia todos los campos.
	document.querySelector('#formUsuario').reset();

	$('#modalFormUsuario').modal('show');
}


