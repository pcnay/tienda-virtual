// Validar la entrada, solo caracteres permitidos "txtNombre"
$("#txtNombre").bind('keypress', function(event) {
	var regex = new RegExp("^[A-Za-z0-9- ]+$");
	var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
	if (!regex.test(key)) {
		event.preventDefault();
		return false;
	}
});

// Validar la entrada, solo caracteres permitidos "txtDescripcion "
$("#txtDescripcion").bind('keypress', function(event) {
	var regex = new RegExp("^[A-Za-z0-9- ]+$");
	var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
	if (!regex.test(key)) {
		event.preventDefault();
		return false;
	}
});

// Validar la entrada, solo caracteres permitidos "txtDescripcion "
$("#txtCodigo").bind('keypress', function(event) {
	var regex = new RegExp("^[A-Za-z0-9-/ ]+$");
	var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
	if (!regex.test(key)) {
		event.preventDefault();
		return false;
	}
});

// Script para corregir el error de componentes bloqueados
// Sobreposicionar los modals que tenga el plugins en los modals del proyecto
$(document).on('focusin',function(e){
	if ($(e.target).closest(".tox-dialog").length){
		e.stopImmediatePropagation();
	}
});

// Para llamar a la libreria "tinymce"
tinymce.init({
	selector: '#txtDescripcion',
	width:"100%",
	height:400,
	statusbar:true,
	plugins:[
		"advlist autolink link image lists charmap print preview hr anchor pagebreak",
		"searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
		"save table contextmenu directionality emoticons template paste textcolor"
		],
toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",
});

// Para mostrar la ventana Modal de los Productos
function openModal()
{
	rowTable = "";

	//alert("OpenModal");
	// Se actualizan los datos de la ventana modal a Mostrar, se agregan estos valores para que se pueda actualiar la ventana modal de "Agregar" y "Actualizar" Usuarios.

	// Estes lineas de definieron en "fntEditUsario()"
	// Es el Input "hidden" que se encuentra : /Views/Templetes/Modals/ModalUsuarios.php
	document.querySelector('#idProducto').value = "";	
	// Cambiando los colores de la franja de la ventana.
	// Estas definidos en "ModalUsuarios.php"
	document.querySelector('.modal-header').classList.replace("headerUpdate","headerRegister");
	// Cambiando la clase de los botones (Colores)
	document.querySelector('#btnActionForm').classList.replace("btn-info","btn-primary");
	document.querySelector('#btnText').innerHTML = "Guardar";
	document.querySelector('#titleModal').innerHTML = "Nuevo Producto";
	// Resetear el Formulario, limpia todos los campos.
	document.querySelector('#formProductos').reset();

	$('#modalFormProductos').modal('show');
	//removePhoto();

}

