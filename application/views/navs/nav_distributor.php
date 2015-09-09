			        <li><a href="<?php echo base_url(); ?>Product/products">PRODUCTOS</a></li>
			        <li><a href="<?php echo base_url(); ?>suppliers/viewSuppliers">PROVEEDORES</a></li>
			        <li><a href="<?php echo base_url(); ?>profile/request">PEDIDOS</a></li>
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href=""><b><?php if (isset($username)) echo $username . " "; else echo "Perfil  "; ?></b><span class="glyphicon glyphicon-user" aria-hidden="true"></span></a>
						<ul class="my-account-mn dropdown-menu">
							<li><a href="<?php echo base_url(); ?>profile/account"><i class="fa fa-user fa-fw"></i> Mi Cuenta</a></li>
							<li><a href="<?php echo base_url(); ?>login/logout"><i class="fa fa-sign-out fa-fw"></i> Cerrar sesión</a></li>
						</ul>
					</li>     
		      	</ul>
				<?php if (!(isset($hasSidebar))){ ?>
					</nav>
				<?php }?>


		
