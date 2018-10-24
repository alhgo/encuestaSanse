<?php

require_once('includes/toolkit.php');

//Obtenemos los datos del sitio y del usuario
$user = new Users;
$site = new Site;



?>

<?php snippet('header.php', ['site' => $site]); ?>

<body>
	<!-- Page Content -->
    
<?php snippet('nav.php',['menu' => array('Página oficial' => 'http://www.izquierdaindependiente.es', 'Contactar' => 'contactar.php'), 'site' => $site, 'user' => $user]); ?>
	
	<div class="container">
<?php 

		snippet('user/login_form.php', array('user'=>$user));

 ?>
	</div>

<?php if(!$user->logged) snippet('login_form_modal.php'); ?>

<?php snippet('footer.php', ['libs' => array('forms.js')]); ?>
	
</body>
</html>