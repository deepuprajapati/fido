<?php include('include/header-files.php'); ?>


<!-- write your custom css and js here -->
<style>

.select_srch select + .select2-container{
    top: 0;	
}


@media only screen and (max-width:991px){
.lftBlck_revInv{
padding-top:0;
}

.cardBlck_revInv{
    padding-top: 0;	
}

.rvwBtn_rght{
	margin-top:24px;
}
	
}

@media only screen and (max-width:768px){
.rvwInv_sec{
    margin-top: 55px;
}


	
}

</style>

<!-- write your custom css and js here -->

<!-- Header begins -->
<?php include('include/header-new.php'); 

$media_invoice = new media_invoice();

$invoice_list = $media_invoice->all();

if (isset($_POST['submit'])) {

	$credit_note = new credit_note();

	 $amt = (float) filter_var( $_POST['amt'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
	 $comm = (float) filter_var( $_POST['comm'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
	 $amt_comm = (float) filter_var( $_POST['amt_comm'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
	 $gst = (float) filter_var( $_POST['gst'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
	 $total_amt = (float) filter_var( $_POST['total_amt'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
	 $inv_no = $_POST['inv_no'];

	$credit_note->inv_no = $inv_no;
	$credit_note->amt = $amt;
	$credit_note->comm = $comm;
	$credit_note->amt_comm = $amt_comm;
	$credit_note->gst = $gst;
	$credit_note->total_amt = $total_amt;
	$credit_note->create();

	$lastInsertId = $credit_note->lastInsertId();

	$media_invoice = new media_invoice();

	$media_invoice->id = $inv_no;
	$media_invoice->credit_note = $lastInsertId;
	$media_invoice->save();

	redirectAdmin('creditNotePdf.php?id='.$lastInsertId);
	
}

?>

<section class="main-container">

			<div class="header headerCntnt_wrapr">
				<div class="heading_top">
					<div class="page-title">Create Credit Note</div>
					
				</div>
			</div>

			<div class="container-fluid page-content">

				<div class="row">

					<!-- Text addon -->
					<div class="col-lg-6 col-md-12">
						<div class="card card-inverse p-t-20 p-b-20 min_hght_440">
							<div class="card-header">
								<div class="row">
								<div class="col-md-9">
									<div class="form-group select_srch">
										<select name='invoice' class="invoice form-control ui-wizard-content select inptFld_sz" required="">
												<option value=''>Select Invoice</option>
												<?php foreach($invoice_list as $key=>$value){ ?>
													<option value='<?php echo $value['id']; ?>' ><?php echo $value['Invoice_No'] ;?></option>
												<?php } ?>
										</select>
									</div>
								</div>
									<div class="col-md-3 rvwInv_sec">
										<button name="submit" type="button" class="btn btn-primary ui-wizard-content pull-right" id="add-step">Review Invoice </button>
									</div>
								</div>
							</div>
							<div class="card-block cardBlck_revInv">
									<fieldset>
										<div class="form-group row">
											<div class="col-lg-4">
												<label class="control-label">Amount</label>
											</div>
											<div class="col-lg-8">
												<input type="text" class="form-control input1" placeholder="">
											</div>
										</div>

										<div class="form-group row">
											<div class="col-lg-4">
											<label class="control-label">Agency Commision</label>
										</div>
											<div class="col-lg-8">
												<input type="text" class="form-control input2" placeholder="">
											</div>
										</div>

										<div class="form-group row">
											<div class="col-lg-4">
											<label class="control-label">Amount With Commision</label>
										</div>
											<div class="col-lg-8">
												<input type="text" class="form-control input3" placeholder="">
											</div>
										</div>

										<div class="form-group row">
											<div class="col-lg-4">
											<label class="control-label">GST</label>
										</div>
											<div class="col-lg-8">
												<input type="text" class="form-control input4" placeholder="">
											</div>
										</div>

										<div class="form-group row">
											<div class="col-lg-4">
											<label class="control-label">Total Amount</label>
										</div>
											<div class="col-lg-8">
												<input type="text" class="form-control input5" placeholder="">
											</div>
										</div>
									</fieldset>
							</div>
						</div>
					</div>
					<!-- /Text addon -->

					<!-- Icon addons -->
					<div class="col-lg-6 col-md-12">
						<div class="card card-inverse p-t-20 p-b-20 min_hght_440">
							<div class="card-header">
								<div class="row">
								<div class="col-md-9">
										<div class="form-group">
											<div class="input-group">
												<input type="text" name="credit_value_value" class="credit_value_value form-control" placeholder="Enter Credit Amount">
											</div>
										</div>
										</div>
										<div class="col-md-3 rvwBtn_rght">
											<button name="submit" type="button" class="btn btn-primary btn-md pull-right" id="add">Review Amount </button>
										</div>
							</div>
							</div>
							<div class="card-block cardBlck_revInv">
								<form class="form-horizontal" action=" " method="POST">
									<input type="hidden" name="inv_no" value="" id="inv_no">
									<fieldset>
										<div class="form-group row">
											<div class="col-lg-4">
												<label class="control-label">Amount</label>
											</div>
											<div class="col-lg-8">
												<input type="text" name="amt" value="" class="form-control output1" placeholder="">
											</div>
										</div>

										<div class="form-group row">
											<div class="col-lg-4">
											<label class="control-label">Agency Commision</label>
										</div>
											<div class="col-lg-8">
												<input type="text" name="comm" value="" class="form-control output2" placeholder="">
											</div>
										</div>

										<div class="form-group row">
											<div class="col-lg-4">
											<label class="control-label">Amount With Commision</label>
										</div>
											<div class="col-lg-8">
												<input type="text" name="amt_comm" value="" class="form-control output3" placeholder="">
											</div>
										</div>

										<div class="form-group row">
											<div class="col-lg-4">
											<label class="control-label">GST</label>
										</div>
											<div class="col-lg-8">
												<input type="text" name="gst" value="" class="form-control output4" placeholder="">
											</div>
										</div>

										<div class="form-group row">
											<div class="col-lg-4">
											<label class="control-label">Total Amount</label>
										</div>
											<div class="col-lg-8">
												<input type="text" name="total_amt" value="" class="form-control output5" placeholder="">
											</div>
										</div>
									</fieldset>
									<div class="col-md-4 p-l-0">
											<button name="submit" type="submit" class="btn btn-primary ui-wizard-content marg_t_30">Create Credit Note </button>
										</div>
								</form>
							</div>
						</div>
					</div>
					<!-- /Icon addons -->

				</div>



		 <?php include('include/footer-new.php'); ?> 

<script>

	function getInCurracy(val) {
		return val.toLocaleString('en-IN', {
							    maximumFractionDigits: 2,
							    style: 'currency',
							    currency: 'INR'
								})	
	}

    $(document).ready(function (){
    	var invoice_comm;

    	var invoice_isMedia;

    	var invoice_isIndian;
    
	    $("#add-step").click(function (){

	        var inv = $('.invoice').val();

	        if(inv!=''){
	        	$.ajax({
					cache: false,
					type: "POST",
					url: "ajax.php",
					data: {'invoice_id_for_creditnote':inv},
					dataType: "json",
					success: function(msg)
	                {
	                    $('.input1').val(getInCurracy(msg.money));
	                    $('.input2').val(getInCurracy(msg.comm));
	                    $('.input3').val(getInCurracy(msg.money_comm));
	                    $('.input4').val(getInCurracy(msg.gst));
	                    $('.input5').val(getInCurracy(msg.amt));

	                    invoice_comm = msg.invoice_comm;
	                    invoice_isMedia = msg.invoice_isMedia
	                    invoice_isIndian = msg.invoice_isIndian
						
	                }
	       		});
	        	
        	}

	    });

	    $("#add").click(function (){

	    	var credit_value = $('.credit_value_value').val();

	    	var inv = $('.invoice').val();

	    	if(credit_value!='' && inv!='')
	    	{
	    		$('#inv_no').val(inv);

	    		if (invoice_isMedia){

	    			var com = Number(invoice_comm)*Number(credit_value)/100;

	    		}
	    		else {
	    			var com = 0;
	    		}



	    		if (invoice_isIndian) {

	    			var gst = (Number(credit_value) + Number(com))*.18;
	    		}else{
	    			var gst = 0;
	    		}

		 		$('.output1').val(getInCurracy(Number(credit_value)));
                $('.output2').val(getInCurracy(com));
                $('.output3').val(getInCurracy(Number(credit_value) + Number(com)));
                $('.output4').val(getInCurracy(Number(gst)));
                $('.output5').val(getInCurracy(Number(gst) + Number(credit_value) + Number(com)));

	    	}else{
	    		console.log('not')
	    	}

	    });

	});
</script>

		 