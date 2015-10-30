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
			<form method="post" id="catalogCategoriesFilter" action="<?php echo base_url() . 'product/' . (isset($viewMyCatalog)? 'orderMySupplierCatalogBy/': (isset($viewMySecSuppCatalog)? 'orderMySecondarySupplierCatalogBy/': 'orderSupplierCatalogBy/')) . "$orderBy";?>" style= "padding-bottom: 0px;">
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
			<?php if (isset($viewMyCatalog)) {?>
				<li>
	                <a href="javascript:;" data-toggle="collapse" data-target="#status" style="padding-top:20px;"><i class="fa fa-fw fa-arrows-v"></i><b> Estado <?php if ($loadInfo->activeProducts>0) echo '<span class="badge">' . $loadInfo->activeProducts . '</span>'; ?> </b><i class="fa fa-fw fa-caret-down"></i></a>
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
	            </li>
	        <?php }?>
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#orderBy" style="padding-top:20px;"><i class="fa fa-fw fa-arrows-v"></i><b> Ordenar </b><i class="fa fa-fw fa-caret-down"></i></a>
				<ul class="collapse nav nav-pills nav-stacked" type="circle" id="orderBy">
					<?php if (isset($viewMyCatalog)) {?>
						<li class="<?php if ($orderBy == 'category_id') echo 'active' ?>" ><a href="<?php echo base_url() . 'Product/orderMySupplierCatalogBy/category_id'; ?>">Ordenado por Relevancia</a></li>
						<li class="<?php if ($orderBy == 'name') echo 'active' ?>" ><a href="<?php echo base_url() . 'Product/orderMySupplierCatalogBy/name'; ?>">Ordenado Alfabeticamente</a></li>
						<li class="<?php if ($orderBy == 'price desc') echo 'active' ?>" ><a href="<?php echo base_url() . 'Product/orderMySupplierCatalogBy/price desc'; ?>">Ordenado por precios (de mayor a menor)</a> </li>
						<li class="<?php if ($orderBy == 'price asc') echo 'active' ?>" ><a href="<?php echo base_url() . 'Product/orderMySupplierCatalogBy/price asc'; ?>">Ordenado por precios (de menor a mayor)</a> </li>
					<?php } else { ?>
						<li class="<?php if ($orderBy == 'category_id') echo 'active' ?>"><a href="<?php echo base_url() . 'Product/orderSupplierCatalogBy/category_id'; ?>">Ordenado por Relevancia</a></li>
						<li class="<?php if ($orderBy == 'name') echo 'active' ?>"><a href="<?php echo base_url() . 'Product/orderSupplierCatalogBy/name'; ?>">Ordenado Alfabeticamente</a></li>
						<li class="<?php if ($orderBy == 'price desc') echo 'active' ?>"><a href="<?php echo base_url() . 'Product/orderSupplierCatalogBy/price desc'; ?>">Ordenado por precios (de mayor a menor)</a> </li>
						<li class="<?php if ($orderBy == 'price asc') echo 'active' ?>"><a href="<?php echo base_url() . 'Product/orderSupplierCatalogBy/price asc'; ?>">Ordenado por precios (de menor a mayor)</a> </li>
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
				<li role="presentation" class="<?php if (isset($viewCatalog)) {echo "active";} ?>"><a href="<?php echo base_url() . 'Product/products'; ?>"><b><span class="glyphicon glyphicon-list" aria-hidden="true"></span> Catalogo General de IntegApp</b></a></li>
			    <li role="presentation" class="<?php if (isset($viewMyCatalog)) {echo "active";} ?>"><a href="<?php echo base_url() . 'Product/myProducts'; ?>"><b><span class="glyphicon glyphicon-list" aria-hidden="true"></span> Catalogo como Proveedor Primario</b></a></li>
				<li role="presentation" class="<?php if (isset($viewMySecSuppCatalog)) {echo "active";} ?>"><a href="<?php echo base_url() . 'Product/mySecondaryProducts'; ?>"><b><span class="glyphicon glyphicon-list" aria-hidden="true"></span> Catalogo como Proveedor Secundario</b></a></li>
			    <li role="presentation" class="<?php if (isset($productLoadView)) { echo "active";} ?>"><a href="<?php echo base_url() . 'Product/productLoadView'; ?>"><b><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> Cargar Productos</b></a></li>
			    <!-- <li role="presentation"><a href="#settings" aria-controls="settings" role="settings" data-toggle="tab">Ajustes</a></li> -->
			</ul>
		</div>  
		<div class="tab-content">
		    <div role="tabpanel" class="tab-pane fade active in" id="catalog">
				