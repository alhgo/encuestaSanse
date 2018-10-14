

  <div class="row">
	<div class="col-lg-12">
	  <h1 class="mt-1">Registrar usuario</h1>
	  <p class="lead">Completa el siguiente formulario para registrarte como usuario.</p>
	</div>
  </div>
   <hr>
    <div class="row">
        <div class="col-lg-12">
			<form action="user.php?action=registerUser" method="post" id="registerForm" class="form">
			  <div class="form-row">
				<div class="form-group col-md-6">
				  <label class="form-label label-badge" for="r-username">Nombre de usuario (no podrá cambiarse)</label>
				  <div class="input-group mb-2">
					<div class="input-group-prepend">
					  <div class="input-group-text"><span class="badge badge-pill " id="badge-username"><i class="fa" id="i-username"></i></span></div>
					</div>
					<input type="text" class="form-control " name="r-username" id="r-username" >
					
				  </div>
				  <div class="invalid-feedback" id="fb-username"></div>
				</div>
			  </div>
			  
			  <div class="form-row">

			  	<div class="form-group col-md-6">
				  <label for="r-name"  class="form-label">Nombre completo</label>
				  <input type="text" class="form-control" id="r-name" name="r-name"  maxlength="150">
				  <div class="invalid-feedback" id="fb-name"></div>
				</div>
				<div class="form-group col-md-6">
				  <label class="form-label label-badge" for="r-email">Correo electrónico</label>
				  <div class="input-group mb-2">
					<div class="input-group-prepend">
					  <div class="input-group-text"><span class="badge badge-pill " id="badge-email"><i class="fa" id="i-email"></i></span></div>
					</div>
					<input type="text" class="form-control " name="r-email" id="r-email" maxlength="150">
				  </div>
				  <div class="invalid-feedback" id="fb-email"></div>
				</div>
			  </div>
			  
			  
			  
			  <div class="form-row">
				<div class="form-group col-md-4">
				  <label class="form-label" for="r-password">Contraseña</label>
				  <input type="password" class="form-control" name="r-password" id="r-password" maxlength="150">
				  <div class="invalid-feedback" id="fb-password"></div>
				</div>
				<div class="form-group col-md-4">
				  <label class="form-label" for="r-password2">Repite la contraseña</label>
				  <input type="password" class="form-control" name="r-password2" id="r-password2">
				  <div class="invalid-feedback" id="fb-password2"></div>
				</div>
				<div class="form-group col-md-4">
				  <select id="r-birth" name="r-birth" class="form-control">
					<option value="" selected>Año de nacimiento</option>
					<?php for($n=date('Y');$n>=1900;$n--) : ?>
					  <option value="<?= $n ?>">Año <?= $n ?></option>
					<?php endfor ?>
				  </select>
				  <div class="invalid-feedback" id="fb-birth"></div>
				</div>
			  </div>
			  <div class="form-group">
				<div class="form-check">
				  <input class="form-check-input" type="checkbox" id="r-legalCheck">
				  <label class="form-check-label" for="legalCheck">
					Acepto las <a href="#" data-toggle="modal" data-target="#legalModal">condiciones de uso del sitio</a>.
				  </label>
				  <div class="invalid-feedback" id="fb-legalCheck"></div>
				</div>
			  </div>
			  <input type="hidden" id="validate-username" value="0">
			  <input type="hidden" id="validate-email" value="0">
			  <input type="hidden" id="action" value="register">
			  
			  <span class="btn btn-primary" id="register-button">Registrarse</span>
			</form>
		</div>
	</div>
	