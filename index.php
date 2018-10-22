<?php

require_once('includes/toolkit.php');

//Obtenemos los datos del sitio y del usuario
$user = new Users;
$site = new Site;

$action = (isset($_GET['action'])) ? $_GET['action'] : '';
?>

<?php snippet('header.php', ['site' => $site]); ?>

<body>

<?php snippet('nav.php',['menu' => array('Página oficial' => 'http://www.izquierdaindependiente.es', 'Contactar' => 'contactar.php'), 'site' => $site, 'user' => $user]); ?>

	<div class="container mt-3">
		
		<?php
		if($action == 'registerUser')
		{
			snippet('encuesta/register.php');
		}
		else
		{
			snippet('encuesta/home.php');
			snippet('encuesta/user_register_form.php');
		}
		
		?>
	

	</div>
	
<?php snippet('encuesta/remember_form_modal.php'); ?>
	
<?php snippet('footer.php', ['libs' => array('encuesta.js')]); ?>

</body>
</html>