<div id="page-wrapper" style="margin-top: 70px;">
	<div class="container" id="main-products">
		<div class="container" id="distributor-products" >
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="col-lg-6 col-md-8 col-sm-8 col-xs-12">
					<div class="panel panel-default pnlDistributor" style="margin-top: 20px; border-radius: 20px;">    
						<div class="panel-body">
					    	<div class="col-md-4 col-sm-4 col-xs-4" style="text-align: center">
						    	<?php if(isset($distributor->logo)) {?>
						      		<img src="<?php echo base_url() . $distributor->logo; ?>" style="max-width: 100%;display: block;margin: 0 auto;max-height: 100px;">
							    <?php } else { ?>
							    	<img src="<?php echo base_url() . IMAGES_PATH . 'noProfilePic.jpg'; ?>" style="max-width: 100%;display: block;margin: 0 auto;max-height: 100px;">
							    <?php } ?>
								<h4 style="height: 2em; margin-top: 10px;"><a href="<?php echo base_url() . 'Distributors/viewDistributor/'. $distributor->id;?>"><?php echo $distributor->fake_name; ?></a></h4>
								<p class="text-info" style="margin-left: auto; height: 15px;text-align: left;">
									<a href="<?php echo base_url() . 'Distributors/viewDistributor/'. $distributor->id;?>"><span class="glyphicon glyphicon-th-large" aria-hidden="true"></span> Detalles de perfil </a>
								</p>
								<p style="margin-top:20;text-align: left;">
									<a href="<?php echo base_url(); ?>Distributors/viewDistributors"><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span><b> Ortopedias</b></a>
								</p>
							</div>
							<div class="col-md-8 col-sm-8 col-xs-8">
						    	<p><b>Razón Social: </b><?php echo $distributor->razon_social;?></p>
						    	<p><b>CUIT: </b><?php echo $distributor->cuit;?></p>
						    	<p><b>Email: </b><?php echo $distributor->comercial_email;?></p>
						    	<p><b>Dirección: </b><?php echo $distributor->commercial_address;?></p>
						    	<p><b>Telefono de Contacto: </b><?php echo $distributor->contact_phone;?></p>
								<p><b>Fax: </b><?php echo $distributor->fax;?></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>	
		<div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px;">
			<div class="col-md-12 col-sm-12 col-xs-12">		
				<?php
					echo '<ol class="breadcrumb" style= "margin-bottom: 5px; font-size:16px">';
					echo '<li><a href="#" onclick="selectCategory(id);" id="-1"><b><i class="fa fa-fw fa-table"></i> PRODUCTOS DEL ORTOPEDISTA </b></a></li>';
					if (isset($selectedCategoryId)) {
						$treeHeight = count($branch);
						for ($i=$treeHeight-1; $i >= 0; $i--) {
							echo '<li><a href="#" onclick="selectCategory(id);" id="'.$branch[$i]->id.'">'.$branch[$i]->name.'</a></li>';
						}
					}  
					echo '</ol>';
				?>					
			</div>
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
								<b>Filtro de categorias:</b>
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
											echo '<a href="#" class="subcategories" onclick="selectCategory(id);" style="padding-left:'.(($treeHeight*10)+15).'px" id="'. $childCategories[$i]->id . '"><b> <span class="glyphicon glyphicon-play" aria-hidden="true"></span> '.$childCategories[$i]->name.'</b></a> <br>';
										}
									}
								?>
								<form method="post" id="catalogCategoriesFilter" action="<?php echo base_url() . 'Distributors/viewDistributorCatalog/' . $orderBy;?>" style= "padding-bottom: 0px;">
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
									<li class="<?php if ($orderBy == 'published_date desc') echo 'active' ?>" ><a href="<?php echo base_url() . 'Distributors/viewDistributorCatalog/published_date desc'; ?>">Ordenado fecha de publicación</a></li>
									<li class="<?php if ($orderBy == 'name') echo 'active' ?>" ><a href="<?php echo base_url() . 'Distributors/viewDistributorCatalog/name'; ?>">Ordenado Alfabeticamente</a></li>
								</ul>
							</ul>
						</div>
				    	<div class="modal-footer">
				        	<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				    	</div>
					</div>
				</div>
			</div>

			<table id="resultset" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th data-class="expand">Imagen</th>
                        <th>Código de Producto</th>
						<th>Código IntegrApp</th>
                        <th data-hide="phone">Producto</th>
                        <th class="centered-cell" data-hide="phone,tablet">Descripción</th>
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
								<a href="<?php echo base_url() . 'product/viewProduct/' . $Catalog[$i]->id; ?>"><strong><?php echo $Catalog[$i]->name; ?></strong></a>
							</td>
							<td>
								<?php echo $Catalog[$i]->description; ?>
								<br>
								<br>
								<b>Categoria: </b><?php echo $Catalog[$i]->categoryPath; ?>
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