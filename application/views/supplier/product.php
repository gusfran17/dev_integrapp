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
		    	<div class="row">
				<div class="col-md-2">
					<select name="" id="FirstCategory">
						<option value="">Seleccione una categoria...</option>
						<?php foreach ($category as $option) {
							echo "<option id='".$option->id."'>".$option->id." - ".$option->name."</option>";
						} ?>
					</select>
					
				</div>
				<div id='result' class=""></div>

		    </div>
		    <div role="tabpanel" class="tab-pane fade" id="settings">...</div>
		  </div>

		</div>
	</div>
</section>