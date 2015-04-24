<section id="home">
	<div class="container">
		<form class="region size1of2" action="<?php echo base_url(); ?>profile/save_password" method="post">
			<div class="form-group">
			  <h3 class="info-level-3">Cambiar contraseña</h3>
			</div>
			<div class="form-group">
			  <label class="control-label" for="password">Contraseña actual</label>
			  <?php echo form_error('password', '<span class="label label-danger">', '</span>'); ?>
			  <input class="form-control" id="password" name="password" type="password" placeHolder="Contraseña">
			</div>
			<div class="form-group">
			  <label class="control-label" for="new_password">Nueva contraseña</label>
			  <?php echo form_error('new_password', '<span class="label label-danger">', '</span>'); ?>
			  <input class="form-control" id="new_password" name="new_password" type="password" placeHolder="Contraseña">
			</div>
			<div class="form-group">
			  <label class="control-label" for="new_repassword">Nueva contraseña (otra vez)</label>
			  <?php echo form_error('new_repassword', '<span class="label label-danger">', '</span>'); ?>
			  <input class="form-control" id="new_repassword" name="new_repassword" type="password" placeHolder="Contraseña">
			</div>
			<div class="form-group">
				<input type="submit" value="Cambiar contraseña" class="btn btn-info">
			</div>
		</form>
	</div>
</section>