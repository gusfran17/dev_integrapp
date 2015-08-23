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
						<?php if ($product->mine){ ?>
							<a href="<?php echo base_url() . 'product/editCatalogProduct/' . $product->id; ?>">
								<button type="button" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Editar</button>
							</a><br>
							<div class="dropdown" style="margin-bottom: 10px;">
								<button class="btn btn-info btn-xs dropdown-toggle" type="button" id="statusDropDown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
									<?php  if ($product->status == 'active') echo 'Activo';
										   else if ($product->status == 'inactive') echo 'Eliminado';
										   else echo 'Publicado';	
									?>
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu" aria-labelledby="statusDropDown">
									<li class="dropdown-header">Cambiar estado</li>
									<?php if ($product->status == 'active') {?>
										<li><a href="<?php echo base_url() . 'product/setProductStatus/' . $product->id . "/published";?>">Publicar</a></li>
										<li><a href="<?php echo base_url() . 'product/setProductStatus/' . $product->id . "/inactive";?>">Eliminar</a></li>
									<?php } else if ($product->status == 'inactive') { ?>
										<li><a href="<?php echo base_url() . 'product/setProductStatus/' . $product->id . "/active";?>">Activar</a></li>
									<?php } else { ?>
										<li><a href="<?php echo base_url() . 'product/setProductStatus/' . $product->id . "/active";?>">Despublicar</a></li>			
									<?php }?>
								</ul>
							</div>
						<?php } else { ?>
							<?php if($product->supplier->associationStatus == 'approved'){ ?>
								<?php if ($product->isCatalogItem == false){ ?>
									<a href="<?php echo base_url() . 'Product/addProductToCatalog/'. $product->id;?>">
										<button type="button" class="btn btn-success btn-xs">Agregar a mi Catálogo</button>
									</a>
								<?php } else {?>
									<a href="<?php echo base_url() . 'Product/removeProductFromCatalog/'. $product->id;?>">
										<button type="button" class="btn btn-danger btn-xs">Remover de mi Catálogo</button>
									</a>
								<?php } ?>
							<?php }?>
						<?php } ?>
						<div class="dropdown" style="margin-bottom: 10px;">
							<button class="btn btn-info btn-xs dropdown-toggle" type="button" id="suppliersDropDown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
								Proveedores
								<span class="caret"></span>
							</button>
							<ul class="dropdown-menu" aria-labelledby="suppliersDropDown">
								<li class="dropdown-header">Proveedor Principal</li>
								<li><a href="<?php echo base_url() . 'Suppliers/viewSupplier/'. $product->supplier->id;?>">
									
								<?php if(isset($product->supplier->logo)){ ?>
     								<img src="<?php echo base_url() . $product->supplier->logo; ?>" style="height: 20px">
     							<?php } else { ?>
     								<img src="<?php echo base_url() . IMAGES_PATH . 'noProfilePic.jpg'; ?>" style="height: 20px">
								<?php } ?>
									<?php echo $product->supplier->fake_name; ?></a>
								</li>
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
									<li data-target="#myCarousel" data-slide-to="0" class="active" style="border:1px solid #BBB;"></li>
									<?php for ($i=1; $i < count($product->images); $i++) {
										echo '<li data-target="#myCarousel" data-slide-to="'.$i.'" style="border: 1px solid #BBB;"></li>';
									}?>								
								</ol>
								<!-- Wrapper for slides -->
								<div class="carousel-inner" role="listbox">
									<?php $path = base_url() . PRODUCT_IMAGES_PATH . $product->id . "/"; ?>
										<div class="item active">
									 		<?php if (count($product->images) > 0){?>
												<img src="<?php echo $path . $product->images[0]; ?>" style="height: 360px; margin: 0 auto;">
											<?php } else { ?>
												<img src="<?php echo base_url() . 'Resources/imgs/NoFoto.jpg'; ?>" style="height: 360px; margin: 0 auto;">
											<?php } ?> 
										</div>
									<?php for ($i=1; $i < count($product->images); $i++) { ?>
												<div class="item">
													<img src="<?php echo $path . $product->images[$i]; ?>" alt="Chania" style="height: 360px; margin: 0 auto;">
												</div>		
									<?php }?>
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