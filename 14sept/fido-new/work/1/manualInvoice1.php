<?php include('include/header-files.php'); ?>

<!-- write your custom css and js here -->
<style type="text/css">

/** Start individual css style **/	

.pdflinks{
    background: #fafbfc;
    padding: 9px 15px 9px 15px;
}

.pdflinks label{
	    margin-right: 10px;
}

.pdflinks a{
    margin-right: 9px;	
}

.pdflinks a i{
vertical-align: middle;
}

/** End individual css style **/	

.chkbox_cstm_wpr .chbx_style span:after{
	left: 3.5px;
}
</style>

<!-- write your custom css and js here -->

<!-- Header begins -->
<?php include('include/header-new.php'); ?>

<?php
$fileBasePath = dirname(__FILE__).'/';
/*
*	Redirect Admin To Home Page
*	If Already Logged In
*/
if(isset($_POST['invoiceend'])){

$invid = trim($_POST['Invoiceno']);
$eid = trim($_POST['est']);
$m = trim($_POST['month']);
$minvoice = new media_invoice();
  $sql1='SELECT Invoice_No FROM  media_invoice WHERE Invoice_No ="'.$invid.'"
  UNION ALL
  SELECT invoice_no FROM mise_invoice WHERE invoice_no ="'.$invid.'"';
  //echo $sql1;
    $search = $minvoice->customQuery($sql1);
	if(empty($search)){


	function isexitinvoice($invid)
{
    $minvoice = new media_invoice();
  $sql1='SELECT Invoice_No FROM  media_invoice WHERE Invoice_No ="'.$invid.'"
  UNION ALL
  SELECT invoice_no FROM mise_invoice WHERE invoice_no ="'.$invid.'"';
  //echo $sql1;
    $search = $minvoice->customQuery($sql1);
    if(empty($search)){
      return false;
    }
    else {
      return true;
    }

}
	$allmoney=0;
	
    if($_POST['iscommision'] =='yes'){
        $other = 1;
        $allmoney = $_POST['iscommision_money'];
        $other_values = new other_values();
        $invoice_details_other = new invoice_details_other();
        if(!empty(trim($_POST['iscommision_val']))){
            $other_values->value = trim($_POST['iscommision_val']);
            $other_values->create();
            $other_values_id = $other_values->lastInsertId();
        }else{
            $other_values_id = $_POST['iscommision_val_drop'];
        }
    }
    else{
            $other = 0;
            foreach($_POST['money'] as $k=>$v)
            {
                $allmoney = $allmoney+trim($v);

            }
        }

	$pubref = $_POST['pub'];
	$invoice_details = new invoice_details();
	$media_invoice = new media_invoice();
	$media_invoice->campaignId=trim($_POST['est']);
	$media_invoice->Invoice_No=trim($_POST['Invoiceno']);
	$media_invoice->Invoice_month=trim($_POST['month']);
	$media_invoice->invoice_date=date('Y-m-d H:i:s');
	$media_invoice->money=$allmoney;
	$media_invoice->invoiceDate=trim($_POST['invoicedate']);
	$media_invoice->invoiceStartDate=trim($_POST['invoicestart']);
	$media_invoice->invoiceEndDate=trim($_POST['invoiceend']);
	$media_invoice->address = trim($_POST['address']);
    $media_invoice->engagementDescription = trim($_POST['pdis']);
    $media_invoice->projectName = trim($_POST['pname']);
    $media_invoice->bank = $_POST['bank'];
	$media_invoice->isMedia=1;
    $media_invoice->others=$other;
	$media_invoice->create();

	$invoiceid=$media_invoice->lastInsertId();
		$invoice_po = new invoice_po();
        $invoice_po->invoice_id = $invoiceid;
        $invoice_po->po_no = trim($_POST['invoicepo']);
        $invoice_po->create();
    if($_POST['iscommision'] =='yes'){
        $invoice_details_other = new invoice_details_other();
        $invoice_details_other->invoice_id = $invoiceid;
        $invoice_details_other->other_id = $other_values_id;
        $invoice_details_other->create();
    }
    else{

         
        foreach($_POST['money'] as $k=>$v)
        {
            if($v!=0){
                $invoice_details->refId=$invoiceid ;
                $invoice_details->pubId=trim($pubref[$k]);
                $invoice_details->money=trim($v);
                $invoice_details->refmediaId=trim($k);
                if($_POST['hide_on_invoice'][$k] == 'yes'){
                $invoice_details->display=0;
                }
                $invoice_details->create();
            }
        }
        
    }
	 redirectAdmin("invoicePDF.php?action=media&month=$m&id=$eid&mid=$invoiceid");
}
}

$projectC = new category_estimate();
 $mformate = new mediadata();
   $project  = new project();
   $minvoice = new media_invoice();
   $sql="SELECT DISTINCT(a.id), a.W_O,a.clientid,a.service_tex FROM project as a , media as b where a.id = b.campaignId and a.reconciliation =1 ORDER BY a.id ASC";
			$Invmedia = $project->customQuery($sql);

   ?>
   
        <!-- Page container begins -->
        <section class="main-container">
            <div class="header headerCntnt_wrapr">
                <div class="heading_top">
                    <div class="page-title">Create Invoice</div>
                    
                </div>
                <!--<div class="links"><a href="" class="btn btn-secondary btn-labeled m-r-10"><b><i class="icon-plus22"></i></b> CREATE ESTIMATE REQUISITION</a><button type="button" class="btn btn-secondary btn-labeled"><b><i class="icon-plus22"></i></b> New Group</button></div>-->
            </div>
            <div class="container-fluid page-content">
                <!-- formatted inputs -->
				<div class="min_hght_440">
					<!-- min height 440 -->
					<div class="card card-inverse card-flat p-10 p-t-20 CrdTop_brdr">
						<div class="card-block p-b-30 p-0">
							<form action="" method="post">
								<div class="row">
									<div class="col-md-3 col-sm-12 m-b-20">
										<div class="form-group select_srch"><label>Estimate No:</label>
										
											<select name='est' class="form-control ui-wizard-content select inptFld_sz" required>
												<option value=''>Select Estimate</option>
												<?php foreach($Invmedia as $key=>$value){ ?>
													<option value='<?php echo $value['id'] ?>' ><?php echo $value['W_O'] ;?></option>
												<?php } ?>
											</select>
										
										</div>
									</div>
									<div class="col-md-3 col-sm-12 m-b-20">
										<div class="form-group "><label>Invoice NO</label>
											<div class="input-group">
												<input id='invoiceno' type="text" placeholder="Invoice NO" name="Invoiceno" class="form-control" required onblur="checkInvoice()" class="form-control inptFld_sz icn_sz_12">
											</div>
											<div style="color: red;" id="result"></div>
										</div>
									</div>
									<div class="col-md-2 col-sm-12 m-b-20">
										<div class="form-group"><label>Invoice Date</label>
											<div class="input-group">
												<span class="input-group-addon"><i class="icon-calendar"></i></span>
												<input  id='invdate' autocomplete="off" type="text" placeholder="Invoice Date" name="invoicedate" class="form-control datepicker-here inptFld_sz icn_sz_12" data-language='en' required>
											</div>
										</div>
									</div>
									<div class="col-md-2 col-sm-12 m-b-20">
										<div class="form-group"><label>Consumption Start Date</label>
											<div class="input-group">
												<span class="input-group-addon"><i class="icon-calendar"></i></span>
												<input id='startdate'  autocomplete="off" type="text" placeholder="Consumption Start Date" name="invoicestart" class="form-control datepicker-here inptFld_sz icn_sz_12" data-language='en' required>
											</div>
										</div>
									</div>
									<div class="col-md-2 col-sm-12 m-b-20">
										<div class="form-group"><label>Consumption End Date </label>
											<div class="input-group">
												<span class="input-group-addon"><i class="icon-calendar"></i></span>
												<input id='enddate' data-position='bottom right' autocomplete="off" type="text" placeholder="Consumption End Date" name="invoiceend" required class="form-control datepicker-here inptFld_sz icn_sz_12" data-language='en'>
											</div>
										</div>
									</div>
									<div class="col-md-12" id="pub_details"></div>
									<div class="col-md-12 text-right">
										<button class="btn btn-primary m-t-30" >Submit Invoice</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
				
				
	<?php include('include/footer-new.php'); ?>  
	<div id="loading" style="display:none;position:fixed;left: 0;right:0;top: 50%;margin: 0px auto;z-index: 8;width: 70px;transform: translate(0%,-50%);" class="spin"><div class="loader12"></div></div>

		 
<script>
  $(document).ready(function() {
	  
	$(function() {
		  $('.datepicker-here').datepicker({
				dateFormat: 'yyyy-mm-dd'
		  });
	});
	
	});
	
</script>

<script>
  $(document).ready(function() {
    $("select[name='est']").change(function() {
		var est = $('option:selected', $(this)).val();
		$('#pub_details').empty();
		 {
    $.ajax({
    type: "POST",
    data: {estimateNo : est},
    cache: false,
    url: "ajax1.php",
    beforeSend: function(){
    $("#loading").show();
    },
	complete: function(){
     $("#loading").hide();
   },
    success: function(msg)
    {
        $("#pub_details").append(msg);


    }
});
  }

         // Clear checks, then check boxes that have class "value"

    });



});

function checkbalance(x){
		var y = x.value;
		var z = $(x).closest('tr').find('.maxamount').text();
		a=z.replace(/\,/g,'');
		a=Number(a);
		y=Number(y);
		if(y<=a && y!=''){
		$(x).closest('tr').find('.bal').text(a-y);
		}
		else{
			$(x).val('');
			$(x).closest('tr').find('.bal').text('');
		}
	}

</script>

<script type="text/javascript">
function checkInvoice()
{
	if($("#invoiceno").val()!=''){
    var value = $.ajax({
        type: "POST",
        url: "ajax1.php",
        data: "chkinvoice="+$("#invoiceno").val(),
        async: false
    }).responseText;
    $('#result').html(value);
    if (value== '') {
   $("#submit").removeAttr("disabled");
  } else {
    $("#submit").attr("disabled", true);
  }
}
}

</script>