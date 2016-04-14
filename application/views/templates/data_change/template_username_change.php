<div id="page-wrapper">
	<div class="container">
		<div class="panel panel-success">
			<div class="panel-heading">
				<h3 class="panel-title" style="text-align:center">Cambio de nombre de usuario</h3>
			</div>
			<div class="panel-body">
				<form class="region size1of2" action="<?php echo base_url(); ?>profile/save_username" method="post">
					<div class="form-group">
					  <label class="control-label" for="email">Nombre de Usuario Actual:</label> <?php if (isset($user)) echo $user; else echo set_value('username'); ?>
					</div>
					<div class="form-group">
					  <label class="control-label" for="username">Nuevo nombre de usuario</label>
					  <?php echo form_error('username', '<span class="label label-danger">', '</span>'); ?>
					  <input class="form-control" id="username" name="username" type="username" placeHolder="Ingrese su nuevo nombre de usuario">
					</div>
					<div class="form-group">
					  <label class="control-label" for="password">Por favor ingrese su contraseña actual para realizar el cambio</label>
					  <?php echo form_error('password', '<span class="label label-danger">', '</span>'); ?>
					  <input class="form-control" id="password" name="password" type="password" placeHolder="Contraseña">
					</div>
					<div class="form-group">
						<input type="submit" value="Guardar Nombre de Usuario" class="btn btn-info">
					</div>
				</form>
			</div> 
		</div>
	</div>
</div>