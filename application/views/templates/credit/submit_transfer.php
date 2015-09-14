<div id="page-wrapper">
        <form action="<?php echo base_url(); ?>credit/requestCredit" method="post" id="frm-agregarcredito" enctype="multipart/form-data">
            <div id="container">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 style="text-align: center;" class="info-level-3"><b>Agregar Crédito</b><br><small>Su crédito actual es: <?php echo number_format($balance, PRICE_DECIMAL_AMOUNT, DECIMAL_SEPARATOR, THOUSANDS_SEPARATOR)?>$</small></h3>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-6 col-sm-12 col-xs-12" >
                            <div class="panel panel-info">
                                <div class="panel-body">
                                    <label class="control-label" >Cantidad depositada</label>
                                        <?php echo form_error('amount', '<span class="label label-danger">', '</span>'); ?>
                                        <div class="input-group">
                                        <span class="input-group-addon">$</span>
                                        <input type="text" class="form-control" id="amount" name="amount" type="text" value="<?php echo set_value('amount'); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="name">Nota al administrador</label>
                                        <?php echo form_error('message', '<span class="label label-danger">', '</span>'); ?>
                                        <textarea class="form-control" id="message" name="message" placeHolder="Mensaje al administrador"><?php echo set_value('message'); ?></textarea>
                                    </div>

                                    <div class="form-group">
                                        <b> Adjuntar comprobante</b>
                                        <input class="checkbox" id="uploadVoucher" name="uploadVoucher" type="checkbox"> 
                                        <label class="control-label" for="userfile">Imagen de Comprobante de depósito (PNG - <?php echo ALLOWED_VOUCHER_IMAGE_MAXWIDTH; ?> píxels x <?php echo ALLOWED_VOUCHER_IMAGE_MAXHEIGHT; ?> píxels)</label>
                                        <?php if($this->session->flashdata('error')!=null) : ?>
                                            <span class="label label-danger"><?php echo $this->session->flashdata('error');  ?></span>
                                        <?php endif;?>
                                        <input class="form-control" id="userfile" name="userfile" type="file">

                                    </div>

                                    <div class="form-group">
                                        <input type="submit" value="Enviar aviso de pago" class="btn btn-info">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseInstructions"><h3 class="panel-title"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span><b> Como agregar crédito a tu cuenta </b><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span></h3></a>
                                </div>
                                <div id="collapseInstructions" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        1. Depositar en esta cuenta <br/>
                                        <pre>
                                                Nombre: PATRICIO 
                                                Apellido: FERNANDEZ
                                                CUIT: 20-31707543-0
                                                Banco Galicia
                                                Nro de Cuenta: 0005397-4 169-1
                                                CBU: 00701699 - 20000005397413

                                        </pre>
                                        2. Completa el formulario informando la cantidad depositada<br/>
                                        3. La imagen del comprobante es opcional.
                                    </div>
                                </div>                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
</div>