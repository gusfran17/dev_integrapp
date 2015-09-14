<div id="page-wrapper">
	<div class="container">

		<ul class="nav nav-tabs" style="margin-bottom: 15px;">
		  <li class="active"><a href="#transferencias" data-toggle="tab">Transferencia</a></li>
		  <li><a href="#historial" data-toggle="tab">Historial del Usuario</a></li>
		</ul>
		<div id="myTabContent" class="tab-content">
			<div class="tab-pane fade active in" id="transferencias">
				<div class="list-group">
					<a href="#" class="list-group-item">
						<h4 class="list-group-item-heading">Cantidad</h4>
						<p class="list-group-item-text">$<?php echo $transfer->amount;?></p>
					</a>
					<a href="#" class="list-group-item">
						<h4 class="list-group-item-heading">Fecha de la transferencia</h4>
						<p class="list-group-item-text"><?php echo date("d-M-y", strtotime($transfer->transfer_date));?></p>
					</a>
					<a href="#" class="list-group-item">
						<h4 class="list-group-item-heading">Comprobante</h4>
						<p class="list-group-item-text">
							<?php if (isset($transfer->voucher_image)) { ?>
								<img src='<?php echo base_url() . VOUCHER_IMAGES_PATH . $transfer->issuer->id . "/" . $transfer->voucher_image;?>' style="width: 300px;"/> 
							<?php } else { ?>
								<img src="<?php echo base_url() . IMAGES_PATH . 'NoFotoGeneric.jpg'; ?>" style="width: 300px;">
							<?php } ?>
						</p>
					</a>
					<a href="#" class="list-group-item">
						<h4 class="list-group-item-heading">Mensaje</h4>
						<p class="list-group-item-text">
							<blockquote>
								<p><?php echo $transfer->message;?></p>
								<small>
									<?php 
										if ($transfer->issuer->role == 'supplier'){
											echo 'El proveedor: ' . $transfer->issuer->username;
										} else if ($transfer->issuer->role == 'distributor') {
											echo 'El ortopedista: ' . $transfer->issuer->username;
										}
									?>
								</small>
							</blockquote>
						</p>
					</a>
				</div> 
			</div>
		  	<div class="tab-pane fade" id="historial">

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

		<a href="<?php echo base_url(); ?>administrator/setApproveTransfer/<?php echo $transfer->id; ?>">
			<button type="button" class="btn btn-success">Aprobar</button>
		</a>
		<a href="/administrator/credit">
			<button type="button" class="btn btn-danger">Cancelar</button>
		</a>

	
	</div>
</div>