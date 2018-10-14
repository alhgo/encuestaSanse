
<?php if(!$user->logged) 
{
	url::go('user.php?action=loginUser');
	die();
}

//Obtenemos los datos del usuario
$user_data = $user->user_data;
//print_r($user_data);

//Si se ha mandado el formulario para actualizar los datos del usuario
if(isset($_POST['update_user_data']))
{
	//print_r($_POST);
	//Actualizamos los datos
	
	$data = Array ('birth' => $_POST['user-birth']);
	if(trim($_POST['user-name']) != '') $data['name'] = $_POST['user-name'];
	if(trim($_POST['user-email']) != '') $data['email'] = $_POST['user-email'];
	if(trim($_POST['user-pass']) != '' && md5($_POST['user-pass']) != $_POST['user-currentPass']) $data['password'] = md5($_POST['user-pass']);
	
	print_r($data);
	//Si el correo es distinto, lo activamos
	$mail = ($_POST['user-email'] != $_POST['user-currentEmail']) ? true : false;
	
	if($user->updateUserData($_POST['user-id'],$data,$mail))
	{
		url::go('user.php?msg=success&txt=Se han actualizado los datos de usuario.');
	}
	else
	{
		url::go('user.php?msg=error&txt=Se ha producido un error al actualizar los datos de usuario.');
	}
	
}


?>

<div class="row justify-content-md-center">
    
    <div class="col-md-6">
		<?php if(isset($_GET['msg']) && isset($_GET['txt'])) : ?>
		<div class="alert alert-<?= $_GET['msg'] ?> alert-dismissible fade show" role="alert">
		  <?= $_GET['txt'] ?>
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		  </button>
		</div>
		<?php endif ?>
    	<div class="row justify-content-between">
			<div class="col-md-8 col-xs-12">
				<h1 class="display-4">Mis datos</h1>	
				<h4>Nombre de usuario: <?php echo $user_data['username'] ?></h4>	
			</div>
			<div class="col-md-2 col-xs-12 text-right">
				<label class="switch">
				  <input type="checkbox" id="user-edit">
				  <span class="slider round"></span>
				</label>
			</div>
		</div>
		
		<form method="post" action="user.php">
		  <div class="form-group row">
			<label for="user-email" class="col-sm-4 col-form-label"><strong>Correo</strong></label>
			<div class="col-sm-8">
			  <input type="email" class="form-control-plaintext" id="user-email" name="user-email" value="<?php echo $user_data['email'] ?>">
			</div>
		  </div>
		  <div class="form-group row">
			<label for="user-name" class="col-sm-4 col-form-label"><strong>Nombre</strong></label>
			<div class="col-sm-8">
			  <input type="text" class="form-control-plaintext" id="user-name" name="user-name" value="<?php echo $user_data['name'] ?>">
			</div>
		  </div>
		  <div class="form-group row">
			<label for="user-birth" class="col-sm-4 col-form-label"><strong>Año de nacimiento</strong></label>
			<div class="col-sm-8">
			  	
			  	<select class="form-control" disabled id="user-birth" name="user-birth">
					<?php for($n=date('Y');$n>=1900;$n--) : ?>
					  <option value="<?= $n ?>" <?php echo ($n == $user_data['birth']) ? 'selected' : '' ?>>Año <?= $n ?></option>
					<?php endfor ?> 
				</select>	  
			</div>
		  </div>	
		  <div class="form-group row">
			<label for="user-pass" class="col-sm-4 col-form-label"><strong>Contraseña</strong></label>
			<div class="col-sm-8">
			  <input type="password" class="form-control-plaintext" id="user-pass" name="user-pass" value="123456">
				<small id="passwordHelpInline" class="text-muted" style="display: none">
				  Dejar en blanco si no se desea cambiar.
				</small>
			</div>
		  </div>
		  <div class="form-group row text-center">
		  	<input type="hidden" name="user-id" id="user-id" value="<?php echo $user_data['id_user'] ?>">
		  	<input type="hidden" name="user-currentPass" value="<?php echo $user_data['password'] ?>">
		  	<input type="hidden" name="user-currentEmail" value="<?php echo $user_data['email'] ?>">
			<button type="submit" class="btn btn-primary btn-md" id="user-button" name="update_user_data" disabled>Actualizar</button>
		  </div>
		</form>
		<hr>
		
	
	
	</div>
    
  </div>


