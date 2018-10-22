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

window.onload = function() {
	
	/*** LOGIN ***/
	$( "#login-button" ).click(function(event) {
		event.preventDefault();
	    event.stopPropagation();
	    
		console.log('enviado');
		
	    $("#msg_success").slideUp();
	    $("#msg_error").slideUp();
		
		//Check fields
		var error = false;
		var error_msg = "Se ha producido un error";
		
		var form_username = $( "#username" ).val();
		var form_password = $( "#password" ).val();
		//Checkbox
		if( $('#remember').prop('checked') ) 
		{
			var form_remember = true;
		}
		else
		{
			var form_remember = false;
		}
		
		if($.trim(form_username) == '') {
			$("#username").addClass('is-invalid');
			$("#label_username").addClass('text-danger');
			error = true;
			error_msg = "Todos los campos son obligatorios";
		}
		else
		{
			$("#username").removeClass('is-invalid');
			$("#label_username").removeClass('text-danger');
			error_msg = "Todos los campos son obligatorios";
		}
		
		if($.trim(form_password) == '') {
			$("#password").addClass('is-invalid');
			$("#label_password").addClass('text-danger');
			error = true;
			error_msg = "Todos los campos son obligatorios";
		}
		else
		{
			$("#password").removeClass('is-invalid');
			$("#label_password").removeClass('text-danger');
			error_msg = "";
		}
		
		if(error)
		{
			console.log('se ha producido un error');
			$("#span_error").html(error_msg);
			$("#msg_error").slideDown();
			
		}
		else{
			console.log('validando');
			//Call widget
			$.post(siteUrl + "/includes/widgets/login.php",
	        {
	          username: form_username,
	          password: form_password,
			  remember: form_remember,
	        },
	        function(data,status){
	            //Si no hay error
	            console.log(data);
	            if(status == 'success')
	            {
		            //Si hay error
		            if(data.indexOf("error") != -1){
			            $("#span_error").html(data.replace("error:", ""));
			            $("#msg_error").slideDown();
		            }
		            else
		            {
			            $("#span_success").html(data);
						$("#submit-button").hide();
						$("#msg_success").slideDown();
						
						//Ocultamos el botón de aceptar
						$('#login-button').hide();
						
		            	//Redirigimos a la página principal
						 window.setTimeout(function(){
							window.location.href = siteUrl;
						}, 3000);

						
		            }
		        }
				else
				{
					$("#span_error").html("Se ha producido un error al procesar el formulario.");
					$("#msg_serror").slideDown();
	
				}
	            
	        });
		}
		
		
		return false;
		
		
	});
	
	/*** REMEMBER PASS ***/
	$("#remember_radio1").click(function() {  
        $('#mail_group').slideUp('fast',function(){
			$('#username_group').slideDown('fast');
			$("#mail_group").val('');
		});
    });
	$("#remember_radio2").click(function() {  
         $('#username_group').slideUp('fast',function(){
			 $('#mail_group').slideDown('fast');
			 $("#username_group").val('');
		 });
    });
	//Función que controla el formulario para resetear contraseña
	$( "#remember-button" ).click(function(event) {
		event.preventDefault();
	    event.stopPropagation();
	    //Dependiendo de lo que se esté comprobando
		if($('#remember_radio1').is(':checked'))
		{
			console.log('comprobando Nombre de usuario');
			//Si el nombre de usuario no está validado
			if($('#validate-username').val() == '0')
			{
				$('#remember-alert').addClass('alert-danger');
				$('#remember-alert').html('El nombre de usuario introducido no existe');
				$('#remember-alert').slideDown('');
			}
			else
			{
				//Quitamos la alerta
				$('#remember-alert').slideUp('');
				//Enviamos el correo mediante el widget
				var form_username = $( "#r-usernamePass" ).val();
				$.post(siteUrl + "/includes/widgets/remember_pass.php",
				{
				  username: form_username,
				  email: ''
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

					if(result !== '') 
					{
						$('#remember-alert').addClass('alert-danger');
						$('#remember-alert').html(result);
						$('#remember-alert').slideDown('');
					}
					else
					{
						$('#remember-alert').removeClass('alert-danger');
						$('#remember-alert').addClass('alert-success');
						$('#remember-alert').html('Se ha enviado un correo con las instrucciones');
						$('#remember-alert').slideDown('');
					}

				}); //Fin de comprobación mediante AJAX
			}
		}
		else if($('#remember_radio2').is(':checked'))
		{
			console.log('comprobando Correo');
		}

	});
	
	//Comprobar nombre de usuario en el registro
	$("#r-usernamePass").keyup(function(){
		//Comprobamos si el nombre de usuario existe
		//Como es una petición por AJAX, la ejecutamos de forma independiente
		var form_username = $( "#r-usernamePass" ).val();
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
			if(result != '') 
			{
				$('#fb-usernamePass').hide();
				//Ponemos el símbolo 
				$('#badge-usernamePass').removeClass('badge-danger');
				$('#badge-usernamePass').addClass('badge-success');
				$('#i-usernamePass').removeClass('fa-times');
				$('#i-usernamePass').addClass('fa-check');
				//Marcamos el input como invalido
				$('#r-usernamePass').removeClass('is-invalid');
				$('#r-usernamePass').addClass('is-valid');

				//Marcamos el campo oculto			
				$('#validate-username').val('1');
			}
			else
			{
				$('#validate-username').val('0');
			//Ponemos el aviso y marcamos la entrad como inválida
			$('#fb-usernamePass').show();
			$('#badge-usernamePass').removeClass('badge-success');
			$('#badge-usernamePass').addClass('badge-danger');
			//Ponemos el símbolo
			$('#badge-usernamePass').removeClass('badge-success');
			$('#badge-usernamePass').addClass('badge-danger');
			$('#i-usernamePass').removeClass('fa-check');
			$('#i-usernamePass').addClass('fa-times');
			//Marcamos el input en rojo
			$('#r-usernamePass').removeClass('is-valid');
			$('#r-usernamePass').addClass('is-invalid');
			
			//Marcamos el campo oculto
			$('#validate-username').val('0');
			}

		}); //Fin de comprobación mediante AJAX

	});
	
	//Formulario de contacto
	$( "#contact-button" ).click(function(event) {
		console.log('hola');
	});
	
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

	//Comprobar nombre de usuario en el registro
	$("#r-username").keyup(function(){
		var result = checkUsername($("#r-username").val());
		markInputReg('username',result);
		//Si está correcto, lo indicamos en el campo oculto
		if(result == '')
		{
			$('#validate-username').val('1');
		}
		else
		{
			$('#validate-username').val('0');
		}
	});
	
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
	
	//Comprobación del ncorreo electrónico
	function checkEmail(val)
	{
		var result = '';
		
		if(!ValidateEmail(val.trim()))
		{
			result =  "El correo introducido no es válido";	
		}
		else
		{
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

		}
		return result;
		
		
	}
	
	//Si las contraseñas coinciden, lo indicamos
	$("#r-password2").keyup(function()
	{
		if($("#r-password2").val() == $("#r-password").val())
			{
				markInputReg('password','');
				markInputReg('password2','');
			}
	});
	
	//Envio del formulario
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
		
		//Si el nombre de usuario no está validado o está vacío
		if($('#validate-username').val() == 0 || $('#r-username').val() == '')
		{
			markInputReg('username','El nombre de usuario debe ser válido', false);
			error = true;
		}
		else
		{
			markInputReg('username','', false);
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
		
		//Si la contraseña est avacía
		if($('#r-password').val().trim() == '')
		{
			markInputReg('password','Debes escribir una contraseña', false);
			error = true;
		}
		else if($('#r-password').val() != $('#r-password2').val() )
		{
			markInputReg('password2','La contraseña no coincide', false);
			markInputReg('password','', false);
			error = true;
		}
		else
		{
			markInputReg('password','', false);
			markInputReg('password2','', false);
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


	/*** USER DATA ***/
	$( "#user-edit" ).click(function() {
		
	    if( $('#user-edit').prop('checked') ) 
		{
			$('#user-email,#user-name,#user-pass').removeClass('form-control-plaintext');
			$('#user-email,#user-name,#user-pass').addClass('form-control');
			$('#user-pass').val('');
			$('#passwordHelpInline').slideDown();
			$('#user-birth').removeAttr('disabled');
			$('#user-button').removeAttr('disabled');
		}
		else
		{
			$('#user-email,#user-name').removeClass('form-control');
			$('#user-email,#user-name').addClass('form-control-plaintext');
			$('#user-pass').val('1234');
			$('#passwordHelpInline').slideUp();
			$('#user-birth').attr("disabled", true);
			$('#user-button').attr("disabled", true);
		}
		
	});
	
	//Activar/desactivar notificaciones
	$( ".cat_check" ).click(function(event) {
		event.preventDefault();
	    event.stopPropagation();
		
		//ID de la categoría y del usuario
		var id_cat = this.value;
		var id_user = $('#user-id').val();
	
		if( $(this).is(':checked') ) 
		{
			//Se ha activado. Se solicita  por AJAX
			var activate = true;
		}
		else
		{
			//Se ha desactivado	
			var activate = false;
		}
		
		//Hacemos la solicitud por AJAX
		$.post(siteUrl + "/includes/widgets/cat_notice.php",
			{
				cat: id_cat,
				user: id_user,
				action: activate
			
			},
			function(data,status){
				//Si no hay error

				if(status == 'success' && data == 'success')
					{
						console.log(activate);
						//Cambiamos el estado del checkbox
						if(activate)
							{
								$('#check' + id_cat).prop('checked', true);
								console.log('checado');
							}
						else
							{
								$('#check' + id_cat).prop('checked', false);
								console.log('deschecado');
							}
					}
				
			});
		
	});

};

//GOOGLE CAPTCHA response
//https://www.youtube.com/watch?v=okaZ6OIqlzs
function recaptcha_callback(){
      //alert("callback working");
	console.log('listo');
      $('#contact-button').prop("disabled", false);
      $('#contact-button').removeClass( "cursor_none");
    }