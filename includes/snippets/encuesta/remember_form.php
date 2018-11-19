	<!-- Modal Header -->
	<div class="modal-header">
		<h4>Reenviar enlace</h4>
		<button type="button" class="close" data-dismiss="modal">&times;</button>

	</div>
	<!-- Modal body -->
    <div class="modal-body" id="remember-body">
		<div id="remember-content">
			<p>Si ya has dado tus datos para realizar la encuesta, escribe de nuevo tu correo electrónico y volveremos a mandarte el enlace.</p>
			<p>
			<form action="" method="post">
				<div class="form-group has-danger <?php echo (isMobile()) ? 'focused' : '' ?>">
				  <label class="form-label" for="remember_email" id="label_username">Correo</label>
				  <input type="text" class="form-control" id="remember_email" name="remember_email">
				</div>

				<!--Mensaje de error-->
				<div class="invalid-feedback" id="fb-remember_email"></div>

			  </form>
			</p>
			<span class="btn btn-primary" id="remember-button">Aceptar</span>
		</div>
	</div>
	
	<!-- Modal footer -->
      <div class="modal-footer" style="display: block">
       
        <!--<button type="button" class="btn btn-danger" data-dismiss="modal"><Cerrar></Cerrar></button>-->
      </div>