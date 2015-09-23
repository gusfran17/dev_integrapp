<div id="page-wrapper">
	<div class="container-fluid" id="main-products">
		<div class="page-header" style="text-align:center; margin: 0px 0 0px;">
			<h2><span class="label label-default" style="color:#ffffff;"><b>CLIENTES</b></span></h2>
		</div>
	</div>
	<div class="bs-example">
	  <ul class="nav nav-tabs nav-pills" style="margin-bottom: 15px;">
	    <li class="active">
	        <a href="#pending" data-toggle="tab"><span class="glyphicon glyphicon-time" aria-hidden="true"></span> Pendientes <span class="badge badge-red"><?php echo count($pendingDistributors); ?></span></a>
	    </li>
	    <li class="">
	        <a href="#approved" data-toggle="tab"><span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span> Aprobados <span class="badge"><?php echo count($approvedDistributors); ?></span></a>
	    </li>
	    <li class="">
	        <a href="#rejected" data-toggle="tab"><span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span> Rechazados <span class="badge"><?php echo count($rejectedDistributors); ?></span></a>
	    </li>
	  </ul>
	  <?php if($this->session->flashdata('success') != null):?>
		<div class="alert alert-dismissable alert-success">
			<button type="button" class="close" data-dismiss="alert"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
			<strong><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span></strong>
		 	<strong>Bien!</strong> <?php echo $this->session->flashdata('success'); ?></a>
		</div>
	  <?php endif;?>
	  <?php if($this->session->flashdata('error') != null):?>
		<div class="alert alert-dismissable alert-success">
			<button type="button" class="close" data-dismiss="alert"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
			<strong><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span></strong>
		 	<strong>Atención!</strong> <?php echo $this->session->flashdata('error'); ?></a>
		</div>
	  <?php endif;?>
	  <div id="myTabContent" class="tab-content">
	    <div class="tab-pane fade active in" id="pending">
	      <div class="row">
	            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	                <div id="example_wrapper" class="dataTables_wrapper form-inline" role="grid">

	                    <table id="resultset" class="table table-bordered table-striped" data-url="data3.json" data-show-columns="true" data-id-field="id">
	                        <thead>
	                            <tr>
	                            	<th>Imagen</th>
	                                <th>Ortopedia</th>
	                                <th>Descuento</th>	                                
	                                <th>Acciones</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                        	<?php 
									$pendingDistributorsSize = count($pendingDistributors);
									for ($i=0; $i < $pendingDistributorsSize; $i++) { ?>
										<tr class="unread">
		                                	<td>
		                                		<a href="">
			                   				    	<?php if(isset($pendingDistributors[$i]->logo)) {?>
											      		<img src="<?php echo base_url() . $pendingDistributors[$i]->logo; ?>" style="max-width: 100%;display: block;margin: 0 auto;max-height: 40px;">
												    <?php } else { ?>
												    	<img src="<?php echo base_url() . IMAGES_PATH . 'noProfilePic.jpg'; ?>" style="max-width: 100%;display: block;margin: 0 auto;max-height: 40px;">
												    <?php } ?>
											    </a>
		                                	</td>
		                                	<td><?php echo $pendingDistributors[$i]->fake_name; ?></td>
		                                	<td>
		                                		<form action="<?php echo base_url() . 'distributors/setSupplierDistributorDiscount/' . $pendingDistributors[$i]->id;?>" method="post" id="<?php echo $pendingDistributors[$i]->id;?>">
			                                		<div class="input-group col-lg-6 col-md-6 col-sm-12 col-xs-12" style="float:left;width: 130px;">
										                <span class="input-group-addon">Descontar</span>
										                <input style="width: 80px;" type="number" class="form-control" id="discount" name="discount" min="0" max="100" step="1" value="<?php echo $pendingDistributors[$i]->discount;?>"/>
										                <span class="input-group-addon">%</span>
										            </div>
										            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
										            	<button type="submit" class="btn btn-success btn-sm" form="<?php echo $pendingDistributors[$i]->id;?>"><span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span> Guardar descuento</button>
										            </div>
									            </form>
		                                	</td>
			                                <td class="centered-cell">
			                                    <a href="<?php echo base_url() . 'distributors/setSupplierDistributorStatus/' . $pendingDistributors[$i]->id . '/approved';?>"><button type="button" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span> Aprobar</button></a>
			                                    <a href="<?php echo base_url() . 'distributors/setSupplierDistributorStatus/' . $pendingDistributors[$i]->id . '/rejected';?>"><button type="button" class="btn btn-danger  btn-xs"><span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span> Rechazar</button></a>
			                                    <a href="<?php echo base_url() . 'distributors/viewDistributor/' . $pendingDistributors[$i]->id;?>"><button type="button" class="btn btn-default  btn-xs"><span class="glyphicon glyphicon-list" aria-hidden="true"></span> Ver detalles</button></a>
	 	                                </td>
			                            </tr>
								<?php } ?>
	                        </tbody>
	                    </table>
	                </div>
	            </div>
	        </div>
	    </div>
	    <div class="tab-pane fade" id="approved">
	        <div class="row">
	            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	                <div id="example_wrapper" class="dataTables_wrapper form-inline" role="grid">

	                    <table id="resultset" class="table table-bordered table-striped">
	                        <thead>
	                            <tr>
	                            	<th>Imagen</th>
	                                <th>Usuario</th>
   	                                <th>Descuento</th>
	                                <th>Acciones</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                        	<?php 
									$approvedDistributorsSize = count($approvedDistributors);
									for ($i=0; $i < $approvedDistributorsSize; $i++) { ?>
										<tr class="unread">
											<td>
		                                		<a href="">
			                   				    	<?php if(isset($approvedDistributors[$i]->logo)) {?>
											      		<img src="<?php echo base_url() . $approvedDistributors[$i]->logo; ?>" style="max-width: 100%;display: block;margin: 0 auto;max-height: 40px;">
												    <?php } else { ?>
												    	<img src="<?php echo base_url() . IMAGES_PATH . 'noProfilePic.jpg'; ?>" style="max-width: 100%;display: block;margin: 0 auto;max-height: 40px;">
												    <?php } ?>
											    </a>
		                                	</td>
		                                	<td><?php echo $approvedDistributors[$i]->fake_name; ?></td>
		                                	<td>
		                                		<form action="<?php echo base_url() . 'distributors/setSupplierDistributorDiscount/' . $approvedDistributors[$i]->id;?>" method="post" id="<?php echo $approvedDistributors[$i]->id;?>">
			                                		<div class="input-group col-lg-6 col-md-6 col-sm-12 col-xs-12" style="float:left;width: 130px;">
										                <span class="input-group-addon">Descontar</span>
										                <input style="width: 80px;" type="number" class="form-control" id="discount" name="discount" min="0" max="100" step="1" value="<?php echo $approvedDistributors[$i]->discount;?>"/>
										                <span class="input-group-addon">%</span>
										                
										            </div>
										            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
										            	<button type="submit" class="btn btn-success btn-sm" form="<?php echo $approvedDistributors[$i]->id;?>"><span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span> Guardar descuento</button>
										            </div>
									            </form>		                                		
		                                	</td>
			                                <td class="centered-cell">
			                                    <a href="<?php echo base_url() . 'distributors/setSupplierDistributorStatus/' . $approvedDistributors[$i]->id . '/rejected';?>"><button type="button" class="btn btn-danger  btn-xs"><span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span> Rechazar</button></a>
			                                    <a href="<?php echo base_url() . 'distributors/viewDistributor/' . $approvedDistributors[$i]->id;?>"><button type="button" class="btn btn-default  btn-xs"><span class="glyphicon glyphicon-list" aria-hidden="true"></span> Ver detalles</button></a>
			                                </td>
			                            </tr>
								<?php } ?>
	                        </tbody>
	                    </table>
	                </div>
	            </div>
	        </div>
	    </div>
	    <div class="tab-pane fade" id="rejected">
	        <div class="row">
	            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	                <div id="example_wrapper" class="dataTables_wrapper form-inline" role="grid">
	                    <table id="resultset" class="table table-bordered table-striped">
	                        <thead>
	                            <tr>
	                            	<th>Image</th>
	                                <th>Usuario</th>
	                                <th>Descuento</th>
	                                <th>Acciones</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                        	<?php 
									$rejectedDistributorsSize = count($rejectedDistributors);
									for ($i=0; $i < $rejectedDistributorsSize; $i++) { ?>
										<tr class="unread">
											<td>
		                                		<a href="">
			                   				    	<?php if(isset($rejectedDistributors[$i]->logo)) {?>
											      		<img src="<?php echo base_url() . $rejectedDistributors[$i]->logo; ?>" style="max-width: 100%;display: block;margin: 0 auto;max-height: 40px;">
												    <?php } else { ?>
												    	<img src="<?php echo base_url() . IMAGES_PATH . 'noProfilePic.jpg'; ?>" style="max-width: 100%;display: block;margin: 0 auto;max-height: 40px;">
												    <?php } ?>
											    </a>
		                                	</td>
		                                	<td><?php echo $rejectedDistributors[$i]->fake_name; ?></td>
			                                <td>
		                                		<form action="<?php echo base_url() . 'distributors/setSupplierDistributorDiscount/' . $rejectedDistributors[$i]->id;?>" method="post" id="<?php echo $rejectedDistributors[$i]->id;?>">
			                                		<div class="input-group col-lg-6 col-md-6 col-sm-12 col-xs-12" style="float:left;width: 130px;">
										                <span class="input-group-addon">Descontar</span>
										                <input style="width: 80px;" type="number" class="form-control" id="discount" name="discount" min="0" max="100" step="1" value="<?php echo $rejectedDistributors[$i]->discount;?>"/>
										                <span class="input-group-addon">%</span>
										                
										            </div>
										            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
										            	<button type="submit" class="btn btn-success btn-sm" form="<?php echo $rejectedDistributors[$i]->id;?>"><span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span> Guardar descuento</button>
										            </div>
									            </form>
									        </td>
			                                <td class="centered-cell">
			                                    <a href="<?php echo base_url() . 'distributors/setSupplierDistributorStatus/' . $rejectedDistributors[$i]->id . '/approved';?>"><button type="button" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span> Aprobar</button></a>
			                                    <a href="<?php echo base_url() . 'distributors/viewDistributor/' . $rejectedDistributors[$i]->id;?>"><button type="button" class="btn btn-default  btn-xs"><span class="glyphicon glyphicon-list" aria-hidden="true"></span> Ver detalles</button></a>
			                                </td>
			                            </tr>
								<?php } ?>
	                        </tbody>
	                    </table>
	                </div>
	            </div>
	        </div>
	    </div>
	  </div>
	</div>
</div>
