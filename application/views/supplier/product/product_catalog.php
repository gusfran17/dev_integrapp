					
							<?php if (isset($statusFilter)):?>
								<?php if (($loadInfo->activeProducts>0) and ($statusFilter != 'active') and (isset($viewMyCatalog))):?>
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<div class="col-lg-3 col-md-2 col-sm-1 col-xs-0">
										</div>
										<div class="alert alert-info alert-dismissible col-lg-6 col-md-8 col-sm-10 col-xs-12" style="text-align: center" role="alert">
										  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span></button>
										  <strong>Recuerde...</strong> Tiene <?php echo $loadInfo->activeProducts;?> productos activos sin publicar <br>
										  <a href="<?php echo base_url() . 'Product/showActiveProducts'; ?>"><b>Ver productos activos</b></a>
										</div>
										<div class="col-lg-3 col-md-2 col-sm-1 col-xs-0">
										</div>
									</div>
								<?php endif;?>		
							<?php endif;?>
							<?php if (isset($viewMyCatalog)) {?>
								<?php if ($statusFilter == 'published') { ?>
									<h1 style="text-align:center;margin-top: 0px;"><span class="label label-default" style="color:#ffffff;"><b><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> Publicados</b></span></h1>
								<?php } else if ($statusFilter == 'active') { ?>
									<h1 style="text-align:center;margin-top: 0px;"><span class="label label-default" style="color:#ffffff;"><b>Activos </b></span><br><small>(No Publicados)</small></h1>
								<?php } else { ?>
									<h1 style="text-align:center;margin-top: 0px;"><span class="label label-default" style="color:#ffffff;"><b><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Eliminados</b></span></h1>
								<?php } ?>
							<?php } ?>
				    		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<?php if($this->session->flashdata('success') != null):?>
									<div class="alert alert-dismissable alert-success col-md-12 col-sm-12 col-xs-12">
										<button type="button" class="close" data-dismiss="alert"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span></button>
										<strong><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span></strong>
									 	<strong>Bien!</strong> <?php echo $this->session->flashdata('success'); ?></a>
									</div>
								<?php endif;?>
								<?php if($this->session->flashdata('error') != null):?>
									<div class="alert alert-dismissable alert-danger col-md-12 col-sm-12 col-xs-12">
										<button type="button" class="close" data-dismiss="alert"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span></button>
										<strong><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span></strong>
									 	<strong>Atención!</strong> <?php echo $this->session->flashdata('error'); ?></a>
									</div>
								<?php endif;?>
								<div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center"> 			
									<?php if(isset($pageLinks)) foreach ($pageLinks as $link) {
										echo $link;
									}  ?>
				    			</div>
								<?php if (isset($viewMyCatalog)) {?>
									<div id="example_wrapper" class="dataTables_wrapper form-inline" role="grid">
									<table id="resultset" class="table table-bordered table-striped">
						                <thead>
						                    <tr>
						                        <th>Imagen</th>
						                        <th class="hidden-phone">Código de Producto</th>
												<th class="hidden-phone hidden-tablet">Código IntegrApp</th>
						                        <th>Producto</th>
						                        <th>Precio (sin IVA)</th>
						                        <th class="hidden-phone hidden-tablet">IVA</th>
						                        <th class="hidden-phone hidden-tablet">Descripción</th>
						                        <th>Acciones</th>
						                    </tr>
						                </thead>
						                <tbody>
											<?php 
											$catalogSize = count($Catalog);
											for ($i=0; $i < $catalogSize; $i++) { ?>
												<tr>
													<td>
														<?php if (count($Catalog[$i]->images)>0) {?>
													      	<a href="<?php echo base_url() . 'product/viewProduct/' . $Catalog[$i]->id; ?>"><img src="<?php echo base_url() . PRODUCT_IMAGES_PATH . $Catalog[$i]->images[0]; ?>" style="max-width: 100%;display: block;margin: 0 auto;max-height: 40px;"></a>
													    <?php } else { ?>
												      		<a href="<?php echo base_url() . 'product/viewProduct/' . $Catalog[$i]->id; ?>"><img src="<?php echo base_url() . IMAGES_PATH . 'NoFoto.jpg'; ?>" style="max-width: 100%;display: block;margin: 0 auto;max-height: 40px;"></a>
													    <?php } ?>
													</td>
													<td class="hidden-phone">
														<a href="<?php echo base_url() . 'product/viewProduct/' . $Catalog[$i]->id; ?>"><?php echo $Catalog[$i]->code; ?></a>
													</td>
													<td class="hidden-phone hidden-tablet">
														<a href="<?php echo base_url() . 'product/viewProduct/' . $Catalog[$i]->id; ?>"><?php echo $Catalog[$i]->integrapp_code; ?></a>
													</td>
													<td>
														<a href="<?php echo base_url() . 'product/viewProduct/' . $Catalog[$i]->id; ?>"><strong><?php echo $Catalog[$i]->name; ?></strong></a>
														<?php  if (count($Catalog[$i]->secondarySuppliers) != 0) { ?>
															<div class="dropdown" style="margin-bottom: 10px;">
																<button class="btn btn-info btn-xs dropdown-toggle" type="button" id="suppliersDropDown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
																	Mayoristas Secundarios
																	<span class="caret"></span>
																</button>
																<ul class="dropdown-menu" aria-labelledby="suppliersDropDown">
																	<li class="dropdown-header">
																		Mayoristas secundarios que lo redistribuyen
																	</li>
																	<?php foreach ($Catalog[$i]->secondarySuppliers as $secSupplier) { ?>
																		<li><a href="<?php echo base_url() . 'Suppliers/viewSupplier/'. $secSupplier->id;?>">
																		<?php if(isset($secSupplier->logo)){ ?>
										     								<img src="<?php echo base_url() . $secSupplier->logo; ?>" style="height: 20px">
										     							<?php } else { ?>
										     								<img src="<?php echo base_url() . IMAGES_PATH . 'noProfilePic.jpg'; ?>" style="height: 20px">
																		<?php } ?>
																			<?php echo $secSupplier->fake_name; ?></a>
																		</li>
																	<?php }?>
																</ul>
															</div>
														<?php } ?>
													</td>
													<td>
														<?php echo '$'.number_format($Catalog[$i]->price, PRICE_DECIMAL_AMOUNT, DECIMAL_SEPARATOR, THOUSANDS_SEPARATOR); ?>
													</td>
													<td class="hidden-phone hidden-tablet">
														<?php echo $Catalog[$i]->tax; ?>
													</td>
													<td class="hidden-phone hidden-tablet">
														<?php echo $Catalog[$i]->description; ?>
														<br>
														<br>
														<b>Categoria: </b><?php echo $Catalog[$i]->categoryPath; ?>

													</td>
													<td>
														<a href="<?php echo base_url() . 'product/editCatalogProduct/' . $Catalog[$i]->id; ?>">
															<button type="button" class="btn btn-success btn-xs col-md-12 col-sm-12 col-xs-12"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Editar</button>
														</a>
														<?php if ($Catalog[$i]->status == 'active') {?>
															<form action="<?php echo base_url() . 'product/publishProduct/' . $Catalog[$i]->id; ?>" id="<?php echo 'publish_' . $Catalog[$i]->id; ?>" style="padding-bottom: 0px;">
																<button type="button" onclick="publishProduct(<?php echo $Catalog[$i]->id; ?>,<?php echo $Catalog[$i]->publishing_cost; ?>)" class="btn btn-primary btn-xs col-md-12 col-sm-12 col-xs-12" form="<?php echo 'publish_' . $Catalog[$i]->id; ?>"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Publicar</button>
															</form>
															<a href="<?php echo base_url() . 'product/deactivateProduct/' . $Catalog[$i]->id; ?>">
																<button type="button" class="btn btn-danger btn-xs col-md-12 col-sm-12 col-xs-12"><span class="glyphicon glyphicon-off" aria-hidden="true"></span> Eliminar</button>
															</a>
														<?php } else if ($Catalog[$i]->status == 'inactive') {?>
															<a href="<?php echo base_url() . 'product/activateProduct/' . $Catalog[$i]->id; ?>">
																<button type="button" class="btn btn-primary btn-xs col-md-12 col-sm-12 col-xs-12"><span class="glyphicon glyphicon-off" aria-hidden="true"></span> Activar</button>
															</a>
														<?php } else if ($Catalog[$i]->status == 'published') {?>
															<form action="<?php echo base_url() . 'product/activateProduct/' . $Catalog[$i]->id; ?>" id="<?php echo 'deactivate_' . $Catalog[$i]->id; ?>" style="padding-bottom: 0px;">
																<button type="button" onclick="deactivateProduct(<?php echo $Catalog[$i]->id; ?>,<?php echo $Catalog[$i]->publishing_cost; ?>)" class="btn btn-warning btn-xs col-md-12 col-sm-12 col-xs-12"><span class="glyphicon glyphicon-save-file" aria-hidden="true"></span> Despublicar</button>
															</form>
															<form action="<?php echo base_url() . 'product/publishProduct/' . $Catalog[$i]->id; ?>" id="<?php echo 'publish_' . $Catalog[$i]->id; ?>" style="padding-bottom: 0px;">
																<button type="button" onclick="publishProduct(<?php echo $Catalog[$i]->id; ?>,<?php echo $Catalog[$i]->publishing_cost; ?>)" class="btn btn-primary btn-xs col-md-12 col-sm-12 col-xs-12" form="<?php echo 'publish_' . $Catalog[$i]->id; ?>"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Republicar</button>
															</form>
														<?php } ?>
													</td>
												</tr>
											<?php } ?>
										</tbody>
									</table>
									</div>
								<?php } else if (isset($viewCatalog)) { ?>
									<?php $catalogSize = count($Catalog);
									for ($i=0; $i < $catalogSize; $i++) { ?>
										<table id="resultset" class="table table-bordered table-striped">
							                <thead>
							                    <tr>
							                        <th>Imagen</th>
							                        <th class="hidden-phone hidden-tablet">Código de Producto</th>
													<th class="hidden-phone">Código IntegrApp</th>
							                        <th>Producto</th>
							                        <th class="hidden-phone">IVA</th>
							                        <th class="hidden-phone hidden-tablet">Descripción</th>
							                        <th>Mayoristas</th>
							                        <th>Acciones</th>
							                    </tr>
							                </thead>
							                <tbody>
												<?php 
												$catalogSize = count($Catalog);
												for ($i=0; $i < $catalogSize; $i++) { ?>
													<tr>
														<td>
															<?php if (count($Catalog[$i]->images)>0) {?>
														      	<a href="<?php echo base_url() . 'product/viewProduct/' . $Catalog[$i]->id; ?>"><img src="<?php echo base_url() . PRODUCT_IMAGES_PATH . $Catalog[$i]->images[0]; ?>" style="max-width: 100%;display: block;margin: 0 auto;max-height: 40px;"></a>
														    <?php } else { ?>
													      		<a href="<?php echo base_url() . 'product/viewProduct/' . $Catalog[$i]->id; ?>"><img src="<?php echo base_url() . IMAGES_PATH . 'NoFoto.jpg'; ?>" style="max-width: 100%;display: block;margin: 0 auto;max-height: 40px;"></a>
														    <?php } ?>
														</td>
														<td class="hidden-phone hidden-tablet">
															<a href="<?php echo base_url() . 'product/viewProduct/' . $Catalog[$i]->id; ?>"><?php echo $Catalog[$i]->code; ?></a>
														</td>
														<td class="hidden-phone">
															<a href="<?php echo base_url() . 'product/viewProduct/' . $Catalog[$i]->id; ?>"><?php echo $Catalog[$i]->integrapp_code; ?></a>
														</td>
														<td>
															<a href="<?php echo base_url() . 'product/viewProduct/' . $Catalog[$i]->id; ?>"><strong><?php echo $Catalog[$i]->name; ?></strong></a>
														</td>
														<td class="hidden-phone">
															<?php echo $Catalog[$i]->tax; ?>
														</td>
														<td class="hidden-phone hidden-tablet">
															<?php echo $Catalog[$i]->description; ?>
															<br>
															<br>
															<b>Categoria: </b><?php echo $Catalog[$i]->categoryPath; ?>

														</td>
														<td>
															<div class="dropdown" style="margin-bottom: 10px;">
																<button class="btn btn-info btn-xs dropdown-toggle" type="button" id="suppliersDropDown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
																	Mayoristas
																	<span class="caret"></span>
																</button>
																<ul class="dropdown-menu" aria-labelledby="suppliersDropDown">
																	<li class="dropdown-header">Mayorista Principal</li>
																	<li><a href="<?php echo base_url() . 'Suppliers/viewSupplier/'. $Catalog[$i]->primarySupplier->id;?>">
																			<?php if(isset($Catalog[$i]->primarySupplier->logo)){ ?>
											     								<img src="<?php echo base_url() . $Catalog[$i]->primarySupplier->logo; ?>" style="height: 20px">
											     							<?php } else { ?>
											     								<img src="<?php echo base_url() . IMAGES_PATH . 'noProfilePic.jpg'; ?>" style="height: 20px">
																			<?php } ?>
																			<?php echo $Catalog[$i]->primarySupplier->fake_name; ?>
																			<?php if ($Catalog[$i]->isSupplierAssociated==true) {?>
																				(precio $<?php echo number_format($Catalog[$i]->price, PRICE_DECIMAL_AMOUNT, DECIMAL_SEPARATOR, THOUSANDS_SEPARATOR); ?>)
																			<?php } ?>
																		</a>
																	</li>
																	<li role="separator" class="divider"></li>
																	<li class="dropdown-header">Mayoristas secundarios que lo redistribuyen</li>
																	<?php foreach ($Catalog[$i]->secondarySuppliers as $secSupplier) { ?>
																		<li><a href="<?php echo base_url() . 'Suppliers/viewSupplier/'. $secSupplier->id;?>">
																		<?php if(isset($secSupplier->logo)){ ?>
										     								<img src="<?php echo base_url() . $secSupplier->logo; ?>" style="height: 20px">
										     							<?php } else { ?>
										     								<img src="<?php echo base_url() . IMAGES_PATH . 'noProfilePic.jpg'; ?>" style="height: 20px">
																		<?php } ?>
																			<?php echo $secSupplier->fake_name; ?></a>
																		</li>
																	<?php }?>
																</ul>
															</div>
														</td>
														<td>
															<?php if ($Catalog[$i]->isSupplierAssociated==true) {?>
																<?php if ($Catalog[$i]->isSecSupplierCatalogItem==false) {?>
																	<form action="<?php echo base_url() . 'product/addProductToSupplierCatalog/' . $Catalog[$i]->id; ?>" method="post" id="<?php echo 'addToSecSuppCat_' . $Catalog[$i]->id; ?>" style="padding-bottom: 0px;">
																		<div class="dropdown" style="margin-bottom: 10px; max-width:300px;">
																			<button class="btn btn-info btn-xs dropdown-toggle" type="button" id="addToCatalogDropDown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
																				<span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> 
																				Agregar a mi Catálogo
																				<span class="caret"></span>
																			</button>
																			<ul class="dropdown-menu" aria-labelledby="suppliersDropDown" style="max-width:300px;">
																				<li><a style="max-width:300px;">
																						El mayorista le ofrece un <b><?php echo $Catalog[$i]->supplierAssociationDiscount;?>%</b> <br>
																						de descuento sobre sus productos<br>
																				</a></li>
																				<li><a><b>Precio final: $<?php echo number_format((($Catalog[$i]->price)-((($Catalog[$i]->supplierAssociationDiscount)*($Catalog[$i]->price))/100)), PRICE_DECIMAL_AMOUNT, DECIMAL_SEPARATOR, THOUSANDS_SEPARATOR);?></b><br><br></a></li>
																				<li><a>
																					Ingrese el precio que quiere que se<br>
																					muestre en su catálogo (es el que <br>
																					verán sus ortopedias clientes): 
																				</a></li>
																				<li><a><input type="text" class="form-control" onclick="event.stopPropagation();" name="productPrice<?php echo $Catalog[$i]->id; ?>" id="productPrice<?php echo $Catalog[$i]->id; ?>" placeholder="Ingrese un precio..."></a></li>
																				<li>
																					<a><button type="submit" onclick="" class="btn btn-success btn-sm col-md-12 col-sm-12 col-xs-12" form="<?php echo 'addToSecSuppCat_' . $Catalog[$i]->id; ?>">
																						<span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> 
																						Agregar
																					</button></a>
																				</li>
																			</ul>
																		</div>
																	</form>
																<?php } else { ?>
																	<form action="<?php echo base_url() . 'product/removeProductFromSupplierCatalog/' . $Catalog[$i]->id; ?>" id="<?php echo 'removeFromSecSuppCat_' . $Catalog[$i]->id; ?>" style="padding-bottom: 0px;">
																		<button type="submit" onclick="" class="btn btn-danger btn-xs col-md-12 col-sm-12 col-xs-12" form="<?php echo 'removeFromSecSuppCat_' . $Catalog[$i]->id; ?>"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Remover de mi Catálogo</button>
																	</form>
																<?php } ?>
															<?php } ?>
														</td>
													</tr>
												<?php } ?>
											</tbody>
										</table>
									<?php } 
								} else if (isset($viewMySecSuppCatalog)) { ?>
									<table id="resultset" class="table table-bordered table-striped">
						                <thead>
						                    <tr>
						                        <th>Imagen</th>
						                        <th class="hidden-phone hidden-tablet">Código de Producto</th>
												<th class="hidden-phone">Código IntegrApp</th>
						                        <th>Producto</th>
						                        <th>Precio Orig.</th>
						                        <th>Mi Precio</th>
						                        <th class="hidden-phone">IVA</th>
						                        <th class="hidden-phone hidden-tablet">Descripción</th>
						                        <th>Acciones</th>
						                    </tr>
						                </thead>
						                <tbody>
											<?php 
											$catalogSize = count($Catalog);
											for ($i=0; $i < $catalogSize; $i++) { ?>
												<tr>
													<td>
														<?php if (count($Catalog[$i]->images)>0) {?>
													      	<a href="<?php echo base_url() . 'product/viewProduct/' . $Catalog[$i]->id; ?>"><img src="<?php echo base_url() . PRODUCT_IMAGES_PATH . $Catalog[$i]->images[0]; ?>" style="max-width: 100%;display: block;margin: 0 auto;max-height: 40px;"></a>
													    <?php } else { ?>
												      		<a href="<?php echo base_url() . 'product/viewProduct/' . $Catalog[$i]->id; ?>"><img src="<?php echo base_url() . IMAGES_PATH . 'NoFoto.jpg'; ?>" style="max-width: 100%;display: block;margin: 0 auto;max-height: 40px;"></a>
													    <?php } ?>
													</td>
													<td class="hidden-phone hidden-tablet">
														<a href="<?php echo base_url() . 'product/viewProduct/' . $Catalog[$i]->id; ?>"><?php echo $Catalog[$i]->code; ?></a>
													</td>
													<td class="hidden-phone">
														<a href="<?php echo base_url() . 'product/viewProduct/' . $Catalog[$i]->id; ?>"><?php echo $Catalog[$i]->integrapp_code; ?></a>
													</td>
													<td>
														<a href="<?php echo base_url() . 'product/viewProduct/' . $Catalog[$i]->id; ?>"><strong><?php echo $Catalog[$i]->name; ?></strong></a>
														
														<div class="dropdown" style="margin-bottom: 10px;">
															<button class="btn btn-info btn-xs dropdown-toggle" type="button" id="suppliersDropDown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
																Mayoristas
																<span class="caret"></span>
															</button>
															<ul class="dropdown-menu" aria-labelledby="suppliersDropDown">
																<li class="dropdown-header">Mayorista Principal</li>
																<li><a href="<?php echo base_url() . 'Suppliers/viewSupplier/'. $Catalog[$i]->primarySupplier->id;?>">
																<?php if(isset($Catalog[$i]->primarySupplier->logo)){ ?>
								     								<img src="<?php echo base_url() . $Catalog[$i]->primarySupplier->logo; ?>" style="height: 20px">
								     							<?php } else { ?>
								     								<img src="<?php echo base_url() . IMAGES_PATH . 'noProfilePic.jpg'; ?>" style="height: 20px">
																<?php } ?>
																	<?php echo $Catalog[$i]->primarySupplier->fake_name; ?></a>
																</li>
																<li role="separator" class="divider"></li>
																<li class="dropdown-header">
																	<?php  if (count($Catalog[$i]->secondarySuppliers) == 0) { ?>
																		No hay mayoristas que redistribuyan este producto
																	<?php } else { ?>
																		Mayoristas secundarios que lo redistribuyen
																	<?php } ?>
																</li>
																<?php foreach ($Catalog[$i]->secondarySuppliers as $secSupplier) { ?>
																	<li><a href="<?php echo base_url() . 'Suppliers/viewSupplier/'. $secSupplier->id;?>">
																	<?php if(isset($secSupplier->logo)){ ?>
									     								<img src="<?php echo base_url() . $secSupplier->logo; ?>" style="height: 20px">
									     							<?php } else { ?>
									     								<img src="<?php echo base_url() . IMAGES_PATH . 'noProfilePic.jpg'; ?>" style="height: 20px">
																	<?php } ?>
																		<?php echo $secSupplier->fake_name; ?></a>
																	</li>
																<?php }?>
															</ul>
														</div>
													</td>
													<td>
														<?php echo '$'.number_format($Catalog[$i]->price, PRICE_DECIMAL_AMOUNT, DECIMAL_SEPARATOR, THOUSANDS_SEPARATOR); ?>
													</td>
													<td>
														<?php echo '$'.number_format($Catalog[$i]->secondary_price, PRICE_DECIMAL_AMOUNT, DECIMAL_SEPARATOR, THOUSANDS_SEPARATOR); ?>
													</td>
													<td class="hidden-phone">
														<?php echo $Catalog[$i]->tax; ?>
													</td>
													<td class="hidden-phone hidden-tablet">
														<?php echo $Catalog[$i]->description; ?>
														<br>
														<br>
														<b>Categoria: </b><?php echo $Catalog[$i]->categoryPath; ?>

													</td>
													<td>
														<form action="<?php echo base_url() . 'product/removeProductFromSupplierCatalog/' . $Catalog[$i]->id; ?>" id="<?php echo 'removeFromSecSuppCat_' . $Catalog[$i]->id; ?>" style="padding-bottom: 0px;">
															<button type="submit" onclick="" class="btn btn-danger btn-xs col-md-12 col-sm-12 col-xs-12" form="<?php echo 'removeFromSecSuppCat_' . $Catalog[$i]->id; ?>"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Remover de mi Catálogo</button>
														</form>
													</td>
												</tr>
											<?php } ?>
										</tbody>
									</table>
								<?php } ?>
								<div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center"> 			
										
									<?php if(isset($pageLinks)) foreach ($pageLinks as $link) {
										echo $link;
									}  ?>
								
				    			</div>
							</div>

						
					