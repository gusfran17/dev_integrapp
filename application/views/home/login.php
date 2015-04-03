<section id="home">
	<h1>Ingresar a mi cuenta</h1>
	<article>
		<?php echo validation_errors(); ?>

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
						<div class="form-group">
							<button type="submit" class="btn btn-default" >Ingresar</button>
						</div> 
					</form>
				</div> 
				<div class="col-md-7" >
					<h3>Registrarse:</h3>
					<p>Si aun no es usuario usted puede <a href="<?php echo base_url(); ?>home/routedHome/register">Registrarse</a></p>
					<a href="<?php echo base_url(); ?>home/routedHome/register">Olvide mi contraseña</a>
				</div>
			</div> 
		</div> 
		
	</article>
</section>