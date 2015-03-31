<section id="home">
	<h1>Ingresar a mi cuenta</h1>
	<article>
		<?php echo validation_errors(); ?>
		<h3>Login:</h3>
		<br>
		<form action="<?php echo base_url(); ?>login/authenticate" method="POST">
			<label for="">Usuario</label>
			<input type="text" name="username" placeholder="Ingrese usuario o email">
			<br>
			<label for="">Contraseña</label>
			<input type="password" name="password" placeholder="Ingrese su contraseña">
			<br>
			<input type="submit">
		</form>
		<br>
		<p>Si aun no es usuario usted puede <a href="<?php echo base_url(); ?>home/routedHome/register">Registrarse</a></p>
		<a href="<?php echo base_url(); ?>home/routedHome/register">Olvide mi contraseña</a>

	</article>
</section>