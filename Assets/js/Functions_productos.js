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
				swal ("Atencion","El Código debe ser mayor que 5 dígito","error");
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

	// Código para cuando se oprime el boton de "agregar"
	// Valida si existe esta etiqueta.
	if (document.querySelector(".btnAddImage"))
	{
		let btnAddImages = document.querySelector(".btnAddImage");

		// Se agrega el evento click al boton "+"
		btnAddImages.onclick = function(e)
		{
			// Se creara la seccion donde se carga la imagenes en la captura de Productos.
			let key = Date.now();
			//alert(key);

			// Se crea la seccion del "DIV" donde se agrega la imagen, utilizando "JavaScript" puro
			let newElement = document.createElement("div");
			newElement.id = "div"+key;
			newElement.innerHTML = `<div class="prevImage"></div>
				<input type="file" name = "foto" id = "img${key}" class="inputUploadfile" >
				<label for="img${key}" class="btnUploadfile"><i class="fas fa-upload"></i></label>
				<button class="btnDeleteImage" type="button" onclick="fntDelItem('#div${key}')"><i class="fas fa-trash-alt"></i></button>`;

			// Se agrega al "DIV" <div id="containerImages">, a la estructura completa, referencia "ModalProductos.php" donde esta donde se crea manualmente el DIV24.
			document.querySelector("#containerImages").appendChild(newElement);
			
			// Se esta agregando el evento "click" 
			document.querySelector("#div"+key+" .btnUploadfile").click();

			fntInputFile();			

		} // btnAddImages.onclick = function(e)

	}

	fntCategorias();
	fntInputFile();


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


//Function para subir el archivo
function fntInputFile()
{
	let inputUploadfile = document.querySelectorAll(".inputUploadfile");
	inputUploadfile.forEach(function(inputUploadfile){
		inputUploadfile.addEventListener('change', function(){
			let idProducto = document.querySelector ("#idProducto").value;
			//console.log("idProducto ",idProducto);
			
			let parentId = this.parentNode.getAttribute("id"); // Obtiene el "id" del elemento padre, es "div24"
			let idFile = this.getAttribute("id"); // Es el elemento que se le esta haciendo "Click"
			let uploadFoto = document.querySelector("#"+idFile).value; 
			let fileimg = document.querySelector("#"+idFile).files; // Obtiene el id de la etiqueta "File", <input type="file" id="img1" ... Obtiene la foto
			let prevImg = document.querySelector("#"+parentId+" .prevImage"); // Obtiene el "DIV" donde se encuentra la imagen, <div class="prevImage"> ...
			let nav =  window.URL || window.webkitURL; // Obtiene la URL, desde JavaScript.

			// Valida si existe una imagen.
			if (uploadFoto != '')
			{
				let type = fileimg[0].type; // Obtiene el tipo archivo.
				let name = fileimg[0].name; // obtiene el nombre del archivo.

				if (type != 'image/jpeg' && type != 'image/jpg' && type != 'image/png')
				{
					prevImg.innerHTML = "Archivo NO válido";
					uploadFoto.value = "";
					return false;
				}
				else
				{
					// Pasando la imagen con Ajax.
					// Crea una URL 
					let objeto_url = nav.createObjectURL(this.files[0]);
					// Se esta agregando el "loading.svg".
					prevImg.innerHTML = `<img class="loading" src="${base_url}/Assets/images/loading.svg" > `;

					// Enviando los datos por Ajax de la imagen que se grabara en la tabla.
					// Detecta en que navegador se encuentra activo. Google Chrome, Firefox o Internet Explorer. 
					let request = (window.XMLHttpRequest) ? new XMLHttpRequest():new ActiveXObject('Microsoft.XMLHTTP');
					let ajaxUrl = base_url+'/Productos/setImage'; // Url a donde buscara el archivo, es en el Controlador/Productos.
					let formData = new FormData();
					// El método utilizado para enviar la informacion es "POST"
					formData.append('idproducto',idProducto);
					formData.append("foto",this.files[0]);
					request.open("POST",ajaxUrl,true); // Abre una conexion, de tipo POST de la URL 
					request.send(formData);
					request.onreadystatechange = function() 
					{
						if (request.readyState != 4) return;
						if (request.status == 200)
						{
							let objData = JSON.parse(request.responseText);
							if (objData.estatus)
							{
								// Asignando la imágen 
								prevImg.innerHTML = `<img src="${objeto_url}">`;
								// Se le asigna al boton "btnDeleteImage"
								document.querySelector("#"+parentId+" .btnDeleteImage").setAttribute("imgname",objData.imgname);
								
								document.querySelector("#"+parentId+" .btnUploadfile").classList.add("notblock");
								document.querySelector("#"+parentId+" .btnDeleteImage").classList.remove("notblock");
							}
							else
							{
								swal("Error", objData.msg,"error")
							}
						} // if (request.status == 200)
						
					} //request.onreadystatechange = funtion() 

				}
			}

		}); // inputUploadfile.addEventListener('change', function(){
		
	}); // inputUploadfile.forEach(function(inputUploadfile){

} //function fntInputFile()

// Funcion utilizada para mostrar el producto en una ventana modal.
function fntViewInfo(idProducto)
{
	// Obtiene los datos desde la tabla.
	// Detecta en que navegador se encuentra activo. Google Chrome, Firefox o Internet Explorer. 
	let request = (window.XMLHttpRequest) ? new XMLHttpRequest():new ActiveXObject('Microsoft.XMLHTTP');
	let ajaxUrl = base_url+'/Productos/getProducto/'+idProducto; // Url a donde buscara el archivo, es en el Controlador/Productos.
	request.open("GET",ajaxUrl,true);
	request.send();

	request.onreadystatechange = function() 
	{
		if (request.readyState == 4 && request.status == 200) // Esta retornando informacion
		{
			// Conviertiendo de formato JSon a Objeto.
			let objData = JSON.parse(request.responseText);
			if (objData.estatus)
			{
				//console.log(objData);
				let objProducto = objData.data;
				let estadoProducto = objProducto[0].estatus == 1?
				'<span class="badge badge-success">Activo</span>':
				'<span class="badge badge-danger">Inactivo</span>';
				console.log(objProducto);
				// console.log(objProducto[0].nombre); Funciona PHP 8 para accesar a un elemento.

				document.querySelector("#celCodigo").innerHTML = objProducto[0].codigo;
				document.querySelector("#celNombre").innerHTML = objProducto[0].nombre;
				document.querySelector("#celPrecio").innerHTML = objProducto[0].precio;
				document.querySelector("#celStock").innerHTML = objProducto[0].stock;
				document.querySelector("#celCategoria").innerHTML = objProducto[0].categoria;
				document.querySelector("#celStatus").innerHTML = estadoProducto;
				document.querySelector("#celDescripcion").innerHTML = objProducto[0].descripcion;

				// Mostrando las imagenes.
				let htmlImage = "";
				if (objProducto.images.length > 0)
				{
					let objProductos = objProducto.images;
					for (let p=0;p<objProductos.length;p++)
					{
						console.log("htmlImage ", objProductos[0].url_image);				
						htmlImage += `<img src="${objProductos[p].url_image}"></img>`;
					} // for (let p=0;p<objProductos.length;p++)
				} // if (objProducto[0].images.length > 0)

				document.querySelector("#celFotos").innerHTML = htmlImage;
				

				$('#modalViewProducto').modal('show');				
				
			} // if (objData.estatus)
			else
			{
				swal("Error",objDat.msg,"error");					
			} // else - if (objData.estatus)

		}
	} // request.onreadystatechange = function() 


	$('#modalViewProducto').modal('show');

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

