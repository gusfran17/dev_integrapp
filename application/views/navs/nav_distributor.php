			        <li><a href="<?php echo base_url(); ?>profile/product">PRODUCTOS</a></li>
			        <li><a href="<?php echo base_url(); ?>suppliers/viewSuppliers">PROVEEDORES</a></li>
			        <li><a href="<?php echo base_url(); ?>profile/request">PEDIDOS</a></li>
			        <li>
						<div class="btn-group">
							<div type="button" class="my-account-btn btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<a href=""><?php if (isset($userdata)) echo $userdata . " "; else echo "Perfil  "; ?><span class="glyphicon glyphicon-user" aria-hidden="true"></span></a>
							</div>
							<ul class="my-account-mn dropdown-menu">
								<li><a href="<?php echo base_url(); ?>profile/account">Mi Cuenta</a></li>
								<li><a href="<?php echo base_url(); ?>login/logout">Cerrar sesión</a></li>
							</ul>
						</div>
					</li>
			      </ul>
			    </div>
			  </div>
			</nav>
		</header>