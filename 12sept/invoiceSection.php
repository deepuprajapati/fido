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



			<div class="resContnr_pdd container-fluid page-content bg-white p-t-15 p-l-35 p-r-35">

						<h1 class="border-bottom border-bottom-grey-100 text-black-400 p-b-10 p-t-15">Invoice Managemnt</h1>
						<div class="min_hght_440">
				<div class="row rwResp respRow">
					
						<!-- Help topics -->
						
							<div class="col-md-6 col-sm-12">
								<div class="bigLnk_wpr marg_b_40 marg_t_30">
									<div class="col-md-2 col-sm-2 col-xs-3 p-0 biglnk_icn_sec">
										<i class="icon-cash x6 text-teal-a600"></i>
									</div>
									<div class="col-md-10 col-sm-10 col-xs-9 p-0">
										<a href="manualInvoice.php" class="biglnk_ttl_sec">
										<h3 class="text-black-400">Media Invoice</h3>
										<p>Create A Media Invoice</p>
										</a>
									</div>
								</div>
							</div> <!-- 1 -->
								

							<div class="col-md-6 col-sm-12">
								<div class="bigLnk_wpr marg_b_40 marg_t_30">
									<div class="col-md-2 col-sm-2 col-xs-3 p-0 biglnk_icn_sec">
										<i class="icon-cash-note-2 x6 text-teal-a600"></i>
									</div>
									<div class="col-md-10 col-sm-10 col-xs-9 p-0">
										<a href="Invoice.php" class="biglnk_ttl_sec">
										<h3 class="text-black-400">Non Media Invoice</h3>
										<p>Create a Non-Media Invoice</p>
										</a>
									</div>
								</div>
							</div> <!-- 2 -->
								


							<div class="col-md-6 col-sm-12">
								<div class="bigLnk_wpr marg_b_40">
									<div class="col-md-2 col-sm-2 col-xs-3 p-0 biglnk_icn_sec">
										<i class="icon-piggy-bank x6 text-teal-a600"></i>
									</div>
									<div class="col-md-10 col-sm-10 col-xs-9 p-0">
										<a href="allinvoice.php" class="biglnk_ttl_sec">
										<h3 class="text-black-400">Invoice</h3>
										<p>List of all the Invoices</p>
										</a>
									</div>
								</div>
							</div> <!-- 3 -->




							<div class="col-md-6 col-sm-12">
								<div class="bigLnk_wpr marg_b_40">
									<div class="col-md-2 col-sm-2 col-xs-3 p-0 biglnk_icn_sec">
										<i class="icon-cash3 x6 text-teal-a600"></i>
									</div>
									<div class="col-md-10 col-sm-10 col-xs-9 p-0">
										<a href="payment.php" class="biglnk_ttl_sec">
										<h3 class="text-black-400">Payment</h3>
										<p>Update the Payment recieved</p>
										</a>
									</div>
								</div>
							</div>  <!-- 4 -->




						</div>
						</div>
						<!-- /Help topics -->

				

			 <?php include('include/footer-new.php'); ?>
				</div>

   </div>
