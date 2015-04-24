<section id="home">
	
	<div class="container">

		<form class="region size1of2" action="<?php echo base_url(); ?>profile/save_username" method="post">

			<div class="form-group">

			  <h3 class="info-level-3">Cambiar Email</h3>

			</div>


			<div class="form-group">

			  <label class="control-label" for="username">Nombre de Usuario Actual</label>

			  <?php echo form_error('username', '<span class="label label-danger">', '</span>'); ?>

			  <input class="form-control" id="username" name="username" type="username" placeHolder="<?php if (isset($user)) echo set_value('username', $user); else echo set_value('username'); ?>">

			</div>

			<div class="form-group">

			  <label class="control-label" for="password">Por favor ingrese su contraseña actual para realizar el cambio</label>

			  <?php echo form_error('password', '<span class="label label-danger">', '</span>'); ?>

			  <input class="form-control" id="password" name="password" type="password" placeHolder="Contraseña">

			</div>

			<div class="form-group">


			<div class="form-group">

				<input type="submit" value="Guardar Nombre de Usuario" class="btn btn-info">

			</div>

		</form>

	</div>

</section>