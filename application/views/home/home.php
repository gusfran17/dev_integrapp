
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
						<h1 class="">INTEGRAPP</h1>
						<h2 class="">Primer sitio que centraliza el mercado de ortopedias</h2>
					</div>
					<div class="col-md-7" id="banner">
						<figure>
							<img src="<?php echo base_url(); ?>/Resources/imgs/banner.jpg" alt="">
						</figure>
					</div>
				</div>
			</header>
			<article>
				<div class="container">
					<h3>Últimos productos publicados</h3>
					<div class="row">
						<?php if (count($Catalog)>0) {?>
							<?php for ($i=0; $i < 4; $i++) {?>
								<a href="<?php echo base_url() . 'product/viewProduct/' . $Catalog[$i]->id; ?>">
									<div class="col-md-3 col-sm-4 col-xs-6 item-catalogo">
										<div class="producto-container" style="text-align:center;">
											<img src="<?php echo base_url() . PRODUCT_IMAGES_PATH . $Catalog[$i]->images[0]; ?>" alt="..." style="max-height: 200px;">
											<div class="jquery-description">
												<h4><?php echo $Catalog[$i]->name; ?></h4> 
												<?php echo $Catalog[$i]->description; ?>
											</div>
										</div>
									</div>
								</a>
							<?php }?>	
						<?php }?>
					</div>
					<br>
					<a href="#">Ver mas</a>
				</div>
			</article>
						<article>
				<div class="container">
					<h3>Distribuidores por zona</h3>
					
					<a href="">Ver mas</a>
				</div>
			</article>
		</div>