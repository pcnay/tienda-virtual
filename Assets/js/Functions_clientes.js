let tableClientes;

// Para cargar la imagen "Cargando".
let divLoading = document.querySelector("#divLoading");
let rowTable = "";

// Agrega el evento de Escucha al cargar el documento.
document.addEventListener('DOMContentLoaded',function(){
	// dataTable para  obtener los datos de los Clientes.
	
	// Es el dataTable para desplegar los "Usuarios".
	tableClientes = $('#tableClientes').dataTable({
		"aProcessing":true,
		"aServerside":true,
		"language": {
			"url":"//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
		},
		"ajax":{
			"url":" "+base_url+"/Clientes/getClientes",
			"dataSrc":""
		},
		"columns":[
			{"data":"id_persona"},
			{"data":"identificacion"},
			{"data":"nombres"},
			{"data":"apellidos"},
			{"data":"email_user"},
			{"data":"telefono"},	
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
		"iDisplayLength":2,
		"order":[[0,"desc"]]
	});


	// Validar la entrada, solo caracteres permitidos "txtIdentificacion"
	$("#txtIdentificacion").bind('keypress', function(event) {
		var regex = new RegExp("^[A-Za-z0-9]+$");
		var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
		if (!regex.test(key)) {
			event.preventDefault();
			return false;
		}
	});

// Validar la entrada, solo caracteres permitidos "txtNombre"
$("#txtNombre").bind('keypress', function(event) {
	var regex = new RegExp("^[A-Za-zñÑ]+$");
	var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
	if (!regex.test(key)) {
		event.preventDefault();
		return false;
	}
});

// Validar la entrada, solo caracteres permitidos "txtApellidos"
$("#txtApellido").bind('keypress', function(event) {
	var regex = new RegExp("^[A-Za-zñÑ]+$");
	var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
	if (!regex.test(key)) {
		event.preventDefault();
		return false;
	}
});

// Validar la entrada, solo caracteres permitidos "txtTelefono"
$("#txtTelefono").bind('keypress', function(event) {
	var regex = new RegExp("^[0-9-]+$");
	var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
	if (!regex.test(key)) {
		event.preventDefault();
		return false;
	}
});

// Validar la entrada, solo caracteres permitidos "txtEmail"
$("#txtEmail").bind('keypress', function(event) {
	var regex = new RegExp("^[a-zA-Z0-9.-_@]+$");
	var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
	if (!regex.test(key)) {
		event.preventDefault();
		return false;
	}
});

// Validar la entrada, solo caracteres permitidos "txtPassword"
$("#txtPassword").bind('keypress', function(event) {
	var regex = new RegExp("^[a-zA-Z0-9.-_@]+$");
	var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
	if (!regex.test(key)) {
		event.preventDefault();
		return false;
	}
});

// Validar la entrada, solo caracteres permitidos "txtNit"
$("#txtNit").bind('keypress', function(event) {
	var regex = new RegExp("^[a-zA-Z0-9]+$");
	var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
	if (!regex.test(key)) {
		event.preventDefault();
		return false;
	}
});

// Validar la entrada, solo caracteres permitidos "txtNombreFiscal"
$("#txtNombreFiscal").bind('keypress', function(event) {
	var regex = new RegExp("^[a-zA-Z0-9.-]+$");
	var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
	if (!regex.test(key)) {
		event.preventDefault();
		return false;
	}
});

// Validar la entrada, solo caracteres permitidos "txtDirFiscal"
$("#txtDirFiscal").bind('keypress', function(event) {
	var regex = new RegExp("^[a-zA-Z0-9#]+$");
	var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
	if (!regex.test(key)) {
		event.preventDefault();
		return false;
	}
});

	if (document.querySelector("#formCliente"))
	{
		let formCliente = document.querySelector("#formCliente");
		// Acivando el evento "onsubmit" a la variable "formUsuario" es donde esta el formulario.
		formCliente.onsubmit = function(e){
			e.preventDefault();
			// Obtiene el contenido de las etiquetas de las capturas de Usuarios.
			let strIdentificacion = document.querySelector('#txtIdentificacion').value;		
			let strNombre = document.querySelector('#txtNombre').value;		
			let strApellido = document.querySelector('#txtApellido').value;		
			let strEmail = document.querySelector('#txtEmail').value;		
			let strTelefono = document.querySelector('#txtTelefono').value;		
			let strNit = document.querySelector('#txtNit').value;		
			let strNomFiscal = document.querySelector('#txtNombreFiscal').value;		
			let strDirFiscal = document.querySelector('#txtDirFiscal').value;		

			let strPassword = document.querySelector('#txtPassword').value;	
			
		
			if ((strIdentificacion == '')|| strApellido == '' || strNombre == '' || strEmail == '' || strTelefono == '' || strNit == '' || strNomFiscal == '' || strDirFiscal == '')
			{
				swal ("Atencion", "Todos los campos son obligatorio","error");
				return false;
			}

			// Obtiene todos las etiquetas que tienen la clase "valid" del formulario de captura.
			let elementsValid = document.getElementsByClassName("valid");
			for (let b=0; b<elementsValid.length;b++)
			{
				if (elementsValid[b].classList.contains('is-invalid'))
				{
					swal ("Atencion", "Por Favor verifique los campos en Rojo","error");
					return false;
				}
			}

			// Detecta en que navegador se encuentra activo. Google Chrome, Firefox o Internet Explorer. 
			let request = (window.XMLHttpRequest) ? new XMLHttpRequest():new ActiveXObject('Microsoft.XMLHTTP');

			let ajaxUrl = base_url+'/Clientes/setCliente';
			let formData = new FormData(formCliente); // Se obtiene el formulario
			request.open("POST",ajaxUrl,true); // Se abre la conexion, y se pasa por "GET"
			request.send(formData); // Se envia la petición (ejecutar el archivo "getRol/XXX")
			// Lo que retorne (echo Json.... el Controllers/Roles/getRol)

			request.onreadystatechange = function(){
				if (request.readyState == 4 && request.status == 200)
				{
					let objData = JSON.parse(request.responseText);
					if (objData.estatus)
					{
						if (rowTable == "")
						{
							// Mostrar los datos en el "dataTable"
							tableClientes.api().ajax.reload(function(){});
						}
						else
						{
							rowTable.cells[1].textContent = strIdentificacion;
							rowTable.cells[2].textContent = strNombre;
							rowTable.cells[3].textContent = strApellido;
							rowTable.cells[4].textContent = strEmail;
							rowTable.cells[5].textContent = strTelefono;
							rowTable = "";

						}
						$('#modalFormCliente').modal("hide");
						formCliente.reset();
						swal("Clientes",objData.msg,"success");

					}
					else
					{
						swal("Error",objData.msg,"error");
					}
				}
			}
		
		} // formUsuario.onsubmit = function(e){

	} // if (document.querySelector("#formUsuario"))


}, false);


// Para mostrar el modal "View User"
function fntViewInfo(idpersona)
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
	let id_persona = idpersona;
	//console.log(idrol);

	// Detecta en que navegador se encuentra activo. Google Chrome, Firefox o Internet Explorer. 
	let request = (window.XMLHttpRequest) ? new XMLHttpRequest():new ActiveXObject('Microsoft.XMLHTTP');

	// Se pasan como parametro al método definido en "Usuarios.php -> Controllers" desde el Ajax
	// Va obtener los datos del usuarios usando "Ajax"
	let ajaxUrl = base_url+'/Clientes/getCliente/'+id_persona; 
	request.open("GET",ajaxUrl,true);
	request.send(); // Se envia la petición (ejecutar el archivo "getRol/XXX")
	// Lo que retorne (echo Json.... el Controllers/Usuarios/getUsuario
	request.onreadystatechange = function()
	{
		if (request.status == 200 && request.readyState == 4)
		{
			// Retorna a un objeto lo que se retorna en "getUsuario"

			let objData = JSON.parse(request.responseText);
			if (objData.estatus)
			{	
				document.querySelector("#celIdentificacion").innerHTML = objData.data.identificacion;
				document.querySelector("#celNombre").innerHTML = objData.data.nombres;
				document.querySelector("#celApellidos").innerHTML = objData.data.apellidos;
				document.querySelector("#celTelefono").innerHTML = objData.data.telefono;
				document.querySelector("#celEmail").innerHTML = objData.data.email_user;
				document.querySelector("#celIde").innerHTML = objData.data.nit;
				document.querySelector("#celNomFiscal").innerHTML = objData.data.nombrefiscal;
				document.querySelector("#celDirFiscal").innerHTML = objData.data.direccionfiscal;
				document.querySelector("#celFechaRegistro").innerHTML = objData.data.fechaRegistro;

				$('#modalViewCliente').modal('show');

			} // if (objData.estatus)
			else
			{
				swal ("Error",objData.msg, "error");
			}

		} // if (request.status == 200)

	} // 	request.onreadystatechange = function()

}

// Editar un Cliente
function fntEditInfo(element,idpersona)
{
	// Se agrega estas lineas ya que se edita un Usuario, y se recarga, pierde la página donde se encontraba la tabla inicialmente.
	rowTable = element.parentNode.parentNode.parentNode;
	// .parentNode = Sube al padre inmediato superior, hasta subir el padre de la etiqueta (dos niveles)
	//console.log(rowTable);
	// rowTable.cells[1].textContent = 


	//console.log('Entre a Function fntEditRol');
	/*
	var btnEditRol_b = document.querySelectorAll(".btnEditRol");
	console.log (btnEditRol_b);
	btnEditRol_b.forEach(function(btnEditRol_b){
	

		btnEditRol_b.addEventListener('click',function(){
			//console.log('Click en el boton de edit');
	*/
	
	// El código para ejecutar Ajax.
	// "us" se agrego junto con los botones de "Editar","Borrar" cunado se muestran los Usuarios. Es el "id" del Usuarios en la tabla.
	//var idpersona = this.getAttribute("us");

	// Se agrega este código para reutilizar la ventana de Capturar Usuarios, se cambiaran valores para las vistas y leyenda de botones.
	// Estes lineas de definieron en "fntEditUsario()"
	// Es el Input "hidden" que se encuentra : /Views/Templetes/Modals/ModalUsuarios.php
	document.querySelector('#idUsuario').value = "";	
	// Cambiando los colores de la franja de la ventana.
	// Estas definidos en "ModalUsuarios.php"
	document.querySelector('.modal-header').classList.replace("headerRegister","headerUpdate");
	// Cambiando la clase de los botones (Colores)
	document.querySelector('#btnActionForm').classList.replace("btn-primary","btn-info");
	document.querySelector('#btnText').innerHTML = "Actualizar";
	document.querySelector('#titleModal').innerHTML = "Actualizar Cliente";

	let id_persona = idpersona;
	//console.log(idrol);

	// Detecta en que navegador se encuentra activo. Google Chrome, Firefox o Internet Explorer. 
	let request = (window.XMLHttpRequest) ? new XMLHttpRequest():new ActiveXObject('Microsoft.XMLHTTP');

	// Se pasan como parametro al método definido en "Usuarios.php -> Controllers" desde el Ajax
	// Va obtener los datos del usuarios usando "Ajax"
	let ajaxUrl = base_url+'/Clientes/getCliente/'+id_persona; 
	request.open("GET",ajaxUrl,true);
	request.send(); // Se envia la petición (ejecutar el archivo "getRol/XXX")
	// Lo que retorne (echo Json.... el Controllers/Usuarios/getUsuario
	request.onreadystatechange = function()
	{
		// request.status == 200 ; se realizo la peticion

		if (request.status == 200 && request.readyState == 4)
		{
			// Retorna a un objeto lo que se retorna en "getUsuario"

			//$('#modalViewUser').modal('show');
			//console.log(request.responseText);

			let objData = JSON.parse(request.responseText);
			if (objData.estatus)			
			{	
				//console.log("password ",objData.data.passwords);
				document.querySelector("#idUsuario").value = objData.data.id_persona;
				document.querySelector("#txtIdentificacion").value = objData.data.identificacion;
				document.querySelector("#txtNombre").value = objData.data.nombres;
				document.querySelector("#txtApellido").value = objData.data.apellidos;
				document.querySelector("#txtTelefono").value = objData.data.telefono;
				document.querySelector("#txtEmail").value = objData.data.email_user;
				document.querySelector("#txtPassword").value = objData.data.passwords;				
				document.querySelector("#txtNit").value = objData.data.nit;
				document.querySelector("#txtNombreFiscal").value = objData.data.nombrefiscal;
				document.querySelector("#txtDirFiscal").value = objData.data.direccionfiscal;
			}
		}

		$('#modalFormCliente').modal('show');

	} // 	request.onreadystatechange = function()

} //function fntEditInfo(idpersona)

// Borrar un Cliente
function fntDelInfo(id_Persona)
{
	/*
	let btnDelRol = document.querySelectorAll(".btnDelRol");
	btnDelRol.forEach(function(btnDelRol){
		btnDelRol.addEventListener('click',function(){
	*/
	let idUsuario = id_Persona;
	// alert(idrol);
	swal({
		title:"Eliminar Cliente",
		text:"Realmente quere eliminar el Cliente?",
		type:"warning",
		showCancelButton:true,
		confirmButtonText:"Si, eliminar !",
		cancelButtonText: "No, Cancelar !",
		closeOnConfirm:false,
		closeOnCancel:true
		},function(isConfirm)
		{
			// Borrar el Cliente, utiliza Ajax para accesar a la Base de datos.
			if (isConfirm)
			{
				let request = (window.XMLHttpRequest) ? new XMLHttpRequest():new ActiveXObject('Microsoft.XMLHTTP');
				// Se pasan como parametro al método definido en "Roles.php -> Controllers" desde el Ajax
				let ajaxDelCliente = base_url+'/Clientes/delCliente';
				let strData = "idUsuario="+idUsuario;
				request.open("POST",ajaxDelCliente,true);
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
							tableClientes.api().ajax.reload(function(){
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


// Para mostrar la ventana Modal de Clientes.
function openModal()
{
	rowTable = "";

	//alert("OpenModal");
	// Se actualizan los datos de la ventana modal a Mostrar, se agregan estos valores para que se pueda actualiar la ventana modal de "Agregar" y "Actualizar" Usuarios.

	// Estes lineas de definieron en "fntEditUsario()"
	// Es el Input "hidden" que se encuentra : /Views/Templetes/Modals/ModalUsuarios.php
	document.querySelector('#idUsuario').value = "";	
	// Cambiando los colores de la franja de la ventana.
	// Estas definidos en "ModalUsuarios.php"
	document.querySelector('.modal-header').classList.replace("headerUpdate","headerRegister");
	// Cambiando la clase de los botones (Colores)
	document.querySelector('#btnActionForm').classList.replace("btn-info","btn-primary");
	document.querySelector('#btnText').innerHTML = "Guardar";
	document.querySelector('#titleModal').innerHTML = "Nuevo Cliente";
	// Resetear el Formulario, limpia todos los campos.
	document.querySelector('#formCliente').reset();

	$('#modalFormCliente').modal('show');
}
