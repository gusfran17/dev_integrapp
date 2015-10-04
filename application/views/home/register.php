<div id="page-wrapper">
	<article class="registro">
		<div class="container-fluid">
			<div class="row" id="registration">
				<div class="col-lg-5 col-md-6 col-sm-12 col-xs-12">
					<leyend><h1 style="padding-bottom:30px">Registrarse</h1></leyend>
					<form action="<?php echo base_url(); ?>register/register" method="POST">
						<fieldset>
							<div class="form-group" style="padding-bottom:40px;">
								<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12" for="username">Usuario</label>
								<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
									<?php echo form_error('username', '<span class="label label-danger">', '</span>'); ?>
									<input type="text" id="username" class="form-control" name="username" value="<?php echo set_value('username'); ?>" placeholder="Ingrese su nombre de usuario">
								</div>
							</div>
							<div class="form-group" style="padding-bottom:40px;">
								<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12" for="password">Nombre</label>
								<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
									<?php echo form_error('name', '<span class="label label-danger">', '</span>'); ?>
									<input type="text" id="name" class="form-control" name="name" value="<?php echo set_value('name'); ?>" placeholder="Ingrese su Nombre">
								</div>
							</div>
							<div class="form-group" style="padding-bottom:40px;">
								<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12" for="password">Apellido</label>
								<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
									<?php echo form_error('lastname', '<span class="label label-danger">', '</span>'); ?>
								<input type="text" id="lastname" class="form-control" name="lastname" value="<?php echo set_value('lastname'); ?>" placeholder="Ingrese su Apellido">
								</div>
							</div>
							<div class="form-group" style="padding-bottom:40px;">
								<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12" for="password">Email</label>
								<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
									<?php echo form_error('email', '<span class="label label-danger">', '</span>'); ?>
									<input type="mail" id="email" class="form-control" name="email" value="<?php echo set_value('email'); ?>" placeholder="Ingrese su E-Mail">
								</div>
							</div>
							<div class="form-group" style="padding-bottom:40px;">
								<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12" for="password">Contraseña</label>
								<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
									<?php echo form_error('password', '<span class="label label-danger">', '</span>'); ?>
									<input type="password" id="pswd" class="form-control" name="password" placeholder="Ingrese su Contraseña">
								</div>
							</div>
							<div class="form-group" style="padding-bottom:40px;">
								<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12" for="password">Confirmar Contraseña</label>
								<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
									<?php echo form_error('repassword', '<span class="label label-danger">', '</span>'); ?>
									<input type="password" id="repassword" class="form-control" name="repassword" placeholder="Repita su Contraseña">
								</div>
							</div>
							<div class="form-group" style="padding-bottom:40px;">
								<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12" for="password">Rol</label>
								<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
									<?php echo form_error('role', '<span class="label label-danger">', '</span>'); ?>
									<select name="role" class="form-control" id="role">
										<option value="noselect">Seleccione rol...</option>
										<!-- <option value="user">Usuario</option> -->
										<option value="distributor">Ortopedista</option>
										<option value="supplier">Proveedor</option>
									</select>
								</div>
							</div>
							<div class="form-group" style="padding-bottom:40px;">
								<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12" for="password">Nombre de la Empresa (nombre de fantasia)</label>
								<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
									<?php echo form_error('fake_name', '<span class="label label-danger">', '</span>'); ?>
									<input type="text" id="fake_name" class="form-control" name="fake_name" value="<?php echo set_value('fake_name'); ?>" placeholder="Ingrese el nombre de fantasia de su empresa">
								</div>
							</div>
							<div class="form-group">
								<div class="col-lg-10 col-md-10 col-sm-10 col-xs-10 col-lg-offset-2 col-md-offset-2 col-sm-offset-2 col-xs-offset-2" style="padding-bottom:20px;">
									<input type="checkbox" name="terms"> Acepto los terminos y condiciones de integrapp
									<?php echo form_error('terms', '<span class="label label-danger">', '</span>'); ?>
								</div>
							</div>
							<div class="form-group">
								<div class="col-lg-10 col-md-10 col-sm-10 col-xs-10 col-lg-offset-2 col-md-offset-2 col-sm-offset-2 col-xs-offset-2" style="padding-bottom:20px;">
									<input type="checkbox" name="newsletter"> Envíenme informacion de ofertas y capacitaciones por mail
								</div>
							</div> 
							<div class="form-group">
								<!-- <input type="submit" class="btn btn-default"> -->
								<div class="col-lg-10 col-md-10 col-sm-10 col-xs-10 col-lg-offset-2 col-md-offset-2 col-sm-offset-2 col-xs-offset-2" style="padding-bottom:20px;">
									<button type="submit" class="btn btn-default" >Registrarme</button>
								</div>
							</div> 
						</fieldset>
					</form>
				</div>
				<div class="col-lg-7 col-md-6 col-sm-12 col-xs-12" id="description-user">
					<div>
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
</div>


  