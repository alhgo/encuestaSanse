<?php

$user = new Users;

?>
			<h2 class="text-center">Formulario de contacto</h2>
			<div class="row justify-content-center">
				<div class="col-12 col-md-8 col-lg-6 pb-5">
                    <!--Contact Form-->
					<form action="" method="post">
                        <div class="card border-primary rounded-0">
                            <div class="card-header p-0">
                                <div class="bg-info text-white text-center py-2">
                                    <h6><i class="fa fa-envelope"></i> Si tienes alguna consulta escríbenos</h6>
                                    
                                </div>
                            </div>
                            <div class="card-body p-3">

                                <!--Body-->
                                <?php if(!$user->logged) : ?>
								<div class="form-group">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-user text-info"></i></div>
                                        </div>
                                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre y Apellido" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-envelope text-info"></i></div>
                                        </div>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="tu correo electrónico" required>
                                    </div>
                                </div>
								<?php else : ?>
								
								
								<?php endif ?>
                                <div class="form-group">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-comment text-info"></i></div>
                                        </div>
                                        <textarea class="form-control" placeholder="Tu consulta" name="consulta" required></textarea>
                                    </div>
                                </div>
								
								<?php if(c::get('captcha.site') != '' && c::get('captcha.secret') != '') : ?>
								<div class="form-group">
									<div class="g-recaptcha" data-sitekey="<?= c::get('captcha.site') ?>" data-callback="recaptcha_callback"></div>
								</div>
								<?php endif ?>
								
                                <div class="text-center">
									
                                    <input type="submit" value="Enviar" type="submit" class="btn btn-info btn-block rounded-0 py-2 cursor_none" id="contact-button" disabled>
                                </div>
                            </div>

                        </div>
                    </form>
                    <!--Form with header-->
				</div>
			</div>

