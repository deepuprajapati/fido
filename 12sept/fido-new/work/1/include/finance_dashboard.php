<?php
	$logid_js = "var ttl_no = parseInt($('.nojs_1').text()) + parseInt($('.nojs_2').text()) + parseInt($('.nojs_3').text()) + parseInt($('.nojs_4').text()) + parseInt($('.nojs_5').text());"
?>
<div class="p-t-28">
	<div class="card card-inverse card-flat border-none resCd_dsh_crd">
		<div class="card-block cardBlck_cstm p-b-10">
			<div class="row p-t-10 p-b-10 m-0 resCd_pd0">
				<!-- Leads -->
				<div class="flx_cntWidth_20_nogap resCode_othrDash p-l-0 p-r-0 br-grey-100 br-lg br-dashed resCode_dsh_cart">
					<div class="cardBx_dashbrd">
						<div class="col-md-12 col-12">
							<h4 class="text-uppercase text-muted no-m">Approved Estimates</h4>
							<div class="x3 no-p no-m m-t-10 m-b-10 text-info"><span class="nojs_1"><?php echo count($project->selectallEstimateWithQuery(''," and p.status = 1  "))?></span> <a href="<?php echo $config['SITE_URL']."estimate.php?action=approved_estimates";?>" class="icnlnk_cards"><i class="icon-arrow-right42"></i></a></div>
						</div>
						<div class="col-md-12">
							<div class="procesBar_in_cart">
								<div class="float-left" style="width:75%;padding-right: 7px;">
									<div class="progress">
										<div class="progress-bar bg-success-100 nojs_1_css" ></div>
									</div>
								</div>
								<div class="float-right text-semibold text-muted nojs_1_txt"></div>
							</div>
						</div>
						<!--<div class="col-md-4 col-4 no-p text-right"><i class="icon-comment x6 text-grey-100 m-t-15"></i></div>--></div>
					<div style="display:none" id="leads"></div>
				</div>
				<!-- /Leads -->
				<!-- Payments -->
				<div class="flx_cntWidth_20_nogap resCode_othrDash p-l-0 p-r-0 br-grey-100 br-lg br-dashed resCode_dsh_cart">
					<div class="cardBx_dashbrd">
						<div class="col-md-12 col-12">
							<h4 class="text-uppercase text-muted no-m">Pending Po Approval</h4>
							<div class="x3 no-p no-m m-t-10 m-b-10 text-info"><span class="nojs_2"><?php echo count($project->no_po_estimate_list()); ?></span> <a href="<?php echo $config['SITE_URL']."estimate.php?action=pending_po_approval";?>" class="icnlnk_cards"><i class="icon-arrow-right42"></i></a></div>
						</div>
						<div class="col-md-12">
							<div class="procesBar_in_cart">
								<div class="float-left" style="width:75%;padding-right: 7px;">
									<div class="progress">
										<div class="progress-bar bg-success-100 nojs_2_css" ></div>
									</div>
								</div>
								<div class="float-right text-semibold text-muted nojs_2_txt"></div>
							</div>
						</div>
					</div>
					<div style="display:none" id="payment"></div>
				</div>
				<!-- /Payments -->
				<!-- Sales -->
				<div class="flx_cntWidth_20_nogap resCode_othrDash p-l-0 p-r-0 br-grey-100 br-lg br-dashed resCode_dsh_cart">
					<div class="cardBx_dashbrd">
						<div class="col-md-12 col-12">
							<h4 class="text-uppercase text-muted no-m">Invoice Requisitions</h4>
							<div class="x3 no-p no-m m-t-10 m-b-10 text-info"><span class="nojs_3"><?php echo count($project->selectallEstimateWithPendinginvoice()); ?></span>
							<a href="<?php echo $config['SITE_URL']."estimate.php?action=pending_invoice";?>" class="icnlnk_cards"><i class="icon-arrow-right42"></i></a></div>
						</div>
						<div class="col-md-12">
							<div class="procesBar_in_cart">
								<div class="float-left" style="width:75%;padding-right: 7px;">
									<div class="progress">
										<div class="progress-bar bg-success-100 nojs_3_css" ></div>
									</div>
								</div>
								<div class="float-right text-semibold text-muted nojs_3_txt"></div>
							</div>
						</div>
					</div>
					<div style="display:none" id="sales"></div>
				</div>
				<!-- /Sales -->
				<!-- Sales -->
				<div class="flx_cntWidth_20_nogap resCode_othrDash p-l-0 p-r-0 br-grey-100 br-lg br-dashed resCode_dsh_cart">
					<div class="cardBx_dashbrd cardBx_dashbrd_mrg0">
						<div class="col-md-12 col-12">
							<h4 class="text-uppercase text-muted no-m">Invoiced</h4>
							<div class="x3 no-p no-m m-t-10 m-b-10 text-info"><span class="nojs_4"><?php echo count($media_invoice->all()); ?></span>
							<a href="<?php echo $config['SITE_URL']."allinvoice.php";?>" class="icnlnk_cards"><i class="icon-arrow-right42"></i></a></div>
						</div>
						<div class="col-md-12">
							<div class="procesBar_in_cart">
								<div class="float-left" style="width:75%;padding-right: 7px;">
									<div class="progress">
										<div class="progress-bar bg-success-100 nojs_4_css" ></div>
									</div>
								</div>
								<div class="float-right text-semibold text-muted nojs_4_txt"></div>
							</div>
						</div>
					</div>
				</div>
				<div class="flx_cntWidth_20_nogap resCode_othrDash p-l-0 p-r-0 resCode_dsh_cart">
					<div class="cardBx_dashbrd cardBx_dashbrd_mrg0">
						<div class="col-md-12 col-12">
							<h4 class="text-uppercase text-muted no-m">Outstanding Invoives</h4>
							<div class="x3 no-p no-m m-t-10 m-b-10 text-info"><span class="nojs_5"><?php echo count($project->selectallEstimateWithQuery('6'," and p.process = 1 and  p.reconciliation = 1 ")); ?></span>
							<a href="" class="icnlnk_cards"><i class="icon-arrow-right42"></i></a></div>
						</div>
						<div class="col-md-12">
							<div class="procesBar_in_cart">
								<div class="float-left" style="width:75%;padding-right: 7px;">
									<div class="progress">
										<div class="progress-bar bg-success-100 nojs_5_css" ></div>
									</div>
								</div>
								<div class="float-right text-semibold text-muted nojs_5_txt"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
                
	<div class="cstmRow cstmRow_flex resCodedashBrd_tbl">
	<div class="chartsemi_section flx_cntWidth_68 p-0 bgWhite resCodeSng_cart">
	<!-- Bordered table -->
		<div class="card card-inverse card-flat box_border_0">
			<div class="p-0 bgWhite">
				<div class="card-header brdr-b">
					<div class="card-title">Top 5 Outstanging Payment</div>
				</div>
				<!--<div class="card-block p-b-10">Basic table with <code>.table-bordered</code> class.</div>-->
				<div class="p-l-20 p-r-20">
				<div class="table-responsive m-t-20">
					<table class="table table-bordered table-hover tableSml_dash_style">
						<thead>
							 <tr><th></th><th>Total</th><th>30 Days</th><th>60 Days</th><th>90 Days</th><th>120 Days</th><th>180+ Days</th></tr>
						</thead>
						<tbody>
						<?php $i=1;
						foreach($outstanging_payment as $key=>$value) { 
						if($i == 6) break; 
						?>
						<tr>
						<td><?php echo $value['Invoice_No'] ?></td>
						<td><?php echo $mformate->numberToCurrency($value['money']) ?></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						</tr>
						<?php $i++;
						} ?>
						</tbody>
					</table>
				</div>
				</div>
			</div>
		</div>
	</div>



	<div class="quicklink_section flx_cntWidth_32 p-0 bgWhite resCodeSng_cart">
	<!-- Bordered table -->
	<div class="card card-inverse card-flat box_border_0">
		<div class="card-header brdr-b">
			<div class="card-title">Quick Link</div>
		</div>
		<!--<div class="card-block p-b-10">Basic table with <code>.table-bordered</code> class.</div>-->
		<ul class="quick_link_list">
	<li><a href="<?php echo $config['SITE_URL']?>payment.php" class="list-group-item">Update Payment Recieved</a></li>
	<li><a href="javascript:;" class="list-group-item">Create Credit Note</a></li>
	<li><a href="addPartner.php" class="list-group-item">Create New Client</a></li>
	<li><a href="addPublisher.php" class="list-group-item">Add New Publisher</a></li>
	<li><a href="javascript:;" class="list-group-item">Create PO</a></li>
	<li><a href="javascript:;" class="list-group-item">Update Payment Done</a></li>
	<li><a href="reports.php" class="list-group-item">Download Reports</a></li>

	</ul>
	</div>
	</div>
	</div>




	<div class="cstmRow cstmRow_flex resCodedashBrd_tbl">
                <div class="flx_cntWidth_45 p-0 bgWhite resCodeSng_cart">
						<div class="card card-inverse card-flat box_border_0">
							<div class="p-0 bgWhite">
								<div class="card-header brdr-b">
									<div class="card-title">Partially Invoiced</div>
								</div>
								<!--<div class="card-block p-b-10">Basic table with <code>.table-bordered</code> class.</div>-->
								<div class="p-l-20 p-r-20">
                        <div class="table-responsive m-t-20">
									<table class="table table-bordered table-hover tableSml_dash_style">
										<thead>
											 <tr><th>Brand</th><th>Estiamte</th><th>Estiamte Money</th><th>Invoiced</th><th>Balance</th></tr>
										</thead>
											<tbody>
								<?php $i=1;
									foreach($allpartially as $key=>$value) { 
										  if($i == 5) break;
										  ?>
									<tr>
										<td><?php echo $value['partner_name'] ?></td>
										<td><?php echo $value['W_O'] ?></td>
										<td><?php echo $mformate->numberToCurrency($value['totalprice']) ?></td>
										 <td><?php echo $mformate->numberToCurrency($value['invoiceMoney']) ?></td>
										<td><?php echo $mformate->numberToCurrency($value['totalprice']-$value['invoiceMoney']) ?></td>
										  </tr>
									<?php $i++;
											} ?>
											</tbody>
									</table>
								</div>
								</div>
							</div>
						</div>
					</div>
                    
		
                    <div class="flx_cntWidth_55 p-0 bgWhite resCodeSng_cart">
						<div class="card card-inverse card-flat box_border_0">
							<div class="p-0 bgWhite">
								<div class="card-header brdr-b">
									<div class="card-title">Payable</div>
								</div>
								<!--<div class="card-block p-b-10">Basic table with <code>.table-bordered</code> class.</div>-->
								<div class="p-l-20 p-r-20">
                        <div class="table-responsive m-t-20">
									<table class="table table-bordered table-hover tableSml_dash_style">
									<thead>
										 <tr><th>Publisher</th><th>Amout</th><th>PO/RO Number</th><th>Payment Status</th></tr>
									</thead>
									<tbody>
											<tr class="no_rcrd">
												<td style="text-align:  center;font-size: 14px;padding: 30px 0;" colspan="4" >No Records</td>
											</tr>	
									</tbody>
									</table>
								</div>
								</div>
							</div>
						</div>
					</div>
					
					
	</div>
	
	
	
	<div class="cstmRow cstmRow_flex resCodedashBrd_tbl">
                <div class="quicklink_section flx_cntWidth_45 p-0 bgWhite resCodeSng_cart">
						<div class="card card-inverse card-flat box_border_0">
							<div class="p-0 bgWhite">
								<div class="card-header brdr-b">
									<div class="card-title">Top Report</div>
								</div>
								<div class="p-l-20 p-r-20">
                        <div class="table-responsive m-t-20">
									<table class="table table-bordered table-hover tableSml_dash_style">
										<tbody>
												<tr><td>Purchase - <a class="tbl_txt_lnk" href="" target="_blank">Download</a></td> </tr>
												<tr><td>Sale - <a class="tbl_txt_lnk" href="" target="_blank">Download</a></td> </tr>
										</tbody>
									</table>
								</div>
								</div>
							</div>
						</div>
					</div>
                    
					<div class="quicklink_section flx_cntWidth_55 p-0 bgWhite resCodeSng_cart">
						<div class="card card-inverse card-flat box_border_0">
							<div class="p-0 bgWhite">
								<div class="card-header brdr-b">
									<div class="card-title">Contract About to Expire</div>
								</div>
								<!--<div class="card-block p-b-10">Basic table with <code>.table-bordered</code> class.</div>-->
								<div class="p-l-20 p-r-20">
                        <div class="table-responsive m-t-20">
									<table class="table table-bordered table-hover tableSml_dash_style">
									<tbody>
									  <?php foreach($recods as $k=>$v){ 
									  echo "<tr><td>".$v['partner_name']."</th><th>".$v['expire_date']."</td></tr>";
									   } ?>	
									</tbody>
									</table>
								</div>
								</div>
							</div>
						</div>
					</div>
					
					
	</div>	
	




                    
			<!-- Related demos -->