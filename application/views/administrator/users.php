<div id="page-wrapper">
    <div class="container">
        <div class="page-header" style="text-align:center; margin: 0px 0 0px;">
            <h2><span class="label label-default" style="color:#ffffff;"><b>USUARIOS</b></span></h2>
        </div>
        <?php if($this->session->flashdata('success')!= null):?>
            <div class="alert alert-dismissable alert-success">
              <button type="button" class="close" data-dismiss="alert"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
              <strong>Bien!</strong> <?php echo $this->session->flashdata('success'); ?></a>
            </div>
        <?php endif;?>

        <ul class="nav nav-tabs" style="margin-bottom: 15px;">
            <li class="active"><a href="#pendingSuppliers" data-toggle="tab">Solicitudes Pendientes</a></li>
            <li><a href="#suppliers" data-toggle="tab">Fabricantes</a></li>
            <li><a href="#distributors" data-toggle="tab">Ortopedistas</a></li>
        </ul>
        <div id="myTabContent" class="tab-content">   
            <div class="tab-pane fade active in" id="pendingSuppliers"> 
                <div class="span12">
                    <div id="example_wrapper" class="dataTables_wrapper form-inline" role="grid">
                        <table id="resultset" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th data-class="expand">Fecha</th>
                                    <th>Estado</th>
                                    <th>Usuario</th>
                                    <th data-hide="phone">Email</th>
                                    <th class="centered-cell" data-hide="phone,tablet">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($pendingSuppliers as $pendingSupplier): ?>
                                <tr>
                                    <td><?php echo date("d-M-y", strtotime($pendingSupplier->register_date));?></td>
                                    <td>pendiente</td>
                                    <td><?php echo $pendingSupplier->username; ?></td>
                                    <td><?php echo $pendingSupplier->email; ?></td>
                                    <td>
                                        <!-- <a href="/administrador/ver_fabricante/<?php echo $pendingSupplier->id; ?>"><button type="button" class="btn btn-default  btn-xs">Ver detalles</button></a> -->
                                        <a href="<?php echo base_url(); ?>administrator/approveSupplier/<?php echo $pendingSupplier->id; ?>"><button type="button" class="btn btn-success btn-xs">Aprobar</button></a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>          
            <div class="tab-pane fade" id="suppliers">
                <div class="span12">
                    <div id="example_wrapper" class="dataTables_wrapper form-inline" role="grid">
                        <table id="resultset" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th data-class="expand">Usuario</th>
                                    <th>Estado</th>
                                    <th data-hide="phone">Email</th>
                                    <th class="centered-cell" data-hide="phone,tablet">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($suppliers as $supplier): ?>
                                <tr>
                                    <td><?php echo $supplier->username; ?></td>
                                    <td>Activo</td>
                                    <td><?php echo $supplier->email; ?></td>
                                    <td>
                                        <form action="<?php echo base_url(); ?>administrator/impersonateUser" method="post" style="padding-bottom:2px">
                                            <input type="hidden" name="imperUsername" value="<?php echo $supplier->username; ?>">
                                            <button type="submit" class="btn btn-success btn-xs">Impersonar</button>
                                        </form>
                                        <form action="<?php echo base_url(); ?>administrator/deactivateUser/<?php echo $supplier->id; ?>" method="post" style="padding-bottom:2px">
                                            <button type="submit" class="btn btn-danger btn-xs">Desactivar</button>
                                            <input type="hidden" name="deactUsername" value="<?php echo $supplier->username; ?>">
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="distributors">
                <div class="span12">
                    <div id="example_wrapper" class="dataTables_wrapper form-inline" role="grid">
                        <table id="resultset" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th data-class="expand">Usuario</th>
                                    <th>Estado</th>
                                    <th data-hide="phone">Email</th>
                                    <th class="centered-cell" data-hide="phone,tablet">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($distributors as $distributor): ?>
                                <tr>
                                    <td><?php echo $distributor->username; ?></td>
                                    <td>activo</td>
                                    <td><?php echo $distributor->email; ?></td>
                                    <td>
                                        <form action="<?php echo base_url(); ?>administrator/impersonateUser" method="post" style="padding-bottom:2px">
                                            <input type="hidden" name="imperUsername" value="<?php echo $distributor->username; ?>">
                                            <button type="submit" class="btn btn-success btn-xs">Impersonar</button>
                                        </form>
                                        <!-- <a href="#"><button type="button" class="btn btn-danger btn-xs">Desactivar</button></a> -->
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

<?php $this->load->view('templates/scripts/table_scripts'); ?>