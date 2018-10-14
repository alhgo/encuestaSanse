<?php
require_once('../toolkit.php');
//Cargamos la clase de user
$user = new Users;

if(isset($_POST['username']) && $_POST['username'] != '')
{
	if($user->usernameExists($_POST['username']))
	{
		//Obtenemos el correo y enviamos un mensaje
		$user_data = $user->getUserDataByUsername($_POST['username']);
		$id_user = $user_data['id_user'];
		$id_reset = $user->resetPass($id_user);
		
		die("RESET:" . $id_reset);
	}
	else
	{
		dia('El nombre de usuario no está registrado');
	}
}
else if(isset($_POST['email']) && $_POST['email'] != '')
{
	if($user->userEmailExists($_POST['email']))
	{
		//die("El correo electrónico ya está registrado");
	}
}
else
{
	echo "";
}
?>
