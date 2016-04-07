<div id="page-wrapper">
	<article>
		<div class="container-fluid">
			<div class="row" id="login-form">
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
					<?php if($this->session->flashdata('success')!= null):?>
					    <div class="alert alert-dismissable alert-success">
					      <button type="button" class="close" data-dismiss="alert"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span></button>
					      <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
					      <strong>Bien!</strong> <?php echo $this->session->flashdata('success'); ?></a>
					    </div>
					<?php endif;?>
					<?php if($this->session->flashdata('error')!= null):?>
					    <div class="alert alert-dismissable alert-danger">
					      <button type="button" class="close" data-dismiss="alert"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span></button>
					      <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
					      <strong>Atenci贸n!</strong> <?php echo $this->session->flashdata('error'); ?></a>
					    </div>
					<?php endif;?>
					<div style="margin-top:0% !important" class="well bs-component">
						<form action="<?php echo base_url(); ?>home/sendMessage" method="POST">
							<fieldset>
								<legend>
									<h2 class="login-titulo">Contacto</h2>
									<p style="font-size:14px !important">Si lo desea, puede escribirnos un mail, le responderemos a la brevedad.</p>
								</legend>							
								<div class="form-group" style="padding-bottom:40px;">
									<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12" for="Nombre y Apellido">Nombre</label>
									<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
										<input type="text" class="form-control" name="name" placeholder="Ingrese nombre y apellido" style="position:relative">
									</div>
								</div>
								<div class="form-group" style="padding-bottom:40px;">
									<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12" for="email">Email</label>
									<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
										<input type="email" class="form-control" name="email" placeholder="Ingrese su email" style="position:relative">
									</div>
								</div>
								<div class="form-group" style="padding-bottom:40px;">
									<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12" for="subject">Asunto</label>
									<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
										<input type="asunto" class="form-control" name="subject" placeholder="Ingrese el motivo de su consulta" style="position:relative">
									</div>
								</div>
								<div class="form-group" style="padding-bottom:40px;">
									<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12" for="message">Mensaje</label>
								  <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
										<textarea type="consulta" class="form-control" name="message" placeholder="Escriba aquí su consulta" style="position:relative"></textarea>
									</div>
								</div>
								<div class="form-group">
									<div class="col-lg-10 col-md-10 col-sm-10 col-xs-10 col-lg-offset-2 col-md-offset-2 col-sm-offset-2 col-xs-offset-2">
										<button type="submit" class="btn btn-default">Enviar</button>
									</div>
								</div>
							</fieldset> 
						</form>
					</div>
				</div> 
				
			</div> 
		</div> 
		
	</article>
</div>