<section id="home" style="margin-top: 70px;">
	<div class="container-fluid" id="main-products">
		<div class="container-fluid" id="supplier-products" >
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="col-md-5 col-sm-5 col-xs-5">
					<div class="well well-small" style="background-color: #EEE; margin-top: 20px; border-radius: 20px;">    
				    	<?php if(isset($supplier->logo)) {?>
				      		<img src="<?php echo base_url() . $supplier->logo; ?>">
					    <?php } ?>
						<h3 style="height: 1em; margin-top: 10px;"><a href="#"><?php echo $supplier->razon_social; ?></a></h3>
						<p class="text-info" style="margin-left: auto;width: 6em; height: 15px;"><a href="">Ver detalles de perfil</a></p>
					</div>

				</div>
			</div>
			<div class="page-header" style="text-align:center; margin: 0px 0 0px;">
				<h2>
					<span class="label label-primary">
						<b>CATALOGO</b>
					</span><br>
					<small>Productos de este proveedor</small>
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
						        <button class="btn btn-info" type="submit">Buscar</button>
						      </span>
						  </div>
						</form>
					</div>
				</div>
				<div class="panel-body">
					<div class="panel panel-default">
						<form method="post" id="catalogCategoriesFilter" action="<?php echo base_url() . 'Suppliers/viewSupplierCatalog/' . $orderBy;?>" style= "padding-bottom: 0px;">
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
								<li class="<?php if ($orderBy == 'category_id') echo 'active' ?>" ><a href="<?php echo base_url() . 'Suppliers/viewSupplierCatalog/category_id'; ?>">Ordenado por categorias</a></li>
								<li class="<?php if ($orderBy == 'name') echo 'active' ?>" ><a href="<?php echo base_url() . 'Suppliers/viewSupplierCatalog/name'; ?>">Ordenado por nombre</a></li>
								<li class="<?php if ($orderBy == 'price desc') echo 'active' ?>" ><a href="<?php echo base_url() . 'Suppliers/viewSupplierCatalog/price desc'; ?>">Ordenado por precios (de mayor a menor)</a> </li>
								<li class="<?php if ($orderBy == 'price asc') echo 'active' ?>" ><a href="<?php echo base_url() . 'Suppliers/viewSupplierCatalog/price asc'; ?>">Ordenado por precios (de menor a mayor)</a> </li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-10 col-sm-10 col-xs-8" style="margin-top: 10px;">
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

			<table id="resultset" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th data-class="expand">Imagen</th>
                        <th>Código de Producto</th>
						<th>Código IntegrApp</th>
                        <th data-hide="phone">Producto</th>
                        <th class="centered-cell" data-hide="phone,tablet">Precio</th>
                        <th class="centered-cell" data-hide="phone,tablet">IVA</th>
                        <th class="centered-cell" data-hide="phone,tablet">Descripción</th>
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
							      		<img src="<?php echo base_url() . PRODUCT_IMAGES_PATH . $Catalog[$i]->id . "/" . $Catalog[$i]->images[0]; ?>" style="max-width: 100%;display: block;margin: 0 auto;max-height: 40px;">
							    <?php } else { ?>
						      		<img src="<?php echo base_url() . 'Resources/imgs/NoFoto.jpg'; ?>" style="max-width: 100%;display: block;margin: 0 auto;max-height: 40px;">
							    <?php } ?>
							</td>
							<td>
								<?php echo $Catalog[$i]->code; ?>
							</td>
							<td>
								<?php echo $Catalog[$i]->integrapp_code; ?>
							</td>
							<td>
								<strong><?php echo $Catalog[$i]->name; ?></strong>
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
								<a href="/fabricante/publicar_producto/17">
									<button type="button" class="btn btn-success btn-xs">Agregar a mi Catálogo</button>
								</a>
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