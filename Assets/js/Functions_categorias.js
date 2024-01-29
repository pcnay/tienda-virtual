let rowTable = "";

	// Validar las datos de capturas de Categorias

	// Validar la entrada, solo caracteres permitidos "txtNombre"
	$("#txtNombre").bind('keypress', function(event) {
		var regex = new RegExp("^[A-Za-z0-9ñÑáéóúí- ]+$");
		var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
		if (!regex.test(key)) {
			event.preventDefault();
			return false;
		}
	});

	// Validar la entrada, solo caracteres permitidos "txtPrecio"
	$("#txtPrecio").bind('keypress', function(event) {
		var regex = new RegExp("^[0-9.]+$");
		var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
		if (!regex.test(key)) {
			event.preventDefault();
			return false;
		}
	});

	// Validar la entrada, solo caracteres permitidos "txtStock"
	$("#txtStock").bind('keypress', function(event) {
		var regex = new RegExp("^[0-9.]+$");
		var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
		if (!regex.test(key)) {
			event.preventDefault();
			return false;
		}
	});

	// Validar la entrada, solo caracteres permitidos "txtDescripcion"
	$("#txtDescripcion").bind('keypress', function(event) {
		var regex = new RegExp("^[A-Za-z0-9 ]+$");
		var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
		if (!regex.test(key)) {
			event.preventDefault();
			return false;
		}
	});


let tableCategorias;
// Cuando se termina de cargar la página, se asignan los eventos Listener.
document.addEventListener('DOMContentLoaded',function()
{
	// Código para mostrar las Categorias.
		// Es el dataTable para desplegar los "Clientes".
		tableCategorias = $('#tableCategorias').dataTable({
			"aProcessing":true,
			"aServerside":true,
			"language": {
				"url":"//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
			},
			"ajax":{
				"url":" "+base_url+"/Categorias/getCategorias",
				"dataSrc":""
			},
			"columns":[
				{"data":"id_categoria"},
				{"data":"nombre"},
				{"data":"descripcion"},
				{"data":"estatus"},
				{"data":"options"}
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
					"className":"btn btn-success"
				},
				{
					"extend": "pdfHtml5",
					"text":"<i class = 'far fa-file-pdf'></i>PDF",
					"titleAttr":"Exportar a PDF",
					"className":"btn btn-danger"
				},
				{
					"extend": "csvHtml5",
					"text":"<i class = 'fas fa-file-csv'></i>CSV",
					"titleAttr":"Exportar a CSV",
					"className":"btn btn-info"
				}
			],
			"resonsieve":"true",
			"bDestroy":true,
			"iDisplayLength":10,
			"order":[[0,"desc"]]
		});
	
	// Se utiliza para que visualize la foto en el recuadro en "Categorías". Tamano : 570(Largo)x380(Ancho)
	if(document.querySelector("#foto"))
	{
    let foto = document.querySelector("#foto");
    foto.onchange = function(e) 
		{
			let uploadFoto = document.querySelector("#foto").value;
			let fileimg = document.querySelector("#foto").files;
			let nav = window.URL || window.webkitURL;
			let contactAlert = document.querySelector('#form_alert'); // Lo muestra en el DIV con el ID "form_alert" en la Vista.
			if(uploadFoto !='')
			{
				let type = fileimg[0].type;
				let name = fileimg[0].name;
				if(type != 'image/jpeg' && type != 'image/jpg' && type != 'image/png')
				{
						contactAlert.innerHTML = '<p class="errorArchivo">El archivo no es válido.</p>';
						if(document.querySelector('#img'))
						{
								document.querySelector('#img').remove();
						}

						// Oculta la X del recuadro de la Imagen.
						document.querySelector('.delPhoto').classList.add("notBlock");
						foto.value="";
						return false; // Se para la ejecucion del programa.
				}
				else
				{  
					contactAlert.innerHTML='';
					if(document.querySelector('#img'))
					{
							document.querySelector('#img').remove();
					}
					document.querySelector('.delPhoto').classList.remove("notBlock"); // Para mostrar la X en la foto
					let objeto_url = nav.createObjectURL(this.files[0]); // Crea un objeto y extrae la ruta donde esta ubicado el archivo.
					// Se crea el nodo para agregar la imagen.
					document.querySelector('.prevPhoto div').innerHTML = "<img id='img' src="+objeto_url+">";
				
				} // if(type != 'image/jpeg' && type != 'image/jpg' && type != 'image/png')

      }
			else
			{
				alert("No selecciono foto");
				if(document.querySelector('#img'))
				{
						document.querySelector('#img').remove();						
				} // if(document.querySelector('#img'))

			} // if(uploadFoto !='')

    } // foto.onchange = function(e) 

	} //if(document.querySelector("#foto"))

	// Para eliminar la imagen Previo de la Foto en el Recuadro.
	if(document.querySelector(".delPhoto"))
	{
		let delPhoto = document.querySelector(".delPhoto");
		delPhoto.onclick = function(e)
		{
			// La imagen actual se tiene que eliminar, pero siempre y cuando el usuario oprima la X de la parte superior.
			document.querySelector("#foto_remove").value = 1;
			removePhoto();
		}
	}

	// =======================================================================
	// SECCION PARA ENVIAR LOS DATOS A LA TABLAS POR MEDIO DE AJAX 
	// =======================================================================

	// Tambien se utiliza para editar una categoria.
	// En esta parte se inicia con el Ajax para grabar la información.
	// Capturar los datos del formulario de "Nuevo Categoria"
	// Seleccionan el id del formulario de Categoria
	let formCategoria = document.querySelector("#formCategoria"); // 
	//console.log (formaRol);
	formCategoria.onsubmit = function(e){
		e.preventDefault();
		//console.log("Onsubmit");

		// Obtener el contenido de las etiquetas del Modal "Agregar Categoria"
		let intIdCategoria = document.querySelector('#idCategoria').value;
		let strNombre = document.querySelector("#txtNombre").value;
		let strDescripcion = document.querySelector("#txtDescripcion").value;
		let intStatus = document.querySelector("#listStatus").value;

		if (strNombre == '' || strDescripcion == '' || intStatus == '')
		{
			swal ("Atencion","Todos los campos son obligatorios","error");
			return false; // Detiene el proceso.
		}

		divLoading.style.display = "flex";
		// Detecta en que navegador se encuentra activo. Google Chrome, Firefox o Internet Explorer. 
		let request = (window.XMLHttpRequest) ? new XMLHttpRequest():new ActiveXObject('Microsoft.XMLHTTP');
		let ajaxUrl = base_url+'/Categorias/setCategoria'; // Url a donde buscara el archivo, es en el Controlador/Roles.
		
		var formData = new FormData(formCategoria); // Obtiene la etiqueta del formulario.
		// El método utilizado para enviar la informacion es "POST"
		request.open("POST",ajaxUrl,true);
		request.send(formData);
		request.onreadystatechange = function(){
			if (request.readyState == 4 && request.status == 200) // Verifica que si llego la información al navegador
			{
				// console.log(request.responseText); // Determinar el contenido de lo que retorno(Categorias/setCategoria)
				// La información que viene desde el método "setCategoria" del Controllers "Categorias"
				let objData = JSON.parse(request.responseText);
				divLoading.style.display = null;

				// Accesando a los elementos del Arreglo asociativo, del valor retornado de "setCategoria"
				if (objData.estatus)
				{
					if (rowTable == "")
					{
						tableCategorias.api().ajax.reload() //function(){
							//fntEditRol(); // Para cuando se reacargue el DataTable asigne el evento "Click" de los botones.
							//fntDelRol();
							//fntPermisos();
						//});					
					}
					else
					{
						// Actualizando los registros
						htmlStatus = intStatus == 1 ?
						'<span class="badge badge-success">Activo</span>':
						'<span class="badge badge-danger">Inactivo</span>';

						// No recargara toda la tabla.
						rowTable.cells[1].textContent = strNombre;
						rowTable.cells[2].textContent = strDescripcion;
						rowTable.cells[3].innerHTML = htmlStatus; // Es por que se asigna código HTML (innerHTML)
						rowTable = "";
					}
					$('#modalFormCategorias').modal("hide");
					formCategoria.reset();
					swal("Categorias ",objData.msg,"success");
					removePhoto();					
				}
				else //if (objData.estatus)
				{
					swal("Error",objData.msg,"error");
				} // if (objData.estatus)
				
			}
			//console.log(request);
			return false;
		}
	}


}, false); //document.addEventListener('DOMContentLoaded',function(){

// Funcion para remover la foto de Categoría
function removePhoto()
{
	document.querySelector('#foto').value ="";
	document.querySelector('.delPhoto').classList.add("notBlock"); // Ocultar la X
	// Si existe la etiqueta "img"
	if (document.querySelector('#img'))
	{
		document.querySelector('#img').remove(); // Remueve la imagen.
	}

}


// Para mostrar el modal "View Categoría"
function fntViewInfo(idcategoria)
{
	//$('#modalViewCliente').modal('show');

	//console.log('Entre a Function fntViewCliene');
	/*
	var btnEditRol_b = document.querySelectorAll(".btnEditRol");
	console.log (btnEditRol_b);
	btnEditRol_b.forEach(function(btnEditRol_b){
	

		btnEditRol_b.addEventListener('click',function(){
			//console.log('Click en el boton de edit');
	*/
	
	// El código para ejecutar Ajax.
	// "us" se agrego junto con los botones de "Editar","Borrar" cunado se muestran los Roles. Es el "id" del Rol en la tabla.
	//var idpersona = this.getAttribute("us");
	let id_categoria = idcategoria;
	//console.log(idrol);

	// Detecta en que navegador se encuentra activo. Google Chrome, Firefox o Internet Explorer. 
	let request = (window.XMLHttpRequest) ? new XMLHttpRequest():new ActiveXObject('Microsoft.XMLHTTP');

	// Se pasan como parametro al método definido en "Usuarios.php -> Controllers" desde el Ajax
	// Va obtener los datos del usuarios usando "Ajax"
	let ajaxUrl = base_url+'/Categorias/getCategoria/'+id_categoria; 
	request.open("GET",ajaxUrl,true);
	request.send(); // Se envia la petición (ejecutar el archivo "getCategoria/XXX")
	// Lo que retorne (echo Json.... el Controllers/Categorias/getCategoria
	request.onreadystatechange = function()
	{
		if (request.status == 200 && request.readyState == 4)
		{
			// Retorna a un objeto lo que se retorna en "getCategoria"

			// Convierte a formato JSon lo que viene como objeto de la consulta.
			let objData = JSON.parse(request.responseText);
			if (objData.estatus)
			{	
				let estado = objData.data.estatus == 1 ?
				'<span class="badge badge-success">Activo</span>':
				'<span class="badge badge-danger">Inactivo</span>';

				// Asigna el valor a todas las etiquetas de la ventana Modal.
				document.querySelector("#celId").innerHTML = objData.data.id_categoria;	
				document.querySelector("#celNombre").innerHTML = objData.data.nombre;
				document.querySelector("#celDescripcion").innerHTML = objData.data.descripcion;
				document.querySelector("#celEstado").innerHTML = estado;
				document.querySelector("#imgCategoria").innerHTML = '<img src = "'+objData.data.url_portada+'"></img>';
				
				$('#modalViewCategoria').modal('show');

			} // if (objData.estatus)
			else
			{
				swal ("Error",objData.msg, "error");
			}

		} // if (request.status == 200)

	} // 	request.onreadystatechange = function()

} // function fntViewInfo(idpersona)

// Para editar Categoría
function fntEditInfo(element,idcategoria)
{
	//$('#modalViewCliente').modal('show');
	// Obtener el elemento padre de "element" que se esta mandando en el momento de la ejecucion de la funcion.
	// cada "parentNode" corresponde a cada una de las etiquetas hasta llegar al principal.
	rowTable = element.parentNode.parentNode.parentNode;
	// console.log(rowTable);
	//rowTable.cells[1].textContent = "sdfeds";


	//console.log('Entre a Function fntViewCliene');
	/*
	var btnEditRol_b = document.querySelectorAll(".btnEditRol");
	console.log (btnEditRol_b);
	btnEditRol_b.forEach(function(btnEditRol_b){
	

		btnEditRol_b.addEventListener('click',function(){
			//console.log('Click en el boton de edit');
	*/
	
	// El código para ejecutar Ajax.
	// "us" se agrego junto con los botones de "Editar","Borrar" cunado se muestran los Roles. Es el "id" del Rol en la tabla.
	//var idpersona = this.getAttribute("us");
	// Cambiando los colores de la franja al formulario.
	// Estas definidos en "ModalCategorias.php"
	document.querySelector('.modal-header').classList.replace("headerRegister","headerUpdate");
	// Cambiando la clase de los botones (Colores)
	document.querySelector('#btnActionForm').classList.replace("btn-primary","btn-info");
	document.querySelector('#btnText').innerHTML = "Actualizar";
	document.querySelector('#titleModal').innerHTML = "Actualizar Categoria";

	let id_categoria = idcategoria;
	//console.log(idrol);

	// Detecta en que navegador se encuentra activo. Google Chrome, Firefox o Internet Explorer. 
	let request = (window.XMLHttpRequest) ? new XMLHttpRequest():new ActiveXObject('Microsoft.XMLHTTP');

	// Se pasan como parametro al método definido en "Categoria.php -> Controllers" desde el Ajax
	// Va obtener los datos del usuarios usando "Ajax"
	let ajaxUrl = base_url+'/Categorias/getCategoria/'+id_categoria; 
	request.open("GET",ajaxUrl,true);
	request.send(); // Se envia la petición (ejecutar el archivo "getCategoria/XXX")
	// Lo que retorne (echo Json.... el Controllers/Categorias/getCategoria
	request.onreadystatechange = function()
	{
		if (request.status == 200 && request.readyState == 4)
		{
			// Retorna a un objeto de la funcion "getUsuario" de ModeloCategorias.php, al formato JSon
			let objData = JSON.parse(request.responseText);
			if (objData.estatus)
			{													
				document.querySelector("#idCategoria").value = objData.data.id_categoria;	
				document.querySelector("#txtNombre").value = objData.data.nombre;
				document.querySelector("#txtDescripcion").value = objData.data.descripcion;
				document.querySelector("#foto_actual").value = objData.data.portada;
				document.querySelector("#foto_remove").value = 0;

				if (objData.data.estatus == 1)
				{
					document.querySelector('#listStatus').value = 1;
				}
				else
				{
					document.querySelector('#listStatus').value = 2;
				}

				// Para que se seleccione la opcion que esta grabada en la tabla
				// "selectpicker" = Es una libreria.
				$('#listStatus').selectpicker('render');
				
				// Mostrar la portada de la imagen
				if (document.querySelector('#img'))
				{
					// Coloca la ruta de la imagen.
					document.querySelector('#img').src = objData.data.url_portada;					
				}
				else
				{
					// Se derige a la clase "prevPhoto" (que se define en ModalCategoria), en el "DIV", y crea en tiempo de ejecución.
					document.querySelector('.prevPhoto div').innerHTML = "<img id='img' src="+objData.data.url_portada+">";
				}

				// Para mostrar la "X" 
				if (objData.data.portada == 'portada_categoria.png')
				{
					// Que no se muestre la "X" 
					document.querySelector('.delPhoto').classList.add("notBlock");
				}
				else
				{
					// Que se muestre la "X" en la parte superior de la foto.
					document.querySelector('.delPhoto').classList.remove("notBlock");
				}

				$('#modalFormCategorias').modal('show');

			} // if (objData.estatus)
			else
			{
				swal ("Error",objData.msg, "error");
			}

		} // if (request.status == 200)

	} // 	request.onreadystatechange = function()

} // function fntViewInfo(idpersona)

// Borrar una Categoria
function fntDelInfo(id_Categoria)
{
	/*
	let btnDelRol = document.querySelectorAll(".btnDelRol");
	btnDelRol.forEach(function(btnDelRol){
		btnDelRol.addEventListener('click',function(){
	*/
	let idCategoria = id_Categoria;
	// alert(idrol);
	swal({
		title:"Eliminar Categoria",
		text:"Realmente quiere eliminar la Categoria ?",
		type:"warning",
		showCancelButton:true,
		confirmButtonText:"Si, eliminar !",
		cancelButtonText: "No, Cancelar !",
		closeOnConfirm:false,
		closeOnCancel:true
		},function(isConfirm)
		{
			// Borrar la "Categoria", utiliza Ajax para accesar a la Base de datos.
			if (isConfirm)
			{
				let request = (window.XMLHttpRequest) ? new XMLHttpRequest():new ActiveXObject('Microsoft.XMLHTTP');
				// Se pasan como parametro al método definido en "Roles.php -> Controllers" desde el Ajax
				let ajaxDelCategoria = base_url+'/Categorias/delCategoria';
				let strData = "idCategoria="+idCategoria;
				request.open("POST",ajaxDelCategoria,true);
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
							tableCategorias.api().ajax.reload(function(){
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
} // functio fntDelUsuario...


// Para mostrar la ventana Modal de Categorias.
function openModal()
{
	rowTable = "";

	//alert("OpenModal");
	// Se actualizan los datos de la ventana modal a Mostrar, se agregan estos valores para que se pueda actualiar la ventana modal de "Agregar" y "Actualizar" Usuarios.

	// Estes lineas de definieron en "fntEditUsario()"
	// Es el Input "hidden" que se encuentra : /Views/Templetes/Modals/ModalUsuarios.php
	document.querySelector('#idCategoria').value = "";	
	// Cambiando los colores de la franja de la ventana.
	// Estas definidos en "ModalUsuarios.php"
	document.querySelector('.modal-header').classList.replace("headerUpdate","headerRegister");
	// Cambiando la clase de los botones (Colores)
	document.querySelector('#btnActionForm').classList.replace("btn-info","btn-primary");
	document.querySelector('#btnText').innerHTML = "Guardar";
	document.querySelector('#titleModal').innerHTML = "Nuevo Categoria";
	// Resetear el Formulario, limpia todos los campos.
	document.querySelector('#formCategoria').reset();

	$('#modalFormCategorias').modal('show');
	removePhoto();

}

