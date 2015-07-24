<section id="home">

	<form class="region size1of2" action="<?php echo base_url(); ?>profile/save" method="post" id="frm-login">
		<div class="container">
			<div style="text-align:center; padding: 5px 5px 5px 5px;">
				<h2><span class="label label-primary"><b>MI CUENTA</b></span></h2>
			</div>
			<?php if(isset($success)):?>
				<div class="alert alert-dismissable alert-success">
			      <button type="button" class="close" data-dismiss="alert">×</button>
			      <strong>Bien!</strong> <?php echo $success; ?></a>
			    </div>
			<?php endif;?>
			<div class="alert alert-dismissable alert-info">
				  <button type="button" class="close" data-dismiss="alert">×</button>
				  <strong>Atencion!</strong> Debes completar la informacion con presición. Esta información sera compartida unicamente con los ortopedistas que usted autorice.
			</div>
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title">Datos del perfil</h3>
				</div>
				<div class="panel-body">
					<div class="progress progress-striped active">
						<div class="progress-bar" style="width: <?php echo $supplier->percentage; ?>%"></div>
					</div> Datos completos en un <?php echo $supplier->percentage; ?>%
				</div> 
			</div>
			<h3 class="info-level-3 col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align:center; padding: 5px 5px 5px 5px;"><span class="label label-default"><b>Datos Personales</span></b></h3>
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

			</div>
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
				<div class="region size1of2" >
					<div class="form-group ">
						<h4>Otras acciones</h4>
						<ul>
							<li><a href="<?php echo base_url(); ?>profile/change_password">Cambiar la contraseña</a></li>
							<li><a href="<?php echo base_url(); ?>profile/change_email">Cambiar email de registro</a></li>
							<li><a href="<?php echo base_url(); ?>profile/change_username">Cambiar Nombre de Usuario</a></li>
							<li><a href="<?php echo base_url(); ?>profile/change_logo">Editar el logo de mi empresa</a></li>
						</ul>
					</div>
				</div>				
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<h3 class="info-level-3" style="text-align:center; padding: 5px 5px 5px 5px;"><span class="label label-default"><b>Datos de mi Empresa </span></b></h3>
			
				<?php if(isset($supplier->logo)): ?>
					<div class="form-group" style="display: block; margin-left: auto; margin-right: auto;">
							<img src="<?php echo base_url() . $supplier->logo; ?>" />
					</div>
				<?php endif;?>
			</div>
			<div class="form-group">
			  <label class="control-label" for="fake_name">Nombre de fantasía (Nombre de su empresa)</label>
			  <input class="form-control" id="fake_name" name="fake_name" type="text" placeHolder="Escriba el nombre de fantasía." value="<?php if (isset($supplier)) echo set_value('fake_name', $supplier->fake_name); else echo set_value('fake_name');?>">
			</div>

			<div class="form-group">
			  <label class="control-label" for="razon_social">Razón social</label>
			  <input class="form-control" id="razon_social" name="razon_social" type="text" placeHolder="Escriba aquí una su razón social" value="<?php if (isset($supplier)) echo set_value('razon_social', $supplier->razon_social); else echo set_value('razon_social'); ?>">
			</div>

			<div class="form-group">
			  <label class="control-label" for="comercial_email">Email comercial</label>
			  <?php echo form_error('comercial_email', '<span class="label label-danger">', '</span>'); ?>
			  <input class="form-control" id="comercial_email" name="comercial_email" type="text" placeHolder="Dirección comercial" value="<?php if (isset($supplier)) echo set_value('commercial_email', $supplier->comercial_email); else echo set_value('comercial_email');?>">
			</div>				


			<div class="form-group">
			  <label class="control-label" for="cuit">CUIT</label>
			  <input class="form-control" id="cuit" name="cuit" type="text" placeHolder="cuit" value="<?php if (isset($supplier)) echo set_value('cuit', $supplier->cuit); else echo set_value('cuit'); ?>">
			</div>

			<div class="form-group">
			  <label class="control-label" for="fiscal_address">Dirección fiscal</label>
			  <input class="form-control" id="fiscal_address" name="fiscal_address" type="text" placeHolder="Dirección fiscal" value="<?php if (isset($supplier)) echo set_value('fiscal_address', $supplier->fiscal_address); else echo set_value('fiscal_address'); ?>">
			</div>
			
			<div class="form-group">
			  <label class="control-label" for="service_description">Descripcion del servicio</label>
			  <textarea class="form-control" id="service_description" name="service_description" placeHolder="Describa su actividad comercial."><?php if (isset($supplier)) echo set_value('service_description', $supplier->service_description); else echo set_value('service_description');?></textarea>
			</div>

			<div class="panel panel-primary">
				<div class="panel-heading">
			    	<h3 class="panel-title">Información bancaria (opcional)</h3>
			  	</div>
			  	<div class="panel-body">

					<div class="form-group">
					  <label class="control-label" for="banck_name">Nombre del banco</label>
					  <input class="form-control" id="bank_name" name="bank_name" type="text" placeHolder="Nombre del banco" value="<?php if (isset($supplier)) echo set_value('bank_name', $supplier->bank_name); else echo set_value('bank_name');?>">
					</div>

					<div class="form-group">
					  <label class="control-label" for="bank_branch">Sucursal</label>
					  <input class="form-control" id="bank_branch" name="bank_branch" type="text" placeHolder="Número de la sucursal" value="<?php if (isset($supplier)) echo set_value('bank_branch', $supplier->bank_branch); else echo set_value('bank_branch'); ?>">
					</div>  	

					<div class="form-group">
					  <label class="control-label" for="bank_account">Nro. de cuenta</label>
					  <textarea class="form-control" id="bank_account" name="bank_account" placeHolder="Nro de cuenta bancaria"><?php if (isset($supplier)) echo set_value('bank_account', $supplier->bank_account); else echo set_value('bank_account'); ?></textarea>
					</div>
				    
				    <div class="form-group">
					  <label class="control-label" for="cbu">CBU</label>
					  <input class="form-control" id="cbu" name="cbu" type="text" placeHolder="Codigo Bancario Unico" value="<?php if (isset($supplier)) echo set_value('cbu', $supplier->cbu); else echo set_value('cbu'); ?>">
					</div>

					<div class="form-group">
					  <label class="control-label" for="bank_account_name">Nombre del titular de la cuenta</label>
					  <input class="form-control" id="bank_account_name" name="bank_account_name" type="text" placeHolder="Nombre del titular de la cuenta" value="<?php if (isset($supplier)) echo set_value('bank_account_name', $supplier->bank_account_name); else echo set_value('bank_account_name');?>">
					</div>

			  	</div>
			</div>

			<div class="form-group">
				<input type="submit" value="Guardar" class="btn btn-info">
			</div>
		</div>

	</form>



</section>