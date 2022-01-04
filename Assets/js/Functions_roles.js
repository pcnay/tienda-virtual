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

	var formRol = document.querySelector("#formRol");
	formRol.onsubmit = function(e){
		e.preventDefault();
		var strNombre = document.querySelector("#txtNombre").value;
		var strDescripcion = document.querySelector("#txtDescripcion").value;
		var intStatus = document.querySelector("#listStatus").value;
		if (strNombre == '' || strDescripcion == '' || intStatus == '')
		{
			swal ("Atencion","Todos los campos son obligatorios","error");
			return false; // Detiene el proceso.
		}

		// Detecta en que navegador se encuentra activo. Google Chrome, Firefox o Internet Explorer. 
		var request = (window.XMLHttpRequest) ? new XMLHttpRequest():new ActiveXObject('Microsoft.XMLHTTP');
		var ajaxUrl = base_url+'/Roles/setRol'; // Url a donde buscara el archivo
		
		var formData = new FormData(formRol);
		// El método utilizado para enviar la informacion es "POST"
		request.open("POST",ajaxUrl,true);
		request.send(formData);
		request.onreadystatechange = function(){
			if (request.readyState == 4 && request.status == 200)
			{
				console.log(request.responseText);
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
	$('#modalFormaRol').modal('show');
}