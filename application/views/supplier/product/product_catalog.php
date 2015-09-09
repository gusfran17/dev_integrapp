					
							<?php if (isset($viewMyCatalog)) {?>
								<?php if ($statusFilter == 'published') { ?>
									<h3 style="text-align:center;margin-top: 0px;"><span class="label label-default" style="color:#ffffff;"><b><span class="glyphicon glyphicon-list-alt" aria-hidden="true"> Publicados</span></b></span></h3>
								<?php } else if ($statusFilter == 'active') { ?>
									<h3 style="text-align:center;margin-top: 0px;"><span class="label label-default" style="color:#ffffff;"><b>Activos </b></span><br><small>(No Publicados)</small></h3>
								<?php } else { ?>
									<h3 style="text-align:center;margin-top: 0px;"><span class="label label-default" style="color:#ffffff;"><b><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Eliminados</b></span></h3>
								<?php } ?>
							<?php } ?>
							<?php if (isset($statusFilter)):?>
								<?php if (($loadInfo->activeProducts>0) and ($statusFilter != 'active') and (isset($viewMyCatalog))):?>
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<div class="col-lg-3 col-md-2 col-sm-1 col-xs-0">
										</div>
										<div class="alert alert-info alert-dismissible col-lg-6 col-md-8 col-sm-10 col-xs-12" style="text-align: center" role="alert">
										  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
										  <strong>Recuerde...</strong> Tiene <?php echo $loadInfo->activeProducts;?> productos activos sin publicar <br>
										  <a href="<?php echo base_url() . 'Product/showActiveProducts'; ?>"><b>Ver productos activos</b></a>
										</div>
										<div class="col-lg-3 col-md-2 col-sm-1 col-xs-0">
										</div>
									</div>
								<?php endif;?>		
							<?php endif;?>
				    		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<?php if (isset($viewMyCatalog)) {?>
								  <?php if($this->session->flashdata('success') != null):?>
									<div class="alert alert-dismissable alert-success col-md-12 col-sm-12 col-xs-12">
										<button type="button" class="close" data-dismiss="alert">×</button>
										<strong><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span></strong>
									 	<strong>Bien!</strong> <?php echo $this->session->flashdata('success'); ?></a>
									</div>
								  <?php endif;?>
								  <?php if($this->session->flashdata('error') != null):?>
									<div class="alert alert-dismissable alert-error col-md-12 col-sm-12 col-xs-12">
										<button type="button" class="close" data-dismiss="alert">×</button>
										<strong><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span></strong>
									 	<strong>Atención!</strong> <?php echo $this->session->flashdata('error'); ?></a>
									</div>
								  <?php endif;?>
									<table id="resultset" class="table table-bordered table-striped">
						                <thead>
						                    <tr>
						                        <th data-class="expand">Imagen</th>
						                        <th>Código de Producto</th>
												<th>Código IntegrApp</th>
						                        <th data-hide="phone">Producto</th>
						                        <th class="centered-cell" data-hide="phone,tablet">Precio</th>
						                        <th class="centered-cell" data-hide="phone,tablet">IVA</th>
						                        <th class="centered-cell visible-md-* visible-lg-*" data-hide="phone,tablet">Descripción</th>
						                        <th class="centered-cell" data-hide="phone,tablet">Acciones</th>
						                    </tr>
						                </thead>
						                <tbody>
											<?php 
											$catalogSize = count($Catalog);
											for ($i=0; $i < $catalogSize; $i++) { ?>
												<tr>
													<td>
														<?php if (count($Catalog[$i]->images)>0) {?>
													      	<a href="<?php echo base_url() . 'product/viewProduct/' . $Catalog[$i]->id; ?>"><img src="<?php echo base_url() . PRODUCT_IMAGES_PATH . $Catalog[$i]->id . "/" . $Catalog[$i]->images[0]; ?>" style="max-width: 100%;display: block;margin: 0 auto;max-height: 40px;"></a>
													    <?php } else { ?>
												      		<a href="<?php echo base_url() . 'product/viewProduct/' . $Catalog[$i]->id; ?>"><img src="<?php echo base_url() . 'Resources/imgs/NoFoto.jpg'; ?>" style="max-width: 100%;display: block;margin: 0 auto;max-height: 40px;"></a>
													    <?php } ?>
													</td>
													<td>
														<a href="<?php echo base_url() . 'product/viewProduct/' . $Catalog[$i]->id; ?>"><?php echo $Catalog[$i]->code; ?></a>
													</td>
													<td>
														<a href="<?php echo base_url() . 'product/viewProduct/' . $Catalog[$i]->id; ?>"><?php echo $Catalog[$i]->integrapp_code; ?></a>
													</td>
													<td>
														<a href="<?php echo base_url() . 'product/viewProduct/' . $Catalog[$i]->id; ?>"><strong><?php echo $Catalog[$i]->name; ?></strong></a>
													</td>
													<td>
														<?php echo $Catalog[$i]->price . '$'; ?>
													</td>
													<td>
														<?php echo $Catalog[$i]->tax; ?>
													</td>
													<td>
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
															<form action="<?php echo base_url() . 'product/setProductStatus/' . $Catalog[$i]->id . "/published"; ?>" id="<?php echo 'publish_' . $Catalog[$i]->id; ?>" style="padding-bottom: 0px;">
																<button type="button" onclick="publishProduct(<?php echo $Catalog[$i]->id; ?>,<?php echo $Catalog[$i]->publishing_cost; ?>)" class="btn btn-primary btn-xs col-md-12 col-sm-12 col-xs-12" form="<?php echo 'publish_' . $Catalog[$i]->id; ?>"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Publicar</button>
															</form>
															<a href="<?php echo base_url() . 'product/setProductStatus/' . $Catalog[$i]->id . "/inactive"; ?>">
																<button type="button" class="btn btn-danger btn-xs col-md-12 col-sm-12 col-xs-12"><span class="glyphicon glyphicon-off" aria-hidden="true"></span> Eliminar</button>
															</a>
														<?php } else if ($Catalog[$i]->status == 'inactive') {?>
															<a href="<?php echo base_url() . 'product/setProductStatus/' . $Catalog[$i]->id . "/active"; ?>">
																<button type="button" class="btn btn-primary btn-xs col-md-12 col-sm-12 col-xs-12"><span class="glyphicon glyphicon-off" aria-hidden="true"></span> Activar</button>
															</a>
														<?php } else if ($Catalog[$i]->status == 'published') {?>
															<form action="<?php echo base_url() . 'product/setProductStatus/' . $Catalog[$i]->id . "/active"; ?>" id="<?php echo 'deactivate_' . $Catalog[$i]->id; ?>">
																<button type="button" onclick="deactivateProduct(<?php echo $Catalog[$i]->id; ?>,<?php echo $Catalog[$i]->publishing_cost; ?>)" class="btn btn-warning btn-xs col-md-12 col-sm-12 col-xs-12"><span class="glyphicon glyphicon-save-file" aria-hidden="true"></span> Despublicar</button>
															</form>
														<?php } ?>
													</td>
												</tr>
											<?php } ?>
										</tbody>
									</table>
								<?php } else { 
									$catalogSize = count($Catalog);
									for ($i=0; $i < $catalogSize; $i++) { ?>
											<div class="col-md-4 col-sm-6 col-xs-12 item-catalogo">
												<div class="well" style="background-color: #FFF;">
													<div class="producto-container" >
												    	<a href="#">
												    	<?php if (count($Catalog[$i]->images)>0) {?>
												      		<a href="<?php echo base_url() . 'product/viewProduct/' . $Catalog[$i]->id; ?>"><img src="<?php echo base_url() . PRODUCT_IMAGES_PATH . $Catalog[$i]->id . "/" . $Catalog[$i]->images[0]; ?>" style="max-width: 100%;display: block;margin: 0 auto;max-height: 200px;"></a>
													    <?php } else { ?>
												      		<a href="<?php echo base_url() . 'product/viewProduct/' . $Catalog[$i]->id; ?>"><img src="<?php echo base_url() . 'Resources/imgs/NoFoto.jpg'; ?>" style="max-width: 100%;display: block;margin: 0 auto;max-height: 200px;"></a>
													    <?php } ?>
													    </a>
													</div>
													<div class="catalogProdName" style="text-align:center;"><strong><a href="<?php echo base_url() . 'product/viewProduct/' . $Catalog[$i]->id; ?>"><?php echo $Catalog[$i]->name; ?></a></strong></div>
													<div class="catalogProdCode" style="text-align:center;"><strong>Código IntegrApp: </strong><a href="<?php echo base_url() . 'product/viewProduct/' . $Catalog[$i]->id; ?>"><?php echo $Catalog[$i]->integrapp_code; ?></a></div>
												</div>
											</div>
									<?php } 
								}?>
								<div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center"> 			
										
									<?php if(isset($pageLinks)) foreach ($pageLinks as $link) {
										echo $link;
									}  ?>
								
				    			</div>
							</div>

						
					