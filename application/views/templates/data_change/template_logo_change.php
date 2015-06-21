<section id="home">
	
<div class="container">

<?php if(isset($exito)):?>
	<div class="alert alert-dismissable alert-success">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <strong>Bien!</strong> <?php echo $exito; ?></a>
    </div>
<?php endif;?>

	<form class="region size1of2" action="<?php echo base_url(); ?>profile/save_logo" method="post"  enctype="multipart/form-data" >
		<div class="form-group">
		  <h3 class="info-level-3">Cambiar logotipo de tu negocio</h3>
		</div>

		<div class="form-group">
		  <label class="control-label" for="userfile">Archivo de Logotipo (PNG - 150 píxels x 50 píxels)</label>
		  <?php if(isset($error)): ?><span class="label label-danger"><?php echo $error;  ?></span><?php endif;?>
		  <input class="form-control" id="userfile" name="userfile" type="file">
		</div>

		<div class="form-group">
			<input type="submit" value="Cambiar logotipo" class="btn btn-info">
		</div>
	</form>


</div>


</section>