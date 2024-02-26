
let rowTable = "";

	// Validar las datos de capturas de Notas

	// Validar la entrada, solo caracteres permitidos "txtNombre"
	$("#txtTitulo").bind('keypress', function(event) {
		var regex = new RegExp("^[A-Za-z0-9- ]+$");
		var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
		if (!regex.test(key)) {
			event.preventDefault();
			return false;
		}
	});

	// Validar la entrada, solo caracteres permitidos "txtDuracion"
	$("#txtDuracion").bind('keypress', function(event) {
		var regex = new RegExp("^[0-9]+$");
		var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
		if (!regex.test(key)) {
			event.preventDefault();
			return false;
		}
	});


	// Validar la entrada, solo caracteres permitidos "txtDescripcion"
	$("#txtDescripcion").bind('keypress', function(event) {
		var regex = new RegExp("^[A-Za-z0-9,- ]+$");
		var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
		if (!regex.test(key)) {
			event.preventDefault();
			return false;
		}
	});

	// =====================================================
	// Seccion para integrar la libreria de TinyMCE
	// =====================================================

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


// Funcion para extraer los datos de las Personas
function fntPersonas()
{
	// Valida si existe la etiqueta "listPersonas", es el Combox
	if (document.querySelector('#listPersonas'))
	{
		let ajaxUrl = base_url+'/Personas/getSelectPersonas'; // Obtiene las categorias.
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
				// Agrega el codigo HTML que regresa el Ajax de la consulta (getSelectPersonas), 
				document.querySelector('#listPersonas').innerHTML = request.responseText; // Asigna lo que se ejecuto en ajaxUrl = base_url+'/Categorias/getSelectCategorias', ya que retorna codigo HTML (cuando se ejecuta el "ajaxURL"), por lo que no se conviertio a objeto JSon

				// Se muestren las opciones aplicando el buscador. Se renderiza, se utiliza JQuery (selecpicker)
				// $('#listPersonas').selectpicker('render');
				$('#listPersonas').selectpicker('refresh');
			}
		}
	}
} // function fntPersonas()

let tableNotas;
// Cuando se termina de cargar la página, se asignan los eventos Listener.
document.addEventListener('DOMContentLoaded',function()
{
	// no colocar aqui la funcion : "fntPersonas()" porque muestra error de Sesion de usuario y no deja accesar a esta pagina, se debe colocar en la funcion "OpenModal", se encuentra en la parte de abajo.

	// Código para mostrar las Categorias.
		// Es el dataTable para desplegar los "Clientes".
		tableNotas = $('#tableNotas').dataTable({
			"aProcessing":true,
			"aServerside":true,
			"language": {
				"url":"//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
			},
			"ajax":{
				"url":" "+base_url+"/Notas/getNotas",
				"dataSrc":""
			},
			"columns":[
				{"data":"id_nota"},
				{"data":"titulo_nota"},				
				{"data":"nombre_completo"},
				{"data":"duracion_nota"},
				{"data":"Fecha_Asignado"},
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
			//"order":[[0,"desc"]]
			"order":[[1,"asc"]]
		});


	// =======================================================================
	// SECCION PARA ENVIAR LOS DATOS A LA TABLAS POR MEDIO DE AJAX 
	// =======================================================================

	// Tambien se utiliza para editar una Nota.
	// En esta parte se inicia con el Ajax para grabar la información.
	// Capturar los datos del formulario de "Nueva Nota"
	// Seleccionan el id del formulario de Notas
	//let formNotas = document.querySelector("#formNotas"); // 
	
	// Cuando se oprime el boton "Guardar" (submit)
	if (document.querySelector("#formNotas")) // Si existe el Formulario
	{
		let formNotas = document.querySelector("#formNotas");
		formNotas.onsubmit = function(e) // Se asigna el evento "submit"
		{
			e.preventDefault(); // Previene que se recargue al momento de oprimir el Boton Guardar.
			//console.log("Se oprimio el boton -Guardar- ");
			
			let strTitulo = document.querySelector('#txtTitulo').value;
			//let strDescripcion = document.querySelector('#txtDescripcion').value;
			//let strlistPersonas = document.querySelector('#listPersona').value;
			let intDuracion = document.querySelector('#txtDuracion').value;
			let intStatus = document.querySelector('#listStatus').value;
			let intPersona = document.querySelector('#listPersonas').value;
			let strFecha_Nota = document.querySelector('#txtFecha_Nota').value;

			if (strTitulo == '' || intDuracion == '' || intStatus == '')
			{
				swal ("Atencion","Todos los campos son Obligatorio","error");
				return false;
			}

			divLoading.style.display = "flex"; // Muestra un icono de Carga (circulo)

			tinyMCE.triggerSave();// Seccion del editor guarda todo al TextArea.
			// Ya que para  guardar información se extrae los datos de las etiqueta HTML.

			// Enviando datos por Ajax.
			// Detecta en que navegador se encuentra activo. Google Chrome, Firefox o Internet Explorer. 
			let request = (window.XMLHttpRequest) ? new XMLHttpRequest():new ActiveXObject('Microsoft.XMLHTTP');
			let ajaxUrl = base_url+'/Notas/setNota'; // Url a donde buscara el archivo, es en el Controlador/Productos.
			let formData = new FormData(formNotas);
			// El método utilizado para enviar la informacion es "POST"
			request.open("POST",ajaxUrl,true);
			request.send(formData);

			// Validando lo que regresa el Ajax
			request.onreadystatechange = function()
			{
				// Valida que este devolviendo informacion.
				if (request.readyState == 4 && request.status == 200)
				{	
					// console.log(request.responseText);
					// Parsea el "request", es decir se convierte en Objeto
					divLoading.style.display = "none";
				
					// Convierte a formato JSon lo que retorna la funcion : "setNotas" del controlador que viene ser un arreglo : $arrResponse = array("estatus" => false, "msg" => 'Datos Incorrectos');
					// Dependiendo de la condicion es el contenido del "$arrResponse".

					let objData = JSON.parse(request.responseText);
					if (objData.estatus)
					{
						swal("",objData.msg,"success");	
						// Para agregar las fotos del Producto.
						document.querySelector("#idNota").value = objData.id_nota;

						$('#modalFormNotas').modal("hide");
						tableNotas.api().ajax.reload(); // Recarga el 


						if (rowTable == "") // Es una nota nueva
						{
							tableNotas.api().ajax.reload(); // Recarga el DataTable de las Notas.
						}
						else // Actualizar la Nota
						{
							htmlStatus = intStatus == 1?
								'<span class="badge badge-success">Activo</span>':
								'<span class="badge badge-danger">Inactivo</span>';
							rowTable.cells[1].textContent = strTitulo;
							rowTable.cells[2].textContent = strDescripcion;
							rowTable.cells[3].textContent = intPersona;
							rowTable.cells[4].textContent = intDuracion;
							rowTable.cells[5].textContent = strFecha_Nota;
							rowTable.cells[6].innerHTML = htmlStatus;		// Para que lo agregue como contenido HTML.				
							rowTable = "";	
							$('#modalFormNotas').modal("hide");
							tableNotas.api().ajax.reload(); // Recarga el 
						} // if (rowTable == "")
					}
					else
					{
						swal("Error",objData.msg,"error");						
					}			

					$('#modalFormNotas').modal("hide");
					formNotas.reset();
					

					//swal("Modelos",objData.msg,"success");
					
				} // if (request.readyState == 4 && request.status == 200)

				divLoading.style.display = "none";			
				return false;

			} // request.onreadystatechange = function()

		} // formProductos.onsubmit = function(e)

	} // if (this.document.querySelector("#formProductos"))


}, false); //document.addEventListener('DOMContentLoaded',function(){


		// Para mostrar el modal "View Notas"
function fntViewInfo(idNota)
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
	let id_nota = idNota;
	//console.log(id_nota);

	// Detecta en que navegador se encuentra activo. Google Chrome, Firefox o Internet Explorer. 
	let request = (window.XMLHttpRequest) ? new XMLHttpRequest():new ActiveXObject('Microsoft.XMLHTTP');

	// Se pasan como parametro al método definido en "Usuarios.php -> Controllers" desde el Ajax
	// Va obtener los datos del usuarios usando "Ajax"
	let ajaxUrl = base_url+'/Notas/getNota/'+id_nota; 
	request.open("GET",ajaxUrl,true);
	request.send(); // Se envia la petición (ejecutar el archivo "getNota/XXX")
	// Lo que retorne (echo Json.... el Controllers/Notas/getNota
	console.log(request.responseText);

	request.onreadystatechange = function()
	{
		if (request.status == 200 && request.readyState == 4)
		{			
			// Retorna a un objeto lo que se retorna en "getNota"

			// Convierte a formato JSon lo que viene como objeto de la consulta.
			let objData = JSON.parse(request.responseText);
			//console.log(objData);

			if (objData.estatus)
			{	
				let estado = objData.data.estatus == 1 ?
				'<span class="badge badge-success">Activo</span>':
				'<span class="badge badge-danger">Inactivo</span>';

				// Asigna el valor a todas las etiquetas de la ventana Modal.
				document.querySelector("#celIdNota").innerHTML = objData.data.id_nota;	
				document.querySelector("#celTitulo").innerHTML = objData.data.titulo_nota;
				document.querySelector("#celDescripcion").innerHTML = objData.data.descripcion;
				document.querySelector("#celAsignado").innerHTML = objData.data.nombre_completo;
				document.querySelector("#celDuracion").innerHTML = objData.data.duracion_nota;
				document.querySelector("#celFechaAsignado").innerHTML = objData.data.Fecha_Asignado;
				document.querySelector("#celEstado").innerHTML = estado;
				
				$('#modalViewNotas').modal('show');

			} // if (objData.estatus)
			else
			{
				swal ("Error",objData.msg, "error");
			}

		} // if (request.status == 200)

	} // 	request.onreadystatechange = function()

} // function fntViewInfo(idpersona)

// Para editar Nota
function fntEditInfo(element,idNota)
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
	// "us" se agrego junto con los botones de "Editar","Borrar" cunado se muestran los Roles. Es el "id" del Modulo en la tabla.
	//var idpersona = this.getAttribute("us");
	// Cambiando los colores de la franja al formulario.
	// Estas definidos en "ModalCategorias.php"
	document.querySelector('.modal-header').classList.replace("headerRegister","headerUpdate");
	// Cambiando la clase de los botones (Colores)
	document.querySelector('#btnActionForm').classList.replace("btn-primary","btn-info");
	document.querySelector('#btnText').innerHTML = "Actualizar";
	document.querySelector('#titleModal').innerHTML = "Actualizar Nota";
	

	let id_nota = idNota;
	//console.log(idrol);

	// Detecta en que navegador se encuentra activo. Google Chrome, Firefox o Internet Explorer. 
	let request = (window.XMLHttpRequest) ? new XMLHttpRequest():new ActiveXObject('Microsoft.XMLHTTP');

	// Se pasan como parametro al método definido en "Notas.php -> Controllers" desde el Ajax
	// Va obtener los datos del usuarios usando "Ajax"
	let ajaxUrl = base_url+'/Notas/getNota/'+id_nota; 
	request.open("GET",ajaxUrl,true);
	request.send(); // Se envia la petición (ejecutar el archivo "getModulo/XXX")
	// Lo que retorne (echo Json.... el Controllers/Modulos/getModulo
	request.onreadystatechange = function()
	{
		if (request.status == 200 && request.readyState == 4)
		{
			// Retorna a un objeto de la funcion "getNota" de ModelNota.php, al formato JSon(Objeto)
			let objData = JSON.parse(request.responseText);

			if (objData.estatus)
			{	
				fntPersonas();												
				// idNota = Se definio como campo oculto en "ModalNota.php", "formNotas"
				objPersona = objData.data;
				//console.log(objPersona);
				//console.log(objPersona.id_nota);

				//console.log(objPersona[0].idPersona);	

				document.querySelector("#idNota").value = objPersona.id_nota;	
				document.querySelector("#txtTitulo").value = objPersona.titulo_nota;
				document.querySelector("#txtDescripcion").value = objPersona.descripcion_nota;
				document.querySelector("#txtDuracion").value = objPersona.duracion_nota;
				//document.querySelector("#txtFecha_Nota").value = objData.data.Fecha_Asignado;
				document.querySelector("#txtFecha_Nota").value = objPersona.Fecha_Asignado;
				// Colocar el contenido de descripcion en "tinymce"
				tinymce.activeEditor.setContent(objPersona.descripcion);

				if (objPersona.estatus == 1)
				{
					document.querySelector('#listStatus').value = 1;
				}
				else
				{
					document.querySelector('#listStatus').value = 2;
				}

				// Para que se seleccione la opcion que esta grabada en la tabla
				// "selectpicker" = Es una libreria.
				//$('#listStatus').selectpicker('render');
				$('#listStatus').selectpicker('refresh');
				
				// Colocar el ComboBox en la opcion seleccionada
				//console.log(objData.data.idPersona)
				
				document.querySelector("#listPersonas").value = objPersona.idPersona;
				
				// "selectpicker" = Es una libreria.
				//$('#listPersonas').selectpicker('render'); //
				$('#listPersonas').selectpicker('refresh');

				$('#modalFormNotas').modal('show');

			} // if (objData.estatus)
			else
			{
				swal ("Error",objData.msg, "error");
			}

		} // if (request.status == 200)

	} // 	request.onreadystatechange = function()

} // function fntViewInfo(idpersona)

// Borrar una Categoria
function fntDelInfo(id_Nota)
{
	/*
	let btnDelRol = document.querySelectorAll(".btnDelRol");
	btnDelRol.forEach(function(btnDelRol){
		btnDelRol.addEventListener('click',function(){
	*/
	let idNota = id_Nota;
	// alert(idrol);
	swal({
		title:"Eliminar Nota",
		text:"Realmente quiere eliminar la Nota ?",
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
				let ajaxDelNota = base_url+'/Notas/delNota';
				let strData = "idNota="+idNota;
				request.open("POST",ajaxDelNota,true);
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
							tableNotas.api().ajax.reload(function(){
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
} // functio fntDelNota...


// Para mostrar la ventana Modal de Notas.
function openModal()
{
	rowTable = "";
	fntPersonas();

	//alert("OpenModal");
	// Se actualizan los datos de la ventana modal a Mostrar, se agregan estos valores para que se pueda actualiar la ventana modal de "Agregar" y "Actualizar" Usuarios.

	
	// Es el Input "hidden" que se encuentra : /Views/Templetes/Modals/ModalModulos.php
	document.querySelector('#idNota').value = "";	
	// Cambiando los colores de la franja de la ventana.
	// Estas definidos en "ModalModulos.php"
	document.querySelector('.modal-header').classList.replace("headerUpdate","headerRegister");
	// Cambiando la clase de los botones (Colores)
	document.querySelector('#btnActionForm').classList.replace("btn-info","btn-primary");
	document.querySelector('#btnText').innerHTML = "Nuevo";
	document.querySelector('#titleModal').innerHTML = "Crear Nota";
	// Resetear el Formulario, limpia todos los campos.
	document.querySelector('#formNotas').reset();

	$('#modalFormNotas').modal('show');
	
}

