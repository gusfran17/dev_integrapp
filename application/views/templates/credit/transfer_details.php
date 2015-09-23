<div id="page-wrapper">
	<div class="container">
		<div class="col-md-6 col-sm-12 col-xs-12">
	    	<div class="panel panel-info">
		        <div class="panel-heading">
		            <h3 style="text-align: center;" class="info-level-3"><b>Detalles de la transferencia</b></h3>
		        </div>
		        <div class="panel-body">

					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="form-group">
							<label class="control-label" for="nota">Fecha: </label>
							<?php echo $transfer->transfer_date; ?>
						</div>

						<div class="form-group">
							<label class="control-label" for="nota">Monto: </label>
							$<?php echo $transfer->amount; ?>
						</div>

						<div class="form-group">
							<label class="control-label" for="nota">Estado: </label>
							<?php if($transfer->confirmed == 1):?>
								Confirmado
							<?php else: ?>
								Pendiente
							<?php endif;?>
						</div>

						<div class="form-group">
							<label class="control-label" for="nota">Mensaje</label>
							<?php echo $transfer->message; ?>
						</div>
						<?php if (($transfer->voucher_image != "") and (file_exists(base_url() . VOUCHER_IMAGES_PATH . $transfer->userid . "/" . $transfer->voucher_image))) :?>
							<div class="form-group">
								<label class="control-label" for="nota">Comprobante</label>
								<br>
									<a href='<?php echo base_url() . VOUCHER_IMAGES_PATH . $transfer->userid . "/" . $transfer->voucher_image;?>'>
										<img src='<?php echo base_url() . VOUCHER_IMAGES_PATH . $transfer->userid . "/" . $transfer->voucher_image;?>' style="width: 100px; height: 100px;"/>
									</a>
									<a href='<?php echo base_url() . IMAGES_PATH . 'noFotoGeneric.jpg';?>'>
										<img src='<?php echo base_url() . IMAGES_PATH . 'noFotoGeneric.jpg';?>' style="width: 100px; height: 100px;"/>
									</a>
							</div>
						<?php endif;?>
						<?php if($transfer->confirmed == false):?>
							<a href="<?php echo base_url(); ?>/credit/deletePendingTransfer/<?php echo $transfer->id; ?>"><button type="button" class="btn btn-danger  btn-xs">Cancelar solicitud</button></a>
						<?php endif;?>
						
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6 col-sm-12 col-xs-12">						
			<div class="panel panel-info">
		        <div class="panel-heading">
		            <h3 class="panel-title">Historial de transferencias</h3>
		        </div>
		        <div class="panel-body">
		            <?php foreach($transferHistory as $transfer): ?>
		            	<i>El <?php echo $transfer->transfer_date; ?> informó:</i> <a href="<?php echo base_url(); ?>/credit/viewTransferDetails/<?php echo $transfer->id;?>">$<?php echo $transfer->amount; ?></a> <?php if ($transfer->confirmed) echo "<b style='color:#0F0'>(Aprobada)</b>"; else echo "<b style='color:#F00'>(Pendiente)</b>";?><br/>
		        	<?php endforeach; ?>
		        </div>
		    </div>
		</div>
	</div>

</div>