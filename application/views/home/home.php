
		<div id="carousel_home" class="carousel slide" data-ride="carousel">
			<div class="carousel-inner" role="listbox">
			    <div class="item active">
			        <img src="<?php echo base_url(); ?>/Resources/imgs/1.png" alt="..." style="margin: left;">
			    </div>
				<div class="item">
					<img src="<?php echo base_url(); ?>/Resources/imgs/2.png" alt="..." style="margin: left;">
				</div>
				<div class="item">
				    <img src="<?php echo base_url(); ?>/Resources/imgs/3.png" alt="..." style="margin: left;">
				</div>
			</div>
		</div>
		<div id="page-wrapper" class="container-fluid">
			<header>
				<div class="row">
					<div class="col-md-5">
						<h1 class=""><b>INTEGRAPP</b></h1>
						<h2 class="">Primer sitio que centraliza el mercado de ortopedias</h2>
					</div>
					<div class="col-md-7" id="banner">
						<figure>
							<img src="<?php echo base_url(); ?>/Resources/imgs/banner.jpg" alt="">
						</figure>
					</div>
				</div>
			</header>
			<div class="container">
				<h3>Últimos productos publicados</h3>
				<?php if (count($Catalog)>0) {?>
					<?php for ($i=0; $i < 4; $i++) {?>
						<a href="<?php echo base_url() . 'product/viewProduct/' . $Catalog[$i]->id; ?>">
							<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 item-catalogo" >
								<div class="panel panel-info" style="background-color: #FFF;">
									<div class="panel-body" style="height:350px">
										<div style="height:200px">
											<img src="<?php echo base_url() . PRODUCT_IMAGES_PATH . $Catalog[$i]->images[0]; ?>" style="max-width: 100%;display: block;margin: 0 auto;max-height: 200px;">	
										</div>
										<div class="" style="text-align:center;">
											<div class="">
												<h4><?php echo $Catalog[$i]->name; ?></h4> 
												<?php echo $Catalog[$i]->description; ?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</a>
					<?php }?>	
				<?php }?>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 item-catalogo" >
					<a href="<?php echo base_url(); ?>home/catalog">
						<button type="submit" onclick="" class="btn btn-success btn-sm">
							<span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> 
							Ver más...
						</button>
					</a>
				</div>		
			</div>
		</div>