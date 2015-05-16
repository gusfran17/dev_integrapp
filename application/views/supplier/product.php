<section id="home">
	<h1>CARGA DE PRODUCTOS</h1>
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
		    	<h3>Por favor, seleccione una categoria para comenzar...</h3>
		    	<div class="row" id="productSection">
					<div class="col-md-3" id="products">
						<select name="" id="category1">
							<option value="">Seleccione una categoria...</option>
							<?php foreach ($category as $option) {
								echo "<option id='".$option->id."'>".$option->name."</option>";
							} ?>
						</select>
					</div>
					<div class="col-md-4"><div id="input1" class="input"><label for="selectedCategory">Categoria Seleccionada: <br><input name="selectedCategory" type="text" value=" "></label></div></div>
			    </div>
				<div class="row">
					<div class="col-md-6" id="properties">
						<h3>Propiedades:</h3>
						<label for="#medidas">Medidas</label>
						<div id="medidas">
							<h4>Medidas</h4>
						</div>
						<div></div>
						<div></div>
						<div></div>
					</div>
				</div>			    
			</div>
		    <div role="tabpanel" class="tab-pane fade" id="settings">...</div>
		</div>
	</div>
</section>