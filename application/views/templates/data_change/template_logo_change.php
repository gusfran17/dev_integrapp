<div id="page-wrapper">
		
	<div class="container">
		<?php if(isset($exito)):?>
			<div class="alert alert-dismissable alert-success">
		      <button type="button" class="close" data-dismiss="alert">×</button>
		      <strong>Bien!</strong> <?php echo $exito; ?></a>
		    </div>
		<?php endif;?>
		<div class="panel panel-success">
			<div class="panel-heading">
				<h3 class="panel-title" style="text-align:center">Cambio de Logotipo de tu negocio</h3>
			</div>
			<div class="panel-body">
				<form class="region size1of2" action="<?php echo base_url(); ?>profile/save_logo" method="post"  enctype="multipart/form-data" >
					<div class="form-group">
					  <h4 class="info-level-3">El logotipo es importante para representar a tu empresa. Se vera en todas las secciones en que se haga mencion a la misma</h4>
					</div>
					<div class="form-group">
					  <label class="control-label" for="userfile">Archivo de Logotipo (PNG y JPG - <?php echo ALLOWED_PROFILE_IMAGE_MAXWIDTH; ?> píxels x <?php echo ALLOWED_PROFILE_IMAGE_MAXHEIGHT; ?> píxels)</label>
					  <?php if(isset($error)): ?><span class="label label-danger"><?php echo $error;  ?></span><?php endif;?>
					  <input class="form-control" id="userfile" name="userfile" type="file">
					</div>

					<div class="form-group">
						<input type="submit" value="Cambiar logotipo" class="btn btn-info">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>