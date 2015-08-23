<section id="home" >
	<div class="container-fluid" id="main-products">
		<div class="page-header" style="text-align:center; margin: 0px 0 0px;">
			<h2><span class="label label-default" style="color:#ffffff;"><b>PRODUCTOS</b></span></h2>
		</div>
		<div role="tabpanel">  
			<ul class="nav nav-pills" role="tablist" style="padding: 5px 5px 5px 5px;">
				<li role="presentation" class="<?php if (!(isset($viewMyCatalog))) echo 'active'?>"><a href="<?php echo base_url() . 'Product/products'; ?>"><b><span class="glyphicon glyphicon-list" aria-hidden="true"></span> Catalogo</b></a></li>
			    <li role="presentation" class="<?php if (isset($viewMyCatalog)) echo 'active'?>"><a href="<?php echo base_url() . 'Product/myProducts'; ?>"><b><span class="glyphicon glyphicon-list" aria-hidden="true"></span> Mi Catalogo</b></a></li>
			</ul>
		</div>  
		<div class="tab-content">
		    <div role="tabpanel" class="tab-pane fade active in" id="catalog">
				<div class="row" style="padding: 10px 10px 10px 10px;">
					<div class="panel panel-primary col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-top: 15px;">
						<div class="col-lg-2 col-md-3 col-sm-3 col-xs-4">
			    			<div class="panel panel-info">
			    				<div class="panel-heading">
									<div class="panel-title">
										<form class="searchform" role="search" action="/buscar" method="get" style= "padding-bottom: 0px;">
										  <div class="input-group" class="searchOverSlideshow">
										      <input type="text" name="search" class="form-control">
										      <span class="input-group-btn">
										        <button class="btn btn-info" type="submit"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
										      </span>
										  </div>
										</form>
									</div>
								</div>
			    				<div class="panel-body">
			    					<form method="post" id="catalogCategoriesFilter" action="<?php echo base_url() . 'product/' . (isset($viewMyCatalog)? 'orderMyDistributorCatalogBy/': 'orderDistributorCatalogBy/') . "$orderBy";?>" style= "padding-bottom: 0px;">
			    						<div class="panel panel-default">
			    							<div class="panel-body">	
												<?php
													if (isset($selectedCategoryId)) {
														echo '<ol class="breadcrumb" style= "margin-bottom: 0;">';
														echo '<li><a href="#" onclick="selectCategory(id);" id="-1"><b>' . (isset($viewMyCatalog)? "MIS PRODUCTOS": "PRODUCTOS") . '</b></a></li>';
														$treeHeight = count($branch);
														//echo var_dump($branch);
														for ($i=$treeHeight-1; $i >= 0; $i--) {
															echo '<li><a href="#" onclick="selectCategory(id);" id="'.$branch[$i]->id.'">'.$branch[$i]->name.'</a></li>';
														}
														echo '</ol>';
													} 
													if (isset($childCategories)) {
														echo '<ul>';
														for ($i=0; $i < count($childCategories); $i++) {
															echo '<li><a href="#" onclick="selectCategory(id);" id="'. $childCategories[$i]->id . '">'.$childCategories[$i]->name.'</a></li>';
														}
														echo '</ul>';
													} 
												?>
											
												<input type="text" id="selectedCategoryId" name="selectedCategoryId">
												<script type="text/javascript">
													$('#selectedCategoryId').hide();
													function selectCategory(selectedCategoryId) {
														var catId = selectedCategoryId;
														$('#selectedCategoryId').attr('value',catId);
														$('#catalogCategoriesFilter').submit();
													}
												</script>												
											</div>
										</div>
										<div class="panel panel-default" style="margin-bottom: 0px;">
											<div class="panel-heading">
												<div class="panel-title">
													Ordenar Catalogo
												</div>
											</div>
											<div class="panel-body" style="padding:0px">
								    			<ul class="nav nav-pills nav-stacked" type="circle" style="margin: 5px 5px 5px 5px; padding: 5px 5px 5px 5px;">
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
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>


						<div class="col-lg-10 col-md-9 col-sm-9 col-xs-8">
			      			<div class="col-md-12 col-sm-12 col-xs-12">		
				    			<?php
    								if (isset($selectedCategoryId)) {
										echo '<ol class="breadcrumb">';
										echo '<li><a href="#" onclick="selectCategory(id);" id="-1"><b>' . (isset($viewMyCatalog)? "MIS PRODUCTOS": "PRODUCTOS") . '</b></a></li>';
										$treeHeight = count($branch);
										for ($i=$treeHeight-1; $i >= 0; $i--) {
											echo '<li><a href="#" onclick="selectCategory(id);" id="'.$branch[$i]->id.'">'.$branch[$i]->name.'</a></li>';
										}
										echo '</ol>';
									}  
				    			?>					
			    			</div>
							<table id="resultset" class="table table-bordered table-striped">
				                <thead>
				                    <tr>
				                        <th data-class="expand">Imagen</th>
				                        <th>Código de Producto</th>
										<th>Código IntegrApp</th>
				                        <th data-hide="phone">Producto</th>
				                        <th class="centered-cell" data-hide="phone,tablet">Precio</th>
				                        <th class="centered-cell" data-hide="phone,tablet">IVA</th>
				                        <th class="centered-cell visible-md-* visible-lg-*" data-hide="phone,tablet">Proveedor</th>
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
												<?php if ($Catalog[$i]->associationStatus == 'approved') echo ($Catalog[$i]->price - (($Catalog[$i]->price*$Catalog[$i]->associationDiscount)/100)) . '$'; else echo $Catalog[$i]->price; ?>
											</td>
											<td>
												<?php echo $Catalog[$i]->tax; ?>
											</td>
											<td>
												<a href="<?php echo base_url() . 'Suppliers/viewSupplier/'. $Catalog[$i]->supplier_id;?>"><?php echo $Catalog[$i]->supplier_fakename; ?></a>
											</td>
											<td>
												<?php if($Catalog[$i]->associationStatus == 'approved'){ ?>
													<?php if ($Catalog[$i]->isCatalogItem == false){ ?>
														<a href="<?php echo base_url() . 'Product/addProductToCatalog/'. $Catalog[$i]->id;?>">
															<button type="button" class="btn btn-success btn-xs">Agregar a mi Catálogo</button>
														</a>
													<?php } else {?>
														<a href="<?php echo base_url() . 'Product/removeProductFromCatalog/'. $Catalog[$i]->id;?>">
															<button type="button" class="btn btn-danger btn-xs">Remover de mi Catálogo</button>
														</a>
													<?php } ?>		
												<?php } else {?>
													<p><span class="label label-info" style="color:#ffffff;"><b><?php echo NOT_ASSOCIATED_MESSAGE; ?></b><span></p>
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
</section>