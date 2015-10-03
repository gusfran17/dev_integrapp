<div id="page-wrapper">
	<article>
		<div class="container-fluid">
			<div class="row" id="login-form">
				<div class="col-lg-5 col-md-6 col-sm-12 col-xs-12">
					<div class="well bs-component">
						<form action="<?php echo base_url(); ?>login/renewPassword" method="POST">
							<fieldset>
								<legend><h2>Ingrese su nueva contraseña</h2></legend>							
								<div class="form-group" style="padding-bottom:40px;">
									<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12" for="password">Contraseña</label>
									<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
										<?php echo form_error('password', '<span class="label label-danger">', '</span>'); ?>
										<input type="password" id="pswd" class="form-control" name="password" placeholder="Ingrese su Contraseña">
									</div>
								</div>
								<input name="emailToken" value="<?php echo $emailToken;?>" type="hidden" id="emailToken">
								<input name="userid" value="<?php echo $userid;?>" type="hidden" id="userid">
								<div class="form-group" style="padding-bottom:40px;">
									<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12" for="password">Confirmar Contraseña</label>
									<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
										<?php echo form_error('repassword', '<span class="label label-danger">', '</span>'); ?>
										<input type="password" id="repswd" class="form-control" name="repassword" placeholder="Repita su Contraseña">
									</div>
								</div>
								<div class="form-group">
									<div class="col-lg-10 col-md-10 col-sm-10 col-xs-10 col-lg-offset-2 col-md-offset-2 col-sm-offset-2 col-xs-offset-2">
										<button type="submit" class="btn btn-default" >Ingresar</button>
									</div>
								</div>
							</fieldset> 
						</form>
					</div>
				</div>
			</div> 
		</div> 
		
	</article>
</div>