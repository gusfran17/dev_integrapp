				        <li><a href="<?php echo base_url(); ?>Product">PRODUCTOS</a></li>
				        <li><a href="<?php echo base_url(); ?>suppliers">MAYORISTAS</a></li>
						<li class="dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown" href=""><b><?php if (isset($username)) echo $username . " "; else echo "Perfil  "; ?></b><span class="glyphicon glyphicon-user" aria-hidden="true"></span></a>
							<ul class="my-account-mn dropdown-menu">
								<li><a href="<?php echo base_url(); ?>profile/account"><i class="fa fa-user fa-fw"></i> Mi Cuenta</a></li>
								<li><a href="<?php echo base_url(); ?>login/logout"><i class="fa fa-sign-out fa-fw"></i> Cerrar sesión</a></li>
							</ul>
						</li>     
			      	</ul>
			    </div>
			</nav>


		
