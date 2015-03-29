<section id="home">
	<h1>Acceso Usuarios</h1>
	<h2>Primer sitio de ventas de artefactos ortopedicos que centraliza el mercado</h2>
	<article>
		<?php echo validation_errors(); ?>
		<h3>Login:</h3>
		<form action="<?php echo base_url(); ?>login/authenticate" method="POST">
			<label for="">Usuario</label>
			<input type="text" name="username" placeholder="Ingrese usuario o email">
			<br>
			<label for="">Contraseña</label>
			<input type="password" name="password" placeholder="Ingrese su contraseña">
			<br>
			<input type="submit">
		</form>
		<h3>Registrarse:</h3>
		<p>     Si usted no es usuario usted puede registrarse como Ortopedista o como Proveedor.</p>
		<a href="<?php echo base_url(); ?>home/routedHome/register">     Registrarse</a>

	</article>
</section>