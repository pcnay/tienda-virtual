/* Funciones Generales para el proyecto de Tienda Virtual */ 
// alert("Hola Mundo");

// Valida que solo sean números, bloquea todos los demas caracteres expecto "BackSpace", Enter,
function controlTag(e)
{
	tecla = (document.all) ? e.keyCode: e.which;
	if (tecla === 8) return true;
	else if (tecla===0||tecla===9) return true;
	patron = /[0-9\s]/;
	n = String.fromCharCode(tecla);
	return patron.test(n);
}

// Valida cuando las capturas sean solo Letras.
function testText(txtString)
{
	let stringText = new RegExp(/^[a-zA-ZñÑÁáÉéÍíÓóÚú\s]+$/);
	if (stringText.test(txtString))
	{
		return true;		
	}
	else
	{
		return false;
	}
}

// Valida para numeros Enteros 
function testEntero(intCant)
{
	let intCantidad = new RegExp(/^[0-9]+$/);
	if (intCantidad.test(intCant))
	{
		return true;		
	}
	else
	{
		return false;
	}
}

// Valida los correos electronicos
function fntEmailValidate(email)
{
	//var stringEmail = new RegExp(/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/);

	// Direccion de correo con cualquier caracter Unicode
	//	/^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i

	var stringEmail = new RegExp(/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/);

	if (stringEmail.test(email) == false)
	{
		return false;		
	}
	else
	{
		return true;
	}	
}

function fntValidText()
{
	let validText = document.querySelectorAll(".validText");
	validText.forEach(function(validText){
		validText.addEventListener('keyup',function(){
			let inputValue = this.value;
			if (!testText(inputValue))
			{
				this.classList.add('is-invalid');
			}
			else
			{
				this.classList.remove('is-invalid');
			}
		});	
	});
}

// Funcion para validar los numeros
function fntValidNumber()
{
	let validNumber = document.querySelectorAll(".validNumber");
	validNumber.forEach(function(validNumber){
		validNumber.addEventListener('keyup',function(){
			let inputValue = this.value;
			if (!testEntero(inputValue))
			{
				this.classList.add('is-invalid');
			}
			else
			{
				this.classList.remove('is-invalid');
			}
		});	
	});
}

// Funcion para validar los correos electronicos
function fntValidEmail()
{
	let validEmail = document.querySelectorAll(".validEmail");
	validEmail.forEach(function(validEmail){
		validEmail.addEventListener('keyup',function(){
			let inputValue = this.value;
			if (!fntEmailValidate(inputValue))
			{
				this.classList.add('is-invalid');
			}
			else
			{
				this.classList.remove('is-invalid');
			}
		});	
	});
}

// Para que se ejecuten estas funciones.
window.addEventListener('load',function(){
	fntValidText();
	fntValidEmail();
	fntValidNumber();
},false);

