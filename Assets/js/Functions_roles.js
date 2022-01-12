$('#tableRoles').DataTable();

var tableRoles;
// Cuanddo se termine de cargar agregar un escucha para cargar la funcion.
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

	// Capturar los datos del formulario de "Nuevo Rol"
	// Seleccionan el id del formulario de Rol

	var formRol = document.querySelector("#formRol");
	formRol.onsubmit = function(e){
		e.preventDefault();
		
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
		let ajaxUrl = base_url+'/Roles/setRol'; // Url a donde buscara el archivo
		
		let formData = new FormData(formRol);
		// El método utilizado para enviar la informacion es "POST"
		request.open("POST",ajaxUrl,true);
		request.send(formData);
		request.onreadystatechange = function(){
			if (request.readyState == 4 && request.status == 200)
			{
				// console.log(request.responseText);
				// La información que viene desde el método "setRol" del Controllers "Roles"
				let objData = JSON.parse(request.responseText);

				// Accesando a los elementos del Arreglo asociativo
				if (objData.status)
				{
					$('#modalFormaRol').modal("hide");
					formRol.reset();
					swal("Roles de Usuarios",objData.msg,"success");
					tableRoles.api().ajax.reload(function(){
						fntEditRol(); // Para cuando se reacargue el DataTable asigne el evento "Click" de los botones.
						//fntDelRol();
						//fntPermisos();
					});					
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
	// Se actualizan los datos de la ventana modal a Mostrar.
	document.querySelector('#idRol').value = "";	
	// Cambiando los colores de la franja de la ventana.
	document.querySelector('.modal-header').classList.replace("headerUpdate","headerRegister");
	// Cambiando la clase de los botones (Colores)
	document.querySelector('#btnActionForm').classList.replace("btn-info","btn-primary");
	document.querySelector('#btnText').innerHTML = "Guardar";
	document.querySelector('#titleModal').innerHTML = "Nuevo Rol";
	document.querySelector('#formRol').reset();

	$('#modalFormaRol').modal('show');
}

// Editar Roles.
// Llamando a la funcion cuando se termina de cargar la página.
window.addEventListener('load',function(){
	fntEditRol();
	fntDelrol();
	fntPermisos();
},false);

// Asignando el evento "Click". a los registros de los roles en lo referente al Boton.
function fntEditRol()
{
	console.log('Entre a Function fntEditRol');
	let btnEditRol_b = document.querySelectorAll(".btnEditRol");
	//console.log (btnEditRol_b);
	btnEditRol_b.forEach(function(btnEditRol_b){
		
		btnEditRol_b.addEventListener('click',function(){
			//console.log('Click en el boton de edit');

			// Se actualizan los datos de la ventana modal a Mostrar.
			document.querySelector('#titleModal').innerHTML = "Actualizar Rol";
			document.querySelector('.modal-header').classList.replace("headerRegister","headerUpdate");
			document.querySelector('#btnActionForm').classList.replace("btn-primary","btn-info");
			document.querySelector('#btnText').innerHTML = "Actualizar";

			// El código para ejecutar Ajax.
			// "rl" se agrego junto con los botones de "Editar","Borrar" cunado se muestran los Roles. Es el "id" del Rol en la tabla.
			var idrol = this.getAttribute("rl");
			//console.log(idrol);

			// Detecta en que navegador se encuentra activo. Google Chrome, Firefox o Internet Explorer. 
			let request = (window.XMLHttpRequest) ? new XMLHttpRequest():new ActiveXObject('Microsoft.XMLHTTP');
			// Se pasan como parametro al método definido en "Roles.php -> Controllers" desde el Ajax
			var ajaxUrl = base_url+'/Roles/getRol/'+idrol; 
			request.open("GET",ajaxUrl,true);
			request.send(); // Se envia la petición (ejecutar el archivo "getRol/XXX")
			// Lo que retorne (echo Json.... el Controllers/Roles/getRol)

			request.onreadystatechange = function()
			{			
				if (request.readyState == 4 && request.status == 200)
				{
					// console.log(request.responseText);
					// Convertir la informacion de Objeto a Formato JSon
					var objData = JSON.parse(request.responseText);
					//console.log("ResponseText ",objData);

					if (objData.status)
					{				
						console.log("objData.data.id_rol",objData.data.id_rol);
						document.querySelector("#idRol").value = objData.data.id_rol;

						// Para obtener el contenido de una etiqueta HTML desde JavaScript
						let valor = document.getElementById("idRol").value;
						console.log ("valor = document.getElementById(idRol).value",valor);

						document.querySelector("#txtNombre").value = objData.data.nombrerol;
						document.querySelector("#txtDescripcion").value = objData.data.descripcion;
												
						// Asigna los valores a Select (Combobox)
						// Es importante que se utiliza "var" en "optionSelect" de lo contrario no funciona.
						// "notBlock" = Es una clase para borrar el renglon duplicado 
						if (objData.data.status == 1)
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
		});
	});
}

// Borrar un rol.
function fntDelrol()
{
	let btnDelRol = document.querySelectorAll(".btnDelRol");
	btnDelRol.forEach(function(btnDelRol){
		btnDelRol.addEventListener('click',function(){
			let idrol = this.getAttribute("rl");
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
		});
	});
}
// Asignar el evento "click" al boton de llaves (donde cambian los permisos de los roles).
function fntPermisos()
{
	let btnPermisosRol = document.querySelectorAll(".btnPermisosRol");
	btnPermisosRol.forEach(function(btnPermisosRol){
		btnPermisosRol.addEventListener('click',function(){
			// Obteniendo la información desde la tabla, usando AJAX.

			// "rl" se define en "html" y con JavaScript se extrae el valor. 
			var idrol = this.getAttribute("rl");
			// Determina cual navegador esta usandose.
			let request = (window.XMLHttpRequest) ? new XMLHttpRequest():new ActiveXObject('Microsoft.XMLHTTP');
			// Se pasan como parametro al método definido en "getPermisosRol.php -> Controllers" desde el Ajax
			let ajaxUrl = base_url+'/Permisos/getPermisosRol/'+idrol;
			request.open("GET",ajaxUrl,true);
			request.send();
			request.onreadystatechange = function(){
				// Para que no se abran varias ventanas del modal "ModalPermisos" se usa "request.readyState == 4"
				if (request.readyState == 4 && request.status == 200)
				{
					console.log (request.responseText);
					// #contentAjax = Elemento que se creara en la vista. "/Views/Roles/roles.php"
					document.querySelector('#contentAjax').innerHTML = request.responseText;
					$('.modalPermisos').modal('show');
				}
			}




		});
	});
}