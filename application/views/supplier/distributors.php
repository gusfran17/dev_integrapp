<section id="home">
	<div class="container-fluid" id="main-products">
		<div class="page-header" style="text-align:center; margin: 0px 0 0px;">
			<h2><span class="label label-default" style="color:#ffffff;"><b>CLIENTES</b></span></h2>
		</div>
	</div>
	<div class="bs-example">
	  <ul class="nav nav-tabs nav-pills" style="margin-bottom: 15px;">
	    <li class="active">
	        <a href="#pending" data-toggle="tab">Pendientes <span class="badge badge-red"><?php echo count($pendingDistributors); ?></span></a>
	    </li>
	    <li class="">
	        <a href="#approved" data-toggle="tab">Aprobados <span class="badge"><?php echo count($approvedDistributors); ?></span></a>
	    </li>
	    <li class="">
	        <a href="#rejected" data-toggle="tab">Rechazados <span class="badge"><?php echo count($rejectedDistributors); ?></span></a>
	    </li>
	  </ul>
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
		                                		<div class="input-group porcentaje" style="float:left;width: 130px;">
									                <span class="input-group-addon">Descontar</span>
									                <input style="width: 80px;" type="number" class="form-control" id="discount" name="discount" min="0" max="100" step="1" value="0"/>
									                <span class="input-group-addon">%</span>
									            </div>
		                                	</td>
			                                <td class="centered-cell">
			                                    <a href="<?php echo base_url() . 'distributors/setSupplierDistributorStatus/' . $pendingDistributors[$i]->id . '/approved';?>"><button type="button" class="btn btn-success btn-xs">Aprobar</button></a>
			                                    <a href="<?php echo base_url() . 'distributors/setSupplierDistributorStatus/' . $pendingDistributors[$i]->id . '/rejected';?>"><button type="button" class="btn btn-danger  btn-xs">Bloquear</button></a>
			                                    <a href="<?php echo base_url() . 'distributors/viewDistributor/' . $pendingDistributors[$i]->id;?>"><button type="button" class="btn btn-default  btn-xs">Ver detalles</button></a>
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
		                                		<div class="input-group porcentaje" style="float:left;width: 130px;">
									                <span class="input-group-addon">Descontar</span>
									                <input style="width: 80px;" type="number" class="form-control" id="discount" name="discount" min="0" max="100" step="1" value="0"/>
									                <span class="input-group-addon">%</span>
									            </div>		                                		
		                                	</td>
			                                <td class="centered-cell">
			                                    <a href="<?php echo base_url() . 'distributors/setSupplierDistributorStatus/' . $approvedDistributors[$i]->id . '/rejected';?>"><button type="button" class="btn btn-danger  btn-xs">Bloquear</button></a>
			                                    <a href="<?php echo base_url() . 'distributors/viewDistributor/' . $approvedDistributors[$i]->id;?>"><button type="button" class="btn btn-default  btn-xs">Ver detalles</button></a>
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
		                                		<div class="input-group porcentaje" style="float:left;width: 130px;">
									                <span class="input-group-addon">Descontar</span>
									                <input style="width: 80px;" type="number" class="form-control" id="discount" name="discount" min="0" max="100" step="1" value="0"/>
									                <span class="input-group-addon">%</span>
									            </div>			                                	
			                                </td>
			                                <td class="centered-cell">
			                                    <a href="<?php echo base_url() . 'distributors/setSupplierDistributorStatus/' . $rejectedDistributors[$i]->id . '/approved';?>"><button type="button" class="btn btn-success btn-xs">Aprobar</button></a>
			                                    <a href="<?php echo base_url() . 'distributors/viewDistributor/' . $rejectedDistributors[$i]->id;?>"><button type="button" class="btn btn-default  btn-xs">Ver detalles</button></a>
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
</section>