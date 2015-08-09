<section id="home">
	<div class="container" style="text-align:center;">
		<h2><span class="label label-default" style="color:#ffffff;"><b>PROVEEDORES</b></span></h2>
		
		<div class="col-md-12 col-sm-12 col-xs-12">
			<?php if(isset($suppliers)) for ($i=0; $i < count($suppliers) ; $i++) { ?>
				<div class="col-md-4 col-sm-4 col-xs-12 item-catalogo">
					<div class="well" style="text-align:center;">
						<a href="<?php echo base_url() . 'Suppliers/viewSupplier/'. $suppliers[$i]->id;?>" style="text-align:center;">
							<?php if(isset($suppliers[$i]->logo)){ ?>
								<img src="<?php echo base_url() . $suppliers[$i]->logo; ?>" style="max-width: 100%; margin: 5px 5px 5px 5px; height:80px;">
							<?php } else { ?>
								<img src="<?php echo base_url() . 'Resources/imgs/noProfilePic.jpg'; ?>" style="max-width: 100%; margin: 5px 5px 5px 5px; height:80px;">

							<?php } ?>
						</a>
						<h4 style="height: 2em;"><a href="<?php echo base_url() . 'Suppliers/viewSupplier/'. $suppliers[$i]->id;?>"><?php echo $suppliers[$i]->fake_name; ?></a></h4>
						<p class="text-info" style="margin-left: auto;width: 6em;"><a href="<?php echo base_url() . 'Suppliers/viewCatalog/'. $suppliers[$i]->id;?>"><b>Ver catálogo</b></a></p>
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