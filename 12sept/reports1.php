<?php include('include/header-files.php'); ?>
<style>

@media only screen and (max-width:576px){
	
	/** Start individual page css style **/      
	
	.rwResp{
		padding: 0px !important;
		margin-top: 12px;
	}
	
	@media only screen and (max-width:576px){
		.resContnr_pdd {
			padding: 4px 8px 20px 8px !important;
		}
	}
	
	/** End individual page css style **/
	
}


</style>
 <?php include('include/header-new.php'); ?>
<?php
$fileBasePath = dirname(__FILE__).'/';
?>
	<section class="main-container">
		<h1 style="display:none">Empty Heading</h1>



			<div class="resContnr_pdd container-fluid page-content bg-white p-t-15 p-l-35 p-r-35">

						<h1 class="border-bottom border-bottom-grey-100 text-black-400 p-b-10 p-t-15">Finance Reports</h1>
				<div class="row rwResp respRow">
					
						<!-- Help topics -->
						
							<div class="col-md-6 col-sm-12">
								<div class="bigLnk_wpr marg_b_40 marg_t_30">
									<div class="col-md-2 col-sm-2 col-xs-3 p-0 biglnk_icn_sec">
										<i class="icon-book4 x6 text-teal-a600"></i>
									</div>
									<div class="col-md-10 col-sm-10 col-xs-9 p-0">
										<a href="download_sale_register.php" class="biglnk_ttl_sec">
										<h3 class="text-black-400">Sale Register</h3>
										<p>Create A Media Invoice</p>
										</a>
									</div>
								</div>
							</div>
								

							<div class="col-md-6 col-sm-12">
								<div class="bigLnk_wpr marg_b_40 marg_t_30">
									<div class="col-md-2 col-sm-2 col-xs-3 p-0 biglnk_icn_sec">
										<i class="icon-editing x6 text-teal-a600"></i>
									</div>
									<div class="col-md-10 col-sm-10 col-xs-9 p-0">
										<a href="unbilled_estimate.php" class="biglnk_ttl_sec">
										<h3 class="text-black-400">Unbilled Estimates</h3>
										<p>Create a Non-Media Invoice</p>
										</a>
									</div>
								</div>
							</div>
								


							<div class="col-md-6 col-sm-12">
								<div class="bigLnk_wpr marg_b_40">
									<div class="col-md-2 col-sm-2 col-xs-3 p-0 biglnk_icn_sec">
										<!--<i class="icon-wait-1 x6 text-teal-a600"></i>-->
										<img src="asset-new/img/awaited-icon.png" style="display: block;margin: 0px auto;">
									</div>
									<div class="col-md-10 col-sm-10 col-xs-9 p-0">
										<a href="awaited_po_summary.php" class="biglnk_ttl_sec">
										<h3 class="text-black-400">Awaited PO Summary</h3>
										<p>List of all the Invoices</p>
										</a>
									</div>
								</div>
							</div>


							<div class="col-md-6 col-sm-12">
								<div class="bigLnk_wpr marg_b_40">
									<div class="col-md-2 col-sm-2 col-xs-3 p-0 biglnk_icn_sec">
										<i class="icon-file-text3 x6 text-teal-a600"></i>
									</div>
									<div class="col-md-10 col-sm-10 col-xs-9 p-0">
										<a href="ro_register.php" class="biglnk_ttl_sec">
										<h3 class="text-black-400">RO Register</h3>
										<p>Update the Payment recieved</p>
										</a>
									</div>
								</div>
							</div>

							<div class="col-md-6 col-sm-12">
								<div class="bigLnk_wpr marg_b_40">
									<div class="col-md-2 col-sm-2 col-xs-3 p-0 biglnk_icn_sec">
										<i class="icon-file-text3 x6 text-teal-a600"></i>
									</div>
									<div class="col-md-10 col-sm-10 col-xs-9 p-0">
										<a href="estimate_register.php" class="biglnk_ttl_sec">
										<h3 class="text-black-400">Estimate Register</h3>
										<p>Update the Payment recieved</p>
										</a>
									</div>
								</div>
							</div>


							<div class="col-md-6 col-sm-12">
								<div class="bigLnk_wpr marg_b_40">
									<div class="col-md-2 col-sm-2 col-xs-3 p-0 biglnk_icn_sec">
										<i class="icon-file-text3 x6 text-teal-a600"></i>
									</div>
									<div class="col-md-10 col-sm-10 col-xs-9 p-0">
										<a href="open_estimate.php" class="biglnk_ttl_sec">
										<h3 class="text-black-400">Open Estimate Summery</h3>
										<p>Update the Payment recieved</p>
										</a>
									</div>
								</div>
							</div>


							<div class="col-md-6 col-sm-12">
								<div class="bigLnk_wpr marg_b_40">
									<div class="col-md-2 col-sm-2 col-xs-3 p-0 biglnk_icn_sec">
										<i class="icon-file-text3 x6 text-teal-a600"></i>
									</div>
									<div class="col-md-10 col-sm-10 col-xs-9 p-0">
										<a href="awaited_po_summary.php?action=with_po" class="biglnk_ttl_sec">
										<h3 class="text-black-400">Estimate With PO</h3>
										<p>Update the Payment recieved</p>
										</a>
									</div>
								</div>
							</div>



						</div>
						<!-- /Help topics -->

				

			 <?php include('include/footer-new.php'); ?>
				</div>

   </div>
