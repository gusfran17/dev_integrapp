					
			    		<?php if(isset($productLoaded)):?>
			    			<div class="alert alert-warning alert-dismissible" role="alert">
							  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span></button>
							  <strong><span class="glyphicon glyphicon-check" aria-hidden="true"></span></strong>
							  <strong>¡Felicitaciones!</strong> El producto ha sido cargado exitosamente. Puede encontrar el mismo más abajo. Desde alli puede editarlo, duplicarlo o eliminarlo.
							</div>
						<?php endif;?>
						<?php if(isset($productCancelled)):?>
			    			<div class="alert alert-warning alert-dismissible" role="alert">
							  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span></button>
							  <strong><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span></strong>
							  <strong>¡Atencion!</strong> La operacion ha sido cancelada.
							</div>
						<?php endif;?>
						<?php if($this->session->flashdata('success') != null):?>
							<div class="alert alert-dismissable alert-success" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span></button>
								<strong><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span></strong>
							 	<strong>Bien!</strong> <?php echo $this->session->flashdata('success'); ?></a>
							</div>
						<?php endif;?>
						<?php if($this->session->flashdata('error') != null):?>
							<div class="alert alert-dismissable alert-danger" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span></button>
								<strong><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span></strong>
							 	<strong>Atención!</strong> <?php echo $this->session->flashdata('error'); ?></a>
							</div>
						<?php endif;?>

					    <div class="panel panel-primary" id="categorySelection">
									<div class="panel-heading">
										<div class="panel-title">
											<h4>Seleccione una categoria:</h4>
										</div>
									</div>
									<div class="panel-body">

										<div class="col-md-3 productsCategorySelect" id="productsCategorySelect">
											<select name="category1" id="category1" class= "categories col-xs-12 col-sm-12 col-md-12 col-lg-12">
												<option id="0">Seleccione una categoria...</option>
												<?php foreach ($loadCategory as $option) {
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
						<form class="region size1of2" action="<?php echo base_url(); ?>product/saveProduct" method="post" id="formLoadProducts" style="margin-top: 20px;">
							<div class="panel panel-info">
								<div class="panel-heading">
									<div class="panel-title">
										<h4>Planilla Datos de Producto</h4>
									</div>
								</div>
								<div class="panel-body">
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
										<div id="editionAlert">
											<!-- This is filled with an alert when product is being edited, copied or deleted 
											The following is for when form validation occurs in edition-->
											<?php if(isset($editProduct)):?>
												<div class="alert alert-warning alert-dismissible" role="alert">
													<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span></button>
													<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
													<strong>¡Atención!</strong> Se encuentra editando un producto.<br>Para volver a cargar un producto desde el inicio debe presionar en <b>Cancelar</b> al final de la pantalla.
												</div>
											<?php endif;?>
										</div>
										<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5" id="formOptions">
											<div class="form-group">
												<label for="" class="control-label">Categoria seleccionada</label> (Seleccione la categoria en la sección superior)
												<?php echo form_error('categoryTree', '<span class="label label-danger">', '</span>'); ?>
												<input type="text" class="form-control" id="categoryTree" name="categoryTree" value="<?php if (isset($editProduct)) echo set_value('categoryTree', $editProduct->category->ascending_path); else if (!(isset($productLoaded) or isset($productCancelled))) echo set_value('categoryTree');?>" >
												<input type="text" name="categoryID" value="<?php if (isset($editProduct)) echo set_value('categoryID', $editProduct->category_id); else if (!(isset($productLoaded) or isset($productCancelled))) echo set_value('categoryID');?>" id="categoryID">
												<input type="text" name="editProductID" value="<?php if (isset($editProduct)) echo set_value('editProductID',$editProduct->id); else if (!(isset($productLoaded) or isset($productCancelled))) echo set_value('editProductID');?>" id="editProductID">
												<input type="text" name="editProductStatus" value="<?php if (isset($editProduct)) echo set_value('editProductStatus',$editProduct->status); else if (!(isset($productLoaded) or isset($productCancelled))) echo set_value('editProductStatus');?>" id="editProductStatus">
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
													$("#editProductStatus").hide();
													$("#imagesPath").hide();
													$("#basePath").hide();
													$("#categoryTree").attr('disabled','disabled');
													if ($("#editProductStatus").val() == "published"){
														$("#categorySelection").hide();
													}
												</script>

											</div>
											<div class="form-group">
												<label for="" class="control-label">Nombre del producto*</label>
												<?php echo form_error('productName', '<span class="label label-danger">', '</span>'); ?>
												<input type="text" class="form-control" name="productName" id="productName" placeholder="Ingrese un nombre único..." value="<?php if (isset($editProduct)) echo set_value('productName', $editProduct->name); else if (!(isset($productLoaded) or isset($productCancelled))) echo set_value('productName');?>">
											</div>
											<div class="form-group">
												<label for="" class="control-label">Código*</label>
												<?php echo form_error('productCode', '<span class="label label-danger">', '</span>'); ?>
												<input type="text" class="form-control" name="productCode" id="productCode" placeholder="Ingrese el código (único) del producto..." value="<?php if (isset($editProduct)) echo set_value('productCode', $editProduct->code); else if (!(isset($productLoaded) or isset($productCancelled))) echo set_value('productCode');?>">
											</div>
											<div class="form-group">
												<label for="" class="control-label">Condición IVA*</label>
												<select class="form-control" name="productVAT" id="productVAT">
													<option value="0%" id="IVA0" <?php if (isset($editProduct)){ if ($editProduct->tax == '0%') echo 'selected';} else if (!(isset($productLoaded) or isset($productCancelled))) echo set_select('productVAT', '0%', TRUE); ?> >0%</option>
													<option value="10,5%" id="IVA1" <?php if (isset($editProduct)){ if ($editProduct->tax == '10,5%') echo 'selected';} else if (!(isset($productLoaded) or isset($productCancelled))) echo set_select('productVAT', '10,5%'); ?> >10,5%</option>
													<option value="21%" id="IVA2" <?php if (isset($editProduct)){ if ($editProduct->tax == '21%') echo 'selected';} else if (!(isset($productLoaded) or isset($productCancelled))) echo set_select('productVAT', '21%'); ?> >21%</option>
													<option value="27%" id="IVA3" <?php if (isset($editProduct)){ if ($editProduct->tax == '27%') echo 'selected';} else if (!(isset($productLoaded) or isset($productCancelled))) echo set_select('productVAT', '27%'); ?> >27%</option>
												</select>
											</div>
											<div class="form-group">
												<label for="" class="control-label">Precio (sin IVA)*</label>
												<?php echo form_error('productPrice', '<span class="label label-danger">', '</span>'); ?>
												<input type="text" class="form-control" name="productPrice" id="productPrice" placeholder="Ingrese el precio del producto..." value="<?php if (isset($editProduct)) echo set_value('productPrice', $editProduct->price); else if (!(isset($productLoaded) or isset($productCancelled))) echo set_value('productPrice');?>">
											</div>
											<div class="form-group">
												<label for="productDesc" class="control-label">Descripción*</label>
												<?php echo form_error('productDesc', '<span class="label label-danger">', '</span>'); ?>
												<textarea class="form-control" name="productDesc" id="productDesc"><?php if (isset($editProduct)) echo set_value('productDesc', $editProduct->description); else if (!(isset($productLoaded) or isset($productCancelled))) echo set_value('productDesc');?></textarea> 
												
											</div>
											<div class="form-group">
												<label for="productIndic" class="control-label">Indicaciones (aplicaciones del producto)</label>
												<?php echo form_error('productIndic', '<span class="label label-danger">', '</span>'); ?>
												<textarea class="form-control" name="productIndic" id="productIndic"><?php if (isset($editProduct)) echo set_value('productIndic', $editProduct->indications); else if (!(isset($productLoaded) or isset($productCancelled))) echo set_value('productIndic');?></textarea> 
												
											</div>
											<div class="form-group">
												<label for="productPresc" class="control-label">Como Prescribirlo*</label>
												<?php echo form_error('productPresc', '<span class="label label-danger">', '</span>'); ?>
												<textarea class="form-control" name="productPresc" id="productPresc"><?php if (isset($editProduct)) echo set_value('productPresc', $editProduct->prescription); else if (!(isset($productLoaded) or isset($productCancelled))) echo set_value('productPresc');?></textarea> 
												
											</div>
											<div class="panel panel-default">
												<div class="panel-heading">
													<div class="panel-title">
														<h4>Especificaciones técnicas</h4>
													</div>
												</div>
												<div class="panel-body" style="margin: 10px 10px 10px 10px; padding-left: 0px;">
													<div>
													    <div>
													    	<div class="input_fields_wrap panel panel-info col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin: 10px 10px 10px 10px">
													    		<label for="" class="control-label">Variantes Exitentes (medidas, talles, etc.)</label><p>(Si agrega campos no los deje vacios porque estos no serán guardados)</p>
													    		<button class="add_field_button btn btn-success btn-sm"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> Agregar mas campos</button>
																<div class="form-group">
																    <label for="" class="col-xs-6 col-sm-6 col-md-6 col-lg-6">Atributo</label>
																	<label for="" class="col-xs-6 col-sm-6 col-md-6 col-lg-6">Valor</label>
															    </div>
																<?php if (isset($attributes)) { 
																	for ($i=0; $i<count($attributes); $i++) {?> 
																		<div class="form-group_specifications">
																			<textarea type="text" id="<?php echo $i+1; ?>" name="<?php echo 'attribute'. ($i+1);?>" placeholder="Ej.:Ancho" class="col-xs-5 col-sm-5 col-md-5 col-lg-5" style="margin-right:10px;">
																				<?php echo  $attributes[$i]->attribute_name;?>
																			</textarea>
																			<textarea type="text" id="<?php echo $i+1; ?>" name="<?php echo 'value'. ($i+1);?>" placeholder="Ej.:30cm" class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
																				<?php echo  $attributes[$i]->attribute_value;?>
																			</textarea>
																			<a href="#" class="remove_field"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
																		</div>
																	<?php }
																} else { ?>	
																	<div class="form-group_specifications">
																	    <textarea type="text" name="0" name="attribute0" placeholder="Ej.:Talle" value="" class="col-xs-5 col-sm-5 col-md-5 col-lg-5" style="margin-right:10px;"></textarea>
																	    <textarea type="text" name="0" name="value0" placeholder="Ej.:XS/S/M/L/XL" value="" class="col-xs-6 col-sm-6 col-md-6 col-lg-6"></textarea><a href="#" class="remove_field"> <span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
																    </div>
																<?php } ?>														
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
																				<div class="color" style="border-style: solid; border-width: 1px; background-color: <?php echo $color->color;?>; height: 20px; width: 20px;">
																					<input name="selectedColorsArray[]" value="<?php echo $color->color;?>" type="hidden" id="selectedColorsArray[]">
																				</div>
																			<?php endforeach; ?>
																		<?php } else { ?>
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

												$('.color').on('click', function(){
													$(this).remove();
												});
						                	</script>
										</div>
										<div  class="col-xs-12 col-sm-12 col-md-7 col-lg-7" id="divRecentlyAddedProducts">
											<div class="form-group">
												<h3>imagenes de producto</h3>
												<div id="freewalk-dropzone" class="dropzone"></div>
												<div class="dropzone-previews"></div>
												
												<?php if(isset($images)):?>
													<script type="text/javascript">
														function imagePush(image){
															$("#imagesArray").append("<input type='hidden' name='images[]' value='"+ image +"' />");
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
														<?php foreach($images as $i): ?>
															var mockFile = { name: "images", size: 12345, file_name: '<?php echo $i;?>' };
															myDropzone.options.addedfile.call(myDropzone, mockFile);
															myDropzone.options.thumbnail.call(myDropzone, mockFile, "<?php if (isset($editProduct)) echo base_url() . PRODUCT_IMAGES_PATH . $i; else echo base_url() . PRODUCT_IMAGES_PATH . $i;?>");
														<?php endforeach; ?>
													</script>
												<?php else: ?>
													<script type="text/javascript">
														function imagePush(image){
															$("#imagesArray").append("<input type='hidden' name='images[]' value='"+ image +"' />");
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
													<?php if(isset($images)):?>
														<?php foreach($images as $i): ?>
															<input id="prodImagesArray" type="hidden" name="images[]" value="<?php echo $i;?>">
														<?php endforeach; ?>
													<?php endif;?>
												</div>
											</div>
											<table class="table table-bordered table-striped">
												<caption>Productos Cargados</caption>
												<thead>
													<tr>
														<th>Nombre</th>
														<th>Precio (sin IVA)</th>
														<th>Código Integrapp</th>
														<th>Código</th>
														<th>Acción</th>
													</tr>
												</thead>
												<tbody id="tableBody">
													<?php if (isset($lastLoadedProductsGrid)) { for ($i=0; $i<count($lastLoadedProductsGrid); $i++) {?> 
														<tr id="<?php echo 'tr_' . $lastLoadedProductsGrid[$i]->integrapp_code;?>">
															<td><?php echo $lastLoadedProductsGrid[$i]->name;?></td>
															<td><?php echo '$'.number_format($lastLoadedProductsGrid[$i]->price, PRICE_DECIMAL_AMOUNT, DECIMAL_SEPARATOR, THOUSANDS_SEPARATOR);?></td>
															<td><?php echo $lastLoadedProductsGrid[$i]->integrapp_code;?></td>
															<td><?php echo $lastLoadedProductsGrid[$i]->code;?></td>
															<td>
																
																<button type='submit' class="btn btn-success btn-xs" name = "editRecentlyAdded" id="<?php echo $lastLoadedProductsGrid[$i]->integrapp_code;?>" form="divRecentlyAddedProducts"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Editar</button>
																<button type='submit' class="btn btn-success btn-xs" name = "duplicateRecentlyAdded" id="<?php echo $lastLoadedProductsGrid[$i]->integrapp_code;?>" form="divRecentlyAddedProducts"><span class="glyphicon glyphicon-duplicate" aria-hidden="true"></span> Duplicar</button>
																<!-- <button type='submit' class="btn btn-warning btn-xs" name = "deleteRecentlyAdded" id="<?php echo $lastLoadedProductsGrid[$i]->integrapp_code;?>" form="divRecentlyAddedProducts">Eliminar</button> -->
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
											<?php if (isset($editProduct)) { ?> 
												<input type="text" name = "recentlyAddedIntegrappCode[]" id="recentlyAddedIntegrappCode[]" value="<?php echo $editProduct->integrapp_code;?>">
											<?php }; ?>
											<script type="text/javascript">
												$("#recentlyAddedIntegrappCodes").hide();

											</script>
										</div>
									</div>
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align:center;">
										<button type="submit" id="saveProduct" name="submitLoad" value="Guardar" class="btn btn-success btn-lg"><span class='glyphicon glyphicon-floppy-save' aria-hidden='true'></span> Guardar</button>
										<button type="submit" id="cancelLoad" name="submitLoad" value="Cancelar" class="btn btn-warning btn-lg"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Cancelar</button>
									</div>

								</div>
							</div>

						</form>			    
					