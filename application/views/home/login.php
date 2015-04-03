<section id="home">
	<h1>Ingresar a mi cuenta</h1>
	<article>
		<?php echo validation_errors(); ?>
<<<<<<< HEAD
		<div class="container-fluid">
			<div class="row" id="login-form">
				<div class="col-md-5 col-sm-7 col-xs-12">
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
				</div> 
				<div class="col-md-7" >
					<h3>Registrarse:</h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fugit animi minima ad, saepe possimus numquam. Sunt odio, ratione dolor. Vitae ea omnis modi, fugiat, ducimus a illum minus culpa sed!</p>
					<a href="<?php echo base_url(); ?>home/routedHome/register">Registrar</a>
				</div>
			</div> 
		</div> 
		
=======
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
>>>>>>> 64847266ed9d26046efcc37fd5c6292963184d62

	</article>
</section>