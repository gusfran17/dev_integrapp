<div id="page-wrapper">
	<article>
		<div class="container-fluid">
			<div class="row" id="login-form">
				<div class="col-lg-5 col-md-6 col-sm-12 col-xs-12">
					<?php if($this->session->flashdata('success')!= null):?>
					    <div class="alert alert-dismissable alert-success">
					      <button type="button" class="close" data-dismiss="alert"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span></button>
					      <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
					      <strong>Bien!</strong> <?php echo $this->session->flashdata('success'); ?></a>
					    </div>
					<?php endif;?>
					<?php if($this->session->flashdata('error')!= null):?>
					    <div class="alert alert-dismissable alert-danger">
					      <button type="button" class="close" data-dismiss="alert"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span></button>
					      <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
					      <strong>Atención!</strong> <?php echo $this->session->flashdata('error'); ?></a>
					    </div>
					<?php endif;?>
					<div class="well bs-component">
						<form action="<?php echo base_url(); ?>login/sendRenewPasswordEmail" method="POST">
							<fieldset>
								<legend><h2>Ingrese su email o nombre de usuario</h2></legend>							
								<div class="form-group" style="padding-bottom:40px;">
									<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12" for="usernameOrEmail">Usuario/Email</label>
									<?php echo form_error('usernameOrEmail', '<span class="label label-danger">', '</span>'); ?>
									<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
										<input type="text" class="form-control" name="usernameOrEmail" placeholder="Ingrese usuario o email" style="position:relative">
									</div>
								</div>
								<div class="form-group">
									<div class="col-lg-10 col-md-10 col-sm-10 col-xs-10 col-lg-offset-2 col-md-offset-2 col-sm-offset-2 col-xs-offset-2">
										<button type="submit" class="btn btn-default" >Renovar contraseña</button>
									</div>
								</div>
							</fieldset> 
						</form>
					</div>
				</div> 
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
					<h3>Registrarse:</h3>
					<p>Si aun no es usuario usted puede <a href="<?php echo base_url(); ?>register">Registrarse</a></p>
				</div>
			</div> 
		</div> 
		
	</article>
</div>