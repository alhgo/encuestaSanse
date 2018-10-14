<?php
require_once('../toolkit.php');
//Cargamos la clase de user
$user = new Users;

if(isset($_POST['username']) && $_POST['username'] != '')
{
	if($user->usernameExists($_POST['username']))
	{
		die("El nombre de usuario ya está registrado");	
	}
}
else if(isset($_POST['email']) && $_POST['email'] != '')
{
	if($user->userEmailExists($_POST['email']))
	{
		die("El correo electrónico ya está registrado");
	}
}
else
{
	echo "";
}
?>
