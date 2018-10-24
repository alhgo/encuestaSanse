<?php
require_once('includes/toolkit.php');
$cookiename = c::get('cookie.user');
setcookie($cookiename, null, time() - 3600, "/");
$url = c::get('site.url');

//Obtenemos las variables
$vars = array();
foreach($_GET AS $key => $value){
	$vars[] = $key . '=' . $value;
}

header("Location:" . $url . 'login.php?' . implode('&',$vars)); /* Redirección del navegador */

/* Asegurándonos de que el código interior no será ejecutado cuando se realiza la redirección. */
exit;
?>
