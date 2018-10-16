// JavaScript Document

/*PLaceholder Label Animation: https://codepen.io/nathanlong/pen/kkLKrL */
$('input').focus(function(){
  $(this).parents('.form-group').addClass('focused');
});

$('input').blur(function(){
  var inputValue = $(this).val();
  if ( inputValue == "" ) {
    $(this).removeClass('filled');
    $(this).parents('.form-group').removeClass('focused');  
  } else {
    $(this).addClass('filled');
  }
})  

/* FORMS */
window.onload = function() {
	
	/*** REGISTER FORM VALIDATION ***/
	//Función que marca los campos como válidos o inválidos en el formulario de registro
	//Si la variable "msg" se pasa vacía, mara el campo como "válido"
	function markInputReg(field,msg,badge=true)
	{
		if(msg !== '')
		{
			$('#fb-' + field).html(msg);
			$('#fb-' + field).show();
			if(badge)
			{
				$('#badge-' + field).removeClass('badge-success');
				$('#badge-' + field).addClass('badge-danger');
				//Ponemos el símbolo
				$('#badge-' + field).removeClass('badge-success');
				$('#badge-' + field).addClass('badge-danger');
				$('#i-' + field).removeClass('fa-check');
				$('#i-' + field).addClass('fa-times');
			}
			
			//Marcamos el input como invalido
			$('#r-' + field).removeClass('is-valid');
			$('#r-' + field).addClass('is-invalid');
		}
		else
		{
			$('#fb-' + field).html(msg);
			$('#fb-' + field).hide();
			if(badge)
			{
				//Ponemos el símbolo 
				$('#badge-' + field).removeClass('badge-danger');
				$('#badge-' + field).addClass('badge-success');
				$('#i-' + field).removeClass('fa-times');
				$('#i-' + field).addClass('fa-check');
			}
			//Marcamos el input como invalido
			$('#r-' + field).removeClass('is-invalid');
			$('#r-' + field).addClass('is-valid');
		}
	}

	//Comprobar correo en el registro
	$("#r-email").keyup(function(){
		var result = checkEmail($("#r-email").val());
		markInputReg('email',result);
		if(result == '')
		{
			$('#validate-email').val('1');
		}
		else
		{
			$('#validate-email').val('0');
		}
	});
	
	
	//Comprobación del nombre de usuario
	function checkUsername(val)
	{
		var result = '';
		console.log(val);
		if(val.trim().length < 4 || val.trim().length > 8 || val.includes('@'))
		{
			result =  "Entre 4 y 8 caracteres (sin @)";
			
		}
		else
		{
			//Comprobamos si el nombre de usuario existe
			//Como es una petición por AJAX, la ejecutamos de forma independiente
			var form_username = $( "#r-username" ).val();
			$.post(siteUrl + "/includes/widgets/check_username.php",
			{
			  username: form_username
			},
			function(data,status){
				//Si no hay error

				if(status == 'success')
				{
					result = data;
				}
				else
				{
					result = "Se ha producido un error al comprobar el nombre de usuario.";
				}
				//Ponemos el resultado y validamos el campo oculto
				markInputReg('username',result);
				if(result == '') 
				{
					$('#validate-username').val('1');
				}
				else
				{
					$('#validate-username').val('0');
				}

			}); //Fin de comprobación mediante AJAX

		}
		return result;
		
		
	}
	
	//Funcion que comprueba si un correo es válido
	function ValidateEmail(mail) 
	{
	 if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(mail))
	  {
		return (true)
	  }
		return (false)
	}
	
	//Comprobación del correo electrónico
	function checkEmail(val)
	{
		var result = '';
		
		if(!ValidateEmail(val.trim()))
		{
			result =  "El correo introducido no es válido";	
		}
		else
		{
			/*
			//Comprobamos si el correo existe
			//Como es una petición por AJAX, la ejecutamos de forma independiente
			var form_email = $( "#r-email" ).val();
			$.post(siteUrl + "/includes/widgets/check_username.php",
			{
			  email: form_email
			},
			function(data,status){
				//Si no hay error

				if(status == 'success')
				{
					result = data;
				}
				else
				{
					result = "Se ha producido un error al comprobar el correo electrónico.";
				}
				//Ponemos el resultado 
				markInputReg('email',result);
				if(result == '') 
				{
					$('#validate-email').val('1');
				}
				else
				{
					$('#validate-email').val('0');
				}

			}); //Fin de comprobación mediante AJAX
			*/
		}
		return result;
		
		
	}
	
	//Envio del formulario de registro
	$( "#register-button" ).click(function(event) {
		event.preventDefault();
	    event.stopPropagation();
		
		//Por defecto no hay errores
		var error = false;
	    
		//Si el nombre está vacio
		if($('#r-name').val().trim() === '')
		{
			markInputReg('name','El campo nombre es obligatorio', false);
			error = true;
		}
		else
		{
			markInputReg('name','', false);
		}
		
		//Si el correo no está validado o está vacío
		if($('#validate-email').val() == 0 || $('#r-email').val() == '')
		{
			markInputReg('email','El correo debe ser válido', false);
			error = true;
		}
		else
		{
			markInputReg('email','', false);
		}
		
		//Si el año de nacimiento está vacío
		if($('#r-birth').val().trim() == '')
		{
			markInputReg('birth','Debe indicar un año de nacimiento', false);
			error = true;
		}
		else
		{
			markInputReg('birth','', false);
		}
		
		//Si la zona de residencia está vacía
		if($('#r-zone').val().trim() == '')
		{
			markInputReg('zone','Debe indicar la zona de residencia', false);
			error = true;
		}
		else
		{
			markInputReg('zone','', false);
		}
		
		//Si no se ha indicado el sexo
		if( typeof $('input[name=r-sexo]:checked', '#registerForm').val() !== "undefined" ) 
		{
			markInputReg('sexo','', false);
		}
		else
		{
			markInputReg('sexo','Debes indicar el sexo', false);	
			error = true;
			
		}
		
		
		//Si no se ha marcado el checkbox
		if( $('#r-legalCheck').prop('checked') ) 
		{
			markInputReg('legalCheck','', false);
		}
		else
		{
			markInputReg('legalCheck','Debes aceptar las condiciones de uso', false);	
			error = true;
		}
		
		//Si todo está bien mandamos el formulario
		if(error === false)
		{
			console.log('enviado');
			$('#registerForm').submit();
		}
		
	});
	
	
	$( "#remember-button" ).click(function(event) {
		event.preventDefault();
	    event.stopPropagation();
		
		//Comprobamos si el correo existe
		//Como es una petición por AJAX, la ejecutamos de forma independiente
		var form_email = $( "#remember_email" ).val();
		$.post(siteUrl + "/includes/widgets/check_encuestado.php",
		{
		  email: form_email
		},
		function(data,status){
			//Si no hay error

			if(status == 'success')
			{
				result = data;
				console.log(data);
			}
			else
			{
				result = "Se ha producido un error al comprobar el correo electrónico.";
			}
			//Ponemos el resultado 
			markInputReg('remember_email',result);
			if(result == '') 
			{
				//$('#validate-email').val('1');
			}
			else
			{
				//$('#validate-email').val('0');
			}

		}); //Fin de comprobación mediante AJAX
		
		
	});
}


