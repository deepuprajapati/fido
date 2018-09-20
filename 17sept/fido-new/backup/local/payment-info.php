<?php include('include/header-files.php'); ?>
<!-- write your custom css and js here -->
	<style>
	
	.odd_tr_stl td{
		background-color:#FAFBFC !important;
	}


	.odd_tr_stl.actv_td td, .evn_tr_stl.actv_td td{
		background-color: #565090b0 !important;
		color: #fff;
	}
	
	.odd_tr_stl.actv_td td p, .evn_tr_stl.actv_td td p{
		margin: 0px;
		color: #fff;
	}
	
	.odd_tr_stl.actv_td .chkbox_cstm_wpr .chbx_style span, .evn_tr_stl.actv_td .chkbox_cstm_wpr .chbx_style span{
		    border: 1px solid #ffffff;
	}
	
	.odd_tr_stl.actv_td .chkbox_cstm_wpr .chbx_style span:after, .evn_tr_stl.actv_td .chkbox_cstm_wpr .chbx_style span:after{
		    color: #ffffff;
	}
	
	.tr_stl_loop{
		display:none;
	}
	
	.tr_stl_loop td{
		background-color: #8a86b230 !important;
		font-size: 11px !important;
		padding: 3px 16px 5px 16px !important;
		border-color: #88888857 !important;
	}
	
	
	.infoTbl_tlt{
		display: flex;
		align-items: center;
		justify-content: space-between;
	}
	
	.infoTbl_tlt span.title{
    width: calc(100% - 30px);
	}

	.infoTbl_tlt i{
		background: #ec426b;
		color: #fff;
		padding: 7px 8px 6px 7px;
		cursor: pointer;
		display: block;
		font-size: 10px;
	}
	
	.srchFld{
		width: 100%;
		height: 21px;
		border: 0;
		display: none;
		font-size: 11px;
		padding: 5px;
	}
	
	</style>
    <?php include('include/header-new.php'); ?>	
    <?php 
    $allclient = (new  Partner())->getPartners();

    ?>
    <!-- /Global stylesheets -->

        <!-- Page container begins -->
        <section class="main-container">
            <div class="header headerCntnt_wrapr">
                <div class="heading_top">
                    <div class="page-title">Payments Info</div>
                    
                </div>
                <!--<div class="links"><a href="" class="btn btn-secondary btn-labeled m-r-10"><b><i class="icon-plus22"></i></b> CREATE ESTIMATE REQUISITION</a><button type="button" class="btn btn-secondary btn-labeled"><b><i class="icon-plus22"></i></b> New Group</button></div>-->
            </div>
            <div class="container-fluid page-content">
                <!-- formatted inputs -->
                <div class="min_hght_440">
                <div class="card card-inverse card-flat p-10 p-t-20 CrdTop_brdr">
                    <div class="card-block p-b-50 p-0">
                        <form class="form-add-steps" action="#" id="myForm">
                            <div class="row">
                                <div class="col-md-6 col-sm-6 marg_b_20">
                                    <div class="form-group select_srch"><label>Select Client:</label>
										<select name="client" class="form-control ui-wizard-content select" onchange="client_select(this.value)" required="">
												<option value="">Select Client</option>
												<option value="all">All Clients</option>
												<?php foreach($allclient as $key=>$value): ?>
													<option value="<?= $value['id']; ?>"><?= $value['partner_name']; ?></option>
												 <?php endforeach; ?>
											</select>
									</div>
                                </div>
                            </div>
						<div class="table-responsive marg_t_30">
						<table class="table">
							<thead>
								<tr>
									<th style="width:20px">#</th>
									<th style="width:194px">Client Name</th>
									<th style="width:194px">Total Amt Billed</th>
									<th style="width:194px">Outstanding</th>
									<th style="width:194px">Amt Recived</th>
									<th style="width:194px">TDS</th>
									<th style="width:194px">Total</th>
								</tr>
							</thead>
							<tbody id="pay_info_html">
								
								
							</tbody>
						</table>
						</div>
						<div class="col-md-12 text-center">

							</form>
						
					</div>
					</div>
				</div>
				</div>
            <!-- /formatted inputs -->
                       <!-- Footer -->
     <?php include('include/footer-new.php'); ?>  
<script>
	function client_select(client)
	{
		$("#pay_info_html").html('');
		$(".balance-id").html('<i class="sppner fa fa-spinner fa-spin fa-5x fa-fw"></i>');  
		$("#pay_info_html").html('');   
		$.ajax({
		type: "GET",
		url: "ajax.php",
		data: "client_payment_show=" + client,
		dataType: "html",
		success: function(html){  
			 $("#pay_info_html").html(html);
			 fltrTR();
			 icnNo();
			}
		  }); 
	}
		
</script>
<script>
function icnNo(){
	$('.infoTbl_tlt i').click(function(){
		var iconNo = $(this).attr('id');
		$('.'+iconNo).slide();
		//console.log(iconNo);
	})
}

</script>


<script>
function fltrTR(){
  $(".srchFld").on("keyup", function() {
    var value = $(this).val().toLowerCase();
	var inptNo =  $(this).attr('id');
	//alert(inptNo);
	$("#pay_info_html tr.trloop_1 td:nth-child("+inptNo+")").filter(function() {
      if($(this).text().toLowerCase().indexOf(value) > -1){
		$(this).parent().show();
	  }else{
		$(this).parent().hide();
	  }
	  
    });
  });	
}

</script>
