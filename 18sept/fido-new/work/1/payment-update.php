<?php include('include/header-files.php'); ?>


<!-- write your custom css and js here -->
<style type="text/css">

/** Start individual page css style **/


	.error_show{
		border-top: 0 !important;
		padding: 0 !important;
		font-size: 11px !important;
		padding-bottom: 4px !important;
		color: #ff0000 !important;
		text-align: center !important;
	} 
	
	.even_tr_clr td{
		background-color: #fff !important;	
	}
	
	.odd_tr_clr td{
		background-color: #FAFBFC !important;	
	}
	
	.error_show:last-child{
		    border-bottom: 1px solid #EAEFF0 !important;
	}

	.sppner{
		z-index: 9999 !important;
		position: absolute !important;
		font-size: 9em !important;
		margin-left: 500px !important;
	}


	.pagination li.paginateActive a{
		background: #FF5F74 !important;
		color: #fff !important;
		border: 1px solid #FF5F74;
		cursor: no-drop;
	}
	
	.pagination li.paginateDisabled a{
	    cursor: no-drop;	
	}

	.pagination>li>a:hover, .pagination>li>a:focus, .pagination>li>span:hover, .pagination>li>span:focus{
		border: 1px solid #ffdfe3;
	}
	
	.srchFld {
		width: 100%;
		height: 21px;
		border: 1px solid gainsboro;
		display: none;
		font-size: 11px;
		padding: 5px;
	}
	
		
/** End individual page css style **/	
</style>

<!-- write your custom css and js here -->

<!-- Header begins -->
<?php include('include/header-new.php'); ?>

<?php 
if (isset($_POST['submit'])) {
	$urlforservice = $config['API_BASE_URL']."sendmail";
	$balance_payment = 0;
	$payment_info_id = 0;
	//dd($_POST);

	$payment_info = new payment_info_update();
	if(!isset($_POST['bal_client'])){
	$fullPayment = trim($_POST['full_payment']);
	$payment_info->payment_mode = trim($_POST['mode']);
	$payment_info->mode_info = trim($_POST['mode_type']);
	$payment_info->bank = trim($_POST['bank']);
	$payment_info->client_id = $_POST['client'];
	$payment_info->full_payment = $fullPayment;
	$payment_info->balance = 0;
	$payment_info->create();
	$payment_info_id = $payment_info->lastInsertId();
	}else
	{
		$y = explode('|', trim($_POST['bal_client']));
		$payment_info_id = $y[1];
		$fullPayment = $y[0];
	}

	foreach ($_POST['money'] as $key => $value) {
	if(!empty($value['pay_money'])){
		$balance_payment += trim($value['pay_money']);
		$payment = new payment();   
		$userallinfo = $payment->getUserInfoFromInvoice($key);
		$payment->money = trim($value['pay_money']);
		$payment->tds = trim($value['tds']);
		$payment->refId = trim($key);
		$payment->payment_id = $payment_info_id;
		$payment->createdAt = date("Y-m-d H:i:s");
		$payment->create();
		if(!empty($userallinfo)){
	   			$message= "This is notify that the paymnet from $userallinfo[0]['partner_name'] has been Received of amount ".trim($value['pay_money']) + trim($value['tds'])." against invoice no $userallinfo[0]['Invoice_No']";
                $data['email']=$userallinfo[0]['email'];
                $data['name']=$userallinfo[0]['name'];
                $data['msg']=$message;
                $data['subject'] ='Payment Received from '.$userallinfo[0]['partner_name'];
                $services = postCURL($urlforservice,$data);
            }
	}

}
	$payment_info->id = $payment_info_id;
	$payment_info->balance = $fullPayment - $balance_payment;
	$payment_info->save();
		redirectAdmin('payment-update.php');
} 

$allclient = (new  Partner())->getPartners();


?>
        <!-- Page container begins -->
        <section class="main-container">
            <div class="header headerCntnt_wrapr">
                <div class="heading_top">
                    <div class="page-title">Payments Update</div>
                    
                </div>
                <!--<div class="links"><a href="" class="btn btn-secondary btn-labeled m-r-10"><b><i class="icon-plus22"></i></b> CREATE ESTIMATE REQUISITION</a><button type="button" class="btn btn-secondary btn-labeled"><b><i class="icon-plus22"></i></b> New Group</button></div>-->
            </div>
            <div class="container-fluid page-content">
                <!-- formatted inputs -->
                <div class="min_hght_440"><!-- min height 440 -->
					<div class="card card-inverse card-flat p-10 p-t-20 CrdTop_brdr">
						<div class="card-block p-b-50 p-0">
							<form class="form-add-steps" action=" "  method="post" id="myForm">
								<div class="row">
									<div class="col-md-4 col-sm-6">
										<div class="form-group select_srch"><label>Select Client:</label>
											<select name="client" class="form-control ui-wizard-content select" onchange="client_select(this.value)" required="">
												<option value="">Select Client</option>
												<?php foreach($allclient as $key=>$value): ?>
													<option value="<?= $value['id']; ?>"><?= $value['partner_name']; ?></option>
												 <?php endforeach; ?>
											</select>
										</div>
									</div>
									<div class="col-md-2 col-sm-3">
										<div class="form-group select_srch"><label>Select Bank:</label>
											<select name="bank" id="bank" class="form-control ui-wizard-content select" required>
												<option value="">Select Bank</option>
											   <option value="icici">ICICI</option>
												<option value="kotak">KOTAK</option>

											</select>
										</div>
									</div>
									<div class="col-md-2 col-sm-3">
										<div class="form-group select_srch"><label>Select Mode:</label>
											<select name="mode" id="mode" class="form-control ui-wizard-content select" required="">
												<option value="">Select Mode</option>
												<option value="cheque">Cheque</option>
												<option value="rtgs_neft">RTGS / NEFT</option>
											</select>
										</div>
									</div>
									<div class="col-md-2 col-sm-3">
										<div class="form-group select_srch"><label>Cheque / RTGS / NEFT</label>
											<input type="text" id="mode_type" name="mode_type" class="form-control" placeholder="" required>
										</div>
									</div>
									<div class="col-md-2 col-sm-3">
										<div class="form-group select_srch"><label>Payment</label>
											<input type="number" min="0" step=".01" id="full_payment" name="full_payment" class="form-control" placeholder="" required>
										</div>
									</div>
								</div>
							<div class="row" style="margin-top: 10px;">

								<div class="col-md-12 col-sm-12 balance-id">
		  
								</div>
								
							</div>
							<div class="table-responsive marg_t_30">
							<table class="table">
								<thead>
									<tr>
										<th>#</th>
										<th>Invoice No <input class="srchFld" id="2" type="text" placeholder="Search.." ></th>
										<th>Invoice Money <input class="srchFld" id="3" type="text" placeholder="Search.." ></th>
										<th>Balance <input class="srchFld" id="4" type="text" placeholder="Search.."></th>
										<th>Payment <input class="srchFld" id="5" type="text" placeholder="Search.." ></th>
										<th>TDS <input class="srchFld" id="6" type="text" placeholder="Search.." ></th>
										<th>Short And Excess <input class="srchFld" id="7" type="text" placeholder="Search.." ></th>

									</tr>
								</thead>
								<tbody id="pay_info_html">
									
								</tbody>
							</table>
							</div>
							<div class="col-md-12 text-center">

						<button type="submit" name="submit" class="btn btn-primary ui-wizard-content  marg_t_30">
							<i class="icon-paperplane"></i> Submit</button>
								</form>
							
						</div>
						</div>
					</div>
				</div><!-- End min height 440 -->
            <!-- /formatted inputs -->
                       <!-- Footer -->
     <?php include('include/footer-new.php'); ?>  
	 <script src="asset-new/js/jquery.paginate.js"></script>
	 <script>
function client_select(client)
{
	$(".balance-id").html('<i class="sppner fa fa-spinner fa-spin fa-5x fa-fw"></i>');  
	$("#pay_info_html").html('');   
	$.ajax({
	type: "GET",
	url: "ajax.php",
	data: "client_payment_info=" + client,
	dataType: "html",
	success: function(html){  
			$.ajax({
		      type: "GET",
		      url: "ajax.php",
		      data: "client_balance_payment_info=" + client,
		      success: function(htmls) {
				$(".balance-id").html('');     
				$("#pay_info_html").html(html);  
		        $(".balance-id").html(htmls); 
				trInpt_srch();
				var trLgnt =  $('.table tbody tr').length;
				console.log(trLgnt);
				
				if(trLgnt > 0){
					tblPgntn();
					$('.paginateContainer').css('display','block');
					$('.srchFld').css('display','block');
				}else{
					$('.paginateContainer').css('display','none')
					$('.srchFld').css('display','none')
				}			
		      }
		    });
			

		}
	  }); 
}

function shor_update(id)
{
	var shrt = $(".shot_and_excess_"+id).val();
	$.ajax({
		      type: "GET",
		      url: "ajax.php",
		      data: "short_payment=" + id +"&shrt=" + shrt,
		      success: function(htmls) {
		      	// window.location.reload();
		      }
		    });	
}
</script>
<script>

function tblPgntn(){
$('.table').paginate();	
}

</script>
<script>
function trInpt_srch(){
  $(".srchFld").on("keyup", function() {
    var value = $(this).val().toLowerCase();
	var inptNo =  $(this).attr('id');
	//var data_tr =  $(this).attr('data-tr-no');
	//console.log(data_tr);
	$("#pay_info_html tr td:nth-child("+inptNo+")").filter(function() {
      if($(this).text().toLowerCase().indexOf(value) > -1){
		$(this).parent().show();
	  }else{
		$(this).parent().hide();
	  }
	  
    });
  });	
}

</script>