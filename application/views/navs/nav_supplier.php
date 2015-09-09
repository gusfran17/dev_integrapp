		        <li><a title="<?php if ($loadInfo->activeProducts>0) echo 'Tiene ' . $loadInfo->activeProducts . ' productos sin publicar'; ?>" href="<?php echo base_url(); ?>Product/myProducts">PRODUCTOS <?php if ($loadInfo->activeProducts>0) echo '<span class="badge">' . $loadInfo->activeProducts . '</span>'; ?></a></li>
		        <li><a title="<?php if ($loadInfo->activeProducts>0) echo 'Tiene ' . $loadInfo->pendingDistributors . ' solicitudes pendientes'; ?>" href="<?php echo base_url(); ?>Distributors/viewDistributors">ORTOPEDIAS <?php if ($loadInfo->pendingDistributors>0) echo '<span class="badge">' . $loadInfo->pendingDistributors . '</span>'; ?></a></li>
		        <li><a href="<?php echo base_url(); ?>profile/auction">SUBASTA</a></li>
		        <li><a href="<?php echo base_url(); ?>profile/credit">CREDITO</a></li>
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