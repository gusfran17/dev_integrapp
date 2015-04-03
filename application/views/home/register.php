<section id="home">
	<h1>Registrarse</h1>
	<article class="registro">

<?php echo validation_errors(); ?>
	<div class="container-fluid">
		<div class="row" id="registration">
			<div class="col-md-5 col-sm-7">
				<form action="<?php echo base_url(); ?>register/register" method="POST">
					<div class="form-group">
						<label for="username">Nombre de Usuario</label>
						<input type="text" id="username" class="form-control" name="username" value="<?php echo set_value('username'); ?>" placeholder="Ingrese su usuario">
					</div>
					<div class="form-group">
						<label for="name">Nombre</label>
						<input type="text" id="name" class="form-control" name="name" value="<?php echo set_value('name'); ?>" placeholder="Ingrese su Nombre">
					</div>
					<div class="form-group">
						<label for="lastname">Apellido</label>
						<input type="text" id="lastname" class="form-control" name="lastname" value="<?php echo set_value('lastname'); ?>" placeholder="Ingrese su Apellido">
					</div>
					<div class="form-group">
						<label for="email">Email</label>
						<input type="mail" id="email" class="form-control" name="email" value="<?php echo set_value('email'); ?>" placeholder="Ingrese su E-Mail">
					</div>
					<div class="form-group">
						<label for="pswd">Contraseña</label>
						<input type="password" id="pswd" class="form-control" name="password" placeholder="Ingrese su Contraseña">
					</div>
					<div class="form-group">
						<label for="repswd">Confirmar Contraseña</label>
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
			</div>
			<div class="col-md-7 col-sm-5" id="description-user">
				<div>
					<h3>USUARIO</h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ex voluptatum nulla incidunt enim assumenda iste voluptatem repudiandae optio aut praesentium quod, in consequuntur, vitae rem facilis expedita. Possimus, culpa, ad.</p>
					<hr>
					<h3>PROVEEDOR</h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Enim cupiditate voluptas amet, illo, voluptate tempora rerum obcaecati maiores, eum dolorem natus. Saepe vitae quasi sed placeat ab dolor ipsa beatae.</p>
					<hr>
					<h3>ORTOPEDISTA</h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Necessitatibus ullam magni totam aspernatur illo perferendis quasi delectus debitis, distinctio animi adipisci eaque laudantium recusandae inventore doloribus accusamus at, dolore asperiores.</p>
				</div>
			</div>
		</div>
	</div>
	</article>
</section>


  