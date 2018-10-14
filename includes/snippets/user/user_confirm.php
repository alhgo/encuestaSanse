
<?php
//Iniciamos Firebase
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

$serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/includes/' . c::get('fb.jsonFile'));

if(isset($_GET['id']) && isset($_GET['token']))
{
	try {
		$id_user = $user->userConfirmTemp($_GET['id'],$_GET['token']);
		//Insertamos el usuario en FIREBASE
		$firebase = (new Factory)
			->withServiceAccount($serviceAccount)
			->withDatabaseUri(c::get('fb.url'))
			->create();

		$database = $firebase->getDatabase();
		$newPost = $database
			->getReference('users')
			->push([
				'id' => $id_user,
				'confirmed' => time()
			]);
		//Obtenemos la clave FB
		$fb_key = $newPost->getKey();
		//Lo insertamos en la base de datos
		$user->userInsertFBtoken($id_user,$fb_key);
		
		//Enviamos el aviso
		$result_title = 'USUARIO REGISTRADO';
		$result_text = 'El proceso de registro ha terminado correctamente.';
		$result_subtext = 'Acceda a cualquier página del sitio para comenzar a usarla como usuario registrado.';
		

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
	$result_text = 'No se han recibido datos de confirmación.';
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