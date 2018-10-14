<?php

require_once('includes/toolkit.php');

//Obtenemos los datos del sitio y del usuario
$user = new Users;
$site = new Site;

//Si el usuario no es administrador, lo sacamos de la página
if(!$user->logged || !$user->is_admin) {
	url::go('logout.php?error=no_admin');
}


?>

<?php snippet('header.php', ['site' => $site]); ?>

<body>

<?php snippet('nav.php',['menu' => array('Menú 1' => 'menu1.html', 'Menú 2' => 'menu2.html'), 'site' => $site, 'user' => $user]); ?>

	<div class="container-fluid p-0 m-0">
		
		<?php snippet('breadcrumb.php',array('data' => ['Admin' => 'admin.php'])); ?>
	</div>
	<div class="container">
		
		<?php snippet('admin/admin_home.php'); ?>

	</div>
	
<?php snippet('footer.php', ['libs' => array('forms.js')]); ?>

</body>
</html>