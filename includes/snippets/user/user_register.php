
<?php


if(isset($_POST['r-username']) && isset($_POST['r-password']))
{
	//Datos del usuario para insertarlos en la tabla temporal
	$token = md5(uniqid(rand(), true));
	$data = Array ("username" => $_POST['r-username'],
				   "name" => $_POST['r-name'],
				   "email" => $_POST['r-email'],
				   "password" => md5($_POST['r-password']),
				   "birth" => $_POST['r-birth'],
				   "token" => $token,
				   "expire" => time() + 86400
	);
	
	try {
		$user->userInsertTemp($data);
		$result_title = 'USUARIO REGISTRADO';
		$result_text = 'Se ha enviado un correo.';
		$result_subtext = 'Siga las instrucciones.';

	}
	catch(Exception $e) {
		$error_code = $e->getMessage();
		$result = $user->getErrorCode($error_code);
		$result_title = 'ERROR';
		$result_text = $result['title'];
		$result_subtext = $result['text'];
	}
	
}	
else
{
	$result_title = 'ERROR';
	$result_text = 'No se han recibido datos de registro.';
	$result_subtext = 'Quizás está accediendo a esta página sin rellenar antes el <a href="user.php?action=register">formulario de registro</a>';
}

?>
	<div class="row mt-4">
		<div class="col-md-12">
			<div class="jumbotron">
			  <h1 class="display-6"><?= $result_title ?></h1>
			  <p class="lead"><?= $result_text ?></p>
			  <hr class="my-4">
			  <p><?= $result_subtext ?></p>
			  <p class="lead">
				<a class="btn btn-primary btn-lg" href="<?= c::get('site.url') ?>" role="button">Volver al inicio</a>
			  </p>
			</div>
		</div>
	</div>