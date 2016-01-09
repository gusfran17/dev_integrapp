	<body>
		<div id="wrapper">
			<nav class="navbar navbar-inverse navbar-fixed-top">
			    <div class="navbar-header" style="width:300px">
		            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
		                <span class="sr-only">Toggle navigation</span>
		                <span class="icon-bar"></span>
		                <span class="icon-bar"></span>
		                <span class="icon-bar"></span>
		            </button>
			      	<a class="navbar-brand" href="<?php echo base_url(); ?>"><figure><img src="<?php echo base_url(); ?>/Resources/imgs/logo_small.png" alt="Logo"></figure></a>
			    </div>
				    <form class="navbar-form navbar-left" role="search" action="<?php echo base_url() . 'Product/search'; ?>" method="post">
						<div class="input-group" style="padding-top:20px;" class="searchOver">
					    	<input type="text" name="searchCatalog" class="form-control" placeholder="Buscar">
					    	<span class="input-group-btn">
					        	<button class="btn btn-info" type="submit"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
					    	</span>
					  	</div>
					</form>	   
				<div class="collapse navbar-collapse navbar-inverse navbar-ex1-collapse">
			    <ul class="nav navbar-right top-nav" id="bs-example-navbar-collapse-1">
		        