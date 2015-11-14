<div id="page-wrapper">
	<div class="container">
        <div class="page-header" style="text-align:center; margin: 0px 0 0px;">
            <h2><span class="label label-default" style="color:#ffffff;"><b>PROVEEDORES</b></span></h2>
        </div>
        <div class="span12">
        	<?php if($this->session->flashdata('success')!= null):?>
	            <div class="alert alert-dismissable alert-success">
	              <button type="button" class="close" data-dismiss="alert"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span></button>
	              <strong>Bien!</strong> <?php echo $this->session->flashdata('success'); ?></a>
	            </div>
	        <?php endif;?>
			<?php if($this->session->flashdata('error')!= null):?>
	            <div class="alert alert-dismissable alert-danger">
	              <button type="button" class="close" data-dismiss="alert"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span></button>
	              <strong>Atención!</strong> <?php echo $this->session->flashdata('error'); ?></a>
	            </div>
	        <?php endif;?>
            <div id="example_wrapper" class="dataTables_wrapper form-inline" role="grid">
                <table id="resultset" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Foto</th>
                            <th>Nombre <span class="glyphicon glyphicon-sort" aria-hidden="true"></span></th>
                            <th>Descuento que Ofrezco al Proveedor <span class="glyphicon glyphicon-sort" aria-hidden="true"></span></th>
                            <th>Estado <span class="glyphicon glyphicon-sort" aria-hidden="true"></span></th>
                            <th>Acciones <span class="glyphicon glyphicon-sort" aria-hidden="true"></span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($suppliers as $supplier): ?>
	                        <tr>
	                            <td>
	                            	<a href="<?php echo base_url() . 'Suppliers/viewSupplier/' . $supplier->id; ?>">
										<?php if (isset($supplier->logo)) {?>
											<img src="<?php echo base_url() . $supplier->logo; ?>" style="max-width: 100%;display: block;margin: 0 auto;max-height: 40px;">
									    <?php } else { ?>
									    	<img src="<?php echo base_url() . IMAGES_PATH . 'noProfilePic.jpg'; ?>" style="max-width: 100%;display: block;margin: 0 auto;max-height: 40px;">
									    <?php } ?>
								    </a>
								</td>
	                            <td><?php echo $supplier->fake_name ?></td>
	                            <td>
	                            	<?php if ($supplier->supplierSuplierAssociationStatus == 'associated') { ?>
	                            		<form action="<?php echo base_url() . 'suppliers/setToSupplierDiscount/' . $supplier->id;?>" method="post" id="<?php echo $supplier->id;?>">
		                            		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
			                            		<div class="input-group" style="float:left;width: 130px;">
									                <span class="input-group-addon">Descontar</span>
									                <input style="width: 80px;" type="number" class="form-control" id="discount" name="discount" min="0" max="100" step="1" value="<?php echo $supplier->toSupplierDiscount;?>"/>
									                <span class="input-group-addon">%</span>
									            </div>
								            </div>
								            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
								            	<button type="submit" class="btn btn-success btn-sm" form="<?php echo $supplier->id;?>"><span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span> Modificar descuento</button>
								            </div>
							            </form>
	                            	<?php } else { ?>
	                            		No Aplica
	                            	<?php } ?>
	                            </td>
	                            <td>
	                            	<?php if ($supplier->supplierSuplierAssociationStatus == 'none') { ?>
										No asociado
	                            	<?php } else if ($supplier->supplierSuplierAssociationStatus == 'sent') { ?>
	                            		Le ha enviado una solicitud de asociación
	                            	<?php } else if ($supplier->supplierSuplierAssociationStatus == 'received') { ?>
	                            		Ha recibidouna solicitud de asociación
	                            	<?php } else if ($supplier->supplierSuplierAssociationStatus == 'associated') { ?>
	                            		Asociado
	                            	<?php } ?>
	                            </td>
	                            <td>
	                            	<?php if ($supplier->supplierSuplierAssociationStatus == 'none') { ?>
	                            		<a href="<?php echo base_url() . 'Suppliers/sendSupplierSupplierRequest/' . $supplier->id; ?>">
	                            			<button class="btn btn-success btn-sm col-xs-12"><span class="glyphicon glyphicon-link" aria-hidden="true"></span> Enviar solicitud</button>
	                            		</a>
	                            	<?php } else if ($supplier->supplierSuplierAssociationStatus == 'sent') { ?>
	                            		<a href="<?php echo base_url() . 'Suppliers/cancelSupplierSupplierRequest/' . $supplier->id; ?>">
	                            			<button class="btn btn-warning btn-sm col-xs-12"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Cancelar Solicitud</button>
	                            		</a>
	                            	<?php } else if ($supplier->supplierSuplierAssociationStatus == 'received') { ?>
	                            		<a href="<?php echo base_url() . 'Suppliers/sendSupplierSupplierRequest/' . $supplier->id; ?>">
	                            			<button class="btn btn-primary btn-sm col-xs-12"><span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span> Aceptar Solicitud</button>
	                            		</a>
	                            	<?php } else if ($supplier->supplierSuplierAssociationStatus == 'associated') { ?>
	                            		<a href="<?php echo base_url() . 'Suppliers/cancelSupplierSupplierRequest/' . $supplier->id; ?>">
	                            			<button class="btn btn-warning btn-sm col-xs-12"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Desasociarme</button>
	                            		</a>
	                            	<?php } ?>
	                            	<a href="<?php echo base_url() . 'Suppliers/viewCatalog/'. $supplier->id;?>"><b>
										<button class="btn btn-warning btn-sm col-xs-12"> <span class="glyphicon glyphicon-list" aria-hidden="true"></span> Ver Catálogo</button>
	                            	</b></a>
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
