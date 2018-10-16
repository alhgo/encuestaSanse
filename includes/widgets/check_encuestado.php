<?php
require_once('../toolkit.php');
//Cargamos la clase de user
$encuesta = new Encuesta;

if(isset($_POST['email']) && $_POST['email'] != '')
{
	
	$return = $encuesta->resendCorreo($_POST['email']);
	die($return);
}
else
{
	die('No se ha proporcionado un correo electrónico válido');
}
?>
