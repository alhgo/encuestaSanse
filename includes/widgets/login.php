<?php
require_once('../toolkit.php');
//Cargamos la clase de user
$user = new Users;
//Comprobamos que las cookies están habilitadas
setcookie("test_cookie", "test", time() + 3600, '/');
if(count($_COOKIE) == 0) {
    die('error:Parece que las cookies no están habilitadas en el navegador');
} 
else
{
	//setcookie("test_cookie", "", time() - 3600);
}

//Si no se han pasado los datos
if(!isset($_POST['username']) || !isset($_POST['password']))
{
	die('error:No se han pasado los datos del formulario.');
}

//Procedemos a logear
if($user->loginUser($_POST['username'],$_POST['password'], $_POST['remember']))
{
	
	echo "Logeado correctamente. En unos segundos será redirigido.";
	
}
else
{
	echo "error:El usuario y contraseña no son correctos.";
}

?>
