

  <div class="row">
	<div class="col-lg-12">
	  <h2 class="mt-1">Recordar contraeña</h2>
	  <p class="lead">Indica tu nombre de usuario o correo electrónico con el que te hayas registrado para resetear tu contraseña.</p>
	</div>
  </div>
   <hr>
    <div class="row">
        <div class="col-lg-12">
			<form action="user.php?action=rememberPass" method="post" id="rememberForm">
			  	<div class="form-row">
			  		<div class="form-group col-md-12">
						<div class="form-check form-check-inline">
						  <input class="form-check-input" type="radio" name="remember_radio" id="remember_radio1" value="option1" checked>
						  <label class="form-check-label" for="remember_radio1" >Recuperar por nombre de usuario</label>
						</div>
						<div class="form-check form-check-inline">
						  <input class="form-check-input" type="radio" name="remember_radio" id="remember_radio2" value="option2">
						  <label class="form-check-label" for="remember_radio2">Recuperar por correo</label>
						</div>
					</div>
				</div>
			  <div class="form-row" id="username_group">
				<div class="form-group col-md-6">
			  	  <label class="form-label label-badge" for="r-usernamePass">Nombre de usuario</label>
				  <div class="input-group mb-2" >
					<div class="input-group-prepend">
					  <div class="input-group-text"><span class="badge badge-pill " id="badge-usernamePass"><i class="fa" id="i-usernamePass"></i></span></div>
					</div>
					<input type="text" class="form-control " name="r-usernamePass" id="r-usernamePass">
					
				  </div>
				  <div class="invalid-feedback" id="fb-usernamePass">El nombre de usuario no existe</div>
				 </div>
				 
			  </div>
			  <div class="form-row" id="mail_group" style="display: none">  
				  	
				  	<div class="form-group col-md-6">
					  <label class="form-label" for="r-mail">Correo electrónico</label>
					  <input type="text" class="form-control" id="r-mail" name="r-mail" maxlength="150">
					  <div class="invalid-feedback" id="fb-name"></div>
					</div>
				</div>

			  <input type="hidden" id="validate-username" value="0">
			  <input type="hidden" id="action" value="rememberPass">
			  	<div class="alert " role="alert" id="remember-alert" style="display: none">
				 
				</div>
			  <span class="btn btn-primary" id="remember-button">Aceptar</span>
			</form>
		</div>
	</div>
	