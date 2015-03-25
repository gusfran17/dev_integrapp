<section id="home">
	<h1>Acceso Usuarios</h1>
	<h2>Subtitulo o Slogan</h2>
	<br>
	<article>
		<?php echo validation_errors(); ?>

		<h3>Login:</h3>
		<br>
		<br>
		<form action="<?php echo base_url(); ?>login/authenticate" method="POST">
			<label for="">Usuario</label>
			<input type="text" name="username" placeholder="Ingrese usuario o email">
			<br>
			<label for="">Contraseña</label>
			<input type="password" name="password" placeholder="Ingrese su contraseña">
			<br>
			<label for="">Ingresar como:</label>
			<br>
		<!-- 	<select name="" id="">
			<option value="fabricante">Fabricante</option>
			<option value="ortopedista">Ortopedista</option>
		</select> -->
			<input type="submit">
		</form>
		<h3>Registrarse:</h3>
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fugit animi minima ad, saepe possimus numquam. Sunt odio, ratione dolor. Vitae ea omnis modi, fugiat, ducimus a illum minus culpa sed!</p>
		<a href="<?php echo base_url(); ?>home/routedHome/register">Registrar</a>

	</article>
</section>