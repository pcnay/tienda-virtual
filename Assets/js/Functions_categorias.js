
	// Validar las datos de capturas de Categorias

	// Validar la entrada, solo caracteres permitidos "txtNombre"
	$("#txtNombre").bind('keypress', function(event) {
		var regex = new RegExp("^[A-Za-z0-9 ]+$");
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
			"iDisplayLength":2,
			"order":[[0,"desc"]]
		});
	


	// Se utiliza para la carga de la foto en "Categorías"
	if(document.querySelector("#foto"))
	{
    let foto = document.querySelector("#foto");
    foto.onchange = function(e) 
		{
			let uploadFoto = document.querySelector("#foto").value;
			let fileimg = document.querySelector("#foto").files;
			let nav = window.URL || window.webkitURL;
			let contactAlert = document.querySelector('#form_alert');
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
						document.querySelector('.delPhoto').classList.add("notBlock");
						foto.value="";
						return false;
				}
				else
				{  
					contactAlert.innerHTML='';
					if(document.querySelector('#img'))
					{
							document.querySelector('#img').remove();
					}
					document.querySelector('.delPhoto').classList.remove("notBlock"); // Para mostrar la X en la foto
					let objeto_url = nav.createObjectURL(this.files[0]);
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

	if(document.querySelector(".delPhoto"))
	{
		let delPhoto = document.querySelector(".delPhoto");
		delPhoto.onclick = function(e)
		{
			removePhoto();
		}
	}

	// Seccion para enviar los datos a la tablas por medio de Ajax
	// En esta parte se inici con el Ajax para grabar la información.
	// Capturar los datos del formulario de "Nuevo Categoria"
	// Seleccionan el id del formulario de Categoria
	var formCategoria = document.querySelector("#formCategoria");
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

		// Detecta en que navegador se encuentra activo. Google Chrome, Firefox o Internet Explorer. 
		let request = (window.XMLHttpRequest) ? new XMLHttpRequest():new ActiveXObject('Microsoft.XMLHTTP');
		let ajaxUrl = base_url+'/Categorias/setCategoria'; // Url a donde buscara el archivo, es en el Controlador/Roles.
		
		var formData = new FormData(formCategoria);
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
					$('#modalFormCategoria').modal("hide");
					formCategoria.reset();
					swal("Categorias ",objData.msg,"success");
					removePhoto();
					// Recarga el DataTable
					//tableRoles.api().ajax.reload() //function(){
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
			return false;
		}
	}


}, false); //document.addEventListener('DOMContentLoaded',function(){

// Funcion para remover la foto de Categoría
function removePhoto()
{
	document.querySelector('#foto').value ="";
	document.querySelector('.delPhoto').classList.add("notBlock"); // Ocultar la X
	document.querySelector('#img').remove(); // Remueve la imagen.
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
			// Retorna a un objeto lo que se retorna en "getUsuario"

			let objData = JSON.parse(request.responseText);
			if (objData.estatus)
			{	
				let estado = objData.data.estatus == 1 ?
				'<span class="badge badge-success">Activo</span>':
				'<span class="badge badge-danger">Inactivo</span>';
				
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



// Para mostrar la ventana Modal de Clientes.
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
}

