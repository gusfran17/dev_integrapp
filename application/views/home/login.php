<div id="page-wrapper">
	<h1>Ingresar a mi cuenta</h1>
	<article>
		<div class="container-fluid">
			<div class="row" id="login-form">
				<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
					<?php if($this->session->flashdata('success')!= null):?>
					    <div class="alert alert-dismissable alert-success">
					      <button type="button" class="close" data-dismiss="alert"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
					      <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
					      <strong>Bien!</strong> <?php echo $this->session->flashdata('success'); ?></a>
					    </div>
					<?php endif;?>
					<?php if($this->session->flashdata('error')!= null):?>
					    <div class="alert alert-dismissable alert-danger">
					      <button type="button" class="close" data-dismiss="alert"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
					      <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
					      <strong>Atención!</strong> <?php echo $this->session->flashdata('error'); ?></a>
					    </div>
					<?php endif;?>
					<form action="<?php echo base_url(); ?>login/authenticate" method="POST">
						<?php if($this->session->flashdata('register_user')!= null):?>
						    <div class="alert alert-dismissable alert-success">
						      <button type="button" class="close" data-dismiss="alert"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
						      <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
						      <strong>Atención!</strong> <?php echo $this->session->flashdata('register_user'); ?></a>
						    </div>
						<?php endif;?>
					
						<div class="form-group">
							<label for="username">Usuario</label>
							<?php echo form_error('username', '<span class="label label-danger">', '</span>'); ?>
							<?php echo form_error('password', '<span class="label label-danger">', '</span>'); ?>
							<input type="text" class="form-control" name="username" placeholder="Ingrese usuario o email" style="position:relative">
						</div>
						<div class="form-group">
							<label for="password">Contraseña</label>
							<input type="password" class="form-control" name="password" placeholder="Ingrese su contraseña" style="position:relative">
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-default" >Ingresar</button>
						</div> 
					</form>
				</div> 
				<div class="col-lg-7 col-md-7 col-sm-12 col-xs-12" >
					<h3>Registrarse:</h3>
					<p>Si aun no es usuario usted puede <a href="<?php echo base_url(); ?>home/routedHome/register">Registrarse</a></p>
					<a href="<?php echo base_url(); ?>home/routedHome/register">Olvide mi contraseña</a>
				</div>
			</div> 
		</div> 
		
	</article>
</div>