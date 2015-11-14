<div id="page-wrapper">
	<form action="<?php echo base_url(); ?>profile/save" method="post" >
		<div class="container">
			<div style="text-align:center; padding: 5px 5px 5px 5px;">
				<?php if(isset($distributor->logo)){ ?>
					<div class="form-group" style="display: block; margin-left: auto; margin-right: auto;">
							<img src="<?php echo base_url() . $distributor->logo; ?>" />
					</div>
				<?php }else { ?>
					<h2><span class="label label-primary"><b>MI CUENTA</b></span></h2>
				<?php } ?>
			</div>

			<?php if(isset($success)):?>
				<div class="alert alert-dismissable alert-success">
			      <button type="button" class="close" data-dismiss="alert"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></button>
			      <strong><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span></strong>
			      <strong>¡Bien!</strong> <?php echo $success; ?></a>
			    </div>
			<?php endif;?>
			<?php if(isset($error)):?>
				<div class="alert alert-dismissable alert-danger">
			      <button type="button" class="close" data-dismiss="alert"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></button>
			      <strong><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span></strong>
			      <strong>¡ERROR!</strong> <?php echo $error; ?></a>
			    </div>
			<?php endif;?>

			<?php if ($distributor->percentage != 100) {?>
				<div class="panel panel-success">
					<div class="panel-heading">
						<h3 class="panel-title">Datos del perfil</h3>
					</div>
	 				<div class="panel-body">		
	 					<p>El ingreso de sus datos hace la información mucho mas visible a los usuarios que consultan sus productos y sus datos de perfil (la ubcicación de su local, el logo de la empresa, los datos de contacto, la descripción del servicio, etc.)</p>
						<div class="progress progress-striped active">
							<div class="progress-bar" style="width: <?php echo $distributor->percentage; ?>%"></div>
						</div>
						<p>Datos completos en un <?php echo $distributor->percentage; ?>%</p>
					</div> 
				</div>
			<?php }?>
			<div class="panel panel-info">
				<div class="panel-heading">
					<div class="panel-title" style= "text-align:center;">
						<h4><b>Datos Personales</b></h4>
					</div>
				</div>
				<div class="panel-body">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align:center;">
						<div class="form-group">
							<h5 style="margin-top:20px;"><b>Usuario:</b> <?php if (isset($user)) echo " " . $user->username; ?></h5>
						</div>
						<div class="form-group">
							<h5><b>Email de Usuario:</b> <?php if (isset($user)) echo " " . $user->email; ?></h5>
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
						<div class="form-group">
							<label class="control-label" for="name">Nombre</label>
							<?php echo form_error('name', '<span class="label label-danger">', '</span>'); ?>
							<input class="form-control" id="name" name="name" type="text" placeHolder="Nombre" style="float:left;" value="<?php if (isset($user)) echo set_value('name', $user->name); else echo set_value('name');?>"> 
						</div>

						<div class="form-group">
							<label class="control-label" for="lastname">Apellido</label>
							<?php echo form_error('lastname', '<span class="label label-danger">', '</span>'); ?>
							<input class="form-control" id="lastname" name="lastname" type="text" placeHolder="Apellido" style="float:left;" value="<?php if (isset($user)) echo set_value('lastname', $user->lastname); else echo set_value('lastname');?>"> 
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
						<h4><b>Logo</b></h4>
						<?php if(isset($distributor->logo)): ?>
							<div class="form-group" style="display: block; margin-left: auto; margin-right: auto; border: solid; padding: 10px 10px 10px 10px;">
									<img src="<?php echo base_url() . $distributor->logo; ?>" />
							</div>
						<?php endif;?>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
						<div class="region size1of2" >
							<div class="form-group" style="padding: 10px 10px 10px 10px;">
								<h4><b>Opciones de Cuenta</b></h4>
								<ul>
									<li><a href="<?php echo base_url(); ?>profile/change_password">Cambiar la contraseña</a></li>
									<li><a href="<?php echo base_url(); ?>profile/change_email">Cambiar email de registro</a></li>
									<li><a href="<?php echo base_url(); ?>profile/change_username">Cambiar Nombre de Usuario</a></li>
									<li><a href="<?php echo base_url(); ?>profile/change_logo">Editar el logo de mi empresa</a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="container">
			</br>
			<div class="alert alert-dismissable alert-info">
			  <button type="button" class="close" data-dismiss="alert"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></button>
			  <strong><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span></strong>
			  <strong>¡Atencion!</strong> Debes completar la informacion con presición. Esta información sera compartida unicamente con los ortopedistas que autorices.
			</div>
			<div class="panel panel-info">
				<div class="panel-heading">
					<div class="panel-title" style= "text-align:center;">
						<h4><b>Datos de mi Empresa</b></h4>
						<?php if(isset($distributor->logo)): ?>
							<div class="form-group" style="display: block; margin-left: auto; margin-right: auto;">
								<img src="<?php echo base_url() . $distributor->logo; ?>" />
							</div>
						<?php endif;?>
					</div>
				</div>
				<div class="panel-body">
					<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">				
						<div class="form-group">
						  <label title="(Nombre de su empresa)" class="control-label" for="fake_name">Nombre de fantasía</label>
						  <input class="form-control" id="fake_name" name="fake_name" type="text" placeHolder="Escriba el nombre de fantasía." value="<?php if (isset($distributor)) echo set_value('fake_name', $distributor->fake_name); else echo set_value('fake_name'); ?>">
						</div>
						<div class="form-group">
						  <label title="(coloque sus mails de contacto aqui separados por punto y coma)" class="control-label" for="comercial_email">Email Comercial</label>
						  <?php echo form_error('comercial_email', '<span class="label label-danger">', '</span>'); ?>
						  <input class="form-control" id="comercial_email" name="comercial_email" type="text" placeHolder="Dirección comercial" value="<?php if (isset($distributor)) echo set_value('comercial_email', $distributor->comercial_email); else echo set_value('comercial_email');?>">
						</div>
						<div class="form-group">
						  <label title="(este sera el numero primario de contacto para sus clientes)" class="control-label" for="contact_phone">Numero de telefono comercial</label> 
						  <?php echo form_error('contact_phone', '<span class="label label-danger">', '</span>'); ?>
						  <input class="form-control" id="contact_phone" name="contact_phone" type="text" placeHolder="Numero de telefono de contacto" value="<?php if (isset($distributor)) echo set_value('contact_phone', $distributor->contact_phone); else echo set_value('contact_phone');?>">
						</div>
						<div class="panel panel-success">
							<div class="panel-heading">
								<a data-toggle="collapse" href="#collapseAuxPhones" aria-expanded="false" class="collapsed">
									<h3 class="panel-title" style="text-align:center">Numeros de teléfono auxiliares <i class="fa fa-caret-down"></i></h3>
								</a>
							</div>
							<div id="collapseAuxPhones" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
		 						<div class="panel-body">		
									<div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
									  <label class="control-label" for="cellphone">Celular</label>
									  <?php echo form_error('cellphone', '<span class="label label-danger">', '</span>'); ?>
									  <input class="form-control" id="cellphone" name="cellphone" type="text" placeHolder="Celular" value="<?php if (isset($distributor)) echo set_value('cellphone', $distributor->cellphone); else echo set_value('comercial_email');?>">
									</div>

									<div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
									  <label class="control-label" for="office_phone">Oficina</label> 
									  <?php echo form_error('office_phone', '<span class="label label-danger">', '</span>'); ?>
									  <input class="form-control" id="office_phone" name="office_phone" type="text" placeHolder="Oficina" value="<?php if (isset($distributor)) echo set_value('office_phone', $distributor->office_phone); else echo set_value('comercial_email');?>">
									</div>

									<div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
									  <label class="control-label" for="personal_phone">Particular</label> 
									  <?php echo form_error('personal_phone', '<span class="label label-danger">', '</span>'); ?>
									  <input class="form-control" id="personal_phone" name="personal_phone" type="text" placeHolder="Particular" value="<?php if (isset($distributor)) echo set_value('personal_phone', $distributor->personal_phone); else echo set_value('comercial_email');?>">
									</div>

									<div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
									  <label class="control-label" for="fax">Fax</label>
									  <?php echo form_error('fax', '<span class="label label-danger">', '</span>'); ?>
									  <input class="form-control" id="fax" name="fax" type="text" placeHolder="Fax" value="<?php if (isset($distributor)) echo set_value('fax', $distributor->fax); else echo set_value('comercial_email');?>">
									</div>
								</div>
							</div> 
						</div>

						<div class="form-group">
						  <label class="control-label" for="service_description">Descripcion del servicio</label>
						  <textarea class="form-control" id="service_description" name="service_description" placeHolder="Describa su actividad comercial."><?php if (isset($distributor)) echo set_value('service_description', $distributor->service_description); else echo set_value('service_description'); ?></textarea>
						</div>

						<div class="form-group">
						  <label class="control-label" for="working_hours">Horarios de Atención</label>
						  <input class="form-control" id="working_hours" name="working_hours" type="text" placeHolder="Escriba aquí una su razón social" value="<?php if (isset($distributor)) echo set_value('working_hours', $distributor->working_hours); else echo set_value('working_hours'); ?>">
						</div>

						<div class="form-group">
						  <label class="control-label" for="razon_social">Razón social</label>
						  <input class="form-control" id="razon_social" name="razon_social" type="text" placeHolder="Escriba aquí una su razón social" value="<?php if (isset($distributor)) echo set_value('razon_social', $distributor->razon_social); else echo set_value('razon_social'); ?>">
						</div>

						<div class="form-group">
						  <label class="control-label" for="cuit">CUIT</label>
						  <input class="form-control" id="cuit" name="cuit" type="text" placeHolder="cuit" value="<?php if (isset($distributor)) echo set_value('cuit', $distributor->cuit); else echo set_value('cuit'); ?>">
						</div>

						<div class="form-group">
						  <label class="control-label" for="fiscal_address">Dirección fiscal</label>
						  <input class="form-control" id="fiscal_address" name="fiscal_address" type="text" placeHolder="Dirección fiscal" value="<?php if (isset($distributor)) echo set_value('fiscal_address', $distributor->fiscal_address); else echo set_value('fiscal_address'); ?>">
						</div>
					
					</div>

					<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">

						<legend><b>Geo ubicación</b></legend>
						
						<div class="form-group">
							<label class="control-label" for="city">Ciudad</label><br>
							<?php echo form_error('city', '<span class="label label-danger">', '</span>'); ?>
							<input id="city" class="form-control" name="city" placeholder="Ingrese su ciudad" value="<?php echo set_value('city', $distributor->city); ?>" style="width: 390px;">
						</div>

						<div class="form-group">
							<label class="control-label" for="commercial_address">Dirección comercial</label>
							<?php echo form_error('commercial_address', '<span class="label label-danger">', '</span>'); ?>
							<input class="form-control" onchange="showAddress(); return false" id="commercial_address" name="commercial_address" type="text" placeHolder="Dirección comercial" value="<?php if (isset($distributor)) echo set_value('commercial_address', $distributor->commercial_address); else echo set_value('commercial_address');?>">
						</div>

						<input id="latLocation" name="latLocation" type="hidden" value="<?php echo set_value('latLocation', $distributor->latLocation); ?>"/>
						<input id="longLocation" name="longLocation" type="hidden" value="<?php echo set_value('longLocation', $distributor->longLocation); ?>"/>
						

						<div class="form-group">
							<div class="col-lg-2">
								<label for="inputPassword" title="Permita al navegador ubicar sus coordenadas" class="col-xs-12 col-sm-12 col-md-2 col-lg-2 control-label">
									<a href="javascript:getLocationForProfile();"><img src="<?php echo base_url() . IMAGES_PATH . 'geolocate.png'; ?>" style="height:30px;"/></a>
								</label>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
								<div class="checkbox">
									<label>
										<input onChange="getLocationForProfile();" type="checkbox" id="allowBrowserGeolocation" name="allowBrowserGeolocation"> Permitir a Integrapp utilizar la ubicación geográfica del nagevador
									</label>
								</div>
							</div>
						</div>

						<div class="form-group">
							<div id="map_canvas" style="width: 100%; height: 400px; border: 1px solid #ccc;border-radius: 4px;"></div>
						</div>

						<div class="well bs-component">
								<fieldset>
									<legend>Confirme sus datos</legend>


									<div class="form-group">
										<label class="col-lg-2 control-label">Es el mapa correcto?</label>
										<div class="col-lg-10">
											<div class="radio">
												<label>
													<input name="locationsure" id="locationsure" type="radio" value="yes" <?php if ($distributor->locationsure == 'yes') echo 'checked';?>>
													Si, estoy seguro
												</label>
											</div>
											<div class="radio">
												<label>
													<input name="locationsure" id="locationsure" type="radio" value="moreorless" <?php if ($distributor->locationsure == 'moreorless') echo 'checked';?>>
													No estoy muy seguro
												</label>
											</div>
											<div class="radio">
												<label>
													<input name="locationsure" id="locationsure" type="radio" value="no" <?php if ($distributor->locationsure == 'no') echo 'checked';?>>
													No, el punto esta muy mal ubicado
												</label>
											</div>
										</div>
									</div>

								</fieldset>
							<div id="source-button" class="btn btn-primary btn-xs" style="display: none;">&lt; &gt;</div>
						</div>


					</div>
				</div>
				<div class="form-group" style="text-align: center;">
					<input type="submit" value="Guardar" class="btn btn-info">
				</div>
			</div>
		</div>
	</form>

</div>
<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=AIzaSyDA5gKtCnyf3dSDczZA3DGMKtVxHFQi_tk"
type="text/javascript"></script>
<script type="text/javascript">

	var map = null;
	var geocoder = null;

	function initialize() {
		if (GBrowserIsCompatible()) {
			map = new GMap2(document.getElementById("map_canvas"));
			punto = new GLatLng(<?php if (isset($distributor->latLocation)) echo $distributor->latLocation; else echo '-34.606979'; ?>,
								<?php if (isset($distributor->latLocation)) echo $distributor->longLocation; else echo'-58.394029'; ?>);
			map.setCenter(punto, 17);
			var marker = new GMarker(punto, {draggable: false});
			map.setUIToDefault();
			geocoder = new GClientGeocoder();
		}
	}

	function getLocationForProfile(){
		if (navigator.geolocation){
			navigator.geolocation.getCurrentPosition(showPosition, errorLocation);
		}else{
			alert("Geolocation is not supported by this browser.");
		}
	}

	function errorLocation(error){
		$('input[name=allowBrowserGeolocation]').attr('checked', false);
		$("#geoerrorcontainer").show();
		switch(error.code) {
			case error.PERMISSION_DENIED:
			$("#geoerror").html("Denegaste la ubicación basada en el navegador. Quizas quieras ver nuestra <a href='#'>Politica de privacidad de ubicacion</a>");
			break;
			case error.POSITION_UNAVAILABLE:
			$("#geoerror").text("La información de ubicación no esta disponible");
			break;
			case error.TIMEOUT:
			$("#geoerror").text("Se acabo el tiempo en el que esperamos que el navegador nos diga donde estas");
			break;
			case error.UNKNOWN_ERROR:
			$("#geoerror").text("Hubo un error, pero eso es todo lo que sabemos :(");
				break;
		}
	}

	function showPosition(position){
		$('input[name=allowBrowserGeolocation]').attr('checked', true);
		$("#latLocation").val(position.coords.latitude);
		$("#longLocation").val(position.coords.longitude);
		punto = new GLatLng(position.coords.latitude,position.coords.longitude)
		map.setCenter(punto, 17);
		var marker = new GMarker(punto, {draggable: false});
		map.addOverlay(marker);
		

		GEvent.addListener(marker, "dragend", function() {
			marker.openInfoWindowHtml('<img src="<?php echo base_url() . IMAGES_PATH . 'geolocate.png'; ?>" style="max-height: 40px; max-width: 80px;">Ubicación del navegador<br/>(Solo para referencia)');

		});
		GEvent.addListener(marker, "click", function() {
			marker.openInfoWindowHtml('<img src="<?php echo base_url() . IMAGES_PATH . 'geolocate.png'; ?>" style="max-height: 40px; max-width: 80px;">Ubicación del navegador<br/>(Solo para referencia)');


		});


	}

	function showAddress(address, city) {
		
		var address = $('#commercial_address').val();
		var city = $('#city').val();

		console.log(address + ", " + city);
		if(address == ''){return false;}
		if (geocoder) {
			geocoder.getLatLng(
				address + ", " + city,
				function(point) {
					if (!point) {
						alert("La dirección específicada en el perfil: " + address + " no fue encontrada. Verifiquela");
					} else {
						map.clearOverlays();
						map.setCenter(point, 15);
						var marker = new GMarker(point, {draggable: true});
						map.addOverlay(marker);
						$("#latLocation").val(marker.getLatLng().lat());
						$("#longLocation").val(marker.getLatLng().lng());
							
						GEvent.addListener(marker, "dragend", function() {
							marker.openInfoWindowHtml('<img src="<?php echo base_url() . ((isset($distributor->logo))? $distributor->logo : IMAGES_PATH . 'geolocate.png');?>" style="max-height: 40px; max-width: 80px;">Direccion del formulario<br/>');
							$("#latLocation").val(marker.getLatLng().lat());
							$("#longLocation").val(marker.getLatLng().lng());
						});
						GEvent.addListener(marker, "click", function() {
							marker.openInfoWindowHtml('<img src="<?php echo base_url() . ((isset($distributor->logo))? $distributor->logo : IMAGES_PATH . 'geolocate.png');?>" style="max-height: 40px; max-width: 80px;">Direccion del formulario<br/>');

							$("#latLocation").val(marker.getLatLng().lat());
							$("#longLocation").val(marker.getLatLng().lng());
						});
						GEvent.trigger(marker, "click");
					}
				}
				);
		}
	}

	$( document ).ready(function() {
		initialize(); 
		showAddress('<?php echo set_value('commercial_address', $distributor->commercial_address); ?>', '<?php echo set_value('city', $distributor->city); ?>');
		//getLocationForProfile();
	});


	/*** CITY NAMES PROPOSALS ***/
	var bestPictures = new Bloodhound({
	  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
	  queryTokenizer: Bloodhound.tokenizers.whitespace,
	  prefetch: "<?php echo base_url();?>" + 'profile/getCity/ciudad%20autonoma',
	  remote: "<?php echo base_url();?>" + 'profile/getCity/%QUERY'
	});

	bestPictures.initialize();

	$('#city').typeahead({
		hint: true
	}, {
	  name: 'best-pictures',
	  displayKey: 'value',
	  source: bestPictures.ttAdapter()
	});

	$('#city').on('typeahead:selected', function(event, selection) {
		$("#city").val(selection.value);
		showAddress();
		event.preventDefault();
	});


	/*** ***/
	</script>