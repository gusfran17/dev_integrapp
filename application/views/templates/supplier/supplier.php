<section id="home">
	<div class="container-fluid">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="well well-small" style="padding-top: 0px; text-align: center;">
						<h2><span class="label label-default" style="color:#ffffff;"><b><?php echo $supplier->fake_name ?></b></span></h2>
						<?php if($supplier->associationStatus != 'approved'){ ?>
							<p><span class="label label-warning" style="color:#ffffff;"><b><?php echo NOT_ASSOCIATED_MESSAGE; ?></b></span></p>
						<?php } else {?>
							<p><span class="label label-info" style="color:#ffffff;"><b><?php echo ASSOCIATED_MESSAGE; ?></b><span></p>
						<?php }?>
						<?php if(isset($supplier->logo)){ ?>
							<img src="<?php echo base_url() . $supplier->logo; ?>" style="max-width: 100%; margin: 5px 5px 5px 5px; height:120px;">
						<?php } else { ?>
							<img src="<?php echo base_url() . IMAGES_PATH . 'noProfilePic.jpg'; ?>" style="max-width: 100%; margin: 5px 5px 5px 5px; height:120px;">
						<?php } ?>
						<br>
						<?php if ($supplier->razon_social != "") echo "<b>Razón Social: </b>" . $supplier->razon_social . "<br>";?>
						<?php if ($supplier->cuit != "") echo "<b>CUIT:  </b>" . $supplier->cuit . "<br>";?>
						<?php if ($supplier->comercial_email != "") echo "<b>Email:  </b>" . $supplier->comercial_email . "<br>";?>
						<?php if ($supplier->office_phone != "") echo "<b>Teléfono: </b>" . $supplier->office_phone . "<br>";?>
						<?php if ($supplier->fax != "") echo "<b>FAX: </b>" . $supplier->fax . "<br>";?>
					</div>
					<div class="col-md-8 col-sm-6 col-xs-12">
						<div class="panel panel-default">
							<div class="panel-body">
								<?php if ($supplier->commercial_address != "") echo "<h4>Dirección del Comercial</h4>" . $supplier->commercial_address . "<br>";?>
								<?php if ($supplier->service_description != "") echo "<h4>Descripción del Servicio</h4>" . $supplier->service_description . "<br>";?>
								<?php if ($supplier->associationStatus == 'approved') {?>
									<button type="button" class="btn btn-info" style="margin-top:30px;" title='Información bancaria del proveedor' data-toggle="collapse" data-target="#prescriptionCollapse">Informacion Bancaria <span class="caret"></span></button>
									<div id="prescriptionCollapse" class="collapse" style="margin-top: 10px;">
										<div class="panel panel-default">
											<div class="panel-body">	
												<?php echo "<b>Banco:  </b>" . $supplier->bank_name . "<br>";?>
												<?php echo "<b>CBU:  </b>" . $supplier->cbu . "<br>";?>
												<?php echo "<b>Nro. de Cuenta:  </b>" . $supplier->bank_account . "<br>";?>
												<?php echo "<b>Titular:  </b>" . $supplier->bank_account_name . "<br>";?>
											</div>
										</div>
									</div>
								<?php } ?>	
							</div>
						</div>					
					</div>
					<div class="col-md-4 col-sm-6 col-xs-12">
						<div class="panel panel-default">
							<div class="panel-body">
								<ul class="nav nav-pills nav-stacked">
								<li><a href="<?php echo base_url() . 'Suppliers/viewCatalog/'. $supplier->id;?>"><b><span class="glyphicon glyphicon-list" aria-hidden="true"></span> Ver catálogo</b></a></li>
								<?php if ($supplier->associationStatus == 'approved') {?>
									<li><a href="<?php echo base_url() . 'Suppliers/viewCatalog/'. $supplier->id;?>"><b><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Dejar de distribuir sus productos</b></a></li>
								<?php } else {?>
									<li><a href="<?php echo base_url() . 'suppliers/setSupplierDistributorStatus/' . $supplier->id;?>"><b><span class="glyphicon glyphicon-share" aria-hidden="true"></span> Reenviar solicitud de adhesión</b></a></li>
								<?php }?>
								</ul>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</section>