<div id="page-wrapper">
	<div class="container-fluid">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div style="text-align: center;">
				<h2 style="margin-top: 0px; margin-bottom:20px;"><span class="label label-default lblDistributor" style="color:#ffffff; "><b>Perfil de Oropedia</b></span></h2>
			</div>
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="well well-small pnlDistributor" style="padding-top: 0px; text-align: center;">
						<h2><span class="label label-default lblDistributor" style="color:#ffffff;"><b><?php echo $distributor->fake_name ?></b></span></h2>
						<?php if ($distributor->associationStatus != 'approved'){ ?>
							<p><span class="label label-warning" style="color:#ffffff;"><b><?php echo NOT_ASSOCIATED_MESSAGE; ?></b></span></p>
						<?php } else {?>
							<p><span class="label label-info" style="color:#ffffff;"><b><?php echo ASSOCIATED_MESSAGE; ?></b><span></p>
						<?php }?>
						<?php if(isset($distributor->logo)){ ?>
							<img src="<?php echo base_url() . $distributor->logo; ?>" style="max-width: 100%; margin: 5px 5px 5px 5px; height:120px;">
						<?php } else { ?>
							<img src="<?php echo base_url() . IMAGES_PATH . 'noProfilePic.jpg'; ?>" style="max-width: 100%; margin: 5px 5px 5px 5px; height:120px;">
						<?php } ?>
						<br>
						<?php if ($distributor->razon_social != "") echo "<b>Razón Social: </b>" . $distributor->razon_social . "<br>";?>
						<?php if ($distributor->cuit != "") echo "<b>CUIT:  </b>" . $distributor->cuit . "<br>";?>
						<?php if ($distributor->comercial_email != "") echo "<b>Email:  </b>" . $distributor->comercial_email . "<br>";?>
						<?php if ($distributor->office_phone != "") echo "<b>Teléfono: </b>" . $distributor->office_phone . "<br>";?>
						<?php if ($distributor->fax != "") echo "<b>FAX: </b>" . $distributor->fax . "<br>";?>
					</div>
					<div class="col-md-8 col-sm-6 col-xs-12">
						<div class="panel panel-default">
							<div class="panel-body">
								<?php if ($distributor->commercial_address != "") echo "<h4>Dirección del Comercial</h4>" . $distributor->commercial_address . "<br>";?>
								<?php if ($distributor->service_description != "") echo "<h4>Descripción del Servicio</h4>" . $distributor->service_description . "<br>";?>
							</div>
						</div>					
					</div>
					<div class="col-md-4 col-sm-6 col-xs-12">
						<div class="panel panel-default">
							<div class="panel-body">
								<ul class="nav nav-pills nav-stacked">
								<li><a href="<?php echo base_url() . 'Distributors/viewCatalog/'. $distributor->id;?>"><b><span class="glyphicon glyphicon-list" aria-hidden="true"></span> Ver catálogo</b></a></li>
									<?php if ($watchingRole == 'supplier') {?>
										<?php if ($distributor->associationStatus == 'approved') {?>
											<li><a href="<?php echo base_url() . 'Distributors/setSupplierDistributorStatus/' . $distributor->id . '/rejected';?>"><b><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Bloquear</b></a></li>
										<?php } else {?>
											<li><a href="<?php echo base_url() . 'Distributors/setSupplierDistributorStatus/' . $distributor->id . '/approved';?>"><b><span class="glyphicon glyphicon-share" aria-hidden="true"></span> Aprobar adhesión a productos</b></a></li>
										<?php }?>
											<li><a href="<?php echo base_url(); ?>Distributors/viewDistributors"><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span><b> Ortopedias</b></a></li>
									<?php } else {?>
									<?php }?>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>			
	</div>
</div>