<section id="home">
	<h1>Acceso Usuarios</h1>
	<h2>Subtitulo o Slogan</h2>
	<br>
	<article>
		<?php echo validation_errors(); ?>
		<form action="<?php echo base_url(); ?>login/authenticate" method="POST">
			<div class="form-group">
				<label for="">Usuario</label>
				<input type="text" class="form-control" name="username" placeholder="Ingrese usuario o email">
			</div>
			<div class="form-group">
				<label for="">Contraseña</label>
				<input type="password" class="form-control" name="password" placeholder="Ingrese su contraseña">
			</div>
		<!-- 	<label for="">Ingresar como:</label>
			<br>
			<select name="" id="">
			<option value="fabricante">Fabricante</option>
			<option value="ortopedista">Ortopedista</option>
		</select> -->
			<div class="form-group">
				<button type="submit" class="btn btn-default" >Ingresar</button>
			</div> 
		</form>
		<h3>Registrarse:</h3>
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fugit animi minima ad, saepe possimus numquam. Sunt odio, ratione dolor. Vitae ea omnis modi, fugiat, ducimus a illum minus culpa sed!</p>
		<a href="<?php echo base_url(); ?>home/routedHome/register">Registrar</a>

	</article>
</section>