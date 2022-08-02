var tableClientes;

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
		"iDisplayLength":10,
		"order":[[0,"desc"]]
	});

	if (document.querySelector("#formCliente"))
	{
		var formCliente = document.querySelector("#formCliente");
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
						$('#modalFormCliente').modal("hide");
						formCliente.reset();
						swal("Clientes",objData.msg,"success");

						// Mostrar los datos en el "dataTable"
						tableClientes.api().ajax.reload(function(){});
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
