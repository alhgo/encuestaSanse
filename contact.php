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
	if(isset($_POST['name']) && $_POST['name'] != '')
	{
		$from = $_POST['name'];

	}
	else
	{
		$from = $_POST['email'];
	}
	
	$mail->setFrom($_POST['email'], $from);	
	$mail->addAddress(c::get('mail.contact'),'Administrador del sitio');
	$mail->Subject  = 'Solicitud de registro en ' . $site->title;
	$mail->isHTML(false); //Indicamos que NO es un correo HTML
	$mail->CharSet = 'UTF-8'; //Convertimos los caracteres a UTF8
	$mail->Body = "Consulta enviada:
	Fecha: " . date('dd/mm/YY HH:ii:ss') . "
	Nombre: " . $_POST['nombre'] . "
	Correo: " . $_POST['email'] . "
	
	Consulta: " . $_POST['consulta'] . "
	"; 


	try {
		//Desactivamos los errores de la clase PHP Mailer
		@$mail->send();
		echo "Enviado";
	
	} catch (Exception $e) {
		//Insertamos un mensaje de error en el LOG
		$error_msg = 'Se ha producido un error al enviar el correo de contacto. Código de error: ' . $mail->ErrorInfo;
		echo $error_msg;
		log::putErrorLog($error_msg);

	} 

}

?>

<?php snippet('header.php', ['site' => $site]); ?>

<body>

<?php snippet('nav.php',['menu' => array('Página oficial' => 'http://www.izquierdaindependiente.es', 'Contactar' => 'contact.php'), 'site' => $site, 'user' => $user]); ?>

	<div class="container mt-3">
		
		<?php
			snippet('contact.php');
		?>
	

	</div>
	
<?php snippet('encuesta/remember_form_modal.php'); ?>
	
<?php snippet('footer.php', ['libs' => array('forms.js')]); ?>

</body>
</html>