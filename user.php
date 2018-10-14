<?php

require_once('includes/toolkit.php');

//Obtenemos los datos del sitio y del usuario
$user = new Users;
$site = new Site;

//User Action
$action = (isset($_GET['action'])) ? $_GET['action'] : '';

//Obtenemos los datos del usuario
$user = new users;

//Breadcrumb array
switch($action) {
	case 'register':
	case 'registerUser':
	case 'confirmUser':
		$bc_array = ['Inicio' => 'index.php', 'Usuarios' => 'user.php', 'Registro' => ''];
		break;
	case 'loginUser':
		$bc_array = ['Inicio' => 'index.php', 'Usuarios' => 'user.php', 'Login' => ''];
		break;
	case 'rememberPass':
		$bc_array = ['Inicio' => 'index.php', 'Usuarios' => 'user.php', 'Recordar Contraseña' => ''];
		break;
	default:
		$bc_array = ['Inicio' => 'index.php', 'Usuario' => 'user.php'];
	
}

?>

<?php snippet('header.php', ['site' => $site]); ?>

<body>
	<!-- Page Content -->
    
<?php snippet('nav.php',['menu' => array('Menú 1' => 'menu1.html', 'Menú 2' => 'menu2.html'), 'site' => $site, 'user' => $user]); ?>
	<div class="container-fluid p-0 m-0">
		<?php snippet('breadcrumb.php',array('data' => $bc_array)); ?>
	</div>
	<div class="container">
<?php 

	if($action == 'register')
	{
		snippet('user_register_form.php');
	}
	else if($action == 'registerUser')
	{
		snippet('user_register.php', array('user'=>$user));
	}
	else if($action == 'confirmUser')
	{
		snippet('user_confirm.php', array('user'=>$user));
	}
	else if($action == 'loginUser')
	{
		snippet('login_form.php', array('user'=>$user));
	}
	else if($action == 'rememberPass')
	{
		snippet('user_remember.php');
	}
	else
	{
		snippet('user_data.php', array('user' => $user));
	}

 ?>
	</div>

<?php if(!$user->logged && $action != 'loginUser') snippet('login_form_modal.php'); ?>

<?php snippet('footer.php', ['libs' => array('forms.js')]); ?>
	
</body>
</html>