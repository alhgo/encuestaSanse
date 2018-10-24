<?php
$encuesta = new Encuesta;

$error = '';

//Comprobamos que el correo del usuario no está ya registrado
if($encuesta->encuestadoExists($_POST['r-email']))
{
	$error = "El correo que ha introducido ya está registrado. Si ha enviado el formulario de validación de correo dos veces por error, solicite de nuevo el enlace desde la página inicial o póngase en contacto con nosotros.";
}
else
{
	try {
		$id = $encuesta->registerEncuestado($_POST);
		//Si todo ha ido bien, mandamos el correo
		try {
			$result = $encuesta->sendCorreo($id);
		} catch (Exception $e) {
			$error = "Se ha producido un error al enviar el correo tras registrar sus datos. Pruebe a solicitar de nuevo el envío.";
		}

	} catch (Exception $e) {
		$error = "Se ha producido un error al registrar sus datos. Pruébelo más tarde o póngase en contacto con nosotros.";
	}
}


//print_r($_POST);

?>
<h1>Solicitud para realizar la encuesta</h1>
<hr>
<?php if($error != '') : ?>
<p class="text-danger">
ERROR: <?= $error ?>
</p>
<a href="index.php" class="btn btn-primary">Volver</a>
<?php else : ?>
<h4>Solicitud recibida correctamente</h4>
<p>Hemos enviado a la cuenta de correo indicada (<?= $_POST['r-email'] ?>) las instrucciones para realizar la encuesta. Si no recibe el correo revise la carpeta de SPAM de su gestor de correo o póngase en contacto con nosotros.</p>

<?php endif ?>
