<section id="home">
	<div class="container-fluid">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<?php
				if (isset($product->branch)) {
					echo '<ol class="breadcrumb">';
					echo '<li><a href="' . base_url() . 'Product/products/-1" id="-1"><b>PRODUCTOS</b></a></li>';
					$treeHeight = count($product->branch);
					//echo var_dump($product->branch);
					for ($i=$treeHeight-1; $i >= 0; $i--) {
						echo '<li><a href="' . base_url() . 'Product/products/' . $product->branch[$i]->id . '" id="'.$product->branch[$i]->id.'">'.$product->branch[$i]->name.'</a></li>';
					}
					echo '</ol>';
				}
			?>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="col-md-6 col-sm-12 col-xs-12">
						<h2><b><?php echo $product->name; ?></b><small> <b><?php echo $product->price . '$' . ' (' . 'I.V.A. ' . $product->tax . ')';?></b></small></h2>
						<h4><strong>Código Interno (<?php echo $product->supplier->fake_name;?>):</strong> <?php echo $product->code; ?><br></h4>
						<h4><strong>Código IntegrApp: </strong><?php echo $product->integrapp_code; ?></h4>
						<div class="dropdown" style="margin-bottom: 10px;">
							<button class="btn btn-info dropdown-toggle" type="button" id="suppliersDropDown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
								Proveedores
								<span class="caret"></span>
							</button>
							<ul class="dropdown-menu" aria-labelledby="suppliersDropDown">
								<li class="dropdown-header">Proveedor Principal</li>
								<li><a href="<?php echo base_url() . 'Suppliers/viewSupplier/'. $product->supplier->id;?>"><img src="<?php echo base_url() . $product->supplier->logo; ?>" alt="Chania" style="height: 20px"><?php echo $product->supplier->fake_name; ?></a></li>
								<li role="separator" class="divider"></li>
								<li class="dropdown-header">Proveedores que lo distribuyen</li>
								<li><a href="#">ProveeWWW</a></li>
								<li><a href="#">ProveeYYY</a></li>
								<li><a href="#">ProveeZZZ</a></li>
							</ul>
						</div>

						<div id="myCarousel" class="carousel slide" data-ride="carousel">
							<?php if (isset($product->images)){?>
								<!-- Indicators -->
								<ol class="carousel-indicators">
									<?php for ($i=0; $i < count($product->images); $i++) {
											if ($i==0){
												echo '<li data-target="#myCarousel" data-slide-to="'.$i.'" class="active" style="border:1px solid #BBB;"></li>';
											} else {
												echo '<li data-target="#myCarousel" data-slide-to="'.$i.'" style="border: 1px solid #BBB;"></li>';
											}			
									}?>					
								</ol>
								<!-- Wrapper for slides -->
								<div class="carousel-inner" role="listbox">
									<?php
									 	$path = base_url() . PRODUCT_IMAGES_PATH . $product->id . "/";
										for ($i=0; $i < count($product->images); $i++) { 
											if ($i==0) {?>
												<div class="item active">
													<img src="<?php echo $path . $product->images[$i]; ?>" alt="Chania" style="height: 360px">
												</div>	
									<?php 	} else { ?>	
												<div class="item">
													<img src="<?php echo $path . $product->images[$i]; ?>" alt="Chania" style="height: 360px">
												</div>		
									<?php 	}
										}?>
								</div>

								<!-- Left and right controls -->
								
								<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
									<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
									<span class="sr-only">Previous</span>
								</a>
								<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
									<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
									<span class="sr-only">Next</span>
								</a>
							<?php } ?>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12">
							<h4><strong>Descripción: </strong> <?php echo $product->description; ?><br></h4>
							<button type="button" class="btn btn-info" title='Como debe prescribir correctamente este producto (copie el texto a continuación)' data-toggle="collapse" data-target="#prescriptionCollapse">Como Prescribirlo <span class="caret"></span></button>
							<div id="prescriptionCollapse" class="collapse" style="margin-top: 10px;">
								<div class="panel panel-default">
									<div class="panel-body">	
										<?php echo $product->prescription;?>									
									</div>
								</div>
							</div>
						</div>
						<table class="table table-striped">
							<caption><h2><b>Especificaciones Técnicas</b></h2></caption>
							<thead>
								<tr>
									<th>Tipo</th>
									<th>Variantes Disponibles</th>
								</tr>
							</thead>
							<tbody id="tableBody">
								<?php if (isset($product->attributes)) { 
									for ($i=0; $i<count($product->attributes); $i++) {?> 
										<tr>
											<td><?php echo $product->attributes[$i]->attribute_name;?></td>
											<td><?php echo $product->attributes[$i]->attribute_value;?></td>
											
										</tr>
								<?php }
								} ?>
								<?php if (isset($product->colors)) { ?>
									<tr>
										<td>Colores</td>
										<td>
											<?php for ($i=0; $i<count($product->colors); $i++) {?> 
												<div class="color" style="border-style: solid; border-width: 1px; background-color: <?php echo $product->colors[$i]->color;?>; height: 30px; width: 30px;"></div>
											<?php } ?>
										</td>
									</tr>
								<?php }; ?>	
							</tbody>
						</table>
					</div>
					<div class="col-md-6 col-sm-12 col-xs-12" style="text-align:center;">
						<div class="panel panel-default">
							<div class="panel-body">
								<h2><b><?php if ($role == 'supplier') echo "Ortopedias"; else echo "Proveedores" ?></b></h2>
								<img src="<?php echo base_url() . 'Resources/imgs/map_example.png'; ?>" style="max-height: 400px">		
							</div>
						</div>
					</div>
				</div>			
			</div>
		</div>
	</div>
</section>