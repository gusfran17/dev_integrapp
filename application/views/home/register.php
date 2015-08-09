<section id="home">
	<h1>Registrarse</h1>
	<article class="registro">


	<div class="container-fluid">
		<div class="row" id="registration">
			<div class="col-md-5 col-sm-7">
				<form action="<?php echo base_url(); ?>register/register" method="POST">
					<div class="form-group">
						<label for="username">Nombre de Usuario</label>
						<?php echo form_error('username', '<span class="label label-danger">', '</span>'); ?>
						<input type="text" id="username" class="form-control" name="username" value="<?php echo set_value('username'); ?>" placeholder="Ingrese su usuario">
					</div>
					<div class="form-group">
						<label for="name">Nombre</label>
						<?php echo form_error('name', '<span class="label label-danger">', '</span>'); ?>
						<input type="text" id="name" class="form-control" name="name" value="<?php echo set_value('name'); ?>" placeholder="Ingrese su Nombre">
					</div>
					<div class="form-group">
						<label for="lastname">Apellido</label>
						<?php echo form_error('lastname', '<span class="label label-danger">', '</span>'); ?>
						<input type="text" id="lastname" class="form-control" name="lastname" value="<?php echo set_value('lastname'); ?>" placeholder="Ingrese su Apellido">
					</div>
					<div class="form-group">
						<label for="email">Email</label>
						<?php echo form_error('email', '<span class="label label-danger">', '</span>'); ?>
						<input type="mail" id="email" class="form-control" name="email" value="<?php echo set_value('email'); ?>" placeholder="Ingrese su E-Mail">
					</div>
					<div class="form-group">
						<label for="pswd">Contraseña</label>
						<?php echo form_error('password', '<span class="label label-danger">', '</span>'); ?>
						<input type="password" id="pswd" class="form-control" name="password" placeholder="Ingrese su Contraseña">
					</div>
					<div class="form-group">
						<label for="repswd">Confirmar Contraseña</label>
						<?php echo form_error('repassword', '<span class="label label-danger">', '</span>'); ?>
						<input type="password" id="repswd" class="form-control" name="repassword" placeholder="Repita su Contraseña">
					</div>
					<div class="form-group">
						<label for="role">Seleccione Rol</label>
						<select name="role" class="form-control" id="role">
							<option value="noselect">Seleccione rol...</option>
							<option value="user">Usuario</option>
							<option value="distributor">Ortopedista</option>
							<option value="supplier">Proveedor</option>
						</select>
					</div>
					<div class="form-group">
						<label for="fake_name">Nombre de la Empresa (nombre de fantasia)</label>
						<?php echo form_error('fake_name', '<span class="label label-danger">', '</span>'); ?>
						<input type="text" id="fake_name" class="form-control" name="fake_name" value="<?php echo set_value('fake_name'); ?>" placeholder="Ingrese el nombre de fantasia de su empresa">
					</div>
					<div class="form-group">
						<input type="checkbox" name="terms">Acepto los terminos y condiciones de integrapp
						<?php echo form_error('terms', '<span class="label label-danger">', '</span>'); ?>
					</div>
					<div class="form-group">
						<input type="checkbox" name="newsletter">Envíenme informacion de ofertas y capacitaciones por mail
					</div> 
					<div class="form-group">
						<!-- <input type="submit" class="btn btn-default"> -->
						<button type="submit" class="btn btn-default" >Registrarme</button>
					</div> 
				</form>
			</div>
			<div class="col-md-7 col-sm-5" id="description-user">
				<div>
					<h3>COMO USUARIO PUEDE:</h3>
					<ul>
						<li>Tener un registro de las ultimas compras realizadas</li>
						<li>Acceder a descuentos</li>
					</ul>
					<hr>
					<h3>COMO PROVEEDOR PUEDE:</h3>
					<ul>
						<li>Tener los datos de tus productos y listas de precios actualizadas</li>
						<li>Contactarte directo con los ortopedistas y puntos de venta</li>
						<li>Tener alcance nacional</li>
						<li>Acceder a contactarte con ortopedistas</li>
						<li>Participar de capacitaciones</li>
					</ul>
					<hr>
					<h3>COMO ORTOPEDISTA PUEDE:</h3>
					<ul>
						<li>Tener los datos de tu ortopedia publicada en nuestro sitio</li>
						<li>Crear tu pagina institucional dentro de integrapp</li>
						<li>Ofrecer tus servicios a todos los usuarios de integrapp</li>
						<li>Acceder a contactarte con fabricantes</li>
						<li>Participar de capacitaciones
					</ul>
				</div>
			</div>
		</div>
	</div>
	</article>
</section>


  