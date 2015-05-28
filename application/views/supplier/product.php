<section id="home">
	<h1>PRODUCTOS</h1>
	<div class="container-fluid" id="main-products">
		<div role="tabpanel">

		  
		  <ul class="nav nav-tabs" role="tablist">
		    <li role="presentation" class="active"><a href="#catalog" aria-controls="catalog" role="tab" data-toggle="tab">Catalogo</a></li>
		    <li role="presentation"><a href="#my-products" aria-controls="my-products" role="my-products" data-toggle="tab">Mis Productos</a></li>
		    <li role="presentation"><a href="#load-products" aria-controls="load-products" role="load-products" data-toggle="tab">Cargar Productos</a></li>
		    <li role="presentation"><a href="#settings" aria-controls="settings" role="settings" data-toggle="tab">Ajustes</a></li>
		  </ul>

		  
		  <div class="tab-content">
		    <div role="tabpanel" class="tab-pane fade inactive" id="catalog">...</div>
		    <div role="tabpanel" class="tab-pane fade" id="my-products">...</div>
		    <div role="tabpanel" class="tab-pane fade" id="load-products">
		    	<h3>Tips:</h3>
		    	<ul>
		    		<li>Recuerde que el nombre de cada producto no puede ser el mismo de un producto ya cargado con anterioridad.</li>
		    		<li>Recuerde que el código de cada producto no puede ser el mismo de un producto ya cargado con anterioridad.</li>
		    		<li>Recuerde que puede duplicar un producto cargado y editar solo la informacion necesaria para autopopular la planilla de Carga de Productos y no volver a escribir todo a mano.</li>
		    		<li>Recuerde no molestar a la gente de IT por una mala experiencia de usuario.</li>
		    	</ul>
		    	<div class="row" id="productSection">
				    <div class="panel panel-primary" id="">
								<div class="panel-heading">
									<div class="panel-title">
										<h4>Para comenzar seleccione una categoria:</h4>
									</div>
								</div>
								<div class="panel-body">

									<div class="col-md-4" id="products">
										<select name="" id="category1">
											<option value="">Seleccione una categoria...</option>
											<?php foreach ($category as $option) {
												echo "<option id='".$option->id."'>".$option->name."</option>";
											} ?>
										</select>
									</div>
									
					    		</div>
					</div>
					<form class="region size1of2" action="<?php echo base_url(); ?>product/save" method="post" id="">
						<div class="panel panel-info">
							<div class="panel-heading">
								<div class="panel-title">
									<h4>Planilla Datos de Producto</h4>
								</div>
							</div>
							<div class="panel-body">
								<div class="col-xs-12 col-sm-12 col-md-6 col-lg-5">
									<div class="form-group">
										<label for="" class="control-label">Categoria seleccionada</label>
										<input type="text" class="form-control" id="categoryTree" name="" value="">
									</div>
									<div class="form-group">
										<label for="" class="control-label">Nombre del producto*</label>
											<?php echo form_error('productName', '<span class="label label-danger">', '</span>'); ?>
										<input type="text" class="form-control" name="productName" placeholder="Ingrese un nombre único...">
									</div>
									<div class="form-group">
										<label for="" class="control-label">Código*</label>
											<?php echo form_error('productCode', '<span class="label label-danger">', '</span>'); ?>
										<input type="text" class="form-control" name="productCode" placeholder="Ingrese el ID del código único del producto...">
									</div>
									<div class="form-group">
										<label for="" class="control-label">Condición IVA*</label>
											<?php echo form_error('productVAT', '<span class="label label-danger">', '</span>'); ?>
										<input type="text" class="form-control" name="productVAT" placeholder="Ni idea...">
									</div>
									<div class="form-group">
										<label for="" class="control-label">Descripción*</label>
											<?php echo form_error('productDesc', '<span class="label label-danger">', '</span>'); ?>
										<textarea class="form-control" name="productDesc"></textarea> 
									</div>
									<div class="input_fields_wrap">
										<h3>Especificaciones técnicas</h3>
									    <button class="add_field_button btn btn-primary btn-md">Agregar mas campos</button>
									    <div>
									    	<div class="form-group">
											    <input type="text" name="" placeholder="" value="Ej.:Ancho" disabled>
											    <input type="text" name="" placeholder="" value="Ej.:30cm" disabled>
											</div>   
									    </div>
									</div>
									<!--<div>
									<h3>Imagenes</h3>
										<form action="../Dropzone/upload" class="dropzone"></form>
									</div>-->
									
									<div class="form-group">
										<input type="submit" value="Guardar" class="btn btn-primary">
									</div>
								</div>

							</div>
						</div>
					</form>			    
				</div>
			</div>
			<div role="tabpanel" class="tab-pane fade" id="settings">...</div>
	</div>
</section>