<section id="home">
	<h1>Registrarse</h1>
	<h2>Subtitulo o Slogan</h2>
	<article class="registro">

<?php echo validation_errors(); ?>

		<form action="<?php echo base_url(); ?>register/register" method="POST">
			<div class="form-group">
				<label for="">Nombre de Usuario</label>
				<input type="text" class="form-control" name="username" placeholder="Ingrese su usuario">
			</div>
			<div class="form-group">
				<label for="">Nombre</label>
				<input type="text" class="form-control" name="name" placeholder="Ingrese su Nombre">
			</div>
			<div class="form-group">
				<label for="">Apellido</label>
				<input type="text" class="form-control" name="lastname" placeholder="Ingrese su Apellido">
			</div>
			<div class="form-group">
				<label for="">Email</label>
				<input type="mail" class="form-control" name="email" placeholder="Ingrese su E-Mail">
			</div>
			<div class="form-group">
				<label for="">Contraseña</label>
				<input type="password" class="form-control" name="password" placeholder="Ingrese su Contraseña">
			</div>
			<div class="form-group">
				<label for="">Confirmar Contraseña</label>
				<input type="password" class="form-control" name="repassword" placeholder="Repita su Contraseña">
			</div>
			<div class="form-group">
				<label for="">Seleccione Rol</label>
				<select name="role" class="form-control" id="role">
					<option value="user">Usuario</option>
					<option value="distributor">Ortopedista</option>
					<option value="supplier">Proveedor</option>
				</select>
			</div>
			<div class="form-group">
				<input type="checkbox" name="terms">Acepto los terminos y condiciones de integrapp
			</div>
			<div class="form-group">
				<input type="checkbox" name="newsletter">Envíenme informacion de ofertas y capacitaciones por mail
			</div> 
			<div class="form-group">
				<!-- <input type="submit" class="btn btn-default"> -->
				<button type="submit" class="btn btn-default" >Registrarme</button>
			</div> 
		</form>
	</article>
</section>


  