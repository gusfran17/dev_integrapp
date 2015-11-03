<?php if (!(isset($productLoadView))) { ?>
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
					<?php } else { ?>
						<li class="<?php if ($orderBy == 'category_id') echo 'active' ?>"><a href="<?php echo base_url() . 'Product/orderDistributorCatalogBy/category_id'; ?>">Ordenado por Relevancia</a></li>
						<li class="<?php if ($orderBy == 'supplier_id') echo 'active' ?>"><a href="<?php echo base_url() . 'Product/orderDistributorCatalogBy/supplier_id'; ?>">Ordenado por Proveedor</a></li>
						<li class="<?php if ($orderBy == 'name') echo 'active' ?>"><a href="<?php echo base_url() . 'Product/orderDistributorCatalogBy/name'; ?>">Ordenado Alfabeticamente</a></li>
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