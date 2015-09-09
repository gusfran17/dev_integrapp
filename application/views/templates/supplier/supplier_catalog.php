<?php if (isset($hasSidebar)) { ?>
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
					<li class="<?php if ($orderBy == 'category_id') echo 'active' ?>" ><a href="<?php echo base_url() . 'Suppliers/viewSupplierCatalog/category_id'; ?>">Ordenado Relevancia</a></li>
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
	<div class="container-fluid" id="main-products">
		<div class="container-fluid" id="supplier-products" >
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="col-md-6 col-sm-8 col-xs-12">
					<div class="panel panel-default pnlSupplier" style="margin-top: 20px; border-radius: 20px;">    
						<div class="panel-body">
					    	<div class="col-md-4 col-sm-4 col-xs-4" style="text-align: center">
						    	<?php if(isset($supplier->logo)) {?>
						      		<img src="<?php echo base_url() . $supplier->logo; ?>" style="max-width: 100%;display: block;margin: 0 auto;max-height: 100px;">
							    <?php } else { ?>
							    	<img src="<?php echo base_url() . IMAGES_PATH . 'noProfilePic.jpg'; ?>" style="max-width: 100%;display: block;margin: 0 auto;max-height: 100px;">
							    <?php } ?>
								<h3 style="height: 1em; margin-top: 10px;"><a href="<?php echo base_url() . 'Suppliers/viewSupplier/'. $supplier->id;?>"><?php echo $supplier->fake_name; ?></a></h3>
								<p class="text-info" style="margin-left: auto; height: 15px;text-align: left;">
									<a href="<?php echo base_url() . 'Suppliers/viewSupplier/'. $supplier->id;?>"><span class="glyphicon glyphicon-th-large" aria-hidden="true"></span> Detalles de perfil </a>
								</p>
		                        <?php if (($supplier->associationStatus != 'approved') and ($watchingRole == 'distributor')) {?>
									<p style="margin-top:20;text-align: left;">
										<a href="<?php echo base_url() . 'suppliers/setSupplierDistributorStatus/' . $supplier->id;?>"><span class="glyphicon glyphicon-share" aria-hidden="true"></span> Reenviar solicitud de adhesión</a>
									</p>
			                    <?php } ?>
								<p style="margin-top:20;text-align: left;">
									<a href="<?php echo base_url(); ?>suppliers/viewSuppliers"><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span><b> Proveedores</b></a>
								</p>
							</div>
							<div class="col-md-8 col-sm-8 col-xs-8">
						    	<p><b>Razón Social: </b><?php echo $supplier->razon_social;?></p>
						    	<p><b>CUIT: </b><?php echo $supplier->cuit;?></p>
						    	<p><b>Email: </b><?php echo $supplier->comercial_email;?></p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12">		
				<?php
					echo '<ol class="breadcrumb" style= "margin-bottom: 5px; font-size:16px">';
					echo '<li><a href="#" onclick="selectCategory(id);" id="-1"><b><i class="fa fa-fw fa-table"></i> PRODUCTOS DEL PROVEEDOR </b></a></li>';
					if (isset($selectedCategoryId)) {
						$treeHeight = count($branch);
						for ($i=$treeHeight-1; $i >= 0; $i--) {
							echo '<li><a href="#" onclick="selectCategory(id);" id="'.$branch[$i]->id.'">'.$branch[$i]->name.'</a></li>';
						}
					}  
					echo '</ol>';
				?>					
			</div>
		</div>	
		<div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px;">
			<table id="resultset" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th data-class="expand">Imagen</th>
                        <th>Código de Producto</th>
						<th>Código IntegrApp</th>
                        <th data-hide="phone">Producto</th>
                        <?php if (($supplier->associationStatus == 'approved')or(isset($itIsMe))) {?>
	                        <th class="centered-cell" data-hide="phone,tablet">Precio</th>
	                        <th class="centered-cell" data-hide="phone,tablet">IVA</th>
                        <?php } ?>
                        <th class="centered-cell" data-hide="phone,tablet">Descripción</th>
                        <?php if ($supplier->associationStatus == 'approved') {?>
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
							<?php if (($supplier->associationStatus == 'approved')or(isset($itIsMe))) { ?>
								<td>
									<?php echo ($Catalog[$i]->price - (($Catalog[$i]->price*$supplier->associationDiscount)/100)) . '$'; ?>
								</td>
								<td>
									<?php echo $Catalog[$i]->tax; ?>
								</td>
							<?php } ?>
							<td>
								<?php echo $Catalog[$i]->description; ?>
							</td>
							<?php if ($supplier->associationStatus == 'approved') {?>
								<td>
									<a href="">
										<button type="button" class="btn btn-success btn-xs">Agregar a mi Catálogo</button>
									</a>
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
					

</div>