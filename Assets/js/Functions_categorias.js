
// Cuando se termina de cargar la página, se asignan los eventos Listener.
document.addEventListener('DOMContentLoaded',function()
{
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

}, false); //document.addEventListener('DOMContentLoaded',function(){

// Funcion para remover la foto de Categoría
function removePhoto()
{
	document.querySelector('#foto').value ="";
	document.querySelector('.delPhoto').classList.add("notBlock"); // Ocultar la X
	document.querySelector('#img').remove(); // Remueve la imagen.
}


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
