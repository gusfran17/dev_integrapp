					
						
				    		<div class="col-md-2 col-sm-2 col-xs-4">
				    			<div class="panel panel-info">
				    				<div class="panel-heading">
										<div class="panel-title">
											<form class="searchform" role="search" action="/buscar" method="get" style= "padding-bottom: 0px;">
											  <div class="input-group" class="searchOverSlideshow">
											      <input type="text" name="q" class="form-control">
											      <span class="input-group-btn">
											        <button class="btn btn-info" type="submit">Buscar</button>
											      </span>
											  </div>
											</form>
										</div>
									</div>
				    				<div class="panel-body">
				    					<div class="panel panel-default">
											<form method="post" id="catalogCategoriesFilter" action="<?php echo base_url() . 'product/' . (isset($viewMyCatalog)? 'orderMyCatalogBy/': 'orderCatalogBy/') . "$orderBy";?>" style= "padding-bottom: 0px;">
												<?php
													if (isset($selectedCategoryId)) {
														echo '<ol class="breadcrumb" style= "margin-bottom: 0;">';
														echo '<li><a href="#" onclick="selectCategory(id);" id="-1"><b>PRODUCTOS</b></a></li>';
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
														console.log("hola");
														$('#selectedCategoryId').attr('value',catId);
														$('#catalogCategoriesFilter').submit();
													}
												</script>												
											</form>
										</div>
									
										<div class="panel panel-default" style="margin-bottom: 0px;">
											<div class="panel-heading">
												<div class="panel-title">
													Ordenar Catalogo
												</div>
											</div>
							    			<ul class="nav nav-pills nav-stacked" type="circle" style="margin: 5px 5px 5px 5px; padding: 5px 5px 5px 5px;">
												<?php if (isset($viewMyCatalog)) {?>
													<li class="<?php if ($orderBy == 'category_id') echo 'active' ?>" ><a href="<?php echo base_url() . 'Product/orderMyCatalogBy/category_id'; ?>">Ordenado por categorias</a></li>
													<li class="<?php if ($orderBy == 'name') echo 'active' ?>" ><a href="<?php echo base_url() . 'Product/orderMyCatalogBy/name'; ?>">Ordenado por nombre</a></li>
													<li class="<?php if ($orderBy == 'price desc') echo 'active' ?>" ><a href="<?php echo base_url() . 'Product/orderMyCatalogBy/price desc'; ?>">Ordenado por precios (de mayor a menor)</a> </li>
													<li class="<?php if ($orderBy == 'price asc') echo 'active' ?>" ><a href="<?php echo base_url() . 'Product/orderMyCatalogBy/price asc'; ?>">Ordenado por precios (de menor a mayor)</a> </li>
												<?php } else { ?>
													<li class="<?php if ($orderBy == 'category_id') echo 'active' ?>"><a href="<?php echo base_url() . 'Product/orderCatalogBy/category_id'; ?>">Ordenado por categorias</a></li>
													<li class="<?php if ($orderBy == 'name') echo 'active' ?>"><a href="<?php echo base_url() . 'Product/orderCatalogBy/name'; ?>">Ordenado por nombre</a></li>
													<li class="<?php if ($orderBy == 'price desc') echo 'active' ?>"><a href="<?php echo base_url() . 'Product/orderCatalogBy/price desc'; ?>">Ordenado por precios (de mayor a menor)</a> </li>
													<li class="<?php if ($orderBy == 'price asc') echo 'active' ?>"><a href="<?php echo base_url() . 'Product/orderCatalogBy/price asc'; ?>">Ordenado por precios (de menor a mayor)</a> </li>
												<?php } ?>
											</ul>
										</div>
									</div>
								</div>
							</div>
				    		<div class="col-md-10 col-sm-10 col-xs-8">
				      			<div class="col-md-12 col-sm-12 col-xs-12">		
					    			<?php
	    								if (isset($selectedCategoryId)) {
											echo '<ol class="breadcrumb" style= "margin-bottom: 0;">';
											echo '<li><a href="#" onclick="selectCategory(id);" id="-1"><b>PRODUCTOS</b></a></li>';
											$treeHeight = count($branch);
											for ($i=$treeHeight-1; $i >= 0; $i--) {
												echo '<li><a href="#" onclick="selectCategory(id);" id="'.$branch[$i]->id.'">'.$branch[$i]->name.'</a></li>';
											}
											echo '</ol>';
										}  
					    			?>					
				    			</div>
						
								<?php 
								$catalogSize = count($Catalog);
								for ($i=0; $i < $catalogSize; $i++) { ?>
									<div class="col-md-4 col-sm-6 col-xs-12 item-catalogo">
										<div class="well" style="background-color: #FFF;">
											<div class="producto-container" >
										    	<a href="#">
										    	<?php if (count($Catalog[$i]->images)>0) {?>
										      		<img src="<?php echo base_url() . PRODUCT_IMAGES_PATH . $Catalog[$i]->id . "/" . $Catalog[$i]->images[0]; ?>" style="max-width: 100%;display: block;margin: 0 auto;max-height: 200px;">
											    <?php } else { ?>
										      		<img src="<?php echo base_url() . 'Resources/imgs/NoFoto.jpg'; ?>" style="max-width: 100%;display: block;margin: 0 auto;max-height: 200px;">
											    <?php } ?>
											    </a>
											</div>
											<div style="text-align:center;"> <strong><?php echo $Catalog[$i]->name; ?></strong></div>
											<div style="text-align:center;"><strong>Código IntegrApp: </strong><?php echo $Catalog[$i]->integrapp_code; ?></div>
											<div style="text-align:center;"><strong>Precio: </strong><?php echo $Catalog[$i]->price . '$'; ?></div>
										</div>
									</div>
								<?php } ?>
								<div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center"> 			
										
									<?php if(isset($pageLinks)) foreach ($pageLinks as $link) {
										echo $link;
									}  ?>
								
				    			</div>

							</div>
						
					