<section id="home">
	
	<form class="region size1of2" action="<?php echo base_url(); ?>profile/save" method="post" id="frm-login">
		<div class="container">
			<h1>MI CUENTA</h1>
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">

				<div class="form-group">
					<label class="control-label" for="name">Nombre</label>
					<?php echo form_error('name', '<span class="label label-danger">', '</span>'); ?>
					<input class="form-control" id="name" name="name" type="text" placeHolder="Nombre" style="float:left;" value="<?php if (isset($user)) echo set_value('name', $user->name); else echo set_value('name');?>"> 
				</div>

				<div class="form-group">
					<label class="control-label" for="lastname">Apellido</label>
					<?php echo form_error('lastname', '<span class="label label-danger">', '</span>'); ?>
					<input class="form-control" id="lastname" name="lastname" type="text" placeHolder="Apellido" style="float:left;" value="<?php if (isset($user)) echo set_value('lastname', $user->lastname); else echo set_value('lastname'); ?>"> 
				</div>
			</br>
				<div class="form-group">
					<input type="submit" value="Guardar" class="btn btn-info">
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
				<div class="region size1of2" >
					<div class="form-group ">
						<h4>Otras acciones</h4>
						<ul>
							<li><a href="/perfil/cambiar_contrasena">Cambiar la contraseña</a></li>
							<li><a href="/perfil/cambiar_email">Cambiar email de registro</a></li>
							<li><a href="/perfil/cambiar_logo">Editar el logo de mi empresa</a></li>
						</ul>
					</div>
				</div>				
			</div>
		</div>

	</form>	
</section>