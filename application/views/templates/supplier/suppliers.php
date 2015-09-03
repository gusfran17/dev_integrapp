<section id="home">
	<div class="container" style="text-align:center;">
		<h2><span class="label label-default" style="color:#ffffff;"><b>PROVEEDORES</b></span></h2>
		<div class="col-md-12 col-sm-12 col-xs-12">
			<?php if(isset($suppliers)) for ($i=0; $i < count($suppliers) ; $i++) { ?>
				<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 item-catalogo">
					<div class="panel panel-info" style="text-align:center; background-color: #f5f5f5">
						<div class="panel-body">
							<a href="<?php echo base_url() . 'Suppliers/viewSupplier/'. $suppliers[$i]->id;?>" style="text-align:center;">
								<?php if(isset($suppliers[$i]->logo)){ ?>
									<img src="<?php echo base_url() . $suppliers[$i]->logo; ?>" style="max-width: 100%; margin: 5px 5px 5px 5px; height:80px;">
								<?php } else { ?>
									<img src="<?php echo base_url() . 'Resources/imgs/noProfilePic.jpg'; ?>" style="max-width: 100%; margin: 5px 5px 5px 5px; height:80px;">
								<?php } ?>
							</a>
							<h4 style="height: 2em;"><a href="<?php echo base_url() . 'Suppliers/viewSupplier/'. $suppliers[$i]->id;?>"><?php echo $suppliers[$i]->fake_name; ?></a></h4>
							
								<?php if (($suppliers[$i]->associationStatus != 'approved') and ($watchingRole=='distributor')){ ?>
									<p><span class="label label-warning" style="color:#ffffff;"><b><?php echo NOT_ASSOCIATED_MESSAGE; ?></b></span></p>
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 item-catalogo">
										<a href="<?php echo base_url() . 'suppliers/setSupplierDistributorStatus/' . $suppliers[$i]->id;?>"><button type="button" class="btn btn-success btn-xs">Recordar solicitud</button></a>
									</div>
								<?php } else if ($watchingRole=='distributor') {?>
									<p><span class="label label-info" style="color:#ffffff;"><b><?php echo ASSOCIATED_MESSAGE; ?></b><span></p>
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 item-catalogo">
									</div>
								<?php }?>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 item-catalogo">
								<p class="text-info"><a href="<?php echo base_url() . 'Suppliers/viewCatalog/'. $suppliers[$i]->id;?>"><b><span class="glyphicon glyphicon-list" aria-hidden="true"></span> Ver catálogo</b></a></p>
							</div>
						</div>
					</div>
				</div>
			<?php }  ?>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center;">
			<?php if(isset($pageLinks)) foreach ($pageLinks as $link) {
				echo $link;
			}  ?>
		</div>
	</div>		
		
</section>