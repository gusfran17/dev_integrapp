<div id="page-wrapper">
	<div class="container-fluid">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<?php
				if (isset($product->branch)) {
					echo '<ol class="breadcrumb">';
					echo '<li><a href="' . base_url() . 'Product/products" id="-1"><b>PRODUCTOS</b></a></li>';
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
						<div style="min-height:120px">
							<h2><b><?php echo $product->name; ?></b><small> <b><?php if(($product->mine)) echo '$'.number_format($product->price, PRICE_DECIMAL_AMOUNT, DECIMAL_SEPARATOR, THOUSANDS_SEPARATOR) . ' (' . 'I.V.A. ' . $product->tax . ')';?></b></small></h2>
							<?php if ($watchingRole != "pacient") {?>
								<h4><strong>Código Interno <?php echo "(".$product->primarySupplier->fake_name . ")";?>:</strong> <?php echo $product->code; ?><br></h4>
							<?php }?>
							<h4><strong>Código IntegrApp: </strong><?php echo $product->integrapp_code; ?></h4>
							<script type="text/javascript">
								var locations = <?php echo json_encode($distributorLocations) ?>;
								$(document).ready(function() {

								    getGeolocalization(function(){

										bindGoogleMaps(locations,13);
									});
								});
							</script>
							<?php if ($product->mine){ ?>
								<script type="text/javascript">
									function publishProduct(selectedProductId) {
										var productId = selectedProductId;
										if (window.confirm("Al publicar este producto se le descontaran <?php echo $product->publishing_cost; ?>$ de su crédito")){
											$('#publish_' + productId).submit();	
										}
									}
									function deactivateProduct(selectedProductId) {
										var productId = selectedProductId;
										if (window.confirm("¡Atención! Si despublica este producto, deberá pagar nuevamente el costo de publicación para publicarlo más tarde (costo: <?php echo $product->publishing_cost; ?>$)")){
											$('#deactivate_' + productId).submit();	
										}
									}
								</script>
								<a href="<?php echo base_url() . 'product/editCatalogProduct/' . $product->id; ?>">
									<button type="button" class="btn btn-success btn-xs" style="min-width: 170px;"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Editar</button>
								</a><br>
								<div class="dropdown" style="margin-bottom: 10px;">
									<button class="btn btn-info btn-xs dropdown-toggle" type="button" id="statusDropDown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" style="min-width: 170px;">
										<?php  if ($product->status == 'active') echo 'Activo';
											   else if ($product->status == 'inactive') echo 'Eliminado';
											   else echo 'Publicado';	
										?>
										<span class="caret"></span>
									</button>
									<ul class="dropdown-menu" aria-labelledby="statusDropDown">
										<li class="dropdown-header">Cambiar estado</li>
										<?php if ($product->status == 'active') {?>
											<form action="<?php echo base_url() . 'product/publishProduct/' . $product->id;?>" id="<?php echo 'publish_' . $product->id; ?>" style="padding-bottom: 0px;">
											</form>
											<li><a href="#" onclick="publishProduct(<?php echo $product->id; ?>)">
												Publicar (Cuesta <?php echo $product->publishing_cost; ?> $)
											</a></li>
											<li><a href="<?php echo base_url() . 'product/deactivateProduct/' . $product->id;?>">Eliminar</a></li>
										<?php } else if ($product->status == 'inactive') { ?>
											<li><a href="<?php echo base_url() . 'product/activateProduct/' . $product->id;?>">Activar</a></li>
										<?php } else { ?>
											<form action="<?php echo base_url() . 'product/activateProduct/' . $product->id;?>" id="<?php echo 'deactivate_' . $product->id; ?>" style="padding-bottom: 0px;"></form>
											<li><a href="#" onclick="deactivateProduct(<?php echo $product->id ?>)">
												Despublicar
											</a></li>			
										<?php }?>
									</ul>
								</div>
							<?php } else { ?>
								<?php if ($watchingRole != "pacient"){ ?>
									<?php if (($product->primarySupplier->associationStatus == true)){ ?>
										<?php if ($product->isCatalogItem == false){ ?>
											<?php if ($watchingRole == 'supplier'){ ?>
												<form action="<?php echo base_url() . 'product/addProductToSupplierCatalog/' . $product->id; ?>" method="post" id="<?php echo 'addToSecSuppCat_' . $product->id; ?>" style="padding-bottom: 0px;">
													<div class="dropdown" style="margin-bottom: 10px; max-width:300px;">
														<button class="btn btn-info btn-xs dropdown-toggle" type="button" id="addToCatalogDropDown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" style="min-width: 170px;">
															<span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> 
															Agregar a mi Catálogo
															<span class="caret"></span>
														</button>
														<ul class="dropdown-menu" aria-labelledby="suppliersDropDown" style="max-width:300px;">
															<li><a style="max-width:300px;">
																	El mayorista le ofrece un <b><?php echo $product->primarySupplier->associationDiscount;?>%</b> <br>
																	de descuento sobre sus productos<br>
															</a></li>
															<li><a><b>Precio final: $<?php echo number_format((($product->price)-((($product->primarySupplier->associationDiscount)*($product->price))/100)), PRICE_DECIMAL_AMOUNT, DECIMAL_SEPARATOR, THOUSANDS_SEPARATOR);?></b><br><br></a></li>
															<li><a>
																Ingrese el precio que quiere que se<br>
																muestre en su catálogo (es el que <br>
																verán sus ortopedias clientes): 
															</a></li>
															<li><a><input type="text" class="form-control" onclick="event.stopPropagation();" name="productPrice<?php echo $product->id; ?>" id="productPrice<?php echo $product->id; ?>" placeholder="Ingrese un precio..."></a></li>
															<li>
																<a><button type="submit" onclick="" class="btn btn-success btn-sm col-md-12 col-sm-12 col-xs-12" form="<?php echo 'addToSecSuppCat_' . $product->id; ?>">
																	<span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> 
																	Agregar
																</button></a>
															</li>
														</ul>
													</div>
												</form>
											<?php } else if ($watchingRole == 'distributor'){ ?>
												<a href="<?php echo base_url() . 'Product/addProductToDistributorCatalog/'. $product->id;?>">
													<button type="button" class="btn btn-success btn-xs" style="min-width: 170px;">Agregar a mi Catálogo</button>
												</a>
											<?php } ?>
										<?php } else {?>
											<?php if ($watchingRole == 'supplier'){ ?>
												<form action="<?php echo base_url() . 'product/removeProductFromSupplierCatalog/' . $product->id; ?>" id="<?php echo 'removeFromSecSuppCat_' . $product->id; ?>" style="padding-bottom: 0px;">
													<button type="submit" onclick="" class="btn btn-danger btn-xs" style="min-width: 170px;" form="<?php echo 'removeFromSecSuppCat_' . $product->id; ?>"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Remover de mi Catálogo</button>
												</form>
											<?php } else if ($watchingRole == 'distributor'){ ?>
												<a href="<?php echo base_url() . 'Product/removeProductFromDistributorCatalog/'. $product->id;?>">
													<button type="button" class="btn btn-danger btn-xs" style="min-width: 170px;">Remover de mi Catálogo</button>
												</a>
											<?php } ?>
										<?php } ?>
									<?php }?>
								<?php }?>
							<?php } ?>
							<?php if ($watchingRole != "pacient"){ ?>
								<div class="dropdown" style="margin-bottom: 10px;">
									<button class="btn btn-info btn-xs dropdown-toggle" type="button" id="suppliersDropDown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" style="min-width: 170px;">
										Mayoristas
										<span class="caret"></span>
									</button>
									<ul class="dropdown-menu" aria-labelledby="suppliersDropDown">
										<li class="dropdown-header">Mayorista Principal</li>
										<?php if ((isset($product->primarySupplier->price)) or($loadInfo->isDistributorFivesRule == true)) {?>
											<li>
												<a href="<?php echo base_url() . 'Suppliers/viewSupplier/'. $product->primarySupplier->id;?>">
													<?php if(isset($product->primarySupplier->logo)){ ?>
					     								<img src="<?php echo base_url() . $product->primarySupplier->logo; ?>" style="height: 20px">
					     							<?php } else { ?>
					     								<img src="<?php echo base_url() . IMAGES_PATH . 'noProfilePic.jpg'; ?>" style="height: 20px">
													<?php } ?>
													<?php echo $product->primarySupplier->fake_name; ?> 
													<?php if ($watchingRole == "distributor"){
														if (isset($product->primarySupplier->price)) {
															echo "(lo vende a $".number_format($product->primarySupplier->price, PRICE_DECIMAL_AMOUNT, DECIMAL_SEPARATOR, THOUSANDS_SEPARATOR).")";
														} else {
															echo "(no esta asociado)";	
														}
													}?>
												</a>
											</li>
										<?php } else { ?>
											<li><a href="">Información no disponible</a></li>
										<?php } ?>
										<li role="separator" class="divider"></li>
										<li class="dropdown-header">
											<?php  if (count($product->secondarySuppliers) == 0) { ?>
												No hay mayoristas que redistribuyan este producto
											<?php } else { ?>
												Mayoristas secundarios que lo redistribuyen
											<?php } ?>
										</li>
										<?php foreach ($product->secondarySuppliers as $secSupplier) { ?>
											<?php if ((isset($secSupplier->price)) or($loadInfo->isDistributorFivesRule == true)) {?>
												<li>
													<a href="<?php echo base_url() . 'Suppliers/viewSupplier/'. $secSupplier->id;?>">
														<?php if(isset($secSupplier->logo)){ ?>
						     								<img src="<?php echo base_url() . $secSupplier->logo; ?>" style="height: 20px">
						     							<?php } else { ?>
						     								<img src="<?php echo base_url() . IMAGES_PATH . 'noProfilePic.jpg'; ?>" style="height: 20px">
														<?php } ?>
														<?php echo $secSupplier->fake_name; ?>
														<?php if ($watchingRole == "distributor"){
															if (isset($secSupplier->price)){ 
																echo "(lo vende a $".number_format($secSupplier->price, PRICE_DECIMAL_AMOUNT, DECIMAL_SEPARATOR, THOUSANDS_SEPARATOR).")";
															} else {
																echo "(no esta asociado)";	
															}
														}?>
													</a>
												</li>
											<?php }?>
										<?php }?>
									</ul>
								</div>
							<?php } ?>
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
									<?php $path = base_url() . PRODUCT_IMAGES_PATH; ?>
										<div class="item active">
									 		<?php if (count($product->images) > 0){?>
												<img src="<?php echo $path . $product->images[0]; ?>" style="height: 360px; margin: 0 auto;">
											<?php } else { ?>
												<img src="<?php echo base_url() . IMAGES_PATH . 'NoFoto.jpg'; ?>" style="height: 360px; margin: 0 auto;">
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
							<br>
							<h4><strong>Indicaciones: </strong> <?php echo $product->indications; ?><br></h4>
							<br>
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
							<caption><h2><b>Especificaciones</b></h2></caption>
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
						<div class="panel panel-default" style="margin-top: 70px;">
							<div class="panel-body">
								<h2><b><?php if (($watchingRole == 'supplier') or ($watchingRole =='pacient')) echo "Ortopedias que lo comercializan"; else echo "Ortopedias que lo comercializan" ?></b></h2>
								<div id="googleMap" style="width:100%;height:450px;"></div>
								<!-- <img src="<?php echo base_url() . 'Resources/img/map_example.png'; ?>" style="max-height: 400px">		 -->
							</div>
						</div>
					</div>
				</div>			
			</div>
		</div>
	</div>
</div>