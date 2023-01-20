// Se agrega este código en este archivo, ya que solo se requiere en esta parte "Capturas del producto"
// Su tilizan esta comillas ` `para agregar variables con llaves.
document.write(`<script src="${base_url}/Assets/js/plugins/JsBarcode.all.min.js"></script>`);

let tableProductos;
let rowTable;

// Al cargar el documento se ejecuta la funcion.

window.addEventListener('load',function(){
	//fntInputFile();
	fntCategorias();
},false);

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

// Script para corregir el error de componentes bloqueados, en "tinymce"
// Sobreposicionar los modals que tenga el plugins en los modals del proyecto
$(document).on('focusin',function(e){
	if ($(e.target).closest(".tox-dialog").length){
		e.stopImmediatePropagation();
	}
});

// Para llamar a la libreria "tinymce"
// #txtDescripcion = Es la etiqueta que utilizara el "tinymce"
// width = Ocupa el 100% del contenedor 
// plugins = Son los plugins que se utilizan en el "Tinymce"

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


// Valida la longuitud del código de barras.
if (document.querySelector("#txtCodigo"))
{
	let inputCodigo = document.querySelector("#txtCodigo");
	// Cuando se presione y levante la tecla.
	inputCodigo.onkeyup = function() 
	{
		if (inputCodigo.value.length >= 5)
		{
			document.querySelector('#divBarCode').classList.remove("notBlock");
			fntBarcode();
		}
		else
		{
			document.querySelector('#divBarCode').classList.add("notBlock");
		}
	};
}

// Se utiliza para desplegar el código de barra
function fntBarcode()
{
	let codigo = document.querySelector("#txtCodigo").value;
	JsBarcode("#barcode",codigo); // Imprime el código de barras en la etiqueta con el id "barcode"
}

// Esta funcion se llama desde ModalProductos.php; onclick="fntPrintBarcode"
// Para imprimir el código de Barras.
function fntPrintBarcode(area)
{
	let elemntArea = document.querySelector(area);
	let vprint = window.open('','popimpr','height=400,width=600'); //Define el tamaño de la ventana
	vprint.document.write(elemntArea.innerHTML); // Escribe el código HTML en la ventana
	vprint.document.close();
	vprint.print();
	vprint.close();
}


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

	/*
	// Para borrar las imagenes cuando se oprima el boton "Nuevo Producto"
	document.querySelector("#divBarCode").classList.add("notBlock");
	document.querySelector("#containerGallery").classList.add("notBlock");
	document.querySelector("#containerImages").innerHTML = ""; // Elimina las imagenes.
	*/
	
	$('#modalFormProductos').modal('show');
	//removePhoto();

}


// Funcion para extraer los datos de Categorias, para agregarlo en la captura de productos.
function fntCategorias()
{
	// Si existe la etiqueta 
	if (document.querySelector('#listCategoria'))
	{
		let ajaxUrl = base_url+'/Categorias/getSelectCategorias';
		// Para hacer uso del Ajax
		// Detecta en que navegador se encuentra activo. Google Chrome, Firefox o Internet Explorer. 
		let request = (window.XMLHttpRequest) ? new XMLHttpRequest():new ActiveXObject('Microsoft.XMLHTTP');
		//let ajaxUrl = base_url+'/Categorias/setCategoria'; // Url a donde buscara el archivo, es en el Controlador/Roles.
		// El método utilizado para enviar la informacion es "POST"
		request.open("GET",ajaxUrl,true);
		request.send();
		
		// Validando lo que regresa el Ajax
		request.onreadystatechange = function()
		{
			// Valida que este devolviendo informacion.
			if (request.readyState == 4 && request.status == 200)
			{				
				// Agrega el codigo HTML que regresa el Ajax de la consulta (getSelectCategorias)
				document.querySelector('#listCategoria').innerHTML = request.responseText;
				// Se muestren las opciones aplicando el buscador.
				$('#listCategoria').selectpicker('render');

			}
		}

	}

}
