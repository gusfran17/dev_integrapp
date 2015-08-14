<section id="home">
	
	<div class="container">

		<form class="region size1of2" action="<?php echo base_url(); ?>profile/save_email" method="post">

			<div class="form-group">

			  <h3 class="info-level-3">Cambiar Email</h3>

			</div>
			
			<div class="form-group">
				<label for="email" class="control-label">Email Actual</label>
				<input class="form-control" id="email" name="email" type="email" placeHolder="<?php if (isset($email)) echo set_value('email', $email); else echo set_value('email'); ?>" disabled>
			</div>

			<div class="form-group">

			  <label class="control-label" for="email">Nueva Dirección de Email</label>

			  <?php echo form_error('email', '<span class="label label-danger">', '</span>'); ?>

			  <input class="form-control" id="email" name="email" type="email" placeHolder="Ingrese la nueva dirección de email">

			</div>

			<div class="form-group">

			  <label class="control-label" for="password">Por favor ingrese su contraseña actual para realizar el cambio</label>

			  <?php echo form_error('password', '<span class="label label-danger">', '</span>'); ?>

			  <input class="form-control" id="password" name="password" type="password" placeHolder="Contraseña">

			</div>

			<div class="form-group">


			<div class="form-group">

				<input type="submit" value="Guardar Email" class="btn btn-info">

			</div>

		</form>

	</div>

</section>