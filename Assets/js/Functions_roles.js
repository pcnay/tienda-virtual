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
			{"data":"status"}
		],
		"resonsieve":"true",
		"bDestroy":true,
		"iDisplayLength":10,
		"order":[[0,"desc"]]
	});

});

$('#tableRoles').DataTable();

// Para mostrar la ventana Modal de Roles.
function openModal()
{
	//alert("OpenModal");
	$('#modalFormaRol').modal('show');
}