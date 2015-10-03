<div id="page-wrapper">
	<div class="container">

	    <?php if($this->session->flashdata('success')) :?>
	        <div class="alert alert-dismissable alert-success">
	          <button type="button" class="close" data-dismiss="alert"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
	          <strong><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> Bien!</strong> <?php echo $this->session->flashdata('success'); ?></a>
	        </div>
	    <?php endif;?>
		<div class="page-header" style="text-align:center; margin: 0px 0 0px;">
			<h2>
				<span class="label label-default" style="color:#ffffff;"><b>CREDITO</b></span><br>
				<small>Mi Crédito: $<?php echo number_format($balance, PRICE_DECIMAL_AMOUNT, DECIMAL_SEPARATOR, THOUSANDS_SEPARATOR); ?></small>
			</h2>
		</div>
		<h3>
	    	<a href="<?php echo base_url(); ?>credit/setRequestCredit/">
	    		<button type="button" class="btn btn-success btn-sm"><b><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> Agregar crédito</b></button>
	    	</a>
	    </h3>	
	    
	    <div class="row">
	        <div class="span12">
	        	<h4><span class="label label-default" style="color:#ffffff;"><b>Historial de Transacciones</b></span><br></h4>
	            <div id="example_wrapper" class="dataTables_wrapper form-inline" role="grid">
	                <table id="resultset_pend" class="table table-bordered table-striped">
	                    <thead>
	                        <tr>
	                            <th data-class="expand">Fecha</th>
	                            <th>Descripción</th>
	                            <th data-hide="phone">Débitos</th>
	                            <th class="centered-cell" data-hide="phone,tablet">Créditos</th>
	                            <th class="centered-cell" data-hide="phone,tablet">Saldo</th>
	                        </tr>
	                    </thead>
	                    <tbody>
	                    <?php foreach($transactions as $transaction): ?>
	                        <tr>
	                            <td><?php echo date("d-M-y", strtotime($transaction->date_added));?></td>
	                            <td><?php echo $transaction->description; ?></td>
	                            <td>$<?php echo $transaction->debit; ?></td>
	                            <td>$<?php echo $transaction->credit; ?></td>
	                            <td>$<?php echo $transaction->balance; ?></td>
	                        </tr>
	                    <?php endforeach; ?>
	                    </tbody>
	                </table>
	            </div>
			    <br>
			    <br>
			    <h4><span class="label label-default" style="color:#ffffff;"><b>Transferencias a confirmar</b></span><br></h4>
	            <div id="example_wrapper" class="dataTables_wrapper form-inline" role="grid">
	                <table id="resultset" class="table table-bordered table-striped">
	                    <thead>
	                        <tr>
	                            <th data-class="expand">Fecha</th>
	                            <th>Estado</th>
	                            <th data-hide="phone">Cantidad</th>
	                            <th class="centered-cell" data-hide="phone,tablet">Acciones</th>
	                        </tr>
	                    </thead>
	                    <tbody>
	                    <?php foreach($pendingTransfers as $pendingTransfer): ?>
	                        <tr>
	                            <td><?php echo date("M-d", strtotime($pendingTransfer->transfer_date));?></td>
	                            <td>pendiente</td>
	                            <td>$<?php echo $pendingTransfer->amount; ?></td>
	                            <td>
	                                <a href="<?php echo base_url(); ?>credit/viewTransferDetails/<?php echo $pendingTransfer->id; ?>"><button type="button" class="btn btn-info  btn-xs">Ver detalles</button></a>
	                                <a href="<?php echo base_url(); ?>credit/deletePendingTransfer/<?php echo $pendingTransfer->id; ?>"><button type="button" class="btn btn-danger  btn-xs">Cancelar solicitud</button></a>
	                            </td>
	                        </tr>
	                    <?php endforeach; ?>
	                    </tbody>
	                </table>
	            </div>
	        </div>
	    </div>

	</div>

</div>

<script>
jQuery(document).ready(function() {
    jQuery('#resultset, #resultset_pend').dataTable( {
        "bPaginate": true,
        "bLengthChange": false,
        "bFilter": true,
        "bSort": true,
        "bInfo": true,
        "bAutoWidth": false,
        "oLanguage": {
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla",
                "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix":    "",
                "sSearch":         "Buscar:",
                "sUrl":            "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":     "Último",
                    "sNext":     "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }
    } );
} );
</script>

<?php $this->load->view('templates/scripts/table_scripts');