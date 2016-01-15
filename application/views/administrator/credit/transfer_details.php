<div id="page-wrapper">
	<div class="container">

		<ul class="nav nav-tabs" style="margin-bottom: 15px;">
			<?php if (isset($showApprovalForm)) { ?>
				<li class="active"><a href="#transferencias" data-toggle="tab">Transferencia</a></li>
				<li><a href="#historial" data-toggle="tab">Historial del Usuario</a></li>
			<?php } else { ?>
				<li class="active"><a href="#historial" data-toggle="tab">Historial del Usuario</a></li>
			<?php } ?>
		</ul>
		<div id="myTabContent" class="tab-content">
			<div class="tab-pane fade <?php if (isset($showApprovalForm)) echo 'active in' ?>" id="transferencias">
				<div class="list-group">
					<a href="#" class="list-group-item">
						<h4 class="list-group-item-heading">Cantidad</h4>
						<p class="list-group-item-text">$<?php echo $transfer->amount;?></p>
					</a>
					<a href="#" class="list-group-item">
						<h4 class="list-group-item-heading">Fecha de la transferencia</h4>
						<p class="list-group-item-text"><?php echo date("d-M-y", strtotime($transfer->transfer_date));?></p>
					</a>
					<?php if ($transfer->voucher_image != "") { ?>
						<a href="#" class="list-group-item">
							<h4 class="list-group-item-heading">Comprobante</h4>
							<div class="list-group-item-text">
								<img src='<?php echo base_url() . VOUCHER_IMAGES_PATH . $transfer->userid . "/" . $transfer->voucher_image;?>' style="max-width: 100%; max-height: 200px;"/>
							</div>
						</a>
					<?php }?>
					<a href="#" class="list-group-item">
						<h4 class="list-group-item-heading">Mensaje</h4>
						<p class="list-group-item-text">
							<blockquote>
								<p><?php echo $transfer->message;?></p>
								<small>
									<?php 
										if ($transfer->issuer->role == 'supplier'){
											echo 'El mayorista: ' . $transfer->issuer->username;
										} else if ($transfer->issuer->role == 'distributor') {
											echo 'El ortopedista: ' . $transfer->issuer->username;
										}
									?>
								</small>
							</blockquote>
						</p>
					</a>
				</div> 
				<div class="panel panel-info">
		            <div class="panel-heading">
		                <h3 style="text-align: center;" class="info-level-3"><b>Aprobar Transferencia</b></h3>
		            </div>
		            <div class="panel-body">
						<div  class="col-md-6 col-sm-12 col-xs-12">
							<form action="<?php echo base_url(); ?>administrator/approveTransfer" method="post">
									<div class="form-group">
										<label class="control-label" for="adminNote">Nota de aprobación</label>
										<?php echo form_error('adminNote', '<span class="label label-danger">', '</span>'); ?>
										<textarea name="adminNote" style="width: 100%;height: 6em;"></textarea>
									</div>
									<div class="form-group">
										<input type="hidden" name="transferId" value="<?php echo $transfer->id;?>" />
										<input type="submit" value="Aprobar" class="btn btn-info">
										<a href="/administrator/credit">
											<button type="button" class="btn btn-danger">Cancelar</button>
										</a>
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
		  	<div class="tab-pane fade <?php if (!(isset($showApprovalForm))) echo 'active in' ?>" id="historial">

		  		<table class="table table-striped table-hover ">
				 	<thead>
				    	<tr>
				      		<th>#</th>
				      		<th>Fecha</th>
				      		<th>Descripcion</th>
				      		<th>Debito</th>
				      		<th>Credito</th>
				      		<th>Total</th>
				    	</tr>
				  	</thead>
		  			<tbody>
					  	<?php foreach($transactions as $key=>$transaction):?>
					    	<tr class="danger">
		      					<td><?php echo $key+1;?></td>
		      					<td><?php echo date("d-M-y", strtotime($transaction->date_added));?></td>
		      					<td><?php echo $transaction->description;?></td>
		      					<td><?php echo $transaction->debit;?></td>
		      					<td><?php echo $transaction->credit;?></td>
		      					<td><?php echo $transaction->balance;?></td>
		    				</tr>
						<?php endforeach;?>
		  			</tbody>
				</table> 
		  	</div>
		</div>
	</div>
</div>