<section id="home">
	<h1>MI CUENTA</h1>
	<form class="region size1of2" action="/perfil/guardar" method="post" id="frm-login">

		<div class="alert alert-dismissable alert-info">
		  <button type="button" class="close" data-dismiss="alert">×</button>
		  <strong>Atencion!</strong> Debes completar la informacion con presición. Esta información sera compartida unicamente con los ortopedistas que usted autorice.
		</div>
		<div class="form-group">
		  <label class="control-label" for="fake_name">Nombre de fantasía (Nombre de su empresa)</label>
		  <input class="form-control" id="fake_name" name="fake_name" type="text" placeHolder="Escriba el nombre de fantasía." value="<?php echo set_value('fake_name', $distributor->fake_name); ?>">
		</div>


	</form>	
</section>