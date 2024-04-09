
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


let tableMarcas;
// Cuando se termina de cargar la página, se asignan los eventos Listener.
document.addEventListener('DOMContentLoaded',function()
{
	// Código para mostrar las Categorias.
		// Es el dataTable para desplegar los "Clientes".
		tableMarcas = $('#tableMarcas').dataTable({
			"aProcessing":true,
			"aServerside":true,
			"language": {
				"url":"//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
			},
			"ajax":{
				"url":" "+base_url+"/Marcas/getMarcas",
				"dataSrc":""
			},
			"columns":[
				{"data":"id_marca"},
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
	let formMarca = document.querySelector("#formMarca"); // 
	//console.log (formaRol);
	formMarca.onsubmit = function(e){
		e.preventDefault();
		//console.log("Onsubmit");

		// Obtener el contenido de las etiquetas del Modal "Agregar Marca"
		let intIdMarca = document.querySelector('#idMarca').value;
		let strDescripcion = document.querySelector("#txtDescripcion").value;		

		if (strDescripcion == '')
		{
			swal ("Atencion","El campo es obligatorios","error");
			return false; // Detiene el proceso.
		}

		divLoading.style.display = "flex";
		// Detecta en que navegador se encuentra activo. Google Chrome, Firefox o Internet Explorer. 
		let request = (window.XMLHttpRequest) ? new XMLHttpRequest():new ActiveXObject('Microsoft.XMLHTTP');
		let ajaxUrl = base_url+'/Marcas/setMarca'; // Url a donde buscara el archivo, es en el Controlador/Modulos.
		
		let formData = new FormData(formMarca); // Obtiene la etiqueta del formulario.
		// El método utilizado para enviar la informacion es "POST"
		request.open("POST",ajaxUrl,true);
		request.send(formData);
		request.onreadystatechange = function(){
			if (request.readyState == 4 && request.status == 200) // Verifica que si llego la información al navegador
			{
				// console.log(request.responseText); // Determinar el contenido de lo que retorno(Marcas/setMarca)
				// La información que viene desde el método "setMarca" del Controllers "Marcas"
				let objData = JSON.parse(request.responseText);
				divLoading.style.display = null;

				// Accesando a los elementos del Arreglo asociativo, del valor retornado de "setMarca"
				if (objData.estatus)
				{
					if (rowTable == "")
					{
						tableMarcas.api().ajax.reload() //function(){
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
					$('#modalFormMarca').modal("hide");
					formMarca.reset();
					swal("Marcas",objData.msg,"success");
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


// Para mostrar el modal "View Marca"
function fntViewInfo(idmarca)
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
	// "us" se agrego junto con los botones de "Editar","Borrar" cunado se muestran las Marcas. Es el "id" de la Marca en la tabla.
	
	let id_marca = idmarca;
	//console.log(idmarca);

	// Detecta en que navegador se encuentra activo. Google Chrome, Firefox o Internet Explorer. 
	let request = (window.XMLHttpRequest) ? new XMLHttpRequest():new ActiveXObject('Microsoft.XMLHTTP');

	// Se pasan como parametro al método definido en "Marcas.php -> Controllers" desde el Ajax
	// Va obtener los datos del usuarios usando "Ajax"
	let ajaxUrl = base_url+'/Marcas/getMarca/'+id_marca; 
	request.open("GET",ajaxUrl,true);
	request.send(); // Se envia la petición (ejecutar el archivo "getMarca/XXX")
	// Lo que retorne (echo Json.... el Controllers/Marcas/getMarca
	request.onreadystatechange = function()
	{
		if (request.status == 200 && request.readyState == 4)
		{
			// Retorna a un objeto lo que se retorna en "getMarca"

			// Convierte a formato JSon lo que viene como objeto de la consulta.
			let objData = JSON.parse(request.responseText);
			if (objData.estatus)
			{	
				// Asigna el valor a todas las etiquetas de la ventana Modal.
				document.querySelector("#celId").innerHTML = objData.data.id_marca;	
				document.querySelector("#celDescripcion").innerHTML = objData.data.descripcion;
				
				$('#modalViewMarca').modal('show');

			} // if (objData.estatus)
			else
			{
				swal ("Error",objData.msg, "error");
			}

		} // if (request.status == 200)

	} // 	request.onreadystatechange = function()

} // function fntViewInfo(idmodelo)

// Para editar una Marca
function fntEditInfo(element,idMarca)
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
	document.querySelector('#titleModal').innerHTML = "Actualizar Marca";

	let id_marca = idMarca;
	//console.log(idrol);

	// Detecta en que navegador se encuentra activo. Google Chrome, Firefox o Internet Explorer. 
	let request = (window.XMLHttpRequest) ? new XMLHttpRequest():new ActiveXObject('Microsoft.XMLHTTP');

	// Se pasan como parametro al método definido en "Categoria.php -> Controllers" desde el Ajax
	// Va obtener los datos del usuarios usando "Ajax"
	let ajaxUrl = base_url+'/Marcas/getMarca/'+id_marca; 
	request.open("GET",ajaxUrl,true);
	request.send(); // Se envia la petición (ejecutar el archivo "getModulo/XXX")
	// Lo que retorne (echo Json.... el Controllers/Modulos/getModulo
	request.onreadystatechange = function()
	{
		if (request.status == 200 && request.readyState == 4)
		{
			// Retorna a un objeto de la funcion "getMarca" de ModeloMarcas.php, al formato JSon
			let objData = JSON.parse(request.responseText);
			if (objData.estatus)
			{													
				document.querySelector("#idMarca").value = objData.data.id_marca;					
				document.querySelector("#txtDescripcion").value = objData.data.descripcion;
	
				$('#modalFormMarca').modal('show');

			} // if (objData.estatus)
			else
			{
				swal ("Error",objData.msg, "error");
			}

		} // if (request.status == 200)

	} // 	request.onreadystatechange = function()

} // function fntViewInfo(idMarca)

// Borrar una Marca
function fntDelInfo(id_Marca)
{
	/*
	let btnDelRol = document.querySelectorAll(".btnDelRol");
	btnDelRol.forEach(function(btnDelRol){
		btnDelRol.addEventListener('click',function(){
	*/
	let idMarca = id_Marca;
	// alert(idrol);
	swal({
		title:"Eliminar Marca",
		text:"Realmente quiere eliminar la Marca ?",
		type:"warning",
		showCancelButton:true,
		confirmButtonText:"Si, eliminar !",
		cancelButtonText: "No, Cancelar !",
		closeOnConfirm:false,
		closeOnCancel:true
		},function(isConfirm)
		{
			// Borrar la "Marca", utiliza Ajax para accesar a la Base de datos.
			if (isConfirm)
			{
				let request = (window.XMLHttpRequest) ? new XMLHttpRequest():new ActiveXObject('Microsoft.XMLHTTP');
				// Se pasan como parametro al método definido en "Marcas.php -> Controllers" desde el Ajax
				let ajaxDelMarca = base_url+'/Marcas/delMarca';
				let strData = "idMarca="+idMarca;
				request.open("POST",ajaxDelMarca,true);
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
							tableMarcas.api().ajax.reload(function(){
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
} // function fntDelMarca...


// Para mostrar la ventana Modal de Marcas.
function openModal()
{
	rowTable = "";

	//alert("OpenModal");
	// Se actualizan los datos de la ventana modal a Mostrar, se agregan estos valores para que se pueda actualizar la ventana modal de "Agregar" y "Actualizar" Marcas.

	
	// Es el Input "hidden" que se encuentra : /Views/Templetes/Modals/ModalMarcas.php
	document.querySelector('#idMarca').value = "";	
	// Cambiando los colores de la franja de la ventana.
	// Estas definidos en "ModalMarcas.php"
	document.querySelector('.modal-header').classList.replace("headerUpdate","headerRegister");
	// Cambiando la clase de los botones (Colores)
	document.querySelector('#btnActionForm').classList.replace("btn-info","btn-primary");
	document.querySelector('#btnText').innerHTML = "Guardar";
	document.querySelector('#titleModal').innerHTML = "Nueva Marca";
	// Resetear el Formulario, limpia todos los campos.
	document.querySelector('#formMarca').reset();

	$('#modalFormMarca').modal('show');
	//removePhoto();
}

