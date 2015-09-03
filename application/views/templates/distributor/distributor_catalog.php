<section id="home" style="margin-top: 70px;">
	<div class="container-fluid" id="main-products">
		<div class="container-fluid" id="distributor-products" >
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="col-md-6 col-sm-8 col-xs-12">
					<div class="panel panel-default pnlDistributor" style="margin-top: 20px; border-radius: 20px;">    
						<div class="panel-body">
					    	<div class="col-md-4 col-sm-4 col-xs-4" style="text-align: center">
						    	<?php if(isset($distributor->logo)) {?>
						      		<img src="<?php echo base_url() . $distributor->logo; ?>" style="max-width: 100%;display: block;margin: 0 auto;max-height: 100px;">
							    <?php } else { ?>
							    	<img src="<?php echo base_url() . IMAGES_PATH . 'noProfilePic.jpg'; ?>" style="max-width: 100%;display: block;margin: 0 auto;max-height: 100px;">
							    <?php } ?>
								<h3 style="height: 1em; margin-top: 10px;"><a href="<?php echo base_url() . 'Suppliers/viewSupplier/'. $distributor->id;?>"><?php echo $distributor->fake_name; ?></a></h3>
								<p class="text-info" style="margin-left: auto; height: 15px;text-align: left;">
									<a href="<?php echo base_url() . 'Suppliers/viewSupplier/'. $distributor->id;?>"><span class="glyphicon glyphicon-th-large" aria-hidden="true"></span> Detalles de perfil </a>
								</p>
								<p style="margin-top:20;text-align: left;">
									<a href="<?php echo base_url(); ?>Distributors/viewDistributors"><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span><b> Ortopedias</b></a>
								</p>
							</div>
							<div class="col-md-8 col-sm-8 col-xs-8">
						    	<p><b>Razón Social: </b><?php echo $distributor->razon_social;?></p>
						    	<p><b>CUIT: </b><?php echo $distributor->cuit;?></p>
						    	<p><b>Email: </b><?php echo $distributor->comercial_email;?></p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="page-header" style="text-align:center; margin: 0px 0 0px;">
				<h2>
					<span class="label label-default lblDistributor">
						<b>CATALOGO DEL ORTOPEDISTA</b>
					</span>
				</h2>
			</div>
		</div>	
		<div class="col-md-2 col-sm-2 col-xs-4" style="margin-top: 10px;">
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
					<div class="panel panel-default">
						<form method="post" id="catalogCategoriesFilter" action="<?php echo base_url() . 'Distributors/viewDistributorCatalog/' . $orderBy;?>" style= "padding-bottom: 0px;">
							<?php
								if (isset($selectedCategoryId)) {
									echo '<ol class="breadcrumb" style= "margin-bottom: 5px; font-size:16px">';
									echo '<li><a href="#" onclick="selectCategory(id);" id="-1"><b>PRODUCTOS</b></a></li>';
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
										echo '<li><a href="#" onclick="selectCategory(id);" id="'. $childCategories[$i]->id . '"><b>'.$childCategories[$i]->name.'</b></a></li>';
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
				
				</div>
			</div>
		</div>
		<div class="col-md-10 col-sm-10 col-xs-8" style="margin-top: 10px;">
			<div class="col-md-12 col-sm-12 col-xs-12">		
				<?php
					if (isset($selectedCategoryId)) {
						echo '<ol class="breadcrumb" style= "margin-bottom: 5px; font-size:16px">';
						echo '<li><a href="#" onclick="selectCategory(id);" id="-1"><b>PRODUCTOS</b></a></li>';
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
                        <th class="centered-cell" data-hide="phone,tablet">IVA</th>
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
								<?php echo $Catalog[$i]->tax; ?>
							</td>
							<td>
								<?php echo $Catalog[$i]->description; ?>
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
					

</section>