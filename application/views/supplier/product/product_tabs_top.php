<section id="home" >
	<div class="container-fluid" id="main-products">
		<div class="page-header" style="text-align:center; margin: 0px 0 0px;">
			<?php if($loadInfo->activeProducts>0):?>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
					</div>
					<div class="alert alert-info alert-dismissible col-lg-6 col-md-6 col-sm-6 col-xs-6" role="alert">
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					  <strong>Recuerde...</strong> Tiene <?php echo $loadInfo->activeProducts;?> productos activos sin publicar <br>
					  <a href="<?php echo base_url() . 'Product/showActiveProducts'; ?>"><b>Ver productos activos</b></a>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
					</div>
				</div>
			<?php endif;?>			
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