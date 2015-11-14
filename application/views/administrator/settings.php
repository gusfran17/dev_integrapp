<div id="page-wrapper">
	<div class="content">
		<?php if($this->session->flashdata('success')!= null):?>
		    <div class="alert alert-dismissable alert-success">
		      <button type="button" class="close" data-dismiss="alert"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span></button>
		      <strong>Bien!</strong> <?php echo $this->session->flashdata('success'); ?></a>
		    </div>
		<?php endif;?>
		<?php if($this->session->flashdata('error')!= null):?>
		    <div class="alert alert-dismissable alert-success">
		      <button type="button" class="close" data-dismiss="alert"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span></button>
		      <strong>Bien!</strong> <?php echo $this->session->flashdata('error'); ?></a>
		    </div>
		<?php endif;?>
		<table class="table table-striped table-hover ">
	 	<thead>
	    	<tr>
	      		<th>Nombre de Configuración</th>
	      		<th>Valor de Configuración</th>
	      		<th>Acciones</th>
	    	</tr>
	  	</thead>
		<tbody>
	    	<tr class="danger">
				<td><?php echo $settings[0]->setting_name;?></td>
				<td><?php echo $settings[0]->setting_value;?></td>
				<td>
					<?php if ($settings[0]->setting_value == true) { ?>
						<a href="<?php echo base_url(); ?>administrator/deactivateEmailVerification"><button type="button" class="btn btn-warning  btn-xs">Desactivar</button></a>
	                <?php } else { ?>
	                	<a href="<?php echo base_url(); ?>administrator/activateEmailVerification"><button type="button" class="btn btn-success btn-xs">Activar</button></a>
	                <?php } ?>
				</td>
			</tr>
		</tbody>
	</table>
	</div> 
</div>