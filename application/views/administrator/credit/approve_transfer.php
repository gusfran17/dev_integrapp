<div id="page-wrapper">
	<div class="container">
		<div class="panel panel-info">
            <div class="panel-heading">
                <h3 style="text-align: center;" class="info-level-3"><b>Aprobar Transferencia</b></h3>
            </div>
            <div class="panel-body">
				<div  class="col-md-6 col-sm-12 col-xs-12">
					<form action="<?php echo base_url(); ?>administrator/approveTransfer" method="post">
							<div class="form-group">
								<label class="control-label" for="adminNote">Nota</label>
								<?php echo form_error('adminNote', '<span class="label label-danger">', '</span>'); ?>
								<textarea name="adminNote" style="width: 100%;height: 6em;"></textarea>
							</div>
							<div class="form-group">
								<input type="hidden" name="transferId" value="<?php echo $transferId;?>" />
								<input type="submit" value="Aprobar" class="btn btn-info">
							</div>
					</form>
				</div>
				<div  class="col-md-6 col-sm-12 col-xs-12">		
					<div class="panel panel-info">
					    <div class="panel-heading">
					        <h3 class="panel-title">Usted va a aprobar una tranferencia. Recuerde: </h3>
					    </div>
					    <div class="panel-body">
					        1. Verifique en su cuenta bancaria si existe dicha transferencia.<br>
					        2. Se enviará una notificacion al usuario que le hizo la transferencia.
					    </div>
					</div>	
				</div>
			</div>
		</div>
	</div>
</div>