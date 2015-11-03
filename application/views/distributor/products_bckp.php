<?php if (!(isset($productLoadView))) { ?>
	<div class="collapse navbar-collapse navbar-inverse navbar-ex1-collapse">
		<ul class="nav navbar-nav side-nav" style="padding-top:0px;">
			<form class="navbar-form navbar-left" role="search" action="/buscar" method="get">
				<div class="input-group" style="padding-top:20px;" class="searchOverSlideshow">
			    	<input type="text" name="searchSupplierCatalog" class="form-control" placeholder="Buscar">
			    	<span class="input-group-btn">
			        	<button class="btn btn-info" type="submit"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
			    	</span>
			  	</div>
	    	</form>

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
			<form method="post" id="catalogCategoriesFilter" action="<?php echo base_url() . 'product/' . (isset($viewMyCatalog)? 'orderMyDistributorCatalogBy/': 'orderDistributorCatalogBy/') . "$orderBy";?>" style= "padding-bottom: 0px;">
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
					<?php if (isset($viewMyCatalog)) {?>
						<li class="<?php if ($orderBy == 'category_id') echo 'active' ?>" ><a href="<?php echo base_url() . 'Product/orderMyDistributorCatalogBy/category_id'; ?>">Ordenado por Relevancia</a></li>
						<li class="<?php if ($orderBy == 'supplier_id') echo 'active' ?>"><a href="<?php echo base_url() . 'Product/orderMyDistributorCatalogBy/supplier_id'; ?>">Ordenado por Proveedor</a></li>
						<li class="<?php if ($orderBy == 'name') echo 'active' ?>" ><a href="<?php echo base_url() . 'Product/orderMyDistributorCatalogBy/name'; ?>">Ordenado Alfabeticamente</a></li>
						<li class="<?php if ($orderBy == 'price desc') echo 'active' ?>" ><a href="<?php echo base_url() . 'Product/orderMyDistributorCatalogBy/price desc'; ?>">Ordenado por precios (de mayor a menor)</a> </li>
						<li class="<?php if ($orderBy == 'price asc') echo 'active' ?>" ><a href="<?php echo base_url() . 'Product/orderMyDistributorCatalogBy/price asc'; ?>">Ordenado por precios (de menor a mayor)</a> </li>
					<?php } else { ?>
						<li class="<?php if ($orderBy == 'category_id') echo 'active' ?>"><a href="<?php echo base_url() . 'Product/orderDistributorCatalogBy/category_id'; ?>">Ordenado por Relevancia</a></li>
						<li class="<?php if ($orderBy == 'supplier_id') echo 'active' ?>"><a href="<?php echo base_url() . 'Product/orderDistributorCatalogBy/supplier_id'; ?>">Ordenado por Proveedor</a></li>
						<li class="<?php if ($orderBy == 'name') echo 'active' ?>"><a href="<?php echo base_url() . 'Product/orderDistributorCatalogBy/name'; ?>">Ordenado Alfabeticamente</a></li>
						<li class="<?php if ($orderBy == 'price desc') echo 'active' ?>"><a href="<?php echo base_url() . 'Product/orderDistributorCatalogBy/price desc'; ?>">Ordenado por precios (de mayor a menor)</a> </li>
						<li class="<?php if ($orderBy == 'price asc') echo 'active' ?>"><a href="<?php echo base_url() . 'Product/orderDistributorCatalogBy/price asc'; ?>">Ordenado por precios (de menor a mayor)</a> </li>
					<?php } ?>
				</ul>
            </li>
		</ul>

	</div>
</nav>
<?php }?>

<div id="page-wrapper" >
	<div class="container-fluid" id="main-products">	
  		<div class="col-md-12 col-sm-12 col-xs-12">		
			<?php
				echo '<ol class="breadcrumb" style="margin-bottom: 5px; font-size:16px">';
				echo '<li><a href="#" onclick="selectCategory(id);" id="-1"><b><i class="fa fa-fw fa-table"></i> ' . (isset($viewMyCatalog)? "MIS PRODUCTOS": "PRODUCTOS") . '</b></a></li>';
				if (isset($selectedCategoryId)) {
					$treeHeight = count($branch);
					for ($i=$treeHeight-1; $i >= 0; $i--) {
						echo '<li><a href="#" onclick="selectCategory(id);" id="'.$branch[$i]->id.'">'.$branch[$i]->name.'</a></li>';
					}
				}  
				echo '</ol>';
			?>					
		</div>
		<div role="tabpanel">  
			<ul class="nav nav-pills" role="tablist" style="padding: 5px 5px 5px 5px;">
				<li role="presentation" class="<?php if (!(isset($viewMyCatalog))) echo 'active'?>"><a href="<?php echo base_url() . 'Product/products'; ?>"><b><span class="glyphicon glyphicon-list" aria-hidden="true"></span> Catalogo</b></a></li>
			    <li role="presentation" class="<?php if (isset($viewMyCatalog)) echo 'active'?>"><a href="<?php echo base_url() . 'Product/myProducts'; ?>"><b><span class="glyphicon glyphicon-list" aria-hidden="true"></span> Mi Catalogo</b></a></li>
			</ul>
		</div>  
		<?php if($this->session->flashdata('success') != null):?>
			<div class="alert alert-dismissable alert-success col-md-12 col-sm-12 col-xs-12">
				<button type="button" class="close" data-dismiss="alert"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
				<strong><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span></strong>
			 	<strong>Bien!</strong> <?php echo $this->session->flashdata('success'); ?></a>
			</div>
		  <?php endif;?>
		  <?php if($this->session->flashdata('error') != null):?>
			<div class="alert alert-dismissable alert-danger col-md-12 col-sm-12 col-xs-12">
				<button type="button" class="close" data-dismiss="alert"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
				<strong><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span></strong>
			 	<strong>Atención!</strong> <?php echo $this->session->flashdata('error'); ?></a>
			</div>
		  <?php endif;?>
		<div class="tab-content">
		    <div role="tabpanel" class="tab-pane fade active in" id="catalog">
				<div class="row" style="padding: 10px 10px 10px 10px;">
					<div class="panel panel-primary col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-top: 15px;">
						<div class="col-lg-10 col-md-9 col-sm-9 col-xs-8">
							<table id="resultset" class="table table-bordered table-striped">
				                <thead>
				                    <tr>
				                        <th data-class="expand">Imagen</th>
				                        <th>Código de Producto</th>
										<th>Código IntegrApp</th>
				                        <th data-hide="phone">Producto</th>
				                        <th class="centered-cell" data-hide="phone,tablet">IVA</th>
				                        <th class="centered-cell visible-md-* visible-lg-*" data-hide="phone,tablet">Proveedores</th>
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
												<a href="<?php echo base_url() . 'product/viewProduct/' . $Catalog[$i]->id; ?>">
													<strong><?php echo $Catalog[$i]->name; ?></strong>
												</a>
												<br>
												<b>Categoria: </b><?php echo $Catalog[$i]->categoryPath; ?>

											</td>
											<td>
												<?php echo $Catalog[$i]->tax; ?>
											</td>
											<td>
												<div class="dropdown" style="margin-bottom: 10px;">
													<button class="btn btn-info btn-xs dropdown-toggle" type="button" id="suppliersDropDown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
														<?php echo $Catalog[$i]->primarySupplier->fake_name; ?>
														<?php if (isset($Catalog[$i]->primarySupplier->price)){ 
																echo " $".$Catalog[$i]->primarySupplier->price;
														}?>
														<span class="caret"></span>
													</button>
													<ul class="dropdown-menu" aria-labelledby="suppliersDropDown">
														<li class="dropdown-header">Proveedor Principal</li>
														<li><a href="<?php echo base_url() . 'Suppliers/viewSupplier/'. $Catalog[$i]->primarySupplier->id;?>">
														<?php if(isset($Catalog[$i]->primarySupplier->logo)){ ?>
						     								<img src="<?php echo base_url() . $Catalog[$i]->primarySupplier->logo; ?>" style="height: 20px">
						     							<?php } else { ?>
						     								<img src="<?php echo base_url() . IMAGES_PATH . 'noProfilePic.jpg'; ?>" style="height: 20px">
														<?php } ?>
															<?php echo $Catalog[$i]->primarySupplier->fake_name; ?>
															<?php if (isset($Catalog[$i]->primarySupplier->price)){ 
																echo "(lo vende a $".$Catalog[$i]->primarySupplier->price.")";
															} else {
																echo "(no esta asociado)";	
															}?></a>
														</li>
														<li role="separator" class="divider"></li>
														<li class="dropdown-header">Proveedores secundarios que lo redistribuyen</li>
														<?php foreach ($Catalog[$i]->secondarySuppliers as $secSupplier) { ?>
															<li><a href="<?php echo base_url() . 'Suppliers/viewSupplier/'. $secSupplier->id;?>">
															<?php if(isset($secSupplier->logo)){ ?>
							     								<img src="<?php echo base_url() . $secSupplier->logo; ?>" style="height: 20px">
							     							<?php } else { ?>
							     								<img src="<?php echo base_url() . IMAGES_PATH . 'noProfilePic.jpg'; ?>" style="height: 20px">
															<?php } ?>
																<?php echo $secSupplier->fake_name; ?> 
																<?php if (isset($secSupplier->price)) { 
																	echo "(lo vende a $".$secSupplier->price.")";
																} else {
																	echo "(no esta asociado)";	
																}?></a>

															</li>
														<?php }?>
													</ul>
												</div>
											</td>
											<td style="text-align:center;">
												<?php if($Catalog[$i]->associationStatus == 'approved'){ ?>
													<?php if ($Catalog[$i]->isCatalogItem == false){ ?>
														<a href="<?php echo base_url() . 'Product/addProductToDistributorCatalog/'. $Catalog[$i]->id;?>">
															<button type="button" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> Agregar a mi Catálogo</button>
														</a>
													<?php } else {?>
														<a href="<?php echo base_url() . 'Product/removeProductFromDistributorCatalog/'. $Catalog[$i]->id;?>">
															<button type="button" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span> Remover de mi Catálogo</button>
														</a>
													<?php } ?>
												<?php } else {?>
													<?php echo NOT_ASSOCIATED_MESSAGE; ?>
												<?php }?>
											</td>
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
				</div>
			</div>
		</div>
	</div>
</div>
