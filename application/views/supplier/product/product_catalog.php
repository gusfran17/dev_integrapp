					
							<?php if (isset($viewMyCatalog)) {?>
										<?php if ($statusFilter == 'published') { ?>
											<h3 style="text-align:center;margin-top: 0px;"><span class="label label-default" style="color:#ffffff;"><b><span class="glyphicon glyphicon-list-alt" aria-hidden="true"> Publicados</span></b></span></h3>
										<?php } else if ($statusFilter == 'active') { ?>
											<h3 style="text-align:center;margin-top: 0px;"><span class="label label-default" style="color:#ffffff;"><b>Activos </b></span><br><small>(No Publicados)</small></h3>
										<?php } else { ?>
											<h3 style="text-align:center;margin-top: 0px;"><span class="label label-default" style="color:#ffffff;"><b><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Eliminados</b></span></h3>
										<?php } ?>
									<?php } ?>
				    		<div class="col-lg-2 col-md-3 col-sm-3 col-xs-4">
				    			<div class="panel panel-info">
				    				<div class="panel-heading">
										<div class="panel-title">
											<form class="searchform" role="search" action="/buscar" method="get" style= "padding-bottom: 0px;">
											  <div class="input-group" class="searchOverSlideshow">
											      <input type="text" name="q" class="form-control">
											      <span class="input-group-btn">
											        <button class="btn btn-info" type="submit"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
											      </span>
											  </div>
											</form>
										</div>
									</div>
				    				<div class="panel-body">
				    					<form method="post" id="catalogCategoriesFilter" action="<?php echo base_url() . 'product/' . (isset($viewMyCatalog)? 'orderMyCatalogBy/': 'orderCatalogBy/') . "$orderBy";?>" style= "padding-bottom: 0px;">
				    						<div class="panel panel-default">
				    							<div class="panel-body">	
													<?php
														if (isset($selectedCategoryId)) {
															echo '<ol class="breadcrumb" style= "margin-bottom: 0; font-size:16px">';
															echo '<li><a href="#" onclick="selectCategory(id);" id="-1"><b>' . (isset($viewMyCatalog)? "MIS PRODUCTOS": "PRODUCTOS") . '</b></a></li>';
															$treeHeight = count($branch);
															//echo var_dump($branch);
															for ($i=$treeHeight-1; $i >= 0; $i--) {
																echo '<li><a href="#" onclick="selectCategory(id);" id="'.$branch[$i]->id.'">'.$branch[$i]->name.'</a></li>';
															}
															echo '</ol>';
														} 
														if (isset($childCategories)) {
															echo '<ul class="nav nav-pills nav-stacked">';
															for ($i=0; $i < count($childCategories); $i++) {
																echo '<li class="" style="padding: 5px 5px 5px 5px;"><a href="#" onclick="selectCategory(id);" id="'. $childCategories[$i]->id . '"><b>'.$childCategories[$i]->name.'</b></a></li>';
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
											<?php if (isset($viewMyCatalog)) {?>
												<div class="panel panel-default" style="padding:0px">
													<div class="panel-heading">
														<div class="panel-title">
															Estado
														</div>
													</div>
													<div class="panel-body" style="padding:0px">
														<ul class="nav nav-pills nav-stacked" type="circle" style="margin: 5px 5px 5px 5px; padding: 5px 5px 5px 5px;">
															<li class="<?php if ($statusFilter == 'published') echo 'active' ?>" ><a href="<?php echo base_url() . 'Product/showPublishedProducts/'; ?>"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> Publicados</a></li>
															<li class="<?php if ($statusFilter == 'active') echo 'active' ?>" ><a href="<?php echo base_url() . 'Product/showActiveProducts'; ?>">Activos</a></li>
															<li class="<?php if ($statusFilter == 'inactive') echo 'active' ?>" ><a href="<?php echo base_url() . 'Product/showInactiveProducts'; ?>"><b style="color:red"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Eliminados</b></a></li>
														</ul>
													</div>
												</div>
											<?php } ?>
											<div class="panel panel-default" style="margin-bottom: 0px;">
												<div class="panel-heading">
													<div class="panel-title">
														Ordenar Catalogo
													</div>
												</div>
												<div class="panel-body" style="padding:0px">
									    			<ul class="nav nav-pills nav-stacked" type="circle" style="margin: 5px 5px 5px 5px; padding: 5px 5px 5px 5px;">
														<?php if (isset($viewMyCatalog)) {?>
															<li class="<?php if ($orderBy == 'category_id') echo 'active' ?>" ><a href="<?php echo base_url() . 'Product/orderMyCatalogBy/category_id'; ?>">Ordenado por Relevancia</a></li>
															<li class="<?php if ($orderBy == 'name') echo 'active' ?>" ><a href="<?php echo base_url() . 'Product/orderMyCatalogBy/name'; ?>">Ordenado Alfabeticamente</a></li>
															<li class="<?php if ($orderBy == 'price desc') echo 'active' ?>" ><a href="<?php echo base_url() . 'Product/orderMyCatalogBy/price desc'; ?>">Ordenado por precios (de mayor a menor)</a> </li>
															<li class="<?php if ($orderBy == 'price asc') echo 'active' ?>" ><a href="<?php echo base_url() . 'Product/orderMyCatalogBy/price asc'; ?>">Ordenado por precios (de menor a mayor)</a> </li>
														<?php } else { ?>
															<li class="<?php if ($orderBy == 'category_id') echo 'active' ?>"><a href="<?php echo base_url() . 'Product/orderCatalogBy/category_id'; ?>">Ordenado por Relevancia</a></li>
															<li class="<?php if ($orderBy == 'name') echo 'active' ?>"><a href="<?php echo base_url() . 'Product/orderCatalogBy/name'; ?>">Ordenado Alfabeticamente</a></li>
															<li class="<?php if ($orderBy == 'price desc') echo 'active' ?>"><a href="<?php echo base_url() . 'Product/orderCatalogBy/price desc'; ?>">Ordenado por precios (de mayor a menor)</a> </li>
															<li class="<?php if ($orderBy == 'price asc') echo 'active' ?>"><a href="<?php echo base_url() . 'Product/orderCatalogBy/price asc'; ?>">Ordenado por precios (de menor a mayor)</a> </li>
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
											echo '<ol class="breadcrumb" style="font-size:16px">';
											echo '<li><a href="#" onclick="selectCategory(id);" id="-1"><b>' . (isset($viewMyCatalog)? "MIS PRODUCTOS": "PRODUCTOS") . '</b></a></li>';
											$treeHeight = count($branch);
											for ($i=$treeHeight-1; $i >= 0; $i--) {
												echo '<li><a href="#" onclick="selectCategory(id);" id="'.$branch[$i]->id.'">'.$branch[$i]->name.'</a></li>';
											}
											echo '</ol>';
										}  
					    			?>					
				    			</div>
								<?php if (isset($viewMyCatalog)) {?>
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
													</td>
													<td>
														<a href="<?php echo base_url() . 'product/editCatalogProduct/' . $Catalog[$i]->id; ?>">
															<button type="button" class="btn btn-success btn-xs col-md-12 col-sm-12 col-xs-12"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Editar</button>
														</a>
														<?php if ($Catalog[$i]->status == 'active') {?>
															<a href="<?php echo base_url() . 'product/setProductStatus/' . $Catalog[$i]->id . "/published"; ?>">
																<button type="button" class="btn btn-primary btn-xs col-md-12 col-sm-12 col-xs-12"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Publicar</button>
															</a>
															<a href="<?php echo base_url() . 'product/setProductStatus/' . $Catalog[$i]->id . "/inactive"; ?>">
																<button type="button" class="btn btn-warning btn-xs col-md-12 col-sm-12 col-xs-12"><span class="glyphicon glyphicon-off" aria-hidden="true"></span> Eliminar</button>
															</a>
														<?php } else if ($Catalog[$i]->status == 'inactive') {?>
															<a href="<?php echo base_url() . 'product/setProductStatus/' . $Catalog[$i]->id . "/active"; ?>">
																<button type="button" class="btn btn-primary btn-xs col-md-12 col-sm-12 col-xs-12"><span class="glyphicon glyphicon-off" aria-hidden="true"></span> Activar</button>
															</a>
														<?php } else if ($Catalog[$i]->status == 'published') {?>
															<a href="<?php echo base_url() . 'product/setProductStatus/' . $Catalog[$i]->id . "/active"; ?>">
																<button type="button" class="btn btn-warning btn-xs col-md-12 col-sm-12 col-xs-12"><span class="glyphicon glyphicon-save-file" aria-hidden="true"></span> Despublicar</button>
															</a>
															<a href="<?php echo base_url() . 'product/setProductStatus/' . $Catalog[$i]->id . "/inactive"; ?>">
																<button type="button" class="btn btn-danger btn-xs col-md-12 col-sm-12 col-xs-12"><span class="glyphicon glyphicon-off" aria-hidden="true"></span> Eliminar</button>
															</a>
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

						
					