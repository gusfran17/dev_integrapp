<section id="home">

	
	<form action="<?php echo base_url(); ?>profile/save" method="post" >
		
		<div class="container">
			<div style="text-align:center; padding: 5px 5px 5px 5px;">
				<?php if(isset($distributor->logo)){ ?>
					<div class="form-group" style="display: block; margin-left: auto; margin-right: auto;">
							<img src="<?php echo base_url() . $distributor->logo; ?>" />
					</div>
				<?php }else { ?>
					<h2><span class="label label-primary"><b>MI CUENTA</b></span></h2>
				<?php } ?>
			</div>

			<?php if(isset($success)):?>
				<div class="alert alert-dismissable alert-success">
			      <button type="button" class="close" data-dismiss="alert">×</button>
			      <strong><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span></strong>
			      <strong>¡Bien!</strong> <?php echo $success; ?></a>
			    </div>
			<?php endif;?>
			<?php if(isset($error)):?>
				<div class="alert alert-dismissable alert-danger">
			      <button type="button" class="close" data-dismiss="alert">×</button>
			      <strong><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span></strong>
			      <strong>¡ERROR!</strong> <?php echo $error; ?></a>
			    </div>
			<?php endif;?>


			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title">Datos del perfil</h3>
				</div>
 				<div class="panel-body">
					<div class="progress progress-striped active">
						<div class="progress-bar" style="width: <?php echo $distributor->percentage; ?>%"></div>
					</div> Datos completos en un <?php echo $distributor->percentage; ?>%
					</div> 
			</div>
			<div class="panel panel-info">
				<div class="panel-heading">
					<div class="panel-title" style= "text-align:center;">
						<h4><b>Datos Personales</b></h4>
					</div>
				</div>
				<div class="panel-body">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align:center;">
						<div class="form-group">
							<h5 style="margin-top:20px;"><b>Usuario:</b> <?php if (isset($user)) echo " " . $user->username; ?></h5>
						</div>
						<div class="form-group">
							<h5><b>Email de Usuario:</b> <?php if (isset($user)) echo " " . $user->email; ?></h5>
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
						<div class="form-group">
							<label class="control-label" for="name">Nombre</label>
							<?php echo form_error('name', '<span class="label label-danger">', '</span>'); ?>
							<input class="form-control" id="name" name="name" type="text" placeHolder="Nombre" style="float:left;" value="<?php if (isset($user)) echo set_value('name', $user->name); else echo set_value('name');?>"> 
						</div>

						<div class="form-group">
							<label class="control-label" for="lastname">Apellido</label>
							<?php echo form_error('lastname', '<span class="label label-danger">', '</span>'); ?>
							<input class="form-control" id="lastname" name="lastname" type="text" placeHolder="Apellido" style="float:left;" value="<?php if (isset($user)) echo set_value('lastname', $user->lastname); else echo set_value('lastname');?>"> 
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
						<h4><b>Logo</b></h4>
						<?php if(isset($distributor->logo)): ?>
							<div class="form-group" style="display: block; margin-left: auto; margin-right: auto;">
									<img src="<?php echo base_url() . $distributor->logo; ?>" />
							</div>
						<?php endif;?>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
						<div class="region size1of2" >
							<div class="form-group" style="padding: 10px 10px 10px 10px;">
								<h4><b>Opciones de Cuenta</b></h4>
								<ul>
									<li><a href="<?php echo base_url(); ?>profile/change_password">Cambiar la contraseña</a></li>
									<li><a href="<?php echo base_url(); ?>profile/change_email">Cambiar email de registro</a></li>
									<li><a href="<?php echo base_url(); ?>profile/change_username">Cambiar Nombre de Usuario</a></li>
									<li><a href="<?php echo base_url(); ?>profile/change_logo">Editar el logo de mi empresa</a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="container">
			</br>
			<div class="alert alert-dismissable alert-info">
			  <button type="button" class="close" data-dismiss="alert">×</button>
			  <strong><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span></strong>
			  <strong>¡Atencion!</strong> Debes completar la informacion con presición. Esta información sera compartida unicamente con los ortopedistas que autorices.
			</div>
			<div class="panel panel-info">
				<div class="panel-heading">
					<div class="panel-title" style= "text-align:center;">
						<h4><b>Datos de mi Empresa</b></h4>
						<?php if(isset($distributor->logo)): ?>
							<div class="form-group" style="display: block; margin-left: auto; margin-right: auto;">
								<img src="<?php echo base_url() . $distributor->logo; ?>" />
							</div>
						<?php endif;?>
					</div>
				</div>
				<div class="panel-body">
					<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">				
						<div class="form-group">
						  <label class="control-label" for="fake_name">Nombre de fantasía (Nombre de su empresa)</label>
						  <input class="form-control" id="fake_name" name="fake_name" type="text" placeHolder="Escriba el nombre de fantasía." value="<?php if (isset($distributor)) echo set_value('fake_name', $distributor->fake_name); else echo set_value('fake_name'); ?>">
						</div>

						<div class="form-group">
						  <label class="control-label" for="razon_social">Razón social</label>
						  <input class="form-control" id="razon_social" name="razon_social" type="text" placeHolder="Escriba aquí una su razón social" value="<?php if (isset($distributor)) echo set_value('razon_social', $distributor->razon_social); else echo set_value('razon_social'); ?>">
						</div>

						<div class="form-group">
						  <label class="control-label" for="cuit">CUIT</label>
						  <input class="form-control" id="cuit" name="cuit" type="text" placeHolder="cuit" value="<?php if (isset($distributor)) echo set_value('cuit', $distributor->cuit); else echo set_value('cuit'); ?>">
						</div>

						<div class="form-group">
						  <label class="control-label" for="fiscal_address">Dirección fiscal</label>
						  <input class="form-control" id="fiscal_address" name="fiscal_address" type="text" placeHolder="Dirección fiscal" value="<?php if (isset($distributor)) echo set_value('fiscal_address', $distributor->fiscal_address); else echo set_value('fiscal_address'); ?>">
						</div>
						
						<div class="form-group">
						  <label class="control-label" for="service_description">Descripcion del servicio</label>
						  <textarea class="form-control" id="service_description" name="service_description" placeHolder="Describa su actividad comercial."><?php if (isset($distributor)) echo set_value('service_description', $distributor->service_description); else echo set_value('service_description'); ?></textarea>
						</div>
					
					</div>

					<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">

						<div class="form-group">
						  <label class="control-label" for="comercial_email">Email Comercial</label>
						  <?php echo form_error('comercial_email', '<span class="label label-danger">', '</span>'); ?>
						  <input class="form-control" id="comercial_email" name="comercial_email" type="text" placeHolder="Dirección comercial" value="<?php if (isset($distributor)) echo set_value('comercial_email', $distributor->comercial_email); else echo set_value('comercial_email');?>">
						</div>				

						<legend>Geo ubicación</legend>

						<div class="form-group">
						  <label class="control-label" for="commercial_address">Dirección comercial</label>
						  <input class="form-control" id="commercial_address" name="commercial_address" type="text" placeHolder="Dirección comercial" value="<?php if (isset($distributor)) echo set_value('commercial_address', $distributor->commercial_address); else echo set_value('commercial_address');?>">
						</div>

						<div class="form-group">
							<input type="submit" value="Guardar" class="btn btn-info">
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>

</section>