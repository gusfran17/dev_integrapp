<div id="page-wrapper">
	<div class="container">
		<div class="panel panel-success">
			<div class="panel-heading">
				<h3 class="panel-title" style="text-align:center">Cambio de Email</h3>
			</div>
			<div class="panel-body">
				<form class="region size1of2" action="<?php echo base_url(); ?>profile/save_email" method="post">
					<div class="form-group">
					  <label class="control-label" for="email">Email Actual:</label> <?php if (isset($email)) echo $email; else echo set_value('email'); ?>
					</div>
					<div class="form-group">
					  <label class="control-label" for="email">Ingrese el nuevo Email</label>
					  <?php echo form_error('email', '<span class="label label-danger">', '</span>'); ?>
					  <input class="form-control" id="email" name="email" type="email" placeHolder="Ingrese su nevo email">
					</div>
					<div class="form-group">
					  <label class="control-label" for="password">Por favor ingrese su contraseña actual para realizar el cambio</label>
					  <?php echo form_error('password', '<span class="label label-danger">', '</span>'); ?>
					  <input class="form-control" id="password" name="password" type="password" placeHolder="Contraseña">
					</div>
					<div class="form-group">
						<input type="submit" value="Guardar Email" class="btn btn-info">
					</div>
				</form>
			</div> 
		</div>
	</div>
</div>