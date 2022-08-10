$('#tableRoles').DataTable();

var tableRoles;
// Cuanddo se termine de cargar agregar un escucha para cargar la funcion.
// "base_url" se definio en "/Views/Template/Footer_admin.php"
document.addEventListener('DOMContentLoaded',function(){
	tableRoles = $('#tableRoles').dataTable({
		"aProcessing":true,
		"aServerside":true,
		"language": {
			"url":"//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
		},
		"ajax":{
			"url":" "+base_url+"/Roles/getRoles",
			"dataSrc":""
		},
		"columns":[
			{"data":"id_rol"},
			{"data":"nombrerol"},
			{"data":"descripcion"},
			{"data":"estatus"},
			{"data":"options"}
		],
		"resonsieve":"true",
		"bDestroy":true,
		"iDisplayLength":10,
		"order":[[0,"desc"]]
	});

	
	// En esta parte se inici con el Ajax para grabar la información.
	// Capturar los datos del formulario de "Nuevo Rol"
	// Seleccionan el id del formulario de Rol
	var formaRol = document.querySelector("#formRol");
	//console.log (formaRol);
	formaRol.onsubmit = function(e){
		e.preventDefault();
		console.log("Onsubmit");

		// Obtener el contenido de las etiquetas del Modal "Agregar Rol"
		var intIdRol = document.querySelector('#idRol').value;
		let strNombre = document.querySelector("#txtNombre").value;
		let strDescripcion = document.querySelector("#txtDescripcion").value;
		let intStatus = document.querySelector("#listStatus").value;

		if (strNombre == '' || strDescripcion == '' || intStatus == '')
		{
			swal ("Atencion","Todos los campos son obligatorios","error");
			return false; // Detiene el proceso.
		}

		// Detecta en que navegador se encuentra activo. Google Chrome, Firefox o Internet Explorer. 
		let request = (window.XMLHttpRequest) ? new XMLHttpRequest():new ActiveXObject('Microsoft.XMLHTTP');
		let ajaxUrl = base_url+'/Roles/setRol'; // Url a donde buscara el archivo, es en el Controlador/Roles.
		
		let formData = new FormData(formRol);
		// El método utilizado para enviar la informacion es "POST"
		request.open("POST",ajaxUrl,true);
		request.send(formData);
		request.onreadystatechange = function(){
			if (request.readyState == 4 && request.status == 200) // Verifica que si llego la información.
			{
				// console.log(request.responseText); // Determinar el contenido de lo que reotorno(Roles/seRol)
				// La información que viene desde el método "setRol" del Controllers "Roles"
				let objData = JSON.parse(request.responseText);

				// Accesando a los elementos del Arreglo asociativo, del valor retornado de "setRol"
				if (objData.status)
				{
					$('#modalFormaRol').modal("hide");
					formRol.reset();
					swal("Roles de Usuarios",objData.msg,"success");
					// Recarga el DataTable
					tableRoles.api().ajax.reload() //function(){
						//fntEditRol(); // Para cuando se reacargue el DataTable asigne el evento "Click" de los botones.
						//fntDelRol();
						//fntPermisos();
					//});					
				}
				else
				{
					swal("Error",objData.msg,"error");
				}
			}
			//console.log(request);
		}
	}

});


// Para mostrar la ventana Modal de Roles.
function openModal()
{
	//alert("OpenModal");
	// Se actualizan los datos de la ventana modal a Mostrar, se agregan estos valores para que se pueda actualiar la ventana modal de "Agregar" y "Actualizar" Roles.

	// Estes lineas de definieron en "fntEditRol()"
	// Es el Input "hidden" que se encuentra : /Views/Templetes/Modals/ModalRoles.php
	document.querySelector('#idRol').value = "";	
	// Cambiando los colores de la franja de la ventana.
	document.querySelector('.modal-header').classList.replace("headerUpdate","headerRegister");
	// Cambiando la clase de los botones (Colores)
	document.querySelector('#btnActionForm').classList.replace("btn-info","btn-primary");
	document.querySelector('#btnText').innerHTML = "Guardar";
	document.querySelector('#titleModal').innerHTML = "Nuevo Rol";
	// Resetear el Formulario, limpia todos los campos.
	document.querySelector('#formRol').reset();

	$('#modalFormaRol').modal('show');
}

// Editar Roles.
// Llamando a la funcion cuando se termina de cargar la página.
window.addEventListener('load',function(){
	//fntEditRol();
	//fntDelrol();
	//fntPermisos();
},false);

// Asignando el evento "Click". a los registros de los roles en lo referente al Boton.
function fntEditRol(id_rol)
{
	//console.log('Entre a Function fntEditRol');
	/*
	var btnEditRol_b = document.querySelectorAll(".btnEditRol");
	console.log (btnEditRol_b);
	btnEditRol_b.forEach(function(btnEditRol_b){
	

		btnEditRol_b.addEventListener('click',function(){
			//console.log('Click en el boton de edit');
*/

	// Se actualizan los datos de la ventana modal a Mostrar.
	// Se utiliza la misma ventana modal para " Agregar" y "Editar"
	// Cambiando el titulo de la ventana Modal que se encuentra defina en /Views/Templetes/Modals/ModalRoles.php
	document.querySelector('#titleModal').innerHTML = "Actualizar Rol";
	// Reemplaza el nombre de la clase (ya que se utiliza clases de CSS para cambiar el color de la ventana) que contiene la ventana Modal que se encuentra defina en /Views/Templetes/Modals/ModalRoles.php
	document.querySelector('.modal-header').classList.replace("headerRegister","headerUpdate");

	// Reemplaza el nombre de la clase del boton (este nombre de clase se encuentra en "bootStrap") que contiene la ventana Modal que se encuentra defina en /Views/Templetes/Modals/ModalRoles.php
	document.querySelector('#btnActionForm').classList.replace("btn-primary","btn-info");

	// Reemplaza el texto del boton "<span>" que contiene la ventana Modal que se encuentra defina en /Views/Templetes/Modals/ModalRoles.php
	document.querySelector('#btnText').innerHTML = "Actualizar";

	// El código para ejecutar Ajax.
	// "rl" se agrego junto con los botones de "Editar","Borrar" cunado se muestran los Roles. Es el "id" del Rol en la tabla.
	//var idrol = this.getAttribute("rl");
	var idrol = id_rol;
	//console.log(idrol);

	// Detecta en que navegador se encuentra activo. Google Chrome, Firefox o Internet Explorer. 
	let request = (window.XMLHttpRequest) ? new XMLHttpRequest():new ActiveXObject('Microsoft.XMLHTTP');

	// Se pasan como parametro al método definido en "Roles.php -> Controllers" desde el Ajax
	var ajaxUrl = base_url+'/Roles/getRol/'+idrol; 
	request.open("GET",ajaxUrl,true);
	request.send(); // Se envia la petición (ejecutar el archivo "getRol/XXX")
	// Lo que retorne (echo Json.... el Controllers/Roles/getRol)

	// Verifica el resultado de la ejecución Ajax
	request.onreadystatechange = function()
	{			
		if (request.readyState == 4 && request.status == 200) // Vaiida si llego correctamente la respuesta.
		{
			// console.log(request.responseText);
			
			// Convertir la informacion de Objeto a Formato JSon					
			var objData = JSON.parse(request.responseText); // Es el resultado de la ejecución del Ajax-
			//console.log("ResponseText ",objData);

			if (objData.status)
			{				
				//console.log("objData.data.id_rol",objData.data.id_rol);
				document.querySelector("#idRol").value = objData.data.id_rol;

				// Para obtener el contenido de una etiqueta HTML desde JavaScript
				let valor = document.getElementById("idRol").value;
				//console.log ("valor = document.getElementById(idRol).value",valor);

				document.querySelector("#txtNombre").value = objData.data.nombrerol;
				document.querySelector("#txtDescripcion").value = objData.data.descripcion;
										
				// Asigna los valores a Select (Combobox)
				// Es importante que se utiliza "var" en "optionSelect" de lo contrario no funciona.
				// "notBlock" = Es una clase para borrar el renglon duplicado 
				//console.log(typeof(objData.data.estatus));

				if (parseInt(objData.data.estatus) == 1)
				{
					var optionSelect = '<option value="1" selected class="notBlock">Activo</option>';
				}
				else
				{
					var optionSelect = '<option value="2" selected class="notBlock">Inactivo</option>';
				}

				// Completa la instrucción  del Select.
				let htmlSelect = `${optionSelect}
													<option value="1">Activo</option>
													<option value="2">Inactivo</option>`;	
				
				// Asigna el valor a la etiqueta del ComboBox
				document.querySelector('#listStatus').innerHTML = htmlSelect;
				$('#modalFormaRol').modal('show');							
			}
			else
			{
				swal("Error",objData.msg,"error");
			}
		}			
	}
}

// Borrar un rol.
function fntDelRol(id_rol)
{
	/*
	let btnDelRol = document.querySelectorAll(".btnDelRol");
	btnDelRol.forEach(function(btnDelRol){
		btnDelRol.addEventListener('click',function(){
	*/
	let idrol = id_rol;
	// alert(idrol);
	swal({
		title:"Eliminar Rol",
		text:"Realmente quere eliminar el Rol ?",
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
				let ajaxDelRol = base_url+'/Roles/delRol/';
				let strData = "idrol="+idrol;
				request.open("POST",ajaxDelRol,true);
				request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
				request.send(strData);
				request.onreadystatechange = function(){
					// Se hizo la petición y fue exitoso.
					if (request.readyState == 4 && request.status == 200)
					{
						let objData = JSON.parse(request.responseText);
						if (objData.status)
						{
							swal("Eliminar! ",objData.msg,"success");
							tableRoles.api().ajax.reload(function(){
								fntEditRol();
								fntDelrol();
							});
						}
						else
						{
							swal("Atención",objData.msg,"error");
						}
					}
				} 			
			}
	});		
}

// Asignar el evento "click" al boton de llaves (donde cambian los permisos de los roles).
function fntPermisos(id_rol)
{
	/*
	let btnPermisosRol = document.querySelectorAll(".btnPermisosRol");
	btnPermisosRol.forEach(function(btnPermisosRol){
		btnPermisosRol.addEventListener('click',function(){
	*/
	// Obteniendo la información desde la tabla, usando AJAX.

	// "rl" se define en "html" y con JavaScript se extrae el valor. 
	var idrol = id_rol;
	// Determina cual navegador esta usandose.
	let request = (window.XMLHttpRequest) ? new XMLHttpRequest():new ActiveXObject('Microsoft.XMLHTTP');
	// Se pasan como parametro al método definido en "getPermisosRol.php -> Controllers" desde el Ajax
	// "base_url" = Se definio en el archivo "Footer_admin.php" parte superior
 	let ajaxUrl = base_url+'/Permisos/getPermisosRol/'+idrol;
	request.open("GET",ajaxUrl,true); // Abre el archivo con peticion "GET"
	request.send();
	request.onreadystatechange = function(){
		// Para que no se abran varias ventanas del modal "ModalPermisos" se usa "request.readyState == 4"
		if (request.readyState == 4 && request.status == 200)
		{
			//console.log (request.responseText);
			// #contentAjax = Elemento que se creara en la vista. "/Views/Roles/roles.php"
			document.querySelector('#contentAjax').innerHTML = request.responseText;
			$('.modalPermisos').modal('show');
			// Es el "formulario" donde se utilizn los módulos del sistema.
			// <form action="" id="formPermisos" name="formPermisos"></form>
			// Se le agrega el evento "submit", es decir cuando se oprime el boton tipo "submit" ejecutara esta funcion "fntSavePermisos"
			document.querySelector('#formPermisos').addEventListener('submit',fntSavePermisos,false);

		}
	}
}

// Para grabar los permisos, utilizando "Ajax".
function fntSavePermisos(event)
{
	event.preventDefault();
	// Generando el objeto Ajax para llamar la funcion para grabar los permisos asignados al "Rol"
	let request = (window.XMLHttpRequest) ? new XMLHttpRequest():new ActiveXObject('Microsoft.XMLHTTP');

	// "base_url" = Se definio en el archivo "Footer_admin.php" parte superior
	let ajaxUrl = base_url+'/Permisos/setPermisos';
	// Obtiene el objeto "form"
	let formElement = document.querySelector("#formPermisos"); // Obteniendo el formulario de los botones de Permisos.
	// Obtiene todos los elementos del objeto "form".
	let formData = new FormData(formElement);
	request.open("POST",ajaxUrl,true); // Abre el archivo (ejecuta en la ruta definada")
	request.send(formData);

	request.onreadystatechange = function(){
		// 4 = Se ejecuto correctamente el Ajax; 200 = Se retorna datos
		if (request.readyState= 4 && request.status == 200)
		{
			// Convertiendolo a un Objeto.
			var objData = JSON.parse(request.responseText);
			if (objData.status)
			{
				swal("Permisos de Usuario",objData.msg,"success");
			}
			else
			{
				swal("Error",objData.msg,"error");
			}

		}
	}

}