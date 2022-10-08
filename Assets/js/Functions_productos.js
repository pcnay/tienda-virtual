// Se agrega este código en este archivo, ya que solo se requiere en esta parte
// Su tilizan esta comillas ` `para agregar variables con llaves.

document.write(`<script src="${base_url}/Assets/js/plugins/JsBarcode.all.min.js"></script>`);

let tableProductos;

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

// Cuando se cargan la pagina de Productos (JavaScript) carga la pagina 
window.addEventListener('load',function(){
	
	tableProductos = $('#tableProductos').dataTable({
		"aProcessing":true,
		"aServerside":true,
		"language": {
			"url":"//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
		},
		"ajax":{
			"url":" "+base_url+"/Productos/getProductos",
			"dataSrc":""
		},
		"columns":[
			{"data":"id_producto"},
			{"data":"codigo"},
			{"data":"nombre"},
			{"data":"stock"},
			{"data":"precio"},
			{"data":"estatus"},
			{"data":"options"}
		],
		"columnDefs":[
			{'className':"textcenter","targets":[ 3 ]},
			{'className':"textright","targets":[ 4 ]},
			{'className':"textcenter","targets":[ 5 ]}
		],
		'dom': 'lBfrtip',
		'buttons': [
			{
				"extend": "copyHtml5",
				"text":"<i class = 'far fa-copy'></i>Copiar",
				"titleAttr":"Copiar",
				"className":"btn btn-secondary"
			},
			{
				"extend": "excelHtml5",
				"text":"<i class = 'far fa-file-excel'></i>Excel",
				"titleAttr":"Exportar a Excel",
				"className":"btn btn-success",
				"exportOptions":{
					"columns": [0,1,2,3,4,5]
				}
			},
			{
				"extend": "pdfHtml5",
				"text":"<i class = 'far fa-file-pdf'></i>PDF",
				"titleAttr":"Exportar a PDF",
				"className":"btn btn-danger",
				"exportOptions":{
					"columns": [0,1,2,3,4,5]
				}
			},
			{
				"extend": "csvHtml5",
				"text":"<i class = 'fas fa-file-csv'></i>CSV",
				"titleAttr":"Exportar a CSV",
				"className":"btn btn-info",
				"exportOptions":{
					"columns": [0,1,2,3,4,5]
				}
			}
		],
		"resonsieve":"true",
		"bDestroy":true,
		"iDisplayLength":2,
		"order":[[0,"desc"]]
	});

	// Cuando se oprime el boton "Guardar" 
	if (document.querySelector("#formProductos"))
	{
		let formProducto = document.querySelector("#formProductos");
		formProducto.onsubmit = function(e)
		{
			e.preventDefault(); // Previene que se recargue 
			let strNombre = document.querySelector('#txtNombre').value;
			let intCodigo = document.querySelector('#txtCodigo').value;
			let strPrecio = document.querySelector('#txtPrecio').value;
			let intStock = document.querySelector('#txtStock').value;

			if (strNombre == '' || intCodigo == '' || strPrecio == '' || intStock == '')
			{
				swal ("Atencion","Todos los cmpos son Obligatorio","error");
				return false;
			}

			if (intCodigo.length < 5)
			{
				swal ("Atencion","El Código debe ser mayor que 5 díditoso","error");
				return false;
			}

			divLoading.style.display = "flex";
			tinyMCE.triggerSave();// Seccion del editor guarda todo al TextArea.
			// Ya que para  guardar información se extrae los datos de las etiqueta HTML.

			// Detecta en que navegador se encuentra activo. Google Chrome, Firefox o Internet Explorer. 
			let request = (window.XMLHttpRequest) ? new XMLHttpRequest():new ActiveXObject('Microsoft.XMLHTTP');
			let ajaxUrl = base_url+'/Productos/setProducto'; // Url a donde buscara el archivo, es en el Controlador/Productos.
			let formData = new FormData(formProducto);
			// El método utilizado para enviar la informacion es "POST"
			request.open("POST",ajaxUrl,true);
			request.send(formData);

			// Validando lo que regresa el Ajax
			request.onreadystatechange = function()
			{
				// Valida que este devolviendo informacion.
				if (request.readyState == 4 && request.status == 200)
				{	
					//console.log(request.responseText);
					// Parsea el "request", es decir se convierte en Objeto
					let objData = JSON.parse(request.responseText);
					if (objData.estatus)
					{
						swal("",objData.msg,"success");	
						// Para agregar las fotos del Producto.
						document.querySelector("#idProducto").value = objData.id_producto;
						tableProductos.api().ajax.reload();					
					}
					else
					{
						swal("Error",objData.msg,"error");						
					}
					
					/*
					// Agrega el codigo HTML que regresa el Ajax de la consulta (getSelectCategorias)
					document.querySelector('#listCategoria').innerHTML = request.responseText;
					// Se muestren las opciones aplicando el buscador.
					$('#listCategoria').selectpicker('render');
					*/
				}
				divLoading.style.display = "none";
				return false;

			} // request.onreadystatechange = function()

		} // formProductos.onsubmit = function(e)

	} // if (this.document.querySelector("#formProductos"))


	fntCategorias();


},false);

// Valida la longuitud del código de barras.
if (document.querySelector("#txtCodigo"))
{
	let inputCodigo = document.querySelector("#txtCodigo");
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

// Se utiliza para desplegar el código de barra
function fntBarcode()
{
	let codigo = document.querySelector("#txtCodigo").value;
	JsBarcode("#barcode",codigo);

}

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

// Funcion para extraer los datos de Categorias
function fntCategorias()
{
	if (document.querySelector('#listCategoria'))
	{
		let ajaxUrl = base_url+'/Categorias/getSelectCategorias';
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

