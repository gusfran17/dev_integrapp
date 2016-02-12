<!DOCTYPE html>
<html>
  <head>
    <link rel="icon" href="<?php echo base_url(); ?>Resources/img/favicon.png" type="image/x-icon">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,600,700,300,200" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url(); ?>Resources/styles/reset.css" type="text/css" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">    
    <link href="<?php echo base_url(); ?>Resources/styles/main.css" type="text/css" rel="stylesheet" />
    <title>Integrapp</title>
  </head>
  <body class="landingIntegrapp">
    <header>
      <div class="widthContent">
        <nav>
          <div class="search">
          </div>
          <ul>
            <li><a href="<?php echo base_url(); ?>home/catalog">CATALOGO</a></li>
            <li><a href="<?php echo base_url(); ?>home/faq">FAQ</a></li>
            <li><a href="<?php echo base_url(); ?>home/contact">CONTACTO</a></li>
            <li><a href="<?php echo base_url(); ?>login">LOGIN</a></li>
            <li><i class="icon-search"></i>
              <form class="navbar-form navbar-left" role="search" action="<?php echo base_url() . 'Product/search'; ?>" method="post">
                <input type="text" name="searchCatalog" placeholder="Buscar un producto..." class="landing-search">
              </form>            
            </li>
          </ul>
        </nav>
        <div class="logo">
          <a href="<?php echo base_url(); ?>"><img src="Resources/img/logoIntegrapp.png" alt="Logo Integrapp"></a>
        </div>
      </div>
    </header>
    <div class="wrapper">
      
      
      <div class="principal-content">
        <h2 class="principalText">Primer Catálogo Ortopédico Online.</h2><a href="<?php echo base_url(); ?>home/catalog" class="principal-btn">Ver Productos</a>
      </div>
      <section class="products">
        <div class="section-title">
          <h3>Productos</h3>
        </div>
        <div class="container">
          <div class="row">
            <?php if (count($Catalog)>0) {?>
              <?php for ($i=0; $i < ((count($Catalog)>2)? 3:count($Catalog)) ; $i++) {?>
                <a href="<?php echo base_url() . 'product/viewProduct/' . $Catalog[$i]->id; ?>">
                  <div class="col-sm-4">
                    <div class="product-container">
                      <div class="product">
                        <figure><img src="<?php echo base_url() . PRODUCT_IMAGES_PATH . $Catalog[$i]->images[0]; ?>"></figure>
                      </div>
                      <div class="product-share-container">
                        <ul>
                          <li><i class="icon-twitter"></i></li>
                          <li><i class="icon-facebook"></i></li>
                          <li><i class="icon-link"></i></li>
                          <li><?php echo $Catalog[$i]->integrapp_code; ?></li>
                        </ul>
                      </div>
                      <div class="product-txt">
                        <span class="product-title"><?php echo $Catalog[$i]->name; ?></span>
                        <span><?php echo $Catalog[$i]->description; ?></span>
                      </div>
                    </div>
                  </div>
                </a>
              <?php }?> 
            <?php }?>
          </div>
        </div>
        <div class="products-btn-container"><a href="<?php echo base_url(); ?>home/catalog" class="principal-btn products-btn">Ver mas ...</a></div>
      </section>
      <section class="services benefits">
        <div class="section-title">
          <h3>Beneficios</h3>
        </div>
        <div class="container">
          <div class="row">
            <div class="col-sm-4">
              <div class="service-container">
                <div class="service"><i class="icon-preferences"></i></div>
                <div class="service-txt"><span class="service-title">Facíl y práctico</span><span>Con diseño simple y amigable, podes crear tu propio catálogo sin conocimientos técnicos.</span></div>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="service-container">
                <div class="service"><i class="icon-site"></i></div>
                <div class="service-txt"><span class="service-title">Plataforma Integrada</span><span>Conectate con todos los proveedores y Ortopedias del mercado.</span></div>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="service-container">
                <div class="service"><i class="icon-graphic"></i></div>
                <div class="service-txt"><span class="service-title">Compra Segura</span><span>Con transferencias bancarias desde tu propia cuenta.</span></div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <div class="principal-content picture-2">
      </div>
      <section class="services">
        <div class="section-title">
          <h3>Servicios</h3>
        </div>
        <div class="container">
          <div class="row">
            <div class="col-sm-4">
              <div class="service-container">
                <div class="service"><i class="icon-zoom"></i></div>
                <div class="service-txt"><span class="service-title">Catálogo Online</span><span>El catálogo más completo en soluciones ortopedias del país.</span></div>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="service-container">
                <div class="service"><i class="icon-doc"></i></div>
                <div class="service-txt"><span class="service-title">Recetario Clínico</span><span>Pacientes y profesionesles pueden imprimir las recetas de los productos consultados.</span></div>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="service-container">
                <div class="service"><i class="icon-business"></i></div>
                <div class="service-txt"><span class="service-title">Asociaciones Comerciales</span><span>Conectate con proveedores y accedé a beneficios y lista de precios actualizadas.</span></div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <footer>
        <div class="widthContent">
          <ul>
            <li>Copyright 2016</li>
            <li>Todos los derechos reservados</li>
            <li>Developed By Gustavo Franco</li>
          </ul>
          <ul>
            <li>(+549) 11-6402-4497</li>
            <li> <a href="mailto:info@integrapp.com.ar">info@integrapp.com.ar</a></li>
          </ul>
        </div>
      </footer>
    </div>
  </body>
  <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>Resources/scripts/main_script.js"></script>     
</html>