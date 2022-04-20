// Cuando se cargue la ventana obtendra los "Roles"
window.addEventListener('load',function(){
	fntRolesUsuarios();
},false);

// Para extraer los "Roles" y vaciarla al "Select"
function fntRolesUsuarios()
{
	// Se pasan como parametro al método definido en "Roles.php -> Controllers" desde el Ajax
	var ajaxUrl = base_url+'/Roles/getSelectRoles';

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


