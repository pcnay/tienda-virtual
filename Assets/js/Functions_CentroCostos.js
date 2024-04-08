let rowTable = "";

	// Validar la entrada, solo caracteres permitidos "txtDescripcion"
	$("#txtDescripcion").bind('keypress', function(event) {
		var regex = new RegExp("^[A-Za-z0-9-, ]+$");
		var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
		if (!regex.test(key)) {
			event.preventDefault();
			return false;
		}
	});


// Validar la entrada, solo caracteres permitidos "txtDescripcion"
$("#txtNumCentroCostos").bind('keypress', function(event) {
	var regex = new RegExp("^[A-Za-z0-9- ]+$");
	var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
	if (!regex.test(key)) {
		event.preventDefault();
		return false;
	}
});

let tableDeptos;
// Cuando se termina de cargar la página, se asignan los eventos Listener.
document.addEventListener('DOMContentLoaded',function()
{	
	// Código para mostrar los Centros de Costos.		
	tableCentroCostos = $('#tableCentroCostos').dataTable({
		"aProcessing":true,
		"aServerside":true,
		"language": {
			"url":"//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
		},
		"ajax":{
			"url":" "+base_url+"/CentroCostos/getCentroCostos",
			"dataSrc":""
		},
		"columns":[
			{"data":"id_centro_costos"},
			{"data":"num_centro_costos"},
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
		"order":[[2,"asc"]]
	});

	// =======================================================================
	// SECCION PARA ENVIAR LOS DATOS A LA TABLAS POR MEDIO DE AJAX 
	// =======================================================================

	// Tambien se utiliza para editar un Departamento.
	// En esta parte se inicia con el Ajax para grabar la información.
	// Capturar los datos del formulario de "Nuevo Departamento"
	// Seleccionan el id del formulario de Depto
	let formCentroCostos = document.querySelector("#formCentroCostos"); // 
	//console.log (formaCentroCostos);
	formCentroCostos.onsubmit = function(e){
		e.preventDefault();
		//console.log("Onsubmit");

		// Obtener el contenido de las etiquetas del Modal "Agregar Centro Costos"
		let intIdCentroCostos = document.querySelector('#idCentroCostos').value;		
		//console.log(intIdCentroCostos);
		let strDescripcion = document.querySelector("#txtDescripcion").value;
		let strNumCentroCostos = document.querySelector("#txtNumCentroCostos").value;


		if (strDescripcion == '' || strNumCentroCostos == '')
		{
			swal ("Atencion","No se permiten datos vacios","error");
			return false; // Detiene el proceso.
		}

		divLoading.style.display = "flex"; // Para que se active el icono circulo "Cargando"
		// Detecta en que navegador se encuentra activo. Google Chrome, Firefox o Internet Explorer. 
		let request = (window.XMLHttpRequest) ? new XMLHttpRequest():new ActiveXObject('Microsoft.XMLHTTP');
		let ajaxUrl = base_url+'/CentroCostos/setCentroCostos'; // Url a donde buscara el archivo, es en el Controlador/CentroCostos.
		
		var formData = new FormData(formCentroCostos); // Obtiene la etiqueta del formulario.
		// El método utilizado para enviar la informacion es "POST"
		request.open("POST",ajaxUrl,true);
		request.send(formData);
		request.onreadystatechange = function(){
			if (request.readyState == 4 && request.status == 200) // Verifica que si llego la información al navegador
			{
				// console.log(request.responseText); // Determinar el contenido de lo que retorno(CentroCostos/setCentroCostos)
				// La información que viene desde el método "setCentroCostos" del Controllers "CentroCostos"
				let objData = JSON.parse(request.responseText);
				divLoading.style.display = null;

				// Accesando a los elementos del Arreglo asociativo, del valor retornado de "setCentroCostos"
				if (objData.estatus)
				{
					if (rowTable == "")
					{
						tableCentroCostos.api().ajax.reload() //function(){
							//fntEditRol(); // Para cuando se reacargue el DataTable asigne el evento "Click" de los botones.
							//fntDelRol();
							//fntPermisos();
						//});					
					}
					else
					{
						// No recargara toda la tabla.
						rowTable.cells[1].textContent = strNumCentroCostos;
						rowTable.cells[2].textContent = strDescripcion;						
						rowTable = "";
					}
					$('#modalFormCentroCostos').modal("hide");
					formCentroCostos.reset();
					swal("Centro Costos",objData.msg,"success");					
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

// Para mostrar el modal "View Centro De Costo"
function fntViewInfo(idCentroCostos)
{
	// El código para ejecutar Ajax.
	// "us" se agrego junto con los botones de "Editar","Borrar" cunado se muestran los Roles. Es el "id" del Rol en la tabla.
	//var idpersona = this.getAttribute("us");
	let id_CentroCostos = idCentroCostos;
	//console.log(idrol);

	// Detecta en que navegador se encuentra activo. Google Chrome, Firefox o Internet Explorer. 
	let request = (window.XMLHttpRequest) ? new XMLHttpRequest():new ActiveXObject('Microsoft.XMLHTTP');

	// Se pasan como parametro al método definido en "CentroCostos.php -> Controllers" desde el Ajax
	// Va obtener los datos del usuarios usando "Ajax"
	let ajaxUrl = base_url+'/CentroCostos/get_Un_CentroCostos/'+id_CentroCostos; 
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
				document.querySelector("#celId").innerHTML = objData.data.id_centro_costos;	
				document.querySelector("#celNumCentroCostos").innerHTML = objData.data.num_centro_costos;
				document.querySelector("#celDescripcion").innerHTML = objData.data.descripcion;
				
				$('#modalViewCentroCostos').modal('show');

			} // if (objData.estatus)
			else
			{
				swal ("Error",objData.msg, "error");
			}

		} // if (request.status == 200)

	} // 	request.onreadystatechange = function()

} // function fntViewInfo(idDepto)

// Para editar un Centro De Costos
function fntEditInfo(element,idCentroCostos)
{
	//$('#modalViewCentroCostos').modal('show');
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
	// "us" se agrego junto con los botones de "Editar","Borrar" cuanado se muestran los Roles. Es el "id" del Rol en la tabla.
	//var idpersona = this.getAttribute("us");
	// Cambiando los colores de la franja al formulario.
	// Estas definidos en "ModalCategorias.php"
	document.querySelector('.modal-header').classList.replace("headerRegister","headerUpdate");
	// Cambiando la clase de los botones (Colores)
	document.querySelector('#btnActionForm').classList.replace("btn-primary","btn-info");
	document.querySelector('#btnText').innerHTML = "Actualizar";
	document.querySelector('#titleModal').innerHTML = "Actualizar Centro Costos";

	let id_CentroCostos = idCentroCostos;
	//console.log(id_CentroCostos);

	// Detecta en que navegador se encuentra activo. Google Chrome, Firefox o Internet Explorer. 
	let request = (window.XMLHttpRequest) ? new XMLHttpRequest():new ActiveXObject('Microsoft.XMLHTTP');

	// Se pasan como parametro al método definido en "Depto.php -> Controllers" desde el Ajax
	// Va obtener los datos del usuarios usando "Ajax"
	let ajaxUrl = base_url+'/CentroCostos/get_Un_CentroCostos/'+id_CentroCostos; 
	request.open("GET",ajaxUrl,true);
	request.send(); // Se envia la petición (ejecutar el archivo "getCentroCostos/XXX")
	// Lo que retorne (echo Json.... el Controllers/CentroCostos/getCentroCostos
	request.onreadystatechange = function()
	{
		if (request.status == 200 && request.readyState == 4)
		{
			// Retorna a un objeto de la funcion "getCentroCostos" de CentroCostos.php, al formato JSon
			let objData = JSON.parse(request.responseText);
			if (objData.estatus)
			{													
				document.querySelector("#idCentroCostos").value = objData.data.id_centro_costos;					
				document.querySelector("#txtNumCentroCostos").value = objData.data.num_centro_costos;
				document.querySelector("#txtDescripcion").value = objData.data.descripcion;
				console.log(idCentroCostos);
				console.log(objData.data.id_centro_costos);

				$('#modalFormCentroCostos').modal('show');

			} // if (objData.estatus)
			else
			{
				swal ("Error",objData.msg, "error");
			}

		} // if (request.status == 200)

	} // 	request.onreadystatechange = function()

} // function fntViewInfo(idCentroCostos)

// Borrar un Centro de Costos.
function fntDelInfo(id_CentroCostos)
{
	/*
	let btnDelRol = document.querySelectorAll(".btnDelRol");
	btnDelRol.forEach(function(btnDelRol){
		btnDelRol.addEventListener('click',function(){
	*/
	let idCentroCostos = id_CentroCostos;
	// alert(idrol);
	swal({
		title:"Eliminar Centro Costos",
		text:"Realmente quiere eliminar el Centro De Costos ?",
		type:"warning",
		showCancelButton:true,
		confirmButtonText:"Si, eliminar !",
		cancelButtonText: "No, Cancelar !",
		closeOnConfirm:false,
		closeOnCancel:true
		},function(isConfirm)
		{
			// Borrar el "Centro De Costos", utiliza Ajax para accesar a la Base de datos.
			if (isConfirm)
			{
				let request = (window.XMLHttpRequest) ? new XMLHttpRequest():new ActiveXObject('Microsoft.XMLHTTP');
				// Se pasan como parametro al método definido en "CentroCostos.php -> Controllers" desde el Ajax
				let ajaxDelCentroCostos = base_url+'/CentroCostos/delCentroCostos';
				let strData = "idCentroCostos="+idCentroCostos;
				request.open("POST",ajaxDelCentroCostos,true);
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
							tableCentroCostos.api().ajax.reload(function(){
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
} // functio fntDelCentroCostos...


// Para mostrar la ventana Modal de Centro CostosDeptos.
function openModal()
{
	rowTable = "";

	//alert("OpenModal");
	// Se actualizan los datos de la ventana modal a Mostrar, se agregan estos valores para que se pueda actualiar la ventana modal de "Agregar" y "Actualizar" Categorias.

	document.querySelector('#idCentroCostos').value = "";	
	// Cambiando los colores de la franja de la ventana.
	// Estas definidos en "ModalCentroCostos.php"
	document.querySelector('.modal-header').classList.replace("headerUpdate","headerRegister");
	// Cambiando la clase de los botones (Colores)
	document.querySelector('#btnActionForm').classList.replace("btn-info","btn-primary");
	document.querySelector('#btnText').innerHTML = "Guardar";
	document.querySelector('#titleModal').innerHTML = "Nuevo Centro Costos";
	// Resetear el Formulario, limpia todos los campos.
	document.querySelector('#formCentroCostos').reset();
	$('#modalFormCentroCostos').modal('show');
}


