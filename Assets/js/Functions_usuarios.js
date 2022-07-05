var tableUsuarios;
// Al terminar de cargar la vista de la captura de Usuario se ejecutara la funcion
document.addEventListener('DOMContentLoaded',function(){
	
	// Es el dataTable para desplegar los "Usuarios".
	tableUsuarios = $('#tableUsuarios').dataTable({
		"aProcessing":true,
		"aServerside":true,
		"language": {
			"url":"//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
		},
		"ajax":{
			"url":" "+base_url+"/Usuarios/getUsuarios",
			"dataSrc":""
		},
		"columns":[
			{"data":"id_persona"},
			{"data":"nombres"},
			{"data":"apellidos"},
			{"data":"email_user"},
			{"data":"telefono"},	
			{"data":"nombrerol"},		
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

	var formUsuario = document.querySelector("#formUsuario");
	// Acivando el evento "onsubmit" a la variable "formUsuario" es donde esta el formulario.
	formUsuario.onsubmit = function(e){
		e.preventDefault();
		// Obtiene el contenido de las etiquetas de las capturas de Usuarios.
		let strIdentificacion = document.querySelector('#txtIdentificacion').value;		
		let strNombre = document.querySelector('#txtNombre').value;		
		let strApellido = document.querySelector('#txtApellido').value;		
		let strEmail = document.querySelector('#txtEmail').value;		
		let strTelefono = document.querySelector('#txtTelefono').value;		
		let strTipousuario = document.querySelector('#listRolid').value;		
		let strPassword = document.querySelector('#txtPassword').value;		
	
		if ((strIdentificacion == '')|| strApellido == '' || strNombre == '' || strEmail == '' || strTelefono == '' || strTipousuario == '' || strPassword == '')
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

		let ajaxUrl = base_url+'/Usuarios/setUsuario';
		let formData = new FormData(formUsuario); // Se obtiene el formulario
		request.open("POST",ajaxUrl,true); // Se abre la conexion, y se pasa por "GET"
		request.send(formData); // Se envia la petición (ejecutar el archivo "getRol/XXX")
		// Lo que retorne (echo Json.... el Controllers/Roles/getRol)

		request.onreadystatechange = function(){
			if (request.readyState == 4 && request.status == 200)
			{
				let objData = JSON.parse(request.responseText);
				if (objData.estatus)
				{
					$('#modalFormUsuario').modal("hide");
					formUsuario.reset();
					swal("Usuarios",objData.msg,"success");
					// Mostrar los datos en el "dataTable"
					tableUsuarios.api().ajax.reload(function(){

					});
				}
				else
				{
					swal("Error",objData.msg,"error");
				}
			}
		}
	
	} // formUsuario.onsubmit = function(e){

},false);

// Cuando se cargue la ventana obtendra los "Roles"
window.addEventListener('load',function(){
	fntRolesUsuarios();
	//fntViewUsuario();
},false);

// Para extraer los "Usuarios" y vaciarla al "Select"
function fntRolesUsuarios()
{
	// Se pasan como parametro al método definido en "Roles.php -> Controllers" desde el Ajax
	let ajaxUrl = base_url+'/Roles/getSelectRoles';

	// Detecta en que navegador se encuentra activo. Google Chrome, Firefox o Internet Explorer. 
	let request = (window.XMLHttpRequest) ? new XMLHttpRequest():new ActiveXObject('Microsoft.XMLHTTP');

	request.open("GET",ajaxUrl,true); // Se abre la conexion, y se pasa por "GET"
	request.send(); // Se envia la petición (ejecutar el archivo "getRol/XXX")
	// Lo que retorne (echo Json.... el Controllers/Roles/getRol)

	// Agregando al "Select"
	request.onreadystatechange = function(){
		if (request.readyState == 4 && request.status == 200) // Vaiida si llego correctamente la respuesta.
		{
			document.querySelector('#listRolid').innerHTML = request.responseText;
			document.querySelector('#listRolid').value = 1;
			$('#listRolid').selectpicker('render'); // Para que se refresque el Select.
			//$('#listRolid').selectpicker('refresh'); // Para que se refresque el Select.
		}
	}

}

// Para mostrar el modal "View User"
function fntViewUsuario(idpersona)
{
	//console.log('Entre a Function fntEditRol');
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
	let ajaxUrl = base_url+'/Usuarios/getUsuario/'+id_persona; 
	request.open("GET",ajaxUrl,true);
	request.send(); // Se envia la petición (ejecutar el archivo "getRol/XXX")
	// Lo que retorne (echo Json.... el Controllers/Usuarios/getUsuario
	request.onreadystatechange = function()
	{
		if (request.status == 200 && request.readyState == 4)
		{
			// Retorna a un objeto lo que se retorna en "getUsuario"

			//$('#modalViewUser').modal('show');
			//console.log(request.responseText);

			let objData = JSON.parse(request.responseText);
			if (objData.estatus)
			{	
				let estadoUsuario = objData.data.estatus == 1?
				'<span class="badge badge-success">Activo</span>':
				'<span class="badge badge-danger">Inactivo</span>';
				document.querySelector("#celIdentificacion").innerHTML = objData.data.identificacion;
				document.querySelector("#celNombre").innerHTML = objData.data.nombres;
				document.querySelector("#celApellidos").innerHTML = objData.data.apellidos;
				document.querySelector("#celTelefono").innerHTML = objData.data.telefono;
				document.querySelector("#celEmail").innerHTML = objData.data.email_user;
				document.querySelector("#celTipoUsuario").innerHTML = objData.data.nombrerol;
				document.querySelector("#celEstado").innerHTML = estadoUsuario;
				document.querySelector("#celFechaRegistro").innerHTML = objData.data.fechaRegistro;
				$('#modalViewUser').modal('show');

			} // if (objData.estatus)
			else
			{
				swal ("Error",objData.msg, "error");
			}

		} // if (request.status == 200)

	} // 	request.onreadystatechange = function()

}

// Editar un Usuario
// Para mostrar el modal "View User"
function fntEditUsuario(idpersona)
{
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
	document.querySelector('#titleModal').innerHTML = "Actualizar Usuario";

	let id_persona = idpersona;
	//console.log(idrol);

	// Detecta en que navegador se encuentra activo. Google Chrome, Firefox o Internet Explorer. 
	let request = (window.XMLHttpRequest) ? new XMLHttpRequest():new ActiveXObject('Microsoft.XMLHTTP');

	// Se pasan como parametro al método definido en "Usuarios.php -> Controllers" desde el Ajax
	// Va obtener los datos del usuarios usando "Ajax"
	let ajaxUrl = base_url+'/Usuarios/getUsuario/'+id_persona; 
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
				console.log("password ",objData.data.passwords);
				document.querySelector("#idUsuario").value = objData.data.id_persona;
				document.querySelector("#txtIdentificacion").value = objData.data.identificacion;
				document.querySelector("#txtNombre").value = objData.data.nombres;
				document.querySelector("#txtApellido").value = objData.data.apellidos;
				document.querySelector("#txtTelefono").value = objData.data.telefono;
				document.querySelector("#txtEmail").value = objData.data.email_user;
				document.querySelector("#txtPassword").value = objData.data.passwords;
				document.querySelector("#listRolid").value = objData.data.id_rol;
				// Renderiza y asigna el valor que esta guardado en la tabla.
				$('#listRolid').selectpicker('render');

				if (objData.data.estatus == 1)
				{
					// Usuario Activo
					document.querySelector("#listStatus").value = 1;
				}
				else
				{
					// Usuario Inactivo
					document.querySelector("#listStatus").value = 2;
				}

				// Para mostrar la opcion que se le esta indicando
				$('#listStatus').selectpicker('render');

			}
		}

		$('#modalFormUsuario').modal('show');

	} // 	request.onreadystatechange = function()

} //function fntEditUsuario(idpersona)


// Borrar un rol.
function fntDelUsuario(id_Persona)
{
	/*
	let btnDelRol = document.querySelectorAll(".btnDelRol");
	btnDelRol.forEach(function(btnDelRol){
		btnDelRol.addEventListener('click',function(){
	*/
	let idUsuario = id_Persona;
	// alert(idrol);
	swal({
		title:"Eliminar Usuario",
		text:"Realmente quere eliminar el Usuario?",
		type:"warning",
		showCancelButton:true,
		confirmButtonText:"Si, eliminar !",
		cancelButtonText: "No, Cancelar !",
		closeOnConfirm:false,
		closeOnCancel:true
		},function(isConfirm)
		{
			// Borrar el Rol, utiliza Ajax para accesar a la Base de datos.
			if (isConfirm)
			{
				let request = (window.XMLHttpRequest) ? new XMLHttpRequest():new ActiveXObject('Microsoft.XMLHTTP');
				// Se pasan como parametro al método definido en "Roles.php -> Controllers" desde el Ajax
				let ajaxDelUsuario = base_url+'/Usuarios/delUsuario/';
				let strData = "idUsuario="+idUsuario;
				request.open("POST",ajaxDelUsuario,true);
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
							tableUsuarios.api().ajax.reload(function(){
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
}





// Para mostrar la ventana Modal de Roles.
function openModal()
{
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
	document.querySelector('#titleModal').innerHTML = "Nuevo Usuario";
	// Resetear el Formulario, limpia todos los campos.
	document.querySelector('#formUsuario').reset();

	$('#modalFormUsuario').modal('show');
}


