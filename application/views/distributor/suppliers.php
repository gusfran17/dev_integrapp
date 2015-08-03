<section id="home">
	<div class="container">
		<h1><b>PROVEEDORES</b></h1>
		
			<div class="row">
				<?php if(isset($suppliers)) for ($i=0; $i < count($suppliers) ; $i++) { ?>
					<div class="col-md-3 col-sm-4 col-xs-6 item-catalogo" style="margin: 10px 10px 10px 10px;">
						<div class="well">
							<a href="<?php echo base_url() . 'Suppliers/selectSupplier/'. $suppliers[$i]->id;?>">
								<?php if(isset($suppliers[$i]->logo)){ ?>
									<img src="<?php echo base_url() . $suppliers[$i]->logo; ?>" style="max-width: 100%;display: block; margin: 5px 5px 5px 5px; height:80px;">
								<?php } else { ?>
									<div style="max-width: 100%;display: block; margin: 5px 5px 5px 5px; height:80px;"><b>El proveedors no ha cargado su foto de perfil.</b></div>
								<?php } ?>
							</a>
							<h4 style="height: 2em;"><a href="<?php echo base_url() . 'Suppliers/selectSupplier/'. $suppliers[$i]->id;?>"><?php echo $suppliers[$i]->razon_social; ?></a></h4>
							<p class="text-info" style="margin-left: auto;width: 6em;"><a href="<?php echo base_url() . 'Suppliers/selectSupplier/'. $suppliers[$i]->id;?>">Ver catálogo</a></p>
						</div>
					</div>
				<?php }  ?>
			</div>
		
		<div class="col-md-2 col-sm-2 col-xs-2">
		</div>	
		<div class="col-md-8 col-sm-8 col-xs-8">
			<?php if(isset($pageLinks)) foreach ($pageLinks as $link) {
				echo $link;
			}  ?>
		</div>
		<div class="col-md-2 col-sm-2 col-xs-2">
		</div>
	</div>		
		
</section>