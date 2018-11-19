<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$encuesta = new encuesta;
$zonas = $encuesta->getZonas();

function isMobile() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}
?>
	<h4>Rellena el formulario para poder realizar la encuesta</h4>
    <div class="row">
        <div class="col-lg-12">
			<form action="index.php?action=registerUser" method="post" id="registerForm" class="form">
	  
			  <div class="form-row">

			  	<div class="form-group col-md-6 <?php echo (isMobile()) ? 'focused' : '' ?>">
				  <label for="r-name"  class="form-label">Nombre (opcional)</label>
				  <input type="text" class="form-control" id="r-name" name="r-name"  maxlength="150">
				  <div class="invalid-feedback" id="fb-name"></div>
				</div>
				<div class="form-group col-md-6 <?php echo (isMobile()) ? 'focused' : '' ?>">
				  <label class="form-label label-badge" for="r-email">Correo electrónico</label>
				  <div class="input-group mb-2">
					<div class="input-group-prepend">
					  <div class="input-group-text"><span class="badge badge-pill " id="badge-email"><i class="fa" id="i-email"></i></span></div>
					</div>
					<input type="text" class="form-control " name="r-email" id="r-email" maxlength="150">
					
				  </div>
					<p class="small m-0">No será usado para otro fin distinto al de la validación de la encuesta.</p>
				  <div class="invalid-feedback" id="fb-email"></div>
				</div>
			  </div>
			  
			  <div class="form-row">
				<div class="form-group col-md-4">
				  <select id="r-zone" name="r-zone" class="form-control">
					<option value="" selected>Zona de residencia</option>
					<?php foreach($zonas AS $key => $value) : ?>
					  <option value="<?= $zonas[$key]['id_zona'] ?>"><?= $zonas[$key]['nombre'] ?></option>
					<?php endforeach ?>
				  </select>
				  <div class="invalid-feedback" id="fb-zone"></div>
				</div>
				<div class="form-group col-md-4">
				  <select id="r-birth" name="r-birth" class="form-control">
					<option value="" selected>Edad</option>
					<?php for($n=18;$n<=110;$n++) : ?>
					  <option value="<?= $n ?>"><?= $n ?> años</option>
					<?php endfor ?>
				  </select>
				  <div class="invalid-feedback" id="fb-birth"></div>
				</div>
				
				  <div class="form-group col-md-4 text-center">
					  	<div class="form-check-inline">
						  <label class="form-check-label" for="radio1">
							<input type="radio" class="form-check-input" id="radio1" name="r-sexo" value="H" >Hombre
						  </label>
						</div>
						<div class="form-check-inline">
						  <label class="form-check-label" for="radio2">
							<input type="radio" class="form-check-input" id="radio2" name="r-sexo" value="M">Mujer
						  </label>
						</div>
						<div class="form-check-inline">
						  <label class="form-check-label" for="radio2">
							<input type="radio" class="form-check-input" id="radio3" name="r-sexo" value="O">Otro
						  </label>
						</div>
				  <div class="invalid-feedback pt-2" id="fb-sexo"></div>
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
			  <input type="hidden" id="validate-email" value="0">
			  <input type="hidden" id="registered" name="registered" value="<?= time() ?>">
			  
			  <span class="btn btn-primary" id="register-button">Validar correo</span>
				<p class="small">* Para evitar que una misma persona rellene varias encuestas, deberás validar tu dirección de correo antes de poder rellenarla.</p>
			</form>
		</div>
	</div>
<hr>
<p>¿Ya has solicitado la validación del correo y no has recibido el correo de confirmación? <a href="#" data-toggle="modal" data-target="#rememberModal">Pincha aquí</a></p>




	