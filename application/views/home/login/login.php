<div id="page-wrapper">
	<article>
		<div class="container-fluid">
			<div class="row" id="login-form">
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
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
					<?php if($this->session->flashdata('register_user')!= null):?>
					    <div class="alert alert-dismissable alert-success">
					      <button type="button" class="close" data-dismiss="alert"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span></button>
					      <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
					      <strong>Atención!</strong> <?php echo $this->session->flashdata('register_user'); ?></a>
					    </div>
					<?php endif;?>
					<div style="margin-top:0% !important" class="well bs-component">
						<form action="<?php echo base_url(); ?>login/authenticate" method="POST">
							<fieldset>
								<legend><h2>Ingresar a mi cuenta</h2></legend>							
								<div class="form-group" style="padding-bottom:40px;">
									<label class="col-lg-3 col-md-4 col-sm-6 col-xs-12" for="username">Usuario</label>
									<?php echo form_error('username', '<span class="label label-danger">', '</span>'); ?>
									<?php echo form_error('password', '<span class="label label-danger">', '</span>'); ?>
									<div class="col-lg-9 col-md-8 col-sm-6 col-xs-12">
										<input type="text" class="form-control" name="username" placeholder="Ingrese usuario o email" style="position:relative">
									</div>
								</div>
								<div class="form-group" style="padding-bottom:40px;">
									<label class="col-lg-3 col-md-4 col-sm-6 col-xs-12" for="password">Contraseña</label>
									<div class="col-lg-9 col-md-8 col-sm-6 col-xs-12">
										<input type="password" class="form-control" name="password" placeholder="Ingrese su contraseña" style="position:relative">
									</div>
								</div>
								<div class="form-group">
									<div class="col-lg-10 col-md-10 col-sm-10 col-xs-10 col-lg-offset-3 col-md-offset-4 col-sm-offset-6 col-xs-offset-0">
										<button type="submit" class="btn btn-default" >Ingresar</button>
										<a href="<?php echo base_url(); ?>login/forgotPassword"><br><br>
										<b>Olvide mi contraseña</b></a>
									</div>
								</div>
							</fieldset> 
						</form>
					</div>
				</div> 
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
					<h3>Registrarse:</h3>
					<p>Si aun no es usuario usted puede <a href="<?php echo base_url(); ?>register"><button class="btn btn-primary" >Registrarse</button></a></p>
				</div>
			</div> 
		</div> 
		
	</article>
</div>