<?php
require_once('includes/toolkit.php');
$cookiename = c::get('cookie.user');
setcookie($cookiename, null, time() - 3600, "/");
$url = c::get('site.url');

header("Location: $url"); /* Redirección del navegador */

/* Asegurándonos de que el código interior no será ejecutado cuando se realiza la redirección. */
exit;
?>
