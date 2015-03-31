<section id="home">
	<h1>Registrarse</h1>
	<article class="registro">

<?php echo validation_errors(); ?>

		<form action="<?php echo base_url(); ?>register/register" method="POST">
			<label for="">Nombre de Usuario</label>
			<input type="text" name="username" placeholder="Ingrese su usuario">
			<br>
			<label for="">Nombre</label>
			<input type="text" name="name" placeholder="Ingrese su Nombre">
			<br>
			<label for="">Apellido</label>
			<input type="text" name="lastname" placeholder="Ingrese su Apellido">
			<br>
			<label for="">Email</label>
			<input type="mail" name="email" placeholder="Ingrese su E-Mail">
			<br>
			<label for="">Contraseña</label>
			<input type="password" name="password" placeholder="Ingrese su Contraseña">
			<br>
			<label for="">Confirmar Contraseña</label>
			<input type="password" name="repassword" placeholder="Repita su Contraseña">
			<br>
			<label for="">Seleccione Rol</label>
			<select name="role" id="role">
				<option value="user">Usuario</option>
				<option value="distributor">Ortopedista</option>
				<option value="supplier">Proveedor</option>
			</select>
			<br>
			<input type="checkbox" name="terms">Acepto los terminos y condiciones de integrapp
			<br>
			<input type="checkbox" name="newsletter">Envíenme informacion de ofertas y capacitaciones por mail
			<br>  
			<input type="submit">
		</form>
	</article>
</section>


  