<div id="page-wrapper">
	<div class="page-header" style="text-align:center; margin: 0px 0 0px;">
		<h2><span class="label label-default" style="color:#ffffff;"><b>TRANSFERENCIAS</b></span></h2>
	</div>
	<?php if($this->session->flashdata('success')!= null):?>
	    <div class="alert alert-dismissable alert-success">
	      <button type="button" class="close" data-dismiss="alert"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span></button>
	      <strong><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>Bien!</strong> <?php echo $this->session->flashdata('success'); ?></a>
	    </div>
	<?php endif;?>
	<?php if($this->session->flashdata('error')!= null):?>
	    <div class="alert alert-dismissable alert-danger">
	      <button type="button" class="close" data-dismiss="alert"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span></button>
	      <strong><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>Atención!</strong> <?php echo $this->session->flashdata('error'); ?></a>
	    </div>
	<?php endif;?>
	<div class="container">
		<h3>Transferencias a confirmar</h3>
	    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	        <div id="example_wrapper" class="dataTables_wrapper form-inline" role="grid">
	            <table id="resultset" class="table table-bordered table-striped">
	                <thead>
	                    <tr>
	                        <th data-class="expand">Fecha</th>
	                        <th>Usuario</th>
	                        <th>Rol</th>
	                        <th>Estado</th>
	                        <th data-hide="phone">Cantidad</th>
	                        <th class="centered-cell" data-hide="phone,tablet">Acciones</th>
	                    </tr>
	                </thead>
	                <tbody>
	                <?php foreach($pendingTransfers as $pendingTransfer): ?>
	                    <tr>
	                        <td><?php echo date("d-M-y", strtotime($pendingTransfer->transfer_date));?></td>
	                        <td><?php echo $pendingTransfer->username; ?></td>
	                        <td><?php if ($pendingTransfer->role == "supplier") echo "Proveedor"; else if ($pendingTransfer->role=="distributor") echo "Ortopedista"; ?></td>
	                        <td>pendiente</td>
	                        <td>$<?php echo number_format($pendingTransfer->amount, PRICE_DECIMAL_AMOUNT, DECIMAL_SEPARATOR, THOUSANDS_SEPARATOR); ?></td>
	                        <td>
	                            <a href="<?php echo base_url(); ?>administrator/viewTransferDetails/<?php echo $pendingTransfer->id; ?>/<?php echo $pendingTransfer->userid; ?>"><button type="button" class="btn btn-default  btn-xs">Ver detalles</button></a>
	                            <a href="<?php echo base_url(); ?>administrator/setApproveTransfer/<?php echo $pendingTransfer->id; ?>"><button type="button" class="btn btn-success btn-xs">Aprobar</button></a>
	                        </td>
	                    </tr>
	                <?php endforeach; ?>
	                </tbody>
	            </table>
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
