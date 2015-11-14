	<div class="collapse navbar-collapse navbar-inverse navbar-ex1-collapse">
		<ul class="nav navbar-nav side-nav" style="padding-top:0px;">
    		<b>								
		    	<?php	
		    		echo '<h4 style="margin-left: 15px;"><span class="label label-default" style="color:#ffffff; background-color:#D17749"><a href="#" onclick="selectCategory(id);" id="-1" style="color:#ffffff;"><b>'. "PRODUCTOS".'</b></a></span></h4>';
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
			<form method="post" id="catalogCategoriesFilter" action="<?php echo base_url() . 'home/orderCatalogBy/' . "$orderBy";?>" style= "padding-bottom: 0px;">
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
					<li class="<?php if ($orderBy == 'published_date desc') echo 'active' ?>"><a href="<?php echo base_url() . 'home/orderCatalogBy/published_date desc'; ?>">Ordenado por fecha de publicación</a></li>
					<li class="<?php if ($orderBy == 'name') echo 'active' ?>"><a href="<?php echo base_url() . 'home/orderCatalogBy/name'; ?>">Ordenado Alfabeticamente</a></li>
				</ul>
            </li>
            <li>
            	<?php if ($viewType == "tilesView") { ?>
	                <a href="<?php echo base_url() . 'home/catalog/listView'; ?>">
	                	<span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> Estilo Lista
	                </a>
           		<?php } else if ($viewType == "listView") { ?>
					<a href="<?php echo base_url() . 'home/orderCatalogBy/name'; ?>">
						<span class="glyphicon glyphicon-th" aria-hidden="true"></span>Estilo mosaico
					</a>
				<?php } ?>
			</li>
		</ul>

	</div>
</nav> 

<div id="page-wrapper" >
	<div class="container-fluid" id="main-products">	
  		<div class="col-md-12 col-sm-12 col-xs-12">		
			<?php
				echo '<ol class="breadcrumb" style="margin-bottom: 5px; font-size:16px">';
				echo '<li><a href="#" onclick="selectCategory(id);" id="-1"><b><i class="fa fa-fw fa-table"></i> ' .  "PRODUCTOS" . '</b></a></li>';
				if (isset($selectedCategoryId)) {
					$treeHeight = count($branch);
					for ($i=$treeHeight-1; $i >= 0; $i--) {
						echo '<li><a href="#" onclick="selectCategory(id);" id="'.$branch[$i]->id.'">'.$branch[$i]->name.'</a></li>';
					}
				}  
				echo '</ol>';
			?>					
		</div>
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
    	<div class="row" style="padding: 10px 10px 10px 10px;">
			<div class="panel panel-primary col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-top: 15px;">
				<div class="panel-body">
					<div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center">
						<?php if(isset($pageLinks)) foreach ($pageLinks as $link) {
							echo $link;
						}  ?>
	    			</div>
	    			<?php if ($viewType == "tilesView") { 
						$catalogSize = count($Catalog);
						for ($i=0; $i < $catalogSize; $i++) { ?>
								<div class="col-lg-4 col-md-6 col-sm-12 col-xs-12 item-catalogo">
									<div class="panel panel-info" style="background-color: #FFF;">
										<div class="panel-body">

											<div class="producto-container" >
										    	<a href="<?php echo base_url() . 'product/viewProduct/' . $Catalog[$i]->id; ?>">
											    	<?php if (count($Catalog[$i]->images)>0) {?>
											      		<img src="<?php echo base_url() . PRODUCT_IMAGES_PATH . $Catalog[$i]->images[0]; ?>" style="max-width: 100%;display: block;margin: 0 auto;max-height: 200px;">
												    <?php } else { ?>
											      		<img src="<?php echo base_url() . 'Resources/imgs/NoFoto.jpg'; ?>" style="max-width: 100%;display: block;margin: 0 auto;max-height: 200px;">
												    <?php } ?>
											    </a>
											</div>
											<div class="catalogProdLabelGroup">
												<div class="col-xs-12 catalogProdName" style="text-align:center;"><strong><a href="<?php echo base_url() . 'product/viewProduct/' . $Catalog[$i]->id; ?>"><?php echo $Catalog[$i]->name; ?></a></strong></div>
												<div class="col-xs-12 catalogProdName" style="text-align:center;"><b>Categoria: </b><?php echo $Catalog[$i]->categoryPath; ?></div>
												<div class="col-xs-12 catalogProdCode" style="text-align:center;"><strong>Código IntegrApp: </strong><a href="<?php echo base_url() . 'product/viewProduct/' . $Catalog[$i]->id; ?>"><?php echo $Catalog[$i]->integrapp_code; ?></a></div>
											</div>
										</div>
									</div>
								</div>
							<?php } ?>
						<?php } else if ($viewType == "listView") { ?>
							<table id="resultset" class="table table-bordered table-striped">
				                <thead>
				                    <tr>
				                        <th data-class="expand">Imagen</th>
				                        <th>Código de Producto</th>
										<th>Código IntegrApp</th>
				                        <th data-hide="phone">Producto</th>
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
			</div>
		</div>
	</div>
</div>
