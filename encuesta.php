<?php

require_once('includes/toolkit.php');

//Obtenemos los datos del sitio y del usuario
$encuesta = new Encuesta;
$site = new Site;
$user = new Users;

//Datos
$action = (isset($_GET['action']) ? $_GET['action'] : '');
$id_user = (isset($_GET['u']) ? $_GET['u'] : '');
$token = (isset($_GET['t']) ? $_GET['t'] : '');

?>

<?php snippet('header.php', ['site' => $site]); ?>

<body>

<?php snippet('nav.php',['menu' => array('Página oficial' => 'http://www.izquierdaindependiente.es', 'Contactar' => 'contactar.php'), 'site' => $site, 'user' => $user]); ?>

	<div class="container-fluid p-0 m-0">
		
		<?php snippet('breadcrumb.php',array('data' => ['Inicio' => 'index.php', 'Encuesta' => ''])); ?>
	</div>
	<div class="container mt-3">
		<h1>Encuesta</h1>
		<hr>
		<?php
		//Si se ha mandado la encuesta, la registramos
		if($action == 'entregar')
		{
			try {
				$rellenadas = $encuesta->rellenarEncuesta($_POST);
				echo '<div class="alert alert-success" role="alert">
  <strong>¡Gracias!.</strong> La encuesta se ha registrado correctamente.</div>';
				
				echo "<p>Se han inscrito $rellenadas respuestas contestadas</p>";
				
			} catch (Exception $e) {
				
				echo '<div class="alert alert-warning" role="alert">
  <strong>Error.</strong> ' . $e->getMessage() . '</div>';
			}
			
			
			echo "<!--";
			print_r($_POST);
			echo "-->";
		
		}
		
		else
		{
			//Si se ha pasado un token incorrecto o si el usuario ya ha rellenado la encuesta
			try {
				
				$encuesta->encuestadoCheck($id_user, $token);
				
				echo $encuesta->mostrarEncuesta($id_user);
				
			} catch (Exception $e) {
				
				echo '<div class="alert alert-warning" role="alert">
  <strong>Error.</strong> ' . $e->getMessage() . '</div>';
			}
		}

		
		?>
	
	</div>
	
<?php snippet('footer.php', ['libs' => array('encuesta.js')]); ?>

</body>
</html>