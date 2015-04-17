<section id="home">

	
	<form action="<?php echo base_url(); ?>profile/save" method="post" >
		
		<div class="container">
			<h1>MI CUENTA</h1>
				<div class="panel panel-success">
					<div class="panel-heading">
						<h3 class="panel-title">Datos del perfil</h3>
					</div>
		<!-- 				<div class="panel-body">
						<div class="progress progress-striped active">
							<div class="progress-bar" style="width: <?php echo $user->porcentaje; ?>%"></div>
						</div> Datos completos en un <?php echo $user->porcentaje; ?>%
						</div> -->
				</div>

			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
				<div class="form-group">
					<label class="control-label" for="name">Nombre</label>
					<?php echo form_error('name', '<span class="label label-danger">', '</span>'); ?>
					<input class="form-control" id="name" name="name" type="text" placeHolder="Nombre" style="float:left;" value="<?php echo set_value('name', $user->name); ?>"> 
				</div>

				<div class="form-group">
					<label class="control-label" for="lastname">Apellido</label>
					<?php echo form_error('lastname', '<span class="label label-danger">', '</span>'); ?>
					<input class="form-control" id="lastname" name="lastname" type="text" placeHolder="Apellido" style="float:left;" value="<?php echo set_value('lastname', $user->lastname); ?>"> 
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
				<div class="region size1of2" >
					<div class="form-group ">
						<h4>Opciones de Cuenta</h4>
						<ul>
							<li><a href="/perfil/cambiar_contrasena">Cambiar la contraseña</a></li>
							<li><a href="/perfil/cambiar_email">Cambiar email de registro</a></li>
							<li><a href="/perfil/cambiar_logo">Editar el logo de mi empresa</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="container">
			</br>
			<div class="alert alert-dismissable alert-info">
			  <button type="button" class="close" data-dismiss="alert">×</button>
			  <strong>Atencion!</strong> Debes completar la informacion con presición. Esta información sera compartida unicamente con los ortopedistas que usted autorice.
			</div>
			<div class="form-group">
			  <h3 class="info-level-3">Datos de mi empresa</h3>
			</div>

			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">

			
				<div class="form-group">
				  <label class="control-label" for="fake_name">Nombre de fantasía (Nombre de su empresa)</label>
				  <input class="form-control" id="fake_name" name="fake_name" type="text" placeHolder="Escriba el nombre de fantasía." value="<?php echo set_value('fake_name', $distributor->fake_name); ?>">
				</div>

				<div class="form-group">
				  <label class="control-label" for="razon_social">Razón social</label>
				  <input class="form-control" id="razon_social" name="razon_social" type="text" placeHolder="Escriba aquí una su razón social" value="<?php echo set_value('razon_social', $distributor->razon_social); ?>">
				</div>

				<div class="form-group">
				  <label class="control-label" for="cuit">CUIT</label>
				  <input class="form-control" id="cuit" name="cuit" type="text" placeHolder="cuit" value="<?php echo set_value('cuit', $distributor->cuit); ?>">
				</div>

				<div class="form-group">
				  <label class="control-label" for="fiscal_address">Dirección fiscal</label>
				  <input class="form-control" id="fiscal_address" name="fiscal_address" type="text" placeHolder="Dirección fiscal" value="<?php echo set_value('fiscal_address', $distributor->fiscal_address); ?>">
				</div>
				
				<div class="form-group">
				  <label class="control-label" for="service_description">Descripcion del servicio</label>
				  <textarea class="form-control" id="service_description" name="service_description" placeHolder="Describa su actividad comercial."><?php echo set_value('service_description', $distributor->service_description); ?></textarea>
				</div>
			
			</div>

			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
				<legend>Geo ubicación</legend>
				<div class="form-group">
				  <label class="control-label" for="commercial_address">Dirección comercial</label>
				  <input class="form-control" id="commercial_address" name="commercial_address" type="text" placeHolder="Dirección comercial" value="<?php echo set_value('commercial_address', $distributor->commercial_address); ?>">
				</div>

				<div class="form-group">
					<input type="submit" value="Guardar" class="btn btn-info">
				</div>
			</div>
		
		</div>
	</form>

</section>