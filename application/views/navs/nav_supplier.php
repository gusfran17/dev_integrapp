			        <li><a title="<?php if ($loadInfo->activeProducts>0) echo 'Tiene ' . $loadInfo->activeProducts . ' productos sin publicar'; ?>" href="<?php echo base_url(); ?>Product/myProducts">PRODUCTOS <?php if ($loadInfo->activeProducts>0) echo '<span class="badge">' . $loadInfo->activeProducts . '</span>'; ?></a></li>
			        <li><a title="<?php if ($loadInfo->activeProducts>0) echo 'Tiene ' . $loadInfo->pendingDistributors . ' solicitudes pendientes'; ?>" href="<?php echo base_url(); ?>Distributors/viewDistributors">ORTOPEDIAS <?php if ($loadInfo->pendingDistributors>0) echo '<span class="badge">' . $loadInfo->pendingDistributors . '</span>'; ?></a></li>
			        <li><a href="<?php echo base_url(); ?>profile/auction">SUBASTA</a></li>
			        <li><a href="<?php echo base_url(); ?>profile/credit">CREDITO</a></li>
    				<li>
						<div class="btn-group">
							<div type="button" class="my-account-btn btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<a href=""><?php if (isset($username)) echo $username . " "; else echo "Perfil  "; ?><span class="glyphicon glyphicon-user" aria-hidden="true"></span></a>
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

