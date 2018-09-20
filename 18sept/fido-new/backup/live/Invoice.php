<?php include('include/header-files.php'); ?>


<!-- write your custom css and js here -->
<style>
.chkbox_cstm_wpr .chbx_style span:after{
	    left: 2px;
}

.fa, .toggle_drpdown i{color: #909090;}

.icons-list>li:first-child {
    margin-left: 0;
}

.txt_cntr{
	text-align:center !important;
}

.no_Sort{
    cursor: default !important;
}

.no_Sort:after, .no_Sort:before {
    display: none !important;
}

.icn_sz_18{
    font-size: 18px;
}

.icn_sz_19{
    font-size: 19px;
}

.icn_sz_20{
    font-size: 20px;
}

.toggle_drpdown{
    background: none;
    padding: 0;
    line-height: initial;
}

.toggle_drpdown:hover , .toggle_drpdown:active, .toggle_drpdown:focus{
    background: none;
    box-shadow: none;
}

.tooltip_cstm{
    background: none;
    padding: 0;
    line-height: initial;
}

.tooltip_cstm:hover , .tooltip_cstm:active, .tooltip_cstm:focus{
    background: none;
    box-shadow: none;
}

.tooltip_cstm i{
    margin-top: 8px;
}

a.disabled:hover{
background: #ebeaf0;
    color: #9f9999;
}

.popImg_mdl_style object{
    width: 100%;
}

</style>


<!-- write your custom css and js here -->

<!-- Header begins -->
<?php include('include/header-new.php'); ?>

<?php

/**
*	THIS FILE IS FOR ADMIN LOGIN LOGOUT	5/4/2014
**/
$fileBasePath = dirname(__FILE__).'/';
/*
*	Redirect Admin To Home Page
*	If Already Logged In
*/
if(isset($_POST['save']))
{

 $project  = new project();

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

$sqlchk='SELECT Invoice_No FROM  media_invoice WHERE Invoice_No ="'.trim($_POST['Invoiceno']).'"
	UNION ALL
	SELECT invoice_no FROM mise_invoice WHERE invoice_no ="'.trim($_POST['Invoiceno']).'"';
	//echo $sql1;
		$search = $project->customQuery($sqlchk);

if(empty($search)){

  $id = $_POST['id'];
  $Idate=$_POST['Idate'];
  $ISdate=$_POST['ISdate'];
  $IEdate=$_POST['IEdate'];
  $Imoney=$_POST['Imoney'];
  $address=trim($_POST['address']);
  $pname=trim($_POST['pname']);
  $pdis=$_POST['pdis'];
  $bank=$_POST['bank'];
  
  $time = strtotime($Idate);
  $timeStart = strtotime($ISdate);
  $timeEnd = strtotime($IEdate);

if ($_POST['inv_type'] == 'performa') {
	$workOrder = new performa_invoice_counter();
	$wo1 = $workOrder->max('wo');
	$wo2 = work_order_maker($wo1);
	$Fyear=$project->getFinancialYearYY();
	$wo = "ARMPER/".$Fyear."/".$wo2;
	$workOrder->wo = ($wo1+1);
	$workOrder->create();

	$Invoiceno=$wo;
	$minvoice = new performa_invoice();
	$query = "&performa=yes";
}
else{
	$Invoiceno=trim($_POST['Invoiceno']);
	$minvoice = new media_invoice();
	$query = "";
}

     $nMInvoice = new non_media_invoice_details();
     
     $minvoice->Invoice_No = $Invoiceno;
     $minvoice->invoice_date = date('Y-m-d H:i:s');
     $minvoice->campaignId = $id;
     $minvoice->invoiceDate =  date('Y-m-d',$time);
     $minvoice->invoiceStartDate = date('Y-m-d',$timeStart);
     $minvoice->invoiceEndDate = date('Y-m-d',$timeEnd);
     $minvoice->Invoice_month = date('F-Y',$time);
     $minvoice->address = $address;
     $minvoice->engagementDescription = $pdis;
     $minvoice->projectName = $pname;
     $minvoice->bank = $bank;
     $minvoice->money = $Imoney;
     $minvoice->create();
     $last = $minvoice->lastInsertId();
     if ($_POST['inv_type'] == 'normal') {
        $invoice_po = new invoice_po();
        $invoice_po->invoice_id = $last;
        $invoice_po->po_no = trim($_POST['invoicepo']);
        $invoice_po->create();
    foreach($_POST['service'] as $key=>$value){
        if($value !=''){
        $nMInvoice->invoice_id = $last;
        $nMInvoice->service_id = $key;
        $nMInvoice->money = $value;
        $nMInvoice->create();
        }
    }
 }
     redirectAdmin("invoicePDFnew.php?id=$id&mInvoiceId=$last$query");
}
}

$projectC = new category_estimate();
 $mformate = new mediadata();
   $project  = new project();
   $minvoice = new media_invoice();
   $my_company = new my_company();
   $Bankdetails = $my_company->all();
   $allproject= $project->selectNonMedia();
   $performaInvoice = new performa_invoice();


$estimate=new category_estimate();

   if(isset($_POST['po'])){
	   $project->id = $_POST['id'];
	   $project->P_O = $_POST['porder'];
	   $project->save();
		$_SESSION['msg'] = "Purchase order has been updated successfully";
		redirectAdmin('estimate.php');
   }

   if(isset($_POST['save'])){

     //print_r($_POST);
     //die;
   }


   if(isset($_POST['upload'])){
	   $filename=$_FILES["filea"]["tmp_name"];
		//print_r( $_FILES);
		$filename  = basename($_FILES['filea']['name']);
		$extension = pathinfo($filename, PATHINFO_EXTENSION);
		$new       = $_POST['id'].'.'.$extension;
		$target_path = $_SERVER["DOCUMENT_ROOT"]."/mis/uploadfile/".$new;
		//echo $target_path;
		move_uploaded_file($_FILES['filea']['tmp_name'], $target_path);
		$target_file = $target_path . basename($_FILES["filea"]["name"]);
		$project->id = $_POST['id'];
	    $project->P_O = $new;
	    $project->save();
		$_SESSION['msg'] = "Purchase order has been updated successfully";
		//redirectAdmin('estimate.php');
   }



// Instantiate the user class

	//_d($allSettings);
	?>
        <!-- Page container begins -->
       <section class="main-container">
		<div class="header headerCntnt_wrapr">
			<div class="heading_top">
				<div class="page-title">Invoice</div>
			</div>
			<!--<div class="links"><a href="addProject.php" class="btn btn-secondary btn-labeled m-r-10"><b><i class="icon-link"></i></b>  CREATE ESTIMATE REQUISITION</a></div>-->
		</div>
            <div class="container-fluid page-content">
                <!-- Fixed header -->
                <div class="card card-inverse card-flat p-10">
                    <div class="table-responsive tblRspnv_actionbtn">
                        <table id='usertable' class="table datatable table-bordered dataTable_cstm datatable-header-basic">
						<thead>
                                <tr>
									<th>Estimate No
                                        <div class="src_inpt"><input type="text" class="form-control" placeholder="Search"></div>
                                        <div class="sortMask"></div>
                                    </th>
									<th>Invoice No 
                                        <div class="src_inpt"><input type="text" class="form-control" placeholder="Search"></div>
                                        <div class="sortMask"></div>
                                    </th>
                                    <th>Performa Invoice
                                    	<div class="src_inpt"><input type="text" class="form-control" placeholder="Search"></div>
                                        <div class="sortMask"></div>
                                    </th>
									<th>Client
                                        <div class="src_inpt"><input type="text" class="form-control" placeholder="Search"></div>
                                        <div class="sortMask"></div>
                                    </th>
									<th>Project Name
                                        <div class="src_inpt"><input type="text" class="form-control" placeholder="Search"></div>
                                        <div class="sortMask"></div>
                                    </th>
									<th>Total Price
                                        <div class="src_inpt"><input type="text" class="form-control" placeholder="Search"></div>
                                        <div class="sortMask"></div>
                                    </th>
									<th>Project Category
                                        <div class="src_inpt"><input type="text" class="form-control" placeholder="Search"></div>
                                        <div class="sortMask"></div>
                                    </th>
									<th>Duration
                                        <div class="src_inpt"><input type="text" class="form-control" placeholder="Search"></div>
                                        <div class="sortMask"></div>
                                    </th>
									<th class="no_Sort">Action</th>
									</tr>
                            </thead>
							<tbody>
										<?php

										foreach($allproject as $k=>$projectData){
                       $in='';
										//$a = $minvoice->findCustom(array('campaignId'=>$projectData['id']));
										$sql1="select * from media_invoice where campaignId = ".$projectData['id']." and isMedia = 0";
										$a = $minvoice->customQuery($sql1);

										?>

										<tr>
										<td><?php echo $projectData['W_O']; ?></td>
										<td class="txt_cntr"><?php foreach($a as $k=>$v){
										//echo $v['id'];
                               $in  =  $v['id'];
                      ?>
											<div>
												<a style="padding-bottom: 2px;" target="_blank" href="<?php echo $config['SITE_URL']."invoicePDF.php?id=".$projectData['id']."&mInvoiceId=".$v['id']?>" class="marg_b_15 btn btn-secondary btn-labeled btn-xs"><b><i style="color:;" class="fa fa-download" aria-hidden="true"></i></b> <?php echo $v['Invoice_No']?>
												</a>
											</div>
                      <?php
										}?>
									</td>
									<td>
										<?php 
										$performa_invoice_check = $performaInvoice->findCustom(array('campaignId'=>$projectData['id']));
										if (empty($performa_invoice_check)) {
											echo "No Performa";
										} else { ?>
											<div>
												<a style="padding-bottom: 2px;" target="_blank" href="<?php echo $config['SITE_URL']."invoicePDF.php?id=".$projectData['id']."&mInvoiceId=".$performa_invoice_check[0]['id']."&performa=yes";?>" class="marg_b_15 btn btn-secondary btn-labeled btn-xs"><b><i style="color:;" class="fa fa-download" aria-hidden="true"></i></b> <?php echo $performa_invoice_check[0]['Invoice_No'] ?>
												</a>
											</div>
										<?php }
										?>
									</td>
										<td><?php echo $projectData['partner_name']; ?></td>
										<td><?php echo $projectData['project_name']; ?></td>
										<td><?php echo $mformate->moneyFormat($projectData['totalprice']); ?></td>
										<td><?php $val=$projectC->findCustom(array('project_id'=>$projectData['id']));
						                foreach($val as $j=>$catId){
											$catv=$projectC->catValue($catId['project_cat_id']);
											echo $catv[0]['name']."<br>";
											}
											?>
										</td>
                  					<td><?php echo $projectData['project_start']; ?>/<?php echo $projectData['project_end']; ?></td>

									
				              	         <td>
											<?php if($projectData['reconciliation']==1 || $projectData['reconciliation']==2){

											?>
										 <ul class="icons-list" style="text-align: center;">
										 <li class="dropdown">
                                       <button type="button" class="btn btn-secondary toggle_drpdown" style="text-align: center;border: 0;" data-toggle="dropdown" aria-expanded="false"><i style="margin-right:0" class="icon-three-bars position-left"></i></button>
                                        <ul  class="dropdown-menu dropdown-menu-sm  dropdown-menu-right" style="width: 170px;">
										
											<a target="_blank" data-toggle="modal" class="open-AddBookDialog create dropdown-item" data-target="#inv" data-invoice="normal" data-id="<?php echo $projectData['id'];?>"  href="javascript:;">Create Invoice</a>
											<a target="_blank" data-toggle="modal" class="open-AddBookDialog create dropdown-item" data-target="#inv" data-invoice="performa" data-id="<?php echo $projectData['id'];?>"  href="javascript:;">Create Performa Invoice</a>
											<a class="dropdown-item" href="javascript:;">Download Invoice</a>
                                            <a class="dropdown-item" target="_blank" href="<?php echo $config['SITE_URL']."createBill.php?id=".$projectData['id'];?>">Download Bill</a>
                                          
                                            <a class="dropdown-item" href="javascript:;">Send via Email</a>
                                            
                                        </ul>
                                        <?php if($in!='') { ?>

                                        <?php } ?>
										</li>
										 </ul>
							<?php

							}
					         else { echo "Running"; }?>
										</td>
										</tr>
										<?php

										}
										?>
										</tbody>
                        </table>
                    </div>
                </div>
            <!-- /formatted inputs -->
                       <!-- Footer -->
     <?php include('include/footer-new.php'); ?>  
	 
	<script>
		/* Start datatable js code for table and header fixed */
		
		$(function() {
			'use strict';

			$.extend( $.fn.dataTable.defaults, {
				autoWidth: false,
				dom: '<"datatable-header"fBl><"datatable-scroll-wrap"t><"datatable-footer"ip>',
				language: {
					search: '_INPUT_',
					lengthMenu: '<span>Show:</span> _MENU_',
					paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
				},
				lengthMenu: [ 20, 50, 75, 100 ],
				displayLength: 20,
				"bLengthChange": false
			});
			
			$('.datatable-header-basic thead th').on("click.DT", function (e) {
				if (!$(e.target).hasClass('sortMask')) {
					e.stopImmediatePropagation();
				}
			});

			// Basic initialization
			var table_basic = $('.datatable-header-basic').DataTable({
				fixedHeader: true,
				buttons: {
					dom: {
						button: {
							className: 'btn btn-secondary'
						}
					},
					buttons: [
						{
							extend: 'colvis',
							text: '<i class="icon-table2"></i> <span class="caret"></span>',
							className: 'btn btn-secondary',
							collectionLayout: 'fixed'
						},
						{extend: 'copy', className: 'copyButton' },
						{extend: 'csv', className: 'csvButton' },
						{extend: 'excel', className: 'excelButton' },
						{extend: 'print', className: 'printButton' }
					]
				}
			});
			
			
			// Individual column searching with text inputs
			$('.datatable-header-basic th .src_inpt').each(function () {
				$(this).html('<input type="text" class="form-control" placeholder="Search" />');
			});
			table_basic.columns().every( function () {
				var that = this;
				$( 'input', this.header() ).on( 'keyup change', function () {
					if ( that.search() !== this.value ) {
						that
							.search( this.value )
							.draw();
					}
				} );
			});
			

			
			
			

			// Add placeholder to the datatable filter option
			$('.dataTables_filter input[type=search]').attr('placeholder','Type to search...');
			$('.dataTables_filter input[type=search]').attr('class', 'form-control');

			// Enable Select2 select for the length option
			/*$('.dataTables_length select').select2({
				minimumResultsForSearch: Infinity,
				width: 'auto'
			});*/
		});
		
		
		/* End datatable js code for table and header fixed */
	</script>
	 
	 
	<script type="text/javascript">
    function f1(h)
  {
	  var a = $(h).closest('tr').find('.form-control').val();
	  var b = h.getAttribute('value');
	  var c = b + "&povalue=" + a;
	  $(h).closest('tr').find('.spo').attr("href", c);
	  alert(c);

  }
</script>

<script type="text/javascript">

  function checkdata(a,b) {
  var ok = true;

            if (a=='') {
               ok = false;
            }

			if(ok) $(b).closest('tr').find('.spo').removeAttr("disabled");
            else  $(b).closest('tr').find('.spo').attr("disabled", "disabled");

    }
    $(document).ready(function () {
        $(".spo").attr("disabled", "disabled");

            $("#usertable :input").blur(function () {
				var c = $(this).val();
				//alert(c);
                checkdata(c,this);
            });

    });
</script>
<script>
$(document).ready(function(){
$(document).on("click", ".inview", function (e) {
	e.preventDefault();
	var $modal = $(this);
	var pid = $(this).data('id');
	if(pid !=='')
	{
		$.ajax({
		type: "POST",
		data: {pvalue : pid},
		url: "ajax.php",
			success: function(data)
			{
				$('.edit-content').html(data);
			}
		});
	}
});

$(document).on("click", ".create", function (e) {
	e.preventDefault();
	var $modal = $(this);
	var pid = $(this).data('id');
	var invoiceType = $(this).data('invoice');
	if(pid !=='')
	{
		$.ajax({
		type: "POST",
		data: {invCreate : pid,invoice_type:invoiceType},
		url: "ajax.php",
			success: function(data) 
			{
				$('.edit-content').html(data);
			   	$(function() {	
				  	$('.datepicker-here').datepicker({
						dateFormat: 'yyyy-mm-dd'
			  		});
				});
			}
		});
	}
});
});
    
</script>


<div class="modal fade" id="inv" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
		 <form  action="" method="post">
            <div class="modal-header bg_none p-10">
				<h5 class="modal-title" id="myModalLabel">Create invoice</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
            <div class="modal-body">
                
                    <div class="edit-content"></div>
                   
               
            </div>
			
		  <div class="modal-footer bg_none">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			<button type="submit"  name="save"  class="btn btn-primary ui-wizard-content"><i class="icon-paperplane"></i> Submit</button>
		  </div>

		</form>	
        </div>
    </div>
</div>
	
    <script>
    $('#forNoBreakUp').change(function() {
   if(this.checked){
       console.log('yes');
   }
   //'unchecked' event code
});
    </script>

