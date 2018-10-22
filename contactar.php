<?php

require_once('includes/toolkit.php');

//Obtenemos los datos del sitio y del usuario
$user = new Users;
$site = new Site;

//Si se ha mandado el fomulario, enviamos el correo
if(isset($_POST['consulta']) && $_POST['consulta'] != '')
{
	//Declaramos las clases	
	$mail = new PHPMailer(true);
	//Desactivamos el modo de debug para que no muestre errores
	$mail->SMTPDebug = false;
	$mail->do_debug = 0;

	//Datos del correo
	if(isset($_POST['nombre']) && $_POST['nombre'] != '')
	{
		$from = $_POST['nombre'];

	}
	else
	{
		$from = $_POST['email'];
	}
	
	$mail->setFrom($_POST['email'], $from);	
	$mail->addAddress(c::get('mail.contact'),'Administrador del sitio');
	$mail->Subject  = 'Consulta enviada desde ' . $site->title;
	$mail->isHTML(false); //Indicamos que NO es un correo HTML
	$mail->CharSet = 'UTF-8'; //Convertimos los caracteres a UTF8
	$mail->Body = "Consulta enviada:
	Fecha: " . date("Y-m-d H:i:s") . "
	Nombre: " . $_POST['nombre'] . "
	Correo: " . $_POST['email'] . "
	
	Consulta: " . $_POST['consulta'] . "
	"; 


	try {
		//Desactivamos los errores de la clase PHP Mailer
		@$mail->send();
		$sent = true;
	
	} catch (Exception $e) {
		//Insertamos un mensaje de error en el LOG
		$error_msg = 'Se ha producido un error al enviar el correo de contacto. Código de error: ' . $mail->ErrorInfo;
		$sent = false;
		log::putErrorLog($error_msg);

	} 

}

?>

<?php snippet('header.php', ['site' => $site]); ?>

<body>

<?php snippet('nav.php',['menu' => array('Página oficial' => 'http://www.izquierdaindependiente.es', 'Contactar' => 'contactar.php'), 'site' => $site, 'user' => $user]); ?>

	<div class="container mt-3">
		
		<?php
			if(isset($sent))
			{
				if($sent === true)
				{
					echo '
			<div class="row justify-content-center">
				<div class="col-12 col-md-8 col-lg-6 pb-5">
					<div class="alert alert-success" role="alert">
  						La consulta se ha enviado correctamente.
					</div>
				</div>
			</div>';
				}
				else if($sent === false)
				{
					echo '
			<div class="row justify-content-center">
				<div class="col-12 col-md-8 col-lg-6 pb-5">
					<div class="alert alert-danger" role="alert">
  						Lo sentimos. Se ha producido un error y la consult ano ha podido enviarse correctamente.
					</div>
				</div>
			</div>';
				}
			}
		else
		{
			snippet('contact.php');
		}
			
		?>
	

	</div>
	
<?php snippet('encuesta/remember_form_modal.php'); ?>
	
<?php snippet('footer.php', ['libs' => array('forms.js')]); ?>

</body>
</html>