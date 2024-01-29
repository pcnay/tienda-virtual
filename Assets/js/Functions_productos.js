// Se agrega este código en este archivo, ya que solo se requiere en esta parte "Capturas del producto", para evitar que se cargue otra libreria mas al proyecto

// Se utilizan esta comillas ` `para agregar variables con llaves.
// Agregando codigo de JavaScript 

document.write(`<script src="${base_url}/Assets/js/plugins/JsBarcode.all.min.js"></script>`);


let tableProductos;
let rowTable;

// Es importante colocar este evento para cargar las Categorias, ya que de lo contrario muestra error al cargar los productos.
window.addEventListener('DOMContentLoaded',function(){
	fntInputFile();
 	fntCategorias(); // Para que se cargue el combobox al cargarse la vista de Productos.
},false);


// Validar la entrada, solo caracteres permitidos "txtNombre"
$("#txtNombre").bind('keypress', function(event) {
	var regex = new RegExp("^[A-Za-z0-9ñÑáéóúí- ]+$");
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
		"columnDefs":[ // Para centrar las columnas de :
			{'className':"textcenter","targets":[ 3 ]}, // Stock
			{'className':"textright","targets":[ 4 ]}, // Precio
			{'className':"textcenter","targets":[ 5 ]} // Estatus
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
					"columns": [0,1,2,3,4,5] // Cuales columnas se exportaran en el archivo de Excel, Id hasta Estatus
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
		"iDisplayLength":10, // Muestra cuantos productos se mostraran por pantalla
		"order":[[0,"desc"]]
	});

	// Cuando se oprime el boton "Guardar" (submit)
	if (document.querySelector("#formProductos")) // Si existe el Formulario
	{
		let formProducto = document.querySelector("#formProductos");
		formProducto.onsubmit = function(e) // Se asigna el evento "submit"
		{
			e.preventDefault(); // Previene que se recargue al momento de oprimir el Boton Guardar.
			let strNombre = document.querySelector('#txtNombre').value;
			let intCodigo = document.querySelector('#txtCodigo').value;
			let strPrecio = document.querySelector('#txtPrecio').value;
			let intStock = document.querySelector('#txtStock').value;
			let intStatus = document.querySelector('#listStatus').value;

			if (strNombre == '' || intCodigo == '' || strPrecio == '' || intStock == '')
			{
				swal ("Atencion","Todos los campos son Obligatorio","error");
				return false;
			}

			// Validando la longuitud del codigo de barras
			if (intCodigo.length < 5)
			{
				swal ("Atencion","El Código debe ser mayor que 5 dígito","error");
				return false;
			}

			divLoading.style.display = "flex"; // Muestra un icono de Carga (circulo)
			tinyMCE.triggerSave();// Seccion del editor guarda todo al TextArea.
			// Ya que para  guardar información se extrae los datos de las etiqueta HTML.

			// Enviando datos por Ajax.
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

						// Muetra el boton para subir imagenes. Cuando se oprime el boton de "Nuevo".
						// Para que muetre el boton "Subir Imagen"
						document.querySelector("#containerGallery").classList.remove("notBlock"); 
						
						objData.id_producto;

						if (rowTable == "") // Es un producto nuevo
						{
							tableProductos.api().ajax.reload(); // Recarga el DataTable
						}
						else // Actualizar el producto
						{
							htmlStatus = intStatus == 1?
								'<span class="badge badge-success">Activo</span>':
								'<span class="badge badge-danger">Inactivo</span>';
							rowTable.cells[1].textContent = intCodigo;
							rowTable.cells[2].textContent = strNombre;
							rowTable.cells[3].textContent = intStock;
							rowTable.cells[4].textContent = smony+strPrecio;
							rowTable.cells[5].innerHTML = htmlStatus;		// Para que lo agregue como contenido HTML.				
							rowTable = "";	
						} // if (rowTable == "")
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

	// Código para cuando se oprime el boton de "agregar", subir la imagen al servidor.
	// Valida si existe esta etiqueta.
	if (document.querySelector(".btnAddImage"))
	{
		let btnAddImages = document.querySelector(".btnAddImage");

		// Se agrega el evento click al boton "+"
		btnAddImages.onclick = function(e)
		{
			// Se creara la seccion donde se carga la imagenes en la captura de Productos.
			let key = Date.now(); // Retorna la fecha y hora con segundos
			//alert(key);

			// Se crea la seccion del "DIV" donde se agrega la imagen, utilizando "JavaScript" puro
			// class="btnDelteImage notBlock" => para que no se muestre al crear un producto.  
			let newElement = document.createElement("div");
			newElement.id = "div"+key;
			newElement.innerHTML = `<div class="prevImage"></div>
				<input type="file" name = "foto" id = "img${key}" class="inputUploadfile" >
				<label for="img${key}" class="btnUploadfile"><i class="fas fa-upload"></i></label>
				<button class="btnDeleteImage notBlock" type="button" onclick="fntDelItem('#div${key}')"><i class="fas fa-trash-alt"></i></button>`;

			// Se agrega al "DIV" <div id="containerImages">, a la estructura completa, referencia "ModalProductos.php" donde esta donde se crea manualmente el DIV24.
			document.querySelector("#containerImages").appendChild(newElement);
			
			// Se esta agregando el evento "click" y lo agrega al siguiente campo, para que no lo encime.
			// Debe llevar espacios " .btnUploadfile", de lo contrario muestra error.
			document.querySelector("#div"+key+" .btnUploadfile").click();

			fntInputFile();			// Se utiliza para enviar la ruta de la imagen a la tabla de "t_Productos"

		} // btnAddImages.onclick = function(e)

	}

	//fntCategorias();
	fntInputFile();

},false); // window.addEventListener('load',function(){

// Verifica si existe la etiqueta donde se captura los numeros (Codigo)
// Valida la longuitud del código de barras.
if (document.querySelector("#txtCodigo"))
{
	let inputCodigo = document.querySelector("#txtCodigo"); // Asigna la etiqueta Input donde se captura el codigo.

	// Asigna el evento que cada vez que se oprime una tecla.
	inputCodigo.onkeyup = function() 
	{
		// Si es mayor a 5 le elimina la clase "notBlock".
		if (inputCodigo.value.length >= 5)
		{
			document.querySelector('#divBarCode').classList.remove("notBlock");
			fntBarcode(); // Para generar el codigo de barra.
		}
		else
		{
			document.querySelector('#divBarCode').classList.add("notBlock");
		}
	};
}

// Script para corregir el error de componentes bloqueados, para la libreria "tinymce"
// Sobreposicionar los modals que tenga el plugins en los modals del proyecto
$(document).on('focusin',function(e){
	if ($(e.target).closest(".tox-dialog").length){
		e.stopImmediatePropagation();
	}
});

// Para llamar a la libreria "tinymce"
// #txtDescripcion = Es la etiqueta que utilizara el "tinymce"
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

// Se utiliza para desplegar el código de barra, en la pantalla de captura de Productos.
function fntBarcode()
{
	let codigo = document.querySelector("#txtCodigo").value;
	JsBarcode("#barcode",codigo); // Generando el codigo de barras.
}

// Para imprimir el código de Barras.
function fntPrintBarcode(area)
{
	let elementArea = document.querySelector(area);
	let vprint = window.open(' ','popimpr','height=400,width=600'); //Define el tamaño de la ventana
	vprint.document.write(elementArea.innerHTML); // Escribe el código HTML en la ventana
	vprint.document.close();
	vprint.print();
	vprint.close();
}


//Function para subir el archivo (ruta de la imagen), sube al servidor
function fntInputFile()
{
	let inputUploadfile = document.querySelectorAll(".inputUploadfile");
	inputUploadfile.forEach(function(inputUploadfile){
		inputUploadfile.addEventListener('change', function(){
			let idProducto = document.querySelector ("#idProducto").value; // Obtiene la "id_producto"
			//console.log("idProducto ",idProducto);
			// Obtiene los datos de la etiquetas que se utilizan cuando aparece la foto en la pantalla.
			let parentId = this.parentNode.getAttribute("id"); // Obtiene el "id" del elemento padre, es "div24"
			let idFile = this.getAttribute("id"); // Es el elemento que se le esta haciendo "Click"
			let uploadFoto = document.querySelector("#"+idFile).value; 
			let fileimg = document.querySelector("#"+idFile).files; // Obtiene el id de la etiqueta "File", <input type="file" id="img1" ... Obtiene la foto
			let prevImg = document.querySelector("#"+parentId+" .prevImage"); // Obtiene el "DIV" donde se encuentra la imagen, <div class="prevImage"> ...
			let nav =  window.URL || window.webkitURL; // Obtiene la URL, desde JavaScript.

			// Valida si existe una imagen.
			if (uploadFoto != '')
			{
				let type = fileimg[0].type; // Input, Obtiene el tipo archivo.
				let name = fileimg[0].name; // obtiene el nombre del archivo.

				// Valida que tipo de archivos son validos.
				if (type != 'image/jpeg' && type != 'image/jpg' && type != 'image/png')
				{
					prevImg.innerHTML = "Archivo NO válido";
					uploadFoto.value = "";
					return false; // Detiene el proceso.
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
					// Estos dos campos es como se tuvieramos un formulario creado en linea desde JavScript
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
								// Asignando la imágen, enviado por Ajax
								prevImg.innerHTML = `<img src="${objeto_url}">`;
								// Se le asigna al boton "btnDeleteImage"
								document.querySelector("#"+parentId+" .btnDeleteImage").setAttribute("imgname",objData.imgname);
								
								document.querySelector("#"+parentId+" .btnUploadfile").classList.add("notBlock");
								document.querySelector("#"+parentId+" .btnDeleteImage").classList.remove("notBlock");
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

// Funcion para borrar las imagenes de los productos.
function fntDelItem(element)
{
	// element = es el "ID" del DIV.
	// btnDeleteImage = es la clase del DIV seleccionado en el renglon anterior
	// getAttribute = Obtiene el nombre de la imagen : pro_65dff65656565df.jpg
	// nameImg = Obtiene la imagen a borrar.
	let nameImg = document.querySelector(element+' .btnDeleteImage').getAttribute("imgname");
	let idProducto = document.querySelector("#idProducto").value; // Obtiene el Id del Producto.

	// Detecta en que navegador se encuentra activo. Google Chrome, Firefox o Internet Explorer. 
	let request = (window.XMLHttpRequest) ? new XMLHttpRequest():new ActiveXObject('Microsoft.XMLHTTP');
	let ajaxUrl = base_url+'/Productos/delFile'; // Url a donde buscara el archivo, es en el Controlador/Productos.

	// Se esta creando un formulario desde JavaScript, se le estan agregando campos.
	let formData = new FormData();
	formData.append('idproducto',idProducto);
	formData.append("file",nameImg);
	request.open("POST",ajaxUrl,true); // Abre una conexion de tipo POST ala URL 
	request.send(formData);
	request.onreadystatechange = function() {
		if (request.readyState != 4) return;
		if (request.status == 200) // Devuelve información correcto de la ejecucion del Ajax
		{
			// Convierte a un objeto (arreglo) el Ajax retornado.
			let objData = JSON.parse(request.responseText);
			if (objData.estatus)
			{
				// Obtiene el elemento que se mando como parametro, Imagen
				// Obtiene el padre del DIV donde se encuentra alojad la imagen.
				let itemRemove = document.querySelector(element);
				// Remueve el elemento hijo del elemento padre DIV que contiene la (La imagen )
				itemRemove.parentNode.removeChild(itemRemove);
			} // if (objData.estatus)
			else
			{
				swal ("",objData.msg,"error");
				
			}

		} // if (request.status == 200)

	} // onreadystatechange


} // function fntDelItem(element)

// Funcion utilizada para mostrar el producto en una ventana modal.
function fntViewInfo(idProducto)
{
	// Obtiene los datos desde la tabla.
	// Detecta en que navegador se encuentra activo. Google Chrome, Firefox o Internet Explorer. 
	let request = (window.XMLHttpRequest) ? new XMLHttpRequest():new ActiveXObject('Microsoft.XMLHTTP');
	let ajaxUrl = base_url+'/Productos/getProducto/'+idProducto; // Url a donde buscara el archivo, es en el Controlador/Productos, es donde se obtiene los registros del ID del producto, en formato Json.
	request.open("GET",ajaxUrl,true);
	request.send();

	request.onreadystatechange = function() 
	{
		if (request.readyState == 4 && request.status == 200) // Esta retornando informacion correctamente desde el navegador
		{
			// Conviertiendo de formato JSon a Objeto.
			let objData = JSON.parse(request.responseText);
			if (objData.estatus)
			{
				//console.log(objData);				
				let objProducto = objData.data; // Accediendo a las propiedades del objeto.
				let estadoProducto = objProducto[0].estatus == 1? // Boton color Verde si esta activo, en Rojo cuando este Inactivo.
				'<span class="badge badge-success">Activo</span>':
				'<span class="badge badge-danger">Inactivo</span>';
				console.log(objProducto);
				// console.log(objProducto[0].nombre); Funciona PHP 8 para accesar a un elemento.

				// Asignando los valores a las etiquetas de la ventana modal.
				// #celCodigo = Se encuentra en la Ventana Modal "ModalViewProducto", renglon de la tabla id = "celCodigo"
				document.querySelector("#celCodigo").innerHTML = objProducto[0].codigo;
				document.querySelector("#celNombre").innerHTML = objProducto[0].nombre;
				document.querySelector("#celPrecio").innerHTML = objProducto[0].precio;
				document.querySelector("#celStock").innerHTML = objProducto[0].stock;
				document.querySelector("#celCategoria").innerHTML = objProducto[0].categoria;
				document.querySelector("#celStatus").innerHTML = estadoProducto;
				document.querySelector("#celDescripcion").innerHTML = objProducto[0].descripcion;

				// Mostrando las imagenes.
				let htmlImage = "";
				// Determinando que tenga imagenes.
				if (objProducto.images.length > 0)
				{
					let objImagenes = objProducto.images; // Arreglos de Imagenes
					for (let p=0;p<objImagenes.length;p++)
					{
						//console.log("htmlImage ", objProductos[0].url_image);				
						htmlImage += `<img src="${objImagenes[p].url_image}"></img>`;
					} // for (let p=0;p<objProductos.length;p++)
				} // if (objProducto[0].images.length > 0)

				// Mostrando las imagenes si el producto tiene.
				// Asignando las imagenes al <DIV> celFotos que se encuentra en "modalViewProductos"
				document.querySelector("#celFotos").innerHTML = htmlImage;
				$('#modalViewProducto').modal('show');				
				
			} // if (objData.estatus)
			else
			{
				swal("Error",objData.msg,"error");					
			} // else - if (objData.estatus)

		}
	} // request.onreadystatechange = function() 

}

// Para editar el productos.
function fntEditInfo(element,idProducto)
{
	// Se modifica los elementos de la ventana que se utiliza en la captura de Productos, se reutiliza 	
	rowTable = element.parentNode.parentNode.parentNode;	

	// Sube desde "Button" hasta llegar al elemento padre "Renglon"
	// tr = class="odd" role = "row" contiene al renglon del producto que se quiere editar. 

	document.querySelector('.modal-header').classList.replace("headerRegister","headerUpdate");
	// Cambiando la clase de los botones (Colores)
	document.querySelector('#btnActionForm').classList.replace("btn-primary","btn-info");
	document.querySelector('#btnText').innerHTML = "Actualizar";
	document.querySelector('#titleModal').innerHTML = "Actualizar Productos";

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
				let objProducto = objData.data;
				//console.log (objProducto);
				// Asignando valores a la etiquetas de la pantalla de edicion de los productos.
				//objProducto[0]. = Para poder accesar 
				document.querySelector("#idProducto").value = objProducto[0].id_producto;
				document.querySelector("#txtNombre").value = objProducto[0].nombre;
				document.querySelector("#txtDescripcion").value = objProducto[0].descripcion;
				document.querySelector("#txtCodigo").value = objProducto[0].codigo;
				document.querySelector("#txtPrecio").value = objProducto[0].precio;
				document.querySelector("#txtStock").value = objProducto[0].stock;
				document.querySelector("#listCategoria").value = objProducto[0].categoriaid;
				document.querySelector("#listStatus").value = objProducto[0].estatus;
				
				// Coloca el contenido del "tinymce" en el producto.
				tinymce.activeEditor.setContent(objProducto[0].descripcion);
				// Para colocar en los combo box la opcion seleccionada.
				//$('#listaRoles').selectpicker('refresh'); Funciona en PHP 8
				//$('#listCategoria').selectpicker('render');
				$('#listCategoria').selectpicker('refresh');
				$('#listStatus').selectpicker('refresh');
				fntBarcode(); // Para llamar el código de barras.
				// Se quita la clase "notblock", para que se despliegue el codigo de barra.
				document.querySelector("#divBarCode").classList.remove("notBlock");

				// Determinando que tenga imagenes.
				let htmlImage = "";
				if (objProducto.images.length > 0)
				{
					let objProductos = objProducto.images; // Arreglos de Imagenes
					for (let p=0;p<objProductos.length;p++)
					{
						let key = Date.now()+p; // Obtiene la fecha y hora en formato numerico, se utiliza para identificador.
						//console.log("htmlImage ", objProductos[0].url_image);			
						// Se esta creando el elemento de la imagen, cuando se carga en el recuadro.	
						htmlImage += `<div id="div${key}"> 
							<div class="prevImage">
							<img src="${objProductos[p].url_image}"></img>
							</div>
							<button type="button" class="btnDeleteImage" onclick="fntDelItem('#div${key}')" imgname = "${objProductos[p].img}">
							<i class="fas fa-trash-alt"></i></button></div>`;
					} // for (let p=0;p<objProductos.length;p++)
				} // if (objProducto[0].images.length > 0)

				document.querySelector("#containerImages").innerHTML = htmlImage; // El recuadro de la Imagen
				document.querySelector("#divBarCode").classList.remove("notBlock");
				document.querySelector("#containerGallery").classList.remove("notBlock");
				$('#modalFormProductos').modal('show');				
				
			} // if (objData.estatus)
			else
			{
				swal("Error",objData.msg,"error");					
			} // else - if (objData.estatus)

		} // if (request.readyState == 4 && request.status == 200) // Esta retornando informacion

	} // request.onreadystatechange = function() 

}

// Borrar un producto
function fntDelProd(id_Producto)
{
	/*
	let btnDelRol = document.querySelectorAll(".btnDelRol");
	btnDelRol.forEach(function(btnDelRol){
		btnDelRol.addEventListener('click',function(){
	*/
	
	// alert(idrol);
	swal({
		title:"Eliminar Producto",
		text:"Realmente quiere eliminar el Producto",
		type:"warning",
		showCancelButton:true,
		confirmButtonText:"Si, eliminar !",
		cancelButtonText: "No, Cancelar !",
		closeOnConfirm:false,
		closeOnCancel:true
		},function(isConfirm)
		{
			// Borrar el Producto, utiliza Ajax para accesar a la Base de datos.
			if (isConfirm)
			{
				let request = (window.XMLHttpRequest) ? new XMLHttpRequest():new ActiveXObject('Microsoft.XMLHTTP');
				// Se pasan como parametro al método definido en "Roles.php -> Controllers" desde el Ajax
				let ajaxDelProducto = base_url+'/Productos/delProducto';
				let strData = "idProducto="+id_Producto;
				request.open("POST",ajaxDelProducto,true); // Se abre una conexion Ajax de tipo POST
				request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
				request.send(strData);
				request.onreadystatechange = function(){
					// Se hizo la petición y fue exitoso, llego la información al servidor.
					if (request.readyState == 4 && request.status == 200)
					{
						let objData = JSON.parse(request.responseText);
						if (objData.estatus)
						{
							swal("Eliminar! ",objData.msg,"success");
							tableProductos.api().ajax.reload(function(){
								//fntEditRol();
								//fntDelrol();
								//fntPermisos();
							});
						}
						else
						{
							swal("Error",objData.msg,"error");
						}
					}
				} 			
			}
	});		
} // functio fntDelProd...


// Funcion para extraer los datos de Categorias
function fntCategorias()
{
	// Valida si existe la etiqueta "listCategoria", es el Combox
	if (document.querySelector('#listCategoria'))
	{
		let ajaxUrl = base_url+'/Categorias/getSelectCategorias'; // Obtiene las categorias.
		// Detecta en que navegador se encuentra activo. Google Chrome, Firefox o Internet Explorer. 
		let request = (window.XMLHttpRequest) ? new XMLHttpRequest():new ActiveXObject('Microsoft.XMLHTTP');
		//let ajaxUrl = base_url+'/Categorias/setCategoria'; // Url a donde buscara el archivo, es en el Controlador/Roles.
		// El método utilizado para enviar la informacion es "GET"
		request.open("GET",ajaxUrl,true);
		request.send();
		
		// Validando lo que regresa el Ajax
		request.onreadystatechange = function()
		{
			// Valida que este devolviendo informacion.
			if (request.readyState == 4 && request.status == 200)
			{				
				// Agrega el codigo HTML que regresa el Ajax de la consulta (getSelectCategorias)
				document.querySelector('#listCategoria').innerHTML = request.responseText; // Asigna lo que se ejecuto en ajaxUrl = base_url+'/Categorias/getSelectCategorias', ya que retorna codigo HTML (cuando se ejecuta el "ajaxURL"), por lo que no se conviertio a objeto JSon
				// Se muestren las opciones aplicando el buscador. Se renderiza, se utiliza JQuery (selecpicker)
				$('#listCategoria').selectpicker('render');
			}
		}
	}
} // function fntCategorias()

// Para mostrar la ventana Modal de los Productos
function openModal()
{
	rowTable = ""; // Para evitar el error cuando se oprime nuevo producto, y muestra informacion que se haya cargado anteriormente

	//alert("OpenModal");
	// Se actualizan los datos de la ventana modal a Mostrar, se agregan estos valores para que se pueda actualiar la ventana modal de "Agregar" y "Actualizar" Productos.

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

	// Para borrar las imagenes cuando se oprima el boton "Nuevo Producto"
	// Estos son los <DIV> en la pantallas de cpatura de productos ("/View/Modal/Templeate/ModalProducto.php")
	document.querySelector("#divBarCode").classList.add("notBlock");
	document.querySelector("#containerGallery").classList.add("notBlock");
	document.querySelector("#containerImages").innerHTML = ""; // Elimina las imagenes.

	$('#modalFormProductos').modal('show');
	//removePhoto();

}

