<section id="home" >
	<div class="container-fluid" id="main-products">
		<div class="page-header" style="text-align:center; margin: 0px 0 0px;">
			<h2><span class="label label-default" style="color:#ffffff;"><b>PRODUCTOS</b></span></h2>
		</div>
		<div role="tabpanel">  
			<ul class="nav nav-pills" role="tablist" style="padding: 5px 5px 5px 5px;">
				<li role="presentation" class="<?php if (((!(isset($productLoadView)))) and (!(isset($viewMyCatalog)))) {echo "active";} ?>"><a href="<?php echo base_url() . 'Product/products'; ?>"><b><span class="glyphicon glyphicon-list" aria-hidden="true"></span> Catalogo</b></a></li>
			    <li role="presentation" class="<?php if (((!(isset($productLoadView)))) and (isset($viewMyCatalog))) {echo "active";} ?>"><a href="<?php echo base_url() . 'Product/myProducts'; ?>"><b><span class="glyphicon glyphicon-list" aria-hidden="true"></span> Mi Catalogo</b></a></li>
			    <li role="presentation" class="<?php if (isset($productLoadView)) { echo "active";} ?>"><a href="<?php echo base_url() . 'Product/productLoadView'; ?>"><b><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> Cargar Productos</b></a></li>
			    <!-- <li role="presentation"><a href="#settings" aria-controls="settings" role="settings" data-toggle="tab">Ajustes</a></li> -->
			</ul>
		</div>  
		<div class="tab-content">
		    <div role="tabpanel" class="tab-pane fade active in" id="catalog">
				<div class="row panel panel-primary" style="padding: 10px 10px 10px 10px;">