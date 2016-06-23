<div id="page-wrapper" >
	
		<!-- Button trigger modal -->
		
		<!-- Modal -->
		<div class="has-sub" id="cssmenu" >
		 	<div class="has-sub" id="cssmenu" role="document">
		    	<div id="cssmenu">
		      		<div class="has-sub">
						<ul style="padding-top:0px;">
							
				    		<b>								
						    	<?php	
						    		echo '<h4 style="margin-left: 15px;"><span class="label label-default" style="color:#ffffff; background-color:#337ab7"><a href="#" onclick="selectCategory(id);" id="-1" style="color:#ffffff;"><b>'. "PRODUCTOS".'</b></a></span></h4>';
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
										echo '<a href="#" class="subcategories" onclick="selectCategory(id);" style="padding-left:'.(($treeHeight*10)+15).'px" id="'. $childCategories[$i]->id . '"><b> <span class="glyphicon glyphicon-play" aria-hidden="true"></span> '.$childCategories[$i]->name.'</b></a> <br>';
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
			                <br><br>
						
			            	<?php if ($viewType == "tilesView") { ?>
				                <a href="<?php echo base_url() . 'home/catalog/listView'; ?>">
				                	<span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> Estilo Lista
				                </a>
			           		<?php } else if ($viewType == "listView") { ?>
								<a href="<?php echo base_url() . 'home/catalog/tilesView'; ?>">
									<span class="glyphicon glyphicon-th" aria-hidden="true"></span>Estilo mosaico
								</a>
							<?php } ?>
							
						</ul>
					</div>
				<br><br>	
				</div>
				
				
<script type="text/javascript">
    google_ad_client = "ca-pub-6891615026124481";
    google_ad_slot = "9428684656";
    google_ad_width = 160;
    google_ad_height = 600;
</script>
<!-- test-integrapp-1 -->
<script type="text/javascript"
src="//pagead2.googlesyndication.com/pagead/show_ads.js">
</script>

			</div>
		</div>
    	<div class="row" style="padding: 10px 10px 10px 10px;">
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
									      		<img src="<?php echo base_url() . 'Resources/img/NoFoto.jpg'; ?>" style="max-width: 100%;display: block;margin: 0 auto;max-height: 200px;">
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
		                        <th>Imagen</th>
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
								      		<a href="<?php echo base_url() . 'product/viewProduct/' . $Catalog[$i]->id; ?>"><img src="<?php echo base_url() . 'Resources/img/NoFoto.jpg'; ?>" style="max-width: 100%;display: block;margin: 0 auto;max-height: 40px;"></a>
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
