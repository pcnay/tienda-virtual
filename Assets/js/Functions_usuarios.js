const er = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
let tableUsuarios;

// Validar la entrada, solo caracteres permitidos "txtIdentificacion"
$("#txtIdentificacion").bind('keypress', function(event) {
	let regex = new RegExp("^[A-Za-z0-9- ]+$");
	let key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
	if (!regex.test(key)) {
		event.preventDefault();
		return false;
	}
});

// Validar la entrada, solo caracteres permitidos "txtNombre"
$("#txtNombre").bind('keypress', function(event) {
	let regex = new RegExp("^[A-Za-z ]+$");
	let key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
	if (!regex.test(key)) {
		event.preventDefault();
		return false;
	}
});

// Validar la entrada, solo caracteres permitidos "txtApellidos"
$("#txtApellido").bind('keypress', function(event) {
	let regex = new RegExp("^[A-Za-z ]+$");
	let key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
	if (!regex.test(key)) {
		event.preventDefault();
		return false;
	}
});

// Validar la entrada, solo caracteres permitidos "txtApellido"
$("#txtTelefono").bind('keypress', function(event) {
	let regex = new RegExp("^[0-9-]+$");
	let key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
	if (!regex.test(key)) {
		event.preventDefault();
		return false;
	}
});

// Validar la entrada, solo caracteres permitidos "txtApellido"
$("#txtPassword").bind('keypress', function(event) {
	let regex = new RegExp("^[A-Za-z0-9-+@]+$");
	let key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
	if (!regex.test(key)) {
		event.preventDefault();
		return false;
	}
});

// Expresion regular para validar 
const email = document.querySelector('#txtEmail');
email.addEventListener('blur',validarEmail);

function validarEmail(e)
{
	//console.log("error de email");
	if (!er.test(e.target.value)) 
	{		
		swal ("Atencion", "Email incorrecto ","error");
		return false;
	}
}



document.addEventListener('DOMContentLoaded',function(){
// DataTable para desplegarlo en la pantalla principal.

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


	let formUsuario = document.querySelector("#formUsuario");
	formUsuario.onsubmit = function(e) 
	{
		e.preventDefault(); // Evita que se recarga la página
		// Obtiene el contenido de las etiquetas de las capturas de Usuarios.
		let strIdentificacion = document.querySelector('#txtIdentificacion').value;		
		let strNombre = document.querySelector('#txtNombre').value;		
		let strApellido = document.querySelector('#txtApellido').value;		
		let strEmail = document.querySelector('#txtEmail').value;		
		let strTelefono = document.querySelector('#txtTelefono').value;		
		let strTipousuario = document.querySelector('#listaRoles').value;		
		let strPassword = document.querySelector('#txtPassword').value;	
		let intStatus = document.querySelector('#listStatus').value;		

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
		request.onreadystatechange = function()
		{
			if (request.readyState == 4 && request.status == 200)
			{
				let objData = JSON.parse(request.responseText);
				if (objData.estatus)
				{
					if (rowTable == "") // Creando un nuevo usuario.
					{
					// Mostrar los datos en el "dataTable"
						tableUsuarios.api().ajax.reload(function(){});
					}
					else // Cuando se esta editado.
					{
						htmlStatus = intStatus == 1 ? '<span class="badge badge-success">Activos</span>':
						'<span class="badge badge-danger">Inactivos</span>';

						rowTable.cells[1].textContent = strNombre;
						rowTable.cells[2].textContent = strApellido;
						rowTable.cells[3].textContent = strEmail;
						rowTable.cells[4].textContent = strTelefono;
						// Obtiene el nombre que le corresponde al rol asignado, es decir "Administrador", "Vendedor", etc.
						rowTable.cells[5].textContent = document.querySelector("#listaRoles").selectedOptions[0].text;
						rowTable.cells[6].innerHTML = htmlStatus; //Incrusta código HTML en la etiqueta del DataTable.
					}

					$('#modalFormUsuario').modal("hide");
					formUsuario.reset();
					swal("Usuarios",objData.msg,"success");
				}
				else
				{
					swal("Error",objData.msg,"error");
				}
			}
		}




	} // formUsuario.onsubmit = function(e) 

}, false);

// Cuando se cargue la ventana obtendra los "Roles"
window.addEventListener('load',function(){
	fntRolesUsuarios();
	//fntViewUsuario();
},false);


// Para extraer los "Usuarios" y vaciarla al "Select"
function fntRolesUsuarios()
{
	//if (document.querySelector('#listRolid'))
	//{
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
				// Se asigna los datos al ComboBox "listaRoles"
				document.querySelector('#listaRoles').innerHTML = request.responseText;
				// Se comenta esta línea para que muestra datos para seleccionar en el ComboBox
				//document.querySelector('#listaRoles').value = 1;
			//	$('#listaRoles').selectpicker('render'); // Para que se refresque el Select.
				$('#listaRoles').selectpicker('refresh'); // Para que se refresque el Select, funciona en Php 8
			}
		}

	//} // if (document.querySelector('#listRolid'))
	
} // function fntRolesUsuarios()


// Para mostrar el modal "View User"
function fntViewUsuario(idpersona)
{
	//console.log('Entre a Function fntEditRol');
	
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
				// Asigna color cuando este Activo o Inactivo
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

		} // if (request.status == 200 && request.readyState == 4)

	} // 	request.onreadystatechange = function()

} //function fntViewUsuario(idpersona)

// Editar un Usuario
// Para mostrar el modal "View User"
function fntEditUsuario(element,idpersona)
{
	//console.log('Entre a Function fntEditRol');
	// Se agrega estas lineas ya que se edita un Usuario, y se recarga, pierde la página donde se encontraba la tabla inicialmente.
	rowTable = element.parentNode.parentNode.parentNode;
	// .parentNode = Sube al padre inmediato superior, hasta subir el padre de la etiqueta (dos niveles)
	//console.log(rowTable);
	// rowTable.cells[1].textContent = 
	
	// El código para ejecutar Ajax.
	// "us" se agrego junto con los botones de "Editar","Borrar" cunado se muestran los Usuarios. Es el "id" del Usuarios en la tabla.
	//var idpersona = this.getAttribute("us");

	//$('#modalFormUsuario').modal('show');


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
			//console.log("comple la condicion 200 y 400 ");
		//	console.log(request.responseText);

			//$('#modalFormUsuario').modal('show');

			let objData = JSON.parse(request.responseText);
			if (objData.estatus)			
			{	
				//console.log("password ",objData.data.passwords);
				//console.log("Valor de rolid ",objData.data.id_rol);
				document.querySelector("#idUsuario").value = objData.data.id_persona;	
				document.querySelector("#txtIdentificacion").value = objData.data.identificacion;
				document.querySelector("#txtNombre").value = objData.data.nombres;
				document.querySelector("#txtApellido").value = objData.data.apellidos;
				document.querySelector("#txtTelefono").value = objData.data.telefono;
				document.querySelector("#txtEmail").value = objData.data.email_user;
				document.querySelector("#txtPassword").value = objData.data.passwords;	
				
				//document.querySelector("#listRolid").value = objData.data.rolid; // .
				document.querySelector("#listaRoles").value = objData.data.rolid; // .
				//id_rol
				// Renderiza y asigna el valor que esta guardado en la tabla.
				
				// $('#listRolid').selectpicker('render');
				$('#listaRoles').selectpicker('refresh'); // Funciona en PHP 8

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
				//$('#listStatus').selectpicker('render');
				$('#listStatus').selectpicker('refresh'); // Funciona en PHP 8

			}
			
		}

		$('#modalFormUsuario').modal('show');

	} // 	request.onreadystatechange = function()


} //function fntEditUsuario(idpersona)


// Borrar un rol.
function fntDelUsuario(id_Persona)
{

//	let btnDelRol = document.querySelectorAll(".btnDelRol");
//	btnDelRol.forEach(function(btnDelRol){
//		btnDelRol.addEventListener('click',function(){
	
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



// Para mostrar la ventana Modal de Usuarios.
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
	document.querySelector('#titleModal').innerHTML = "Nuevo Usuario";
	// Resetear el Formulario, limpia todos los campos.
	document.querySelector('#formUsuario').reset();

	$('#modalFormUsuario').modal('show');
}