<section id="home">
	<div class="container-fluid" id="main-products">
		<div class="page-header" style="text-align:center">
			<h2><span class="label label-primary"><b>PRODUCTOS</b></span></h2>
		</div>
		<div role="tabpanel">  
		  <ul class="nav nav-pills" role="tablist" style="padding: 5px 5px 5px 5px;">
		    <li role="presentation" class="<?php if ((!(isset($lastLoadedProductsGrid) or isset($productLoaded) or isset($productCancelled)))) {echo "active";} ?>"><a href="<?php echo base_url() . 'Product/orderCatalogBy/category_id'; ?>"><b>Catalogo</b></a></li>
		    <li role="presentation" class="<?php if (isset($lastLoadedProductsGrid) or isset($productLoaded) or isset($productCancelled)) { echo "active";} ?>"><a href="#load-products" aria-controls="load-products" role="load-products" data-toggle="tab"><b>Cargar Productos</b></a></li>
		    <!-- <li role="presentation"><a href="#settings" aria-controls="settings" role="settings" data-toggle="tab">Ajustes</a></li> -->
		  </ul>

		  
		  <div class="tab-content">
		    <div role="tabpanel" class="tab-pane fade <?php if (!(isset($lastLoadedProductsGrid) or isset($productLoaded) or isset($productCancelled)))  {echo "active in";} ?>" id="catalog">
				<div class="panel panel-primary" style="padding: 10px 10px 10px 10px;">
					<div class="row">
						<div class="form-group">
							<div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center">
								<?php if (isset($viewMyCatalog)) {?>
									
										<h2>
											<span class="label label-default">Mi Catalogo</span>
											<br>
											<a href="<?php echo base_url() . 'Product/orderCatalogBy/category_id'; ?>"><small><strong>Ver Catalogo de todos los productos</strong></small></a>
										</h2>
								<?php } else { ?>
										<h2>
											<span class="label label-default">Catalogo General</span>
											<br>
											<a href="<?php echo base_url() . 'Product/orderMyCatalogBy/category_id'; ?>"><small><strong>Ver mi Catalogo</strong></small></a>
										</h2>
								<?php } ?>
							</div>
				    		<div class="col-md-2 col-sm-4 col-xs-6">
				    			<div class="panel panel-info" style="padding: 10px 10px 10px 10px;">
				    				<div class="panel-body">
						    			<ul class="nav nav-pills nav-stacked" type="circle">
											<?php if (isset($viewMyCatalog)) {?>
												<li class="<?php if ($orderBy == 'category_id') echo 'active' ?>" ><a href="<?php echo base_url() . 'Product/orderMyCatalogBy/category_id'; ?>">Ordenar por categorias</a></li>
												<li class="<?php if ($orderBy == 'name') echo 'active' ?>" ><a href="<?php echo base_url() . 'Product/orderMyCatalogBy/name'; ?>">Ordenar por nombre</a></li>
												<li class="<?php if ($orderBy == 'price desc') echo 'active' ?>" ><a href="<?php echo base_url() . 'Product/orderMyCatalogBy/price desc'; ?>">Ordenar por precios (de mayor a menor)</a> </li>
												<li class="<?php if ($orderBy == 'price asc') echo 'active' ?>" ><a href="<?php echo base_url() . 'Product/orderMyCatalogBy/price asc'; ?>">Ordenar por precios (de menor a mayor)</a> </li>
												<br>
												<br>
												<br>
												<br>
												<li class=""><a href="<?php echo base_url() . 'Product/orderCatalogBy/category_id'; ?>"><strong>Ver Catalogo General</strong></a> </li>
											<?php } else { ?>
												<li class="<?php if ($orderBy == 'category_id') echo 'active' ?>"><a href="<?php echo base_url() . 'Product/orderCatalogBy/category_id'; ?>">Ordenar por categorias</a></li>
												<li class="<?php if ($orderBy == 'name') echo 'active' ?>"><a href="<?php echo base_url() . 'Product/orderCatalogBy/name'; ?>">Ordenar por nombre</a></li>
												<li class="<?php if ($orderBy == 'price desc') echo 'active' ?>"><a href="<?php echo base_url() . 'Product/orderCatalogBy/price desc'; ?>">Ordenar por precios (de mayor a menor)</a> </li>
												<li class="<?php if ($orderBy == 'price asc') echo 'active' ?>"><a href="<?php echo base_url() . 'Product/orderCatalogBy/price asc'; ?>">Ordenar por precios (de menor a mayor)</a> </li>
												<br>
												<br>
												<br>
												<br>
												<li class=""><a href="<?php echo base_url() . 'Product/orderMyCatalogBy/category_id'; ?>"><strong>Ver Mi Catalogo</strong></a> </li>
											<?php } ?>
										</ul>
									</div>
								</div>
				    		</div>
				    		<div class="col-md-10 col-sm-8 col-xs-6">							
								<?php 
								$catalogSize = count($Catalog);
								for ($i=0; $i < $catalogSize; $i++) { ?>
									<div class="col-md-4 col-sm-6 col-xs-12 item-catalogo">

										<div class="producto-container" style="<?php if (count($Catalog[$i]->images)>0) echo 'background-image: url('.base_url() . PRODUCT_IMAGES_PATH . $Catalog[$i]->id . "/" . $Catalog[$i]->images[0] . ');'; ?>" > 
											<div class="jquery-description"><h6><?php echo "<strong>Código: </strong>". $Catalog[$i]->code . "</br><strong>Descripción: </strong>". $Catalog[$i]->description; ?></h6></div>
										</div> 
										<div style="text-align:center;"> <strong><?php echo $Catalog[$i]->name; ?></strong></div>
										<div style="text-align:center;"><strong>Código IntegrApp: </strong><?php echo $Catalog[$i]->integrapp_code; ?></div>
										<div style="text-align:center;"><strong>Precio: </strong><?php echo $Catalog[$i]->price . '$'; ?></div>
									</div>
								<?php } ?>
								<div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center"> 			
										<div class="col-md-4 col-sm-4 col-xs-4">
										</div>	
										<div class="col-md-4 col-sm-4 col-xs-4">
											<?php if(isset($pageLinks)) foreach ($pageLinks as $link) {
												echo $link;
											}  ?>
										</div>
										<div class="col-md-4 col-sm-4 col-xs-4">
										</div>
			
				    			</div>

							</div>
						</div>
			    	</div>
		    	</div>
		    </div>
		    <div role="tabpanel" class="tab-pane fade <?php if (isset($lastLoadedProductsGrid) or isset($productLoaded) or isset($productCancelled)) { echo "active in";} ?>" id="load-products">
		    	<div class="row" id="productSection">
		    		<div class="panel panel-primary" style="padding: 10px 10px 10px 10px;">
		    		<?php if(isset($productLoaded)):?>
		    			<div class="alert alert-warning alert-dismissible" role="alert">
						  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						  <strong>¡Atencion!</strong> El producto ha sido cargado exitosamente. Puede encontrar el mismo más abajo. Desde alli puede editarlo, duplicarlo o eliminarlo.
						</div>
					<?php endif;?>
					<?php if(isset($productCancelled)):?>
		    			<div class="alert alert-warning alert-dismissible" role="alert">
						  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						  <strong>¡Atencion!</strong> La operacion ha sido cancelada.
						</div>
					<?php endif;?>
				    <div class="panel panel-primary" id="">
								<div class="panel-heading">
									<div class="panel-title">
										<h4>Seleccione una categoria:</h4>
									</div>
								</div>
								<div class="panel-body">

									<div class="col-md-3" id="products">
										<select name="" id="category1">
											<option value="">Seleccione una categoria...</option>
											<?php foreach ($category as $option) {
												echo "<option id='".$option->id."'>".$option->name."</option>";
											} ?>
										</select>
									</div>

									<div class="col-md-9">
							    		<h3>Recuerde:</h3>
								    	<ul>
								    		<li> El nombre de cada producto no puede ser el mismo de uno ya cargado.</li>
								    		<li> El código de cada producto no puede ser el mismo de uno ya cargado.</li>
								    		<li> Puede duplicar un producto cargado, y asi editar solo la informacion necesaria ahorrandose tiempo.</li>
								    		<li> Puede Editar un producto cargado recientemente desde la planilla de la derecha.</li>
								    		<li> Puede Eliminar un producto cargado recientemente desde la planilla de la derecha.</li>
								    	</ul>	
									</div>
					    		</div>
					</div>
					<form class="region size1of2" action="<?php echo base_url(); ?>product/saveProduct" method="post" id="fromLoadProducts">
						<div class="panel panel-info">
							<div class="panel-heading">
								<div class="panel-title">
									<h4>Planilla Datos de Producto</h4>
								</div>
							</div>
							<div id="editionAlert">
							<!-- This is filled with an alert when product is being edited, copied or deleted 
								  The following is for when form validation occurs in edition-->
								<?php if(isset($editProductID)):?>
									<div class="alert alert-warning alert-dismissible" role="alert">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<strong>¡Atención!</strong> Se encuentra editando un producto cargado recientemente.<br>Para volver a cargar un producto desde el inicio debe presionar en <b>Cancelar</b> al final de la pantalla.
									</div>
								<?php endif;?>
							</div>
							<div class="panel-body">
								<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" id="formOptions">
									<div class="form-group">
										<label for="" class="control-label">Categoria seleccionada</label> (Seleccione la categoria en la sección superior)
										<?php echo form_error('categoryTree', '<span class="label label-danger">', '</span>'); ?>
										<input type="text" class="form-control" id="categoryTree" name="categoryTree" value="<?php if (isset($productLoaded) or isset($productCancelled)) echo ""; else echo set_value('categoryTree');?>" >
										<input type="text" name="categoryID" value="<?php if (!(isset($productLoaded) or isset($productCancelled))) echo set_value('categoryID');?>" id="categoryID">
										<input type="text" name="editProductID" value="<?php if (isset($editProductID)) echo set_value('editProductID',$editProductID);?>" id="editProductID">
										<input type="text" name="imagesPath" value="<?php echo base_url() . PRODUCT_IMAGES_PATH;?>" id="imagesPath">
										<input type="text" name="basePath" value="<?php echo base_url();?>" id="basePath">
										<!-- The following fields are for testing javascript hide operations
										<input type="text" name="categoryID__" value="<?php if (isset($productLoaded) or isset($productCancelled)) echo set_value('categoryID',""); else echo set_value('categoryID');?>" id="categoryID__">
										<input type="text" name="editProductID__" value="" id="editProductID__">
										<input type="text" name="imagesPath__" value="<?php echo base_url() . PRODUCT_IMAGES_PATH;?>" id="imagesPath__">
										<input type="text" name="productEdition__" value="" id="productEdition">
 										-->
										<script type="text/javascript">
											$("#categoryID").hide();
											$("#editProductID").hide();
											$("#imagesPath").hide();
											$("#basePath").hide();
											$("#categoryTree").attr('disabled','disabled');
										</script>

									</div>
									<div class="form-group">
										<label for="" class="control-label">Nombre del producto*</label>
										<?php echo form_error('productName', '<span class="label label-danger">', '</span>'); ?>
										<input type="text" class="form-control" name="productName" id="productName" placeholder="Ingrese un nombre único..." value="<?php if (!(isset($productLoaded) or isset($productCancelled))) echo set_value('productName');?>">
									</div>
									<div class="form-group">
										<label for="" class="control-label">Código*</label>
										<?php echo form_error('productCode', '<span class="label label-danger">', '</span>'); ?>
										<input type="text" class="form-control" name="productCode" id="productCode" placeholder="Ingrese el código (único) del producto..." value="<?php if (!(isset($productLoaded) or isset($productCancelled))) echo set_value('productCode');?>">
									</div>
									<div class="form-group">
										<label for="" class="control-label">Condición IVA*</label>
										<select class="form-control" name="productVAT" id="productVAT">
											<option value="0%" id="IVA0">0%</option>
											<option value="10,5%" id="IVA0">10,5%</option>
											<option value="21%" id="IVA0">21%</option>
											<option value="27%" id="IVA0">27%</option>
										</select>
									</div>
									<div class="form-group">
										<label for="" class="control-label">Precio</label>
										<?php echo form_error('productPrice', '<span class="label label-danger">', '</span>'); ?>
										<input type="text" class="form-control" name="productPrice" id="productPrice" placeholder="Ingrese el precio del producto..." value="<?php if (!(isset($productLoaded) or isset($productCancelled))) echo set_value('productPrice');?>">
									</div>
									<div class="form-group">
										<label for="" class="control-label">Descripción*</label>
										<?php echo form_error('productDesc', '<span class="label label-danger">', '</span>'); ?>
										<textarea class="form-control" name="productDesc" id="productDesc"><?php if (!(isset($productLoaded) or isset($productCancelled))) echo set_value('productDesc');?></textarea> 
										
									</div>
									<div class="panel panel-default">
										<div class="panel-heading">
											<div class="panel-title">
												<h4>Especificaciones técnicas</h4>
											</div>
										</div>
										<div class="panel-body" style="margin: 10px 10px 10px 10px">
											<div>
											    <div>
											    	<div class="input_fields_wrap panel panel-info col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin: 10px 10px 10px 10px">
											    		<label for="" class="control-label">Variantes Exitentes (detalles, medidas, talles, etc.)</label><p>(Si agrega campos no los deje vacios porque estos no serán guardados)</p>
											    		<button class="add_field_button btn btn-primary btn-md">Agregar mas campos</button>
											    		<div class="example_specifications">
														    <textarea type="text" name="attributeExample" placeholder="Tipo de Variante (Ej.:Ancho)" value="" disabled></textarea>
														    <textarea type="text" name="valueExample" placeholder="Valor de Variantes (Ej.:30cm)" value="" disabled></textarea><a href="#" class="remove_field"> X</a>
													    </div>
														<?php if (isset($attributes)) { for ($i=0; $i<count($attributes); $i++) {?> 
															<div class="form-group_specifications">
																<textarea type="text" class="inputProperty" id="<?php echo $i; ?>" name="<?php echo 'attribute'. $i;?>" placeholder="Ej.:Ancho"><?php echo  $attributes[$i]->name;?></textarea>
																<textarea type="text" class="inputProperty" id="<?php echo $i; ?>" name="<?php echo 'value'. $i;?>" placeholder="Ej.:30cm"><?php echo  $attributes[$i]->value;?></textarea><a href="#" class="remove_field"> X</a>
															</div>
														<?php }}; ?>
													</div>
													<div class="panel panel-info col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin: 10px 10px 10px 10px">
														<div class="form-group col-xs-5 col-sm-5 col-md-5 col-lg-5" style="margin: 5px 5px 5px 5px">
															<label for="" class="control-label">Colores Disponibles</label>
															<br>
															<input type="color" class="color-picker" id="color-picker" name="color-picker" data-toggle='popover' title='Agregar un color' style="height: 50px; width: 50px;">
															
														</div>
														<div class="form-group selected_colors_div col-xs-6 col-sm-6 col-md-6 col-lg-6" style="margin: 5px 5px 5px 5px">
															<label for="" class="control-label">Colores Seleccionados</label>
															<br>(Para eliminar un color haga clic en el mismo)
															<div name="selected_colors" id="selected_colors">
																<?php if(isset($colors)){?>
																	<script  type="text/javascript">
																		$('.selected_colors_div').show();
																	</script>
																	<?php foreach($colors as $color): ?>
																		<div class="color" style="border-style: solid; border-width: 1px; background-color: <?php echo $color;?>; height: 20px; width: 20px;">
																			<input name="selectedColorsArray[]" value="<?php echo $color;?>" type="hidden" id="selectedColorsArray[]">
																		</div>
																	<?php endforeach; ?>
																<?php } else {?>
																	<script  type="text/javascript">
																		$('.selected_colors_div').hide();
																	</script>							
																<?php }?>
															</div>
														</div>
													</div>
											    </div>
											</div>
										</div>
									</div>
									<script type="text/javascript">
				            			$('#color-picker').on('change', function(){
				            				$('.selected_colors_div').show();
				            				if($('div.color[style*="background-color: '+$('#color-picker').val()+';"]').length > 0){
				            					console.log("Returned from Color-Picker");
				            					return;
				            				}
				            				var newColor = $("<div/>");
				            				newColor.addClass('color').attr('style', "border-style: solid; border-width: 1px; background-color: "+ $('#color-picker').val() + "; height: 20px; width: 20px;");
				            				var inputColor = $('<input/>');
				            				inputColor.attr("name", "selectedColorsArray[]").attr("value", $('#color-picker').val());
				            				inputColor.attr("type", "hidden");
				            				inputColor.attr("id", "selectedColorsArray[]");
				            				newColor.append(inputColor);
				            				console.log(newColor);
				            				console.log(inputColor);
				            				newColor.on('click', function(){
				            					$(this).remove();
				            				});
				            				$('#selected_colors').append(newColor);
				            			});
				                	</script>
									<div>
										<input type="submit" id="saveProduct" name="submitLoad" value="Guardar" class="btn btn-primary">
										<input type="submit" id="cancelLoad" name="submitLoad" value="Cancelar" class="btn btn-primary">
									</div>
									<script type="text/javascript">
										$("#cancelLoadCheck").hide();
										$('#cancelLoad').click(function(){
											$("#cancelLoadCheck").prop( "checked", true );
										});

									</script>
								</div>
								<div  class="col-xs-12 col-sm-12 col-md-6 col-lg-6" id="divRecentlyAddedProducts">
																		<div class="form-group">
										<h3>imagenes de producto</h3>
										<div id="freewalk-dropzone" class="dropzone"></div>
										<div class="dropzone-previews"></div>
										
										<?php if(isset($imagen)):?>
											<script type="text/javascript">
												function imagePush(image){
													$("#imagesArray").append("<input type='hidden' name='imagen[]' value='"+ image +"' />");
												}
												function imagePop(image){
													$( "input[value='" + image + "']" ).remove();
												}
												Dropzone.autoDiscover = false; // otherwise will be initialized twice
												var myDropzoneOptions = {
													paramName: "userfile",
													maxFilesize: 2,
													addRemoveLinks: true,
													clickable: true,
													url: $("#basePath").val() + "product/upload_foto",
													success: function(file, response){
														var result =  $.parseJSON(response);
														if(result.success){
															file.file_name = result.success.file_name;
															imagePush(result.success.file_name);
														}
													},
													removedfile: function(file){
														//console.log(file);
														imagePop(file.file_name);
														var _ref;
														return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
													}
												}; 
												var myDropzone = new Dropzone('#freewalk-dropzone', myDropzoneOptions);
												<?php foreach($imagen as $i): ?>
													var mockFile = { name: "Imagen", size: 12345, file_name: '<?php echo $i;?>' };
													myDropzone.options.addedfile.call(myDropzone, mockFile);
													myDropzone.options.thumbnail.call(myDropzone, mockFile, "<?php echo base_url() . PRODUCT_IMAGES_PATH . 'temp/thumbs/' . $i;?>");
												<?php endforeach; ?>
											</script>
										<?php else: ?>
											<script type="text/javascript">
												function imagePush(image){
													$("#imagesArray").append("<input type='hidden' name='imagen[]' value='"+ image +"' />");
												}

												function imagePop(image){
													$( "input[value='" + image + "']" ).remove();
												}

												Dropzone.options.freewalkDropzone = {
												  paramName: "userfile", 
												  maxFilesize: 2, 
												  url: $("#basePath").val() + "product/upload_foto",
												  addRemoveLinks: true,
												  dictCancelUpload: "Cancelar",
												  dictRemoveFile: "Borrar", 
												  acceptedFiles: "image/jpeg,image/gif,image/png",
												  dictInvalidFileType: "Solo se aceptan imagenes jpg",

												  accept: function(file, done) {
												    if (file.name == "justinbieber.jpg") {
												      done("Naha, you don't.");
												    }
												    else { done(); }
												  }, 
												  success: function(file, response){
												  	var result =  $.parseJSON(response);
												  	if(result.success){
												  		file.file_name = result.success.file_name;
												  		imagePush(result.success.file_name);
												  	}
												  },
												  removedfile: function(file){
												  	//console.log(file);
												  	imagePop(file.file_name);
												  	var _ref;
												    return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
												  }
												};
											</script>					
										<?php endif;?>

										<div id="imagesArray">
											<?php if(isset($imagen)):?>
												<?php foreach($imagen as $i): ?>
													<input id="prodImagesArray" type="hidden" name="imagen[]" value="<?php echo $i;?>">
												<?php endforeach; ?>
											<?php endif;?>
										</div>
									</div>
									<table class="table table-bordered table-striped">
										<caption>Productos Cargados</caption>
										<thead>
											<tr>
												<th>Nombre</th>
												<th>Precio</th>
												<th>Código Integrapp</th>
												<th>Código</th>
												<th>Acción</th>
											</tr>
										</thead>
										<tbody id="tableBody">
											<?php if (isset($lastLoadedProductsGrid)) { for ($i=0; $i<count($lastLoadedProductsGrid); $i++) {?> 
												<tr id="<?php echo 'tr_' . $lastLoadedProductsGrid[$i]->integrapp_code;?>">
													<td><?php echo $lastLoadedProductsGrid[$i]->name;?></td>
													<td><?php echo $lastLoadedProductsGrid[$i]->price . '$';?></td>
													<td><?php echo $lastLoadedProductsGrid[$i]->integrapp_code;?></td>
													<td><?php echo $lastLoadedProductsGrid[$i]->code;?></td>
													<td>
														<button type='submit' class="btn btn-default" name = "editRecentlyAdded" id="<?php echo $lastLoadedProductsGrid[$i]->integrapp_code;?>" form="divRecentlyAddedProducts">Editar</button>
														<button type='submit' class="btn btn-default" name = "duplicateRecentlyAdded" id="<?php echo $lastLoadedProductsGrid[$i]->integrapp_code;?>" form="divRecentlyAddedProducts">Duplicar</button>
														<button type='submit' class="btn btn-default" name = "deleteRecentlyAdded" id="<?php echo $lastLoadedProductsGrid[$i]->integrapp_code;?>" form="divRecentlyAddedProducts">Eliminar</button>
													</td>
												</tr>
											<?php }}; ?>
											
										</tbody>
									</table>
								</div>
								<div id= "recentlyAddedIntegrappCodes">
									<?php if (isset($lastLoadedProductsGrid)) { for ($i=0; $i<count($lastLoadedProductsGrid); $i++) {?> 
										<input type="text" name = "recentlyAddedIntegrappCode[]" id="recentlyAddedIntegrappCode[]" value="<?php echo $lastLoadedProductsGrid[$i]->integrapp_code;?>">
									<?php }}; ?>

									<script type="text/javascript">
										$("#recentlyAddedIntegrappCodes").hide();

									</script>
								</div>
							</div>
						</div>

					</form>			    
				</div>
				</div>


			</div>
<!-- 			<div role="tabpanel" class="tab-pane fade" id="settings">...</div> -->
	</div>

</section>