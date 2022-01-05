var tableRoles;
// Cuanddo se termine de cargar agregar un escucha para cargar la funcion.
document.addEventListener('DOMContentLoaded',function(){
	tableRoles = $('#tableRoles').dataTable({
		"aProcessing":true,
		"aServerside":true,
		"language": {
			"url":"//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
		},
		"ajax":{
			"url":" "+base_url+"/Roles/getRoles",
			"dataSrc":""
		},
		"columns":[
			{"data":"id_rol"},
			{"data":"nombrerol"},
			{"data":"descripcion"},
			{"data":"status"},
			{"data":"options"}
		],
		"resonsieve":"true",
		"bDestroy":true,
		"iDisplayLength":10,
		"order":[[0,"desc"]]
	});

	// Capturar los datos del formulario de "Nuevo Rol"
	// Seleccionan el id del formulario de Rol

	let formRol = document.querySelector("#formRol");
	formRol.onsubmit = function(e){
		e.preventDefault();
		let strNombre = document.querySelector("#txtNombre").value;
		let strDescripcion = document.querySelector("#txtDescripcion").value;
		let intStatus = document.querySelector("#listStatus").value;
		if (strNombre == '' || strDescripcion == '' || intStatus == '')
		{
			swal ("Atencion","Todos los campos son obligatorios","error");
			return false; // Detiene el proceso.
		}

		// Detecta en que navegador se encuentra activo. Google Chrome, Firefox o Internet Explorer. 
		let request = (window.XMLHttpRequest) ? new XMLHttpRequest():new ActiveXObject('Microsoft.XMLHTTP');
		let ajaxUrl = base_url+'/Roles/setRol'; // Url a donde buscara el archivo
		
		let formData = new FormData(formRol);
		// El método utilizado para enviar la informacion es "POST"
		request.open("POST",ajaxUrl,true);
		request.send(formData);
		request.onreadystatechange = function(){
			if (request.readyState == 4 && request.status == 200)
			{
				// console.log(request.responseText);
				// La información que viene desde el método "setRol" del Controllers "Roles"
				let objData = JSON.parse(request.responseText);

				// Accesando a los elementos del Arreglo asociativo
				if (objData.status)
				{
					$('#modalFormaRol').modal("hide");
					formRol.reset();
					swal("Roles de Usuarios",objData.msg,"success");
					tableRoles.api().ajax.reload(function(){
						//fntEditRol();
						//fntDelRol();
						//fntPermisos();
					});					
				}
				else
				{
					swal("Error",objData.msg,"error");
				}
			}
			//console.log(request);
		}
	}

});

$('#tableRoles').DataTable();

// Para mostrar la ventana Modal de Roles.
function openModal()
{
	//alert("OpenModal");
	// Se actualizan los datos de la ventana modal a Mostrar.
	document.querySelector('#idRol').value = "";	
	// Cambiando los colores de la franja de la ventana.
	document.querySelector('.modal-header').classList.replace("headerUpdate","headerRegister");
	// Cambiando la clase de los botones (Colores)
	document.querySelector('#btnActionForm').classList.replace("btn-info","btn-primary");
	document.querySelector('#btnText').innerHTML = "Guardar";
	document.querySelector('#titleModal').innerHTML = "Nuevo Rol";
	document.querySelector('#formRol').reset();

	$('#modalFormaRol').modal('show');
}

// Editar Roles.
// Llamando a la funcion cuando se termina de cargar la página.
window.addEventListener('load',function(){
	fntEditRol();
},false);

// Asignando el evento "Click". a los registros de los roles en lo referente al Boton.
function fntEditRol()
{
	//console.log('Entre a Function fntEditRol');
	var btnEditRol = document.querySelectorAll(".btnEditRol");
	//console.log (btnEditRol);
	btnEditRol.forEach(function(btnEditRol){
		btnEditRol.addEventListener('click',function(){
			//console.log('Click en el boton de edit');

			// Se actualizan los datos de la ventana modal a Mostrar.
			document.querySelector('#titleModal').innerHTML = "Actualizar Rol";
			document.querySelector('.modal-header').classList.replace("headerRegister","headerUpdate");
			document.querySelector('#btnActionForm').classList.replace("btn-primary","btn-info");
			document.querySelector('#btnText').innerHTML = "Actualizar";

			$('#modalFormaRol').modal('show');
		});
	});
}