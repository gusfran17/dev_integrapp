<div id="page-wrapper">
	<div class="container">
		<div class="panel panel-success">
			<div class="panel-heading">
				<h3 class="panel-title" style="text-align:center">Cambio de Contraseña</h3>
			</div>
			<div class="panel-body">
				<form class="region size1of2" action="<?php echo base_url(); ?>profile/save_password" method="post">
					<div class="form-group">
					  <label class="control-label" for="password">Contraseña actual</label>
					  <?php echo form_error('password', '<span class="label label-danger">', '</span>'); ?>
					  <input class="form-control" id="password" name="password" type="password" placeHolder="Ingrese su contraseña actual">
					</div>
					<div class="form-group">
					  <label class="control-label" for="new_password">Nueva contraseña</label>
					  <?php echo form_error('new_password', '<span class="label label-danger">', '</span>'); ?>
					  <input class="form-control" id="new_password" name="new_password" type="password" placeHolder="Ingrese su nueva contraseña">
					</div>
					<div class="form-group">
					  <label class="control-label" for="new_repassword">Confirmar nueva contraseña</label>
					  <?php echo form_error('new_repassword', '<span class="label label-danger">', '</span>'); ?>
					  <input class="form-control" id="new_repassword" name="new_repassword" type="password" placeHolder="Confirme su nueva contraseña">
					</div>
					<div class="form-group">
						<input type="submit" value="Cambiar contraseña" class="btn btn-info">
					</div>
				</form>
			</div> 
		</div>
	</div>
</div>