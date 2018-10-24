<?php

require_once('includes/toolkit.php');

//Obtenemos los datos del sitio y del usuario
$encuesta = new Encuesta;
$site = new Site;
$user = new Users;

?>

<?php snippet('header.php', ['site' => $site]); ?>

<body>

<?php snippet('nav.php',['menu' => array('Página oficial' => 'http://www.izquierdaindependiente.es', 'contactar' => 'contact.php'), 'site' => $site, 'user' => $user]); ?>

	<div class="container-fluid p-0 m-0">
		
		<?php snippet('breadcrumb.php',array('data' => ['Inicio' => 'index.php', 'Resultados' => ''])); ?>
	</div>
	<div class="container mt-3">
		
		<h4>Los resultados todavía no están disponibles</h4>
	
	</div>
	
<?php snippet('footer.php', ['libs' => array('encuesta.js')]); ?>

</body>
</html>