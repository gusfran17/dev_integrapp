<div id="page-wrapper">
	<div class="container" id="main-products">
		<div class="col-md-12 col-sm-12 col-xs-12 products-titulo">		
			<a class="products-titulo" href="#" onclick="selectCategory(id);" id="-1"> <?php echo (isset($viewMyCatalog)? "Mis Productos": "Productos"); ?></a>					
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12">
			<?php			
				if (isset($selectedCategoryId)) {
					echo '<ol class="breadcrumb" style="margin-bottom: 5px; background-color:transparent !important;">';
					echo '<li><a href="#" onclick="selectCategory(id);" id="-1"><b><i class="fa fa-fw fa-table"></i> ' . (isset($viewMyCatalog)? "MIS PRODUCTOS": "PRODUCTOS") . '</b></a></li>';
					$treeHeight = count($branch);
					for ($i=$treeHeight-1; $i >= 0; $i--) {
						echo '<li><a href="#" onclick="selectCategory(id);" id="'.$branch[$i]->id.'">'.$branch[$i]->name.'</a></li>';
					}
					echo '</ol>';
				}  
			?>					
		</div>
		<div class="col-md-2 col-sm-2 col-xs-12">
			<ol class="breadcrumb" style="margin-bottom: 5px; font-size:16px">
				<li>
	                <a href="<?php echo base_url() . 'home/catalog'; ?>">
	                	<span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span><b> Vista de catálogo para pacientes</b>
	                </a>
				</li>
			</ol>
		</div>
		<div role="tabpanel">  
			<ul class="nav nav-pills" role="tablist" style="padding: 5px 5px 5px 5px;">
				<li role="presentation" class="<?php if (isset($viewCatalog)) {echo "active";} ?>"><a href="<?php echo base_url() . 'Product/products'; ?>"><b><span class="glyphicon glyphicon-list" aria-hidden="true"></span> Catálogo General de IntegrApp</b></a></li>
			    <li role="presentation" class="<?php if (isset($viewMyCatalog)) {echo "active";} ?>"><a href="<?php echo base_url() . 'Product/myProducts'; ?>"><b><span class="glyphicon glyphicon-list" aria-hidden="true"></span><u> Catálogo como Mayorista Primario </u></b></a></li>
				<li role="presentation" class="<?php if (isset($viewMySecSuppCatalog)) {echo "active";} ?>"><a href="<?php echo base_url() . 'Product/mySecondaryProducts'; ?>"><b><span class="glyphicon glyphicon-list" aria-hidden="true"></span> Catálogo como Mayorista Secundario</b></a></li>
			    <li role="presentation" class="<?php if (isset($productLoadView)) { echo "active";} ?>"><a href="<?php echo base_url() . 'Product/productLoadView'; ?>"><b><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> Cargar Productos</b></a></li>
			    <!-- <li role="presentation"><a href="#settings" aria-controls="settings" role="settings" data-toggle="tab">Ajustes</a></li> -->
			</ul>
		</div>  
		<?php if (!(isset($productLoadView))) { ?>
			<!-- Button trigger modal -->
			<div class="col-md-12 col-sm-12 col-xs-12" style="text-align: center;">
				<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal" style="margin-bottom:15px;">
					FILTROS <br>
					<span class="glyphicon glyphicon-filter" aria-hidden="true"></span>
				</button>
			</div>
			<!-- Modal -->
			<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        <h4 class="modal-title" id="myModalLabel">Filtros</h4>
			      </div>
			      <div class="modal-body">
			        <ul style="padding-top:0px;">
			    		<b>Filtro de categorías:</b>
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
									echo '<a href="#" class="subcategories" onclick="selectCategory(id);" style="padding-left:'.(($treeHeight*10)+15).'px" id="'. $childCategories[$i]->id . '"><b> <span class="glyphicon glyphicon-play" aria-hidden="true"></span> '.$childCategories[$i]->name.'</b></a><br>';
								}
							} 
						?>
						<form method="post" id="catalogCategoriesFilter" action="<?php echo base_url() . 'product/' . (isset($viewMyCatalog)? 'orderMySupplierCatalogBy/': (isset($viewMySecSuppCatalog)? 'orderMySecondarySupplierCatalogBy/': 'orderSupplierCatalogBy/')) . "$orderBy";?>" style= "padding-bottom: 0px;">
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
							function deactivateProduct(selectedProductId) {
								var productId = selectedProductId;
								if (window.confirm("¡Atención! Esta seguro que desea eliminar este producto?")){
									$('#deactivate_' + productId).submit();	
								}
							}
						</script>				
						<?php if (isset($viewMyCatalog)) {?>
							<br>
							<b>Filtro de Estados:</b><br>
			                <a href="javascript:;" data-toggle="collapse" data-target="#status" style="padding-top:20px;"><i class="fa fa-fw fa-arrows-v"></i><b> <?php if ($statusFilter == 'published') echo 'Publicados'; else if ($statusFilter == 'inactive') echo 'Eliminados'; else echo 'Activos';?> </b><i class="fa fa-fw fa-caret-down"></i></a>
							<ul id="status" class=" collapse nav nav-pills nav-stacked" type="circle" style="margin: 5px 5px 5px 5px; padding: 5px 5px 5px 5px;">
								<li class="<?php if ($statusFilter == 'published') echo 'active' ?>" >
									<a href="<?php echo base_url() . 'Product/showPublishedProducts/'; ?>">
										<span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span><b> Publicados</b>
										<?php echo '<span class="badge">' . $loadInfo->publishedProducts . '</span>'; ?>
									</a>
								</li>
								<li class="<?php if ($statusFilter == 'active') echo 'active' ?>" >
									<a href="<?php echo base_url() . 'Product/showActiveProducts'; ?>"><b>Activos</b> (Sin publicar) 
										<?php echo '<span class="badge">' . $loadInfo->activeProducts . '</span>'; ?>
									</a>
								</li>
								<li class="<?php if ($statusFilter == 'inactive') echo 'active' ?>" >
									<a href="<?php echo base_url() . 'Product/showInactiveProducts'; ?>">
										<b style="color:red"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Eliminados 
											<?php echo '<span class="badge">' . $loadInfo->inactiveProducts . '</span>'; ?>
										</b>
									</a>
								</li>
							</ul>
				        <?php }?>
		            	<br><br>
		            	<b>Ordenado:</b><br>
		                <a href="javascript:;" data-toggle="collapse" data-target="#orderBy" style="padding-top:20px;">
		                	<i class="fa fa-fw fa-arrows-v"></i>
		                	<b> 
		                		<?php if ($orderBy == 'name') echo 'Alfabeticamente'; 
		                			  else if ($orderBy == 'published_date desc') echo 'Fecha de publicación';
		                			  else if ($orderBy == 'price desc') echo 'Precios (de mayor a menor)';
		                			  else if ($orderBy == 'price asc') echo 'Precios (de menor a mayor)';
		                		?> 
		                	</b>
		                	<i class="fa fa-fw fa-caret-down"></i>
		                </a>
						<ul class="collapse nav nav-pills nav-stacked" type="circle" id="orderBy">
							
							<?php if (isset($viewCatalog)) { ?>
								<li class="<?php if ($orderBy == 'published_date desc') echo 'active' ?>"><a href="<?php echo base_url() . 'Product/orderSupplierCatalogBy/published_date desc'; ?>">Ordenado fecha de publicación</a></li>
								<li class="<?php if ($orderBy == 'name') echo 'active' ?>"><a href="<?php echo base_url() . 'Product/orderSupplierCatalogBy/name'; ?>">Ordenado Alfabeticamente</a></li>
							<?php } else if (isset($viewMyCatalog)) {?>
								<li class="<?php if ($orderBy == 'published_date desc') echo 'active' ?>" ><a href="<?php echo base_url() . 'Product/orderMySupplierCatalogBy/published_date desc'; ?>">Ordenado fecha de publicación</a></li>
								<li class="<?php if ($orderBy == 'name') echo 'active' ?>" ><a href="<?php echo base_url() . 'Product/orderMySupplierCatalogBy/name'; ?>">Ordenado Alfabeticamente</a></li>
								<li class="<?php if ($orderBy == 'price desc') echo 'active' ?>" ><a href="<?php echo base_url() . 'Product/orderMySupplierCatalogBy/price desc'; ?>">Ordenado por precios (de mayor a menor)</a> </li>
								<li class="<?php if ($orderBy == 'price asc') echo 'active' ?>" ><a href="<?php echo base_url() . 'Product/orderMySupplierCatalogBy/price asc'; ?>">Ordenado por precios (de menor a mayor)</a> </li>
							<?php } else if (isset($viewMySecSuppCatalog)) {?>
								<li class="<?php if ($orderBy == 'published_date desc') echo 'active' ?>" ><a href="<?php echo base_url() . 'Product/orderMySecondarySupplierCatalogBy/published_date desc'; ?>">Ordenado fecha de publicación</a></li>
								<li class="<?php if ($orderBy == 'name') echo 'active' ?>" ><a href="<?php echo base_url() . 'Product/orderMySecondarySupplierCatalogBy/name'; ?>">Ordenado Alfabeticamente</a></li>
								<li class="<?php if ($orderBy == 'price desc') echo 'active' ?>" ><a href="<?php echo base_url() . 'Product/orderMySecondarySupplierCatalogBy/price desc'; ?>">Ordenado por precios (de mayor a menor)</a> </li>
								<li class="<?php if ($orderBy == 'price asc') echo 'active' ?>" ><a href="<?php echo base_url() . 'Product/orderMySecondarySupplierCatalogBy/price asc'; ?>">Ordenado por precios (de menor a mayor)</a> </li>
							<?php } ?>
						</ul>
					</ul>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			      </div>
			    </div>
			  </div>
			</div>

		<?php }?>

		<div class="tab-content">
		    <div role="tabpanel" class="tab-pane fade active in" id="catalog">
				