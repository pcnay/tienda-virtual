
let rowTable = "";

	// Validar las datos de capturas de Modelos
	// Validar la entrada, solo caracteres permitidos "txtDescripcion"
	$("#txtDescripcion").bind('keypress', function(event) {
		let regex = new RegExp("^[A-Za-z0-9- ]+$");
		let key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
		if (!regex.test(key)) {
			event.preventDefault();
			return false;
		}
	});


let tableModelos;
// Cuando se termina de cargar la página, se asignan los eventos Listener.
document.addEventListener('DOMContentLoaded',function()
{
	// Código para mostrar las Categorias.
		// Es el dataTable para desplegar los "Clientes".
		tableModelos = $('#tableModelos').dataTable({
			"aProcessing":true,
			"aServerside":true,
			"language": {
				"url":"//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
			},
			"ajax":{
				"url":" "+base_url+"/Modelos/getModelos",
				"dataSrc":""
			},
			"columns":[
				{"data":"id_modelo"},
				{"data":"descripcion"},
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

	// Tambien se utiliza para editar un Modelo.
	// En esta parte se inicia con el Ajax para grabar la información.
	// Capturar los datos del formulario de "Nuevo Modelo"
	// Seleccionan el id del formulario de Modelo
	let formModelo = document.querySelector("#formModelo"); // 
	//console.log (formaRol);
	formModelo.onsubmit = function(e){
		e.preventDefault();
		//console.log("Onsubmit");

		// Obtener el contenido de las etiquetas del Modal "Agregar Modelo"
		let intIdModelo = document.querySelector('#idModelo').value;
		let strDescripcion = document.querySelector("#txtDescripcion").value;		

		if (strDescripcion == '')
		{
			swal ("Atencion","El campo es obligatorios","error");
			return false; // Detiene el proceso.
		}

		divLoading.style.display = "flex";
		// Detecta en que navegador se encuentra activo. Google Chrome, Firefox o Internet Explorer. 
		let request = (window.XMLHttpRequest) ? new XMLHttpRequest():new ActiveXObject('Microsoft.XMLHTTP');
		let ajaxUrl = base_url+'/Modelos/setModelo'; // Url a donde buscara el archivo, es en el Controlador/Modulos.
		
		let formData = new FormData(formModelo); // Obtiene la etiqueta del formulario.
		// El método utilizado para enviar la informacion es "POST"
		request.open("POST",ajaxUrl,true);
		request.send(formData);
		request.onreadystatechange = function(){
			if (request.readyState == 4 && request.status == 200) // Verifica que si llego la información al navegador
			{
				// console.log(request.responseText); // Determinar el contenido de lo que retorno(Categorias/setCategoria)
				// La información que viene desde el método "setModulo" del Controllers "Modulos"
				let objData = JSON.parse(request.responseText);
				divLoading.style.display = null;

				// Accesando a los elementos del Arreglo asociativo, del valor retornado de "setCategoria"
				if (objData.estatus)
				{
					if (rowTable == "")
					{
						tableModelos.api().ajax.reload() //function(){
							//fntEditRol(); // Para cuando se reacargue el DataTable asigne el evento "Click" de los botones.
							//fntDelRol();
							//fntPermisos();
						//});					
					}
					else
					{
						// Actualizando los registros
						// No recargara toda la tabla.						
						rowTable.cells[1].textContent = strDescripcion;
						rowTable = "";
					}
					$('#modalFormModelo').modal("hide");
					formModelo.reset();
					swal("Modelos",objData.msg,"success");
					//removePhoto();					
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


// Para mostrar el modal "View Modelos"
function fntViewInfo(idmodelo)
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
	let id_modelo = idmodelo;
	//console.log(idrol);

	// Detecta en que navegador se encuentra activo. Google Chrome, Firefox o Internet Explorer. 
	let request = (window.XMLHttpRequest) ? new XMLHttpRequest():new ActiveXObject('Microsoft.XMLHTTP');

	// Se pasan como parametro al método definido en "Modelos.php -> Controllers" desde el Ajax
	// Va obtener los datos del usuarios usando "Ajax"
	let ajaxUrl = base_url+'/Modelos/getModelo/'+id_modelo; 
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
				// Asigna el valor a todas las etiquetas de la ventana Modal.
				document.querySelector("#celId").innerHTML = objData.data.id_modulo;	
				document.querySelector("#celDescripcion").innerHTML = objData.data.descripcion;
				
				$('#modalViewModelo').modal('show');

			} // if (objData.estatus)
			else
			{
				swal ("Error",objData.msg, "error");
			}

		} // if (request.status == 200)

	} // 	request.onreadystatechange = function()

} // function fntViewInfo(idmodelo)

// Para editar un Modelo
function fntEditInfo(element,idModelo)
{
	//$('#modalViewModelo').modal('show');
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
	document.querySelector('#titleModal').innerHTML = "Actualizar Modelo";

	let id_modelo = idModelo;
	//console.log(idrol);

	// Detecta en que navegador se encuentra activo. Google Chrome, Firefox o Internet Explorer. 
	let request = (window.XMLHttpRequest) ? new XMLHttpRequest():new ActiveXObject('Microsoft.XMLHTTP');

	// Se pasan como parametro al método definido en "Categoria.php -> Controllers" desde el Ajax
	// Va obtener los datos del usuarios usando "Ajax"
	let ajaxUrl = base_url+'/Modelos/getModelo/'+id_modelo; 
	request.open("GET",ajaxUrl,true);
	request.send(); // Se envia la petición (ejecutar el archivo "getModulo/XXX")
	// Lo que retorne (echo Json.... el Controllers/Modulos/getModulo
	request.onreadystatechange = function()
	{
		if (request.status == 200 && request.readyState == 4)
		{
			// Retorna a un objeto de la funcion "getUsuario" de ModeloCategorias.php, al formato JSon
			let objData = JSON.parse(request.responseText);
			if (objData.estatus)
			{													
				document.querySelector("#idModelo").value = objData.data.id_modelo;					
				document.querySelector("#txtDescripcion").value = objData.data.descripcion;
	
				$('#modalFormModelo').modal('show');

			} // if (objData.estatus)
			else
			{
				swal ("Error",objData.msg, "error");
			}

		} // if (request.status == 200)

	} // 	request.onreadystatechange = function()

} // function fntViewInfo(idpersona)

// Borrar una Modelo
function fntDelInfo(id_Modelo)
{
	/*
	let btnDelRol = document.querySelectorAll(".btnDelRol");
	btnDelRol.forEach(function(btnDelRol){
		btnDelRol.addEventListener('click',function(){
	*/
	let idModelo = id_Modelo;
	// alert(idrol);
	swal({
		title:"Eliminar Modelo",
		text:"Realmente quiere eliminar el Modelo ?",
		type:"warning",
		showCancelButton:true,
		confirmButtonText:"Si, eliminar !",
		cancelButtonText: "No, Cancelar !",
		closeOnConfirm:false,
		closeOnCancel:true
		},function(isConfirm)
		{
			// Borrar la "Modelo", utiliza Ajax para accesar a la Base de datos.
			if (isConfirm)
			{
				let request = (window.XMLHttpRequest) ? new XMLHttpRequest():new ActiveXObject('Microsoft.XMLHTTP');
				// Se pasan como parametro al método definido en "Roles.php -> Controllers" desde el Ajax
				let ajaxDelModelo = base_url+'/Modelos/delModelo';
				let strData = "idModelo="+idModelo;
				request.open("POST",ajaxDelModelo,true);
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
							tableModelos.api().ajax.reload(function(){
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
} // function fntDelModelo...


// Para mostrar la ventana Modal de Categorias.
function openModal()
{
	rowTable = "";

	//alert("OpenModal");
	// Se actualizan los datos de la ventana modal a Mostrar, se agregan estos valores para que se pueda actualiar la ventana modal de "Agregar" y "Actualizar" Usuarios.

	
	// Es el Input "hidden" que se encuentra : /Views/Templetes/Modals/ModalModulos.php
	document.querySelector('#idModelo').value = "";	
	// Cambiando los colores de la franja de la ventana.
	// Estas definidos en "ModalModulos.php"
	document.querySelector('.modal-header').classList.replace("headerUpdate","headerRegister");
	// Cambiando la clase de los botones (Colores)
	document.querySelector('#btnActionForm').classList.replace("btn-info","btn-primary");
	document.querySelector('#btnText').innerHTML = "Guardar";
	document.querySelector('#titleModal').innerHTML = "Nuevo Modelo";
	// Resetear el Formulario, limpia todos los campos.
	document.querySelector('#formModelo').reset();

	$('#modalFormModelo').modal('show');
	//removePhoto();
}

