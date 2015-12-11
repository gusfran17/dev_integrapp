<?php if (isset($hasSidebar)) { ?>
	<div class="collapse navbar-collapse navbar-inverse navbar-ex1-collapse">
		<ul class="nav navbar-nav side-nav" style="padding-top:0px;">
    		<b>								
		    	<?php	
		    		echo '<h4 style="margin-left: 15px;"><span class="label label-default" style="color:#ffffff; background-color:#D17749"><a href="#" onclick="selectCategory(id);" id="-1" style="color:#ffffff;"><b>'.(isset($viewMyCatalog)? "MIS PRODUCTOS": "PRODUCTOS").'</b></a></span></h4>';
		    		if (isset($selectedCategoryId)) {								
						$treeHeight = count($branch);
						for ($i=$treeHeight-1; $i >= 0; $i--) {
							echo '<h4 style="margin-left: 15px;"><span class="label label-default" style="color:#ffffff;"><a href="#" onclick="selectCategory(id);" id="'.$branch[$i]->id.'" style="padding-left:' . (($treeHeight-1-$i)*10) . 'px; color:#ffffff;"><span class="glyphicon glyphicon-play" aria-hidden="true"></span> '.$branch[$i]->name.'</a></span></h4>';
						}
					}
				?> 
			</b>
			<?php
				if (isset($childCategories)) {
					if (!(isset($treeHeight))) $treeHeight = 1;
					for ($i=0; $i < count($childCategories); $i++) {
						echo '<li style="padding-left:'.(($treeHeight*10)+15).'px"><a href="#" class="subcategories" onclick="selectCategory(id);" id="'. $childCategories[$i]->id . '"><b> <span class="glyphicon glyphicon-play" aria-hidden="true"></span> '.$childCategories[$i]->name.'</b></a></li>';
					}
				} 
			?>
			<form method="post" id="catalogCategoriesFilter" action="<?php echo base_url() . 'Suppliers/viewSupplierCatalog/' . $orderBy;?>" style= "padding-bottom: 0px;">
				<input type="hidden" id="hasSidebar" value="true">
				<input type="text" id="selectedCategoryId" name="selectedCategoryId">
			</form>
			<script type="text/javascript">
				$('#selectedCategoryId').hide();
				function selectCategory(selectedCategoryId) {
					var catId = selectedCategoryId;
					$('#selectedCategoryId').attr('value',catId);
					$('#catalogCategoriesFilter').submit();
				}
				function publishProduct(selectedProductId, publishingCost) {
					var productId = selectedProductId;
					if (window.confirm("¡Atención! Al publicar este producto se le descontarán " + publishingCost + "$ de su crédito")){
						$('#publish_' + productId).submit();	
					}
				}
				function deactivateProduct(selectedProductId, publishingCost) {
					var productId = selectedProductId;
					if (window.confirm("¡Atención! Si despublica este producto, deberá pagar nuevamente el costo de publicación cuando desee publicarlo. (costo: " + publishingCost + ")")){
						$('#deactivate_' + productId).submit();	
					}
				}
			</script>				
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#orderBy" style="padding-top:20px;"><i class="fa fa-fw fa-arrows-v"></i><b> Ordenar </b><i class="fa fa-fw fa-caret-down"></i></a>
				<ul class="collapse nav nav-pills nav-stacked" type="circle" id="orderBy">
					<li class="<?php if ($orderBy == 'published_date desc') echo 'active' ?>" ><a href="<?php echo base_url() . 'Suppliers/viewSupplierCatalog/published_date desc'; ?>">Ordenado por fecha de publicación</a></li>
					<li class="<?php if ($orderBy == 'name') echo 'active' ?>" ><a href="<?php echo base_url() . 'Suppliers/viewSupplierCatalog/name'; ?>">Ordenado Alfabeticamente</a></li>
					<?php if (($supplier->associationStatus == 'approved')or(isset($itIsMe))) {?>
                        <li class="<?php if ($orderBy == 'price desc') echo 'active' ?>" ><a href="<?php echo base_url() . 'Suppliers/viewSupplierCatalog/price desc'; ?>">Ordenado por precios (de mayor a menor)</a> </li>
						<li class="<?php if ($orderBy == 'price asc') echo 'active' ?>" ><a href="<?php echo base_url() . 'Suppliers/viewSupplierCatalog/price asc'; ?>">Ordenado por precios (de menor a mayor)</a> </li>
                    <?php } ?>
				</ul>
            </li>
		</ul>

	</div>
</nav>
<?php }?>



<div id="page-wrapper" style="margin-top: 70px;">
	<?php if ((isset($itIsMe)or($supplier->associationStatus == true) or($loadInfo->isDistributorFivesRule == true))) {?>
		<div class="container-fluid" id="main-products">
			<div class="container" id="supplier-products" >
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="col-lg-8 col-md-10 col-sm-10 col-xs-12">
						<div class="panel panel-default pnlSupplier" style="margin-top: 20px; border-radius: 20px;">    
							<div class="panel-body">
						    	<div class="col-md-4 col-sm-4 col-xs-4" style="text-align: center">
							    	<?php if(isset($supplier->logo)) {?>
							      		<img src="<?php echo base_url() . $supplier->logo; ?>" style="max-width: 100%;display: block;margin: 0 auto;max-height: 100px;">
								    <?php } else { ?>
								    	<img src="<?php echo base_url() . IMAGES_PATH . 'noProfilePic.jpg'; ?>" style="max-width: 100%;display: block;margin: 0 auto;max-height: 100px;">
								    <?php } ?>
									<h4 style="height: 2em; margin-top: 10px;"><a href="<?php echo base_url() . 'Suppliers/viewSupplier/'. $supplier->id;?>"><?php echo $supplier->fake_name; ?></a></h4>
									<p class="text-info" style="margin-left: auto; height: 15px;text-align: left;">
										<a href="<?php echo base_url() . 'Suppliers/viewSupplier/'. $supplier->id;?>"><span class="glyphicon glyphicon-th-large" aria-hidden="true"></span> Detalles de perfil </a>
									</p>
			                        <?php if (($supplier->associationStatus != 'approved') and ($watchingRole == 'distributor')) {?>
										<p style="margin-top:20;text-align: left;">
											<a href="<?php echo base_url() . 'suppliers/setSupplierDistributorStatus/' . $supplier->id;?>"><span class="glyphicon glyphicon-share" aria-hidden="true"></span> Reenviar solicitud de adhesión</a>
										</p>
				                    <?php } ?>
									<p style="margin-top:20;text-align: left;">
										<a href="<?php echo base_url(); ?>suppliers"><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span><b> Mayoristas</b></a>
									</p>
								</div>
								<div class="col-md-8 col-sm-8 col-xs-8">
							    	<p><b>Razón Social: </b><?php echo $supplier->razon_social;?></p>
							    	<p><b>CUIT: </b><?php echo $supplier->cuit;?></p>
							    	<p><b>Email: </b><?php echo $supplier->comercial_email;?></p>
							    	<p><b>Dirección: </b><?php echo $supplier->commercial_address;?></p>
							    	<p><b>Telefono de Contacto: </b><?php echo $supplier->contact_phone;?></p>
									<p><b>Fax: </b><?php echo $supplier->fax;?></p>
									<?php if (($supplier->associationStatus == true)) { ?>
										<p><b>Descuento ofrecido: </b><?php echo $supplier->associationDiscount;?>%</p>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>	
			<div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px;">
				<div class="col-md-12 col-sm-12 col-xs-12">		
					<?php
						echo '<ol class="breadcrumb" style= "margin-bottom: 5px; font-size:16px">';
						echo '<li><a href="#" onclick="selectCategory(id);" id="-1"><b><i class="fa fa-fw fa-table"></i> PRODUCTOS DEL MAYORISTA </b></a></li>';
						if (isset($selectedCategoryId)) {
							$treeHeight = count($branch);
							for ($i=$treeHeight-1; $i >= 0; $i--) {
								echo '<li><a href="#" onclick="selectCategory(id);" id="'.$branch[$i]->id.'">'.$branch[$i]->name.'</a></li>';
							}
						}  
						echo '</ol>';
					?>					
				</div>
				<table id="resultset" class="table table-bordered table-striped">
	                <thead>
	                    <tr>
	                        <th data-class="expand">Imagen</th>
	                        <th>Código de Producto</th>
							<th>Código IntegrApp</th>
	                        <th data-hide="phone">Producto</th>
	                        <?php if (($supplier->associationStatus == 'approved')or(isset($itIsMe)or($supplier->associationStatus == true))) {?>
		                        <th class="centered-cell" data-hide="phone,tablet">Precio (sin IVA)</th>
		                        <th class="centered-cell" data-hide="phone,tablet">IVA</th>
	                        <?php } ?>
	                        <th class="centered-cell" data-hide="phone,tablet">Descripción</th>
	                        <?php if (($supplier->associationStatus == 'approved') or ($supplier->associationStatus == true)) {?>
		                        <th class="centered-cell" data-hide="phone,tablet">Acciones</th>
		                    <?php } ?>
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
								<?php if ((isset($itIsMe)) or ($supplier->associationStatus == true)) { ?>
									<td>
										<?php echo '$'.number_format(($Catalog[$i]->price - (($Catalog[$i]->price*$supplier->associationDiscount)/100)), PRICE_DECIMAL_AMOUNT, DECIMAL_SEPARATOR, THOUSANDS_SEPARATOR); ?>
									</td>
									<td>
										<?php echo $Catalog[$i]->tax; ?>
									</td>
								<?php } ?>
								<td>
									<?php echo $Catalog[$i]->description; ?>
									<br>
									<br>
									<b>Categoria: </b><?php echo $Catalog[$i]->categoryPath; ?>
								</td>
								<?php if (($supplier->associationStatus == 'approved') or ($supplier->associationStatus == true)) {?>
									<td>
									<?php if ($Catalog[$i]->isCatalogItem == false){ ?>
										<?php if ($watchingRole == 'distributor') {?>
											<a href="<?php echo base_url() . 'Product/addProductToDistributorCatalog/'. $Catalog[$i]->id;?>">
												<button type="button" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> Agregar a mi Catálogo</button>
											</a>
										<?php } else if ($watchingRole == 'supplier') {?>
											<?php if ($watchingRoleId != $Catalog[$i]->supplier_id) {?>
												<?php if ($supplier->associationStatus) {?>
													<form action="<?php echo base_url() . 'product/addProductToSupplierCatalog/' . $Catalog[$i]->id; ?>" method="post" id="<?php echo 'addToSecSuppCat_' . $Catalog[$i]->id; ?>" style="padding-bottom: 0px;">
														<div class="dropdown" style="margin-bottom: 10px; max-width:300px;">
															<button class="btn btn-info btn-xs dropdown-toggle" type="button" id="addToCatalogDropDown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" style="min-width: 170px;">
																<span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> 
																Agregar a mi Catálogo
																<span class="caret"></span>
															</button>
															<ul class="dropdown-menu" aria-labelledby="suppliersDropDown" style="max-width:300px;">
																<li><a style="max-width:300px;">
																		El mayorista le ofrece un <b><?php echo $supplier->associationDiscount;?>%</b> <br>
																		de descuento sobre sus productos<br>
																</a></li>
																<li><a><b>Precio final: $<?php echo number_format((($Catalog[$i]->price)-((($supplier->associationDiscount)*($Catalog[$i]->price))/100)), PRICE_DECIMAL_AMOUNT, DECIMAL_SEPARATOR, THOUSANDS_SEPARATOR);?></b><br><br></a></li>
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
													No esta asociado a este mayorista.
												<?php } ?>	
											<?php } else { ?>
												Usted es mayorista principal de este producto
											<?php } ?>
										<?php } ?>
									<?php } else {?>
										<?php if ($watchingRole == 'distributor') {?>
											<a href="<?php echo base_url() . 'Product/removeProductFromDistributorCatalog/'. $Catalog[$i]->id;?>">
												<button type="button" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span> Remover de mi Catálogo</button>
											</a>
										<?php } else if ($watchingRole == 'supplier') {?>
											<form action="<?php echo base_url() . 'product/removeProductFromSupplierCatalog/' . $Catalog[$i]->id; ?>" id="<?php echo 'removeFromSecSuppCat_' . $Catalog[$i]->id; ?>" style="padding-bottom: 0px;">
												<button type="submit" onclick="" class="btn btn-danger btn-xs" style="min-width: 170px;" form="<?php echo 'removeFromSecSuppCat_' . $Catalog[$i]->id; ?>"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Remover de mi Catálogo</button>
											</form>
										<?php } ?>
									<?php } ?>
									</td>
								<?php } ?>
							</tr>
						<?php } ?>
					</tbody>
				</table>
				<div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center"> 			
						
					<?php if(isset($pageLinks)) foreach ($pageLinks as $link) {
						echo $link;
					}  ?>
				
				</div>

			</div>
		</div>	
	<?php } ?>
</div>
