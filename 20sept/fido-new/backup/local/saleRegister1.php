<?php include('include/header-files.php'); ?>
<!-- write your custom css and js here -->
<style>

.card{ min-width: min-content;}

table tr td, table tr th{
	font-size: 10px !important;
	line-height: 14px !important;
}

table tr th{
white-space: nowrap;
}


table tr td{
    border: 0.5px dashed #eeeeef !important;
	background: none !important;
}


table tr td a{
color:#565090;
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

 $mformate = new mediadata();

  $category = new Category();
  $query = "SELECT * FROM project_category WHERE id NOT IN ('21','22','23')";
 $service = $category->customQuery($query);
 $project  = new project();
   //$cond="status = 1"
 $allproject = $project->allprowithinvoice();

 $estimate=new category_estimate();

 $partnerInfo = new Partner();
 $company=new Partner();
 $commisonSection=new PartnerCommisionSection();

 $allCategories = $category->all();
 $clientlist=$company->all();
 function getservice($id)
 {
	    $cat =new Category();
	 $estimate=new category_estimate();
	  $currentService=$estimate->findcustomrow(array('project_id'=>$id));

	 $currentService=$cat->findcustomrow(array('id'=>$currentService['project_cat_id']));
	 return $currentService['name'];

 }

function num_to_date($num)
{
	$yrdata= strtotime($num);
    return $yd = date('M/Y', $yrdata);
}
function num_to_fulldate($num)
{
	$yrdata= strtotime($num);
    return $yd = date('d/M/Y', $yrdata);
}
function addDate($num)
{
	return $da=date('d/M/Y',strtotime($num) + (24*3600*30));
}
function projectmoney($id)
{
	$promoney=0;
	$estimate=new category_estimate();
	$currentEst=$estimate->findcustom(array('project_id'=>$id));
	foreach($currentEst as $k=>$v)
	{
		$promoney = $promoney+$v['price'];
	}
	return $promoney;
}
function proCommision($id,$cid)
{
	$company=new Partner();
	$companyType=$company->findcustomrow(array('id'=>$cid));
	$project  = new project();
	$estimate=new category_estimate();
	$currentEst=$estimate->findcustom(array('project_id'=>$id));
	$totaComm = 0;
	foreach($currentEst as $k=>$v)
	{
		if($v['project_cat_id'] == 2 && $companyType['company_type']!=1){
			$sql="SELECT * FROM partner_section_commisions WHERE partner_id=".$cid." and service_id =2";
			$estcomm = $project->customQuery($sql);
			$totaComm = $estcomm[0]['commision'];

		}
	}
	return $totaComm;
}

function getStax($id,$mid,$is)
{
	$project  = new project();
	return $project->getServiceTexForInvoice($id,$mid,$is);
}

  $mise_invoice = new media_invoice();
  $mise_invoce_estimate = new mise_invoce_estimate();
  $miseInvoice = $mise_invoice->all();

	?>
        <!-- Page container begins -->
       <section class="main-container">
    <div class="header headerCntnt_wrapr">
      <div class="heading_top">
        <div class="page-title">Sale Register</div>
      </div>
     <!--<div class="links"><a href="addProject.php" class="btn btn-secondary btn-labeled m-r-10"><b><i class="icon-link"></i></b>  CREATE ESTIMATE REQUISITION</a></div>-->
    </div>
	

	<div class="pageLinsk_top">
		<div class="links"><button type="button"  id="unselect" class="btn btn-primary btn-sm m-r-10">Unselect All</button></div>
	</div>
            <div class="container-fluid page-content">
                <!-- Fixed header -->
                <div class="card card-inverse card-flat p-10">
                    <div class="">
                        <table id="mytable" class="table datatable table-hover table-bordered datatable-header-basic">
							<thead>
								<tr class="bg-info">
									<th style="text-align:center;">Sr. No.</th>
									<th  class="">Invoice Number</th>
									<th class="">Name of the Client</th>
									<th  class="">Month</th>
									<th class="positon-fixed1">Invoice Date</th>
									<th class="positon-fixed1">Estimate Number</th>
									<th class="positon-fixed1">Client PO Number</th>
									<?php foreach($service as $l=>$Datab)  { ?>
									<th><?php echo $Datab['name']; ?></th>
									<?php } ?>
									<th>Analytics</th>
									<th>Agency Commission (%)</th>
									<th>Subtotal</th>
									<th>Service Tax</th>
									<th>INR Value of Invoice</th>
									<th>Bank</th>
									<th>Invoice sent out date</th>
									<th>Payment Terms</th>
									<th>Receipt Due Date</th>
									<th>Receipt Date</th>
									<th>Receipt Amt.</th>
									<th>TDS Deduction</th>
									<th>Short & Excess</th>
									<th>Total Outstanding Amt.</th>
									<th>Outstanding days</th>
									<th>CCO</th>
									<th>Project/Campaign</th>
								</tr>
							</thead>
							
							<tbody>
							<?php $z=1;
							foreach($miseInvoice as $k=>$v) {  ?>
							<tr class="">
							<td style="text-align:center" ><?php echo $z; ?></td>
							<td class=""><a target="_blank" href="<?php echo $config['SITE_URL']."miseInvoicePDF.php?id=".$v['id'];?>"><?php echo $v['Invoice_No']; ?></a></td>
							<td class=""><?php $cdetails = $partnerInfo->getClientDetailsFromProject($v['campaignId']); 
							echo $cdetails[0]['partner_name']; ?></td>
							<td class=""><?php echo $v['Invoice_month']; ?></td>
							<td class=""><?php echo num_to_fulldate($v['invoice_date']) ?></td>
							<td><?php $estinfo = $project->findcustomrow(array('id'=>$v['campaignId'])); 
							echo $estinfo['W_O']; ?></td>
							<td><?php $results = $project->getPoDetailsFromProject($v['campaignId']);
							echo $results[0]['code'];
							$cat =new Category();
							$currentmisc=$estimate->findcustom(array('project_id'=>$v['campaignId']));
							//$currentmisccat=$cat->findcustomrow(array('id'=>$currentmisc['project_cat_id']));
							$misccatidmoney = array();
							foreach($currentmisc as $k=>$y)
							{
							$misccatidmoney[$y['project_cat_id']] = $y['price'];
							}
							//dd($misccatidmoney);
							?></td>
							<?php
							$chk = '';
							foreach($service as $l=>$Data)  {?>
							<td><?php if(array_key_exists($Data['id'], $misccatidmoney))
							{
							if($Data['id'] == 2){
							$chk = true;
							}else{
							$chk = false;
							}
							echo $mformate->moneyFormat($misccatidmoney[$Data['id']]);
							}
							?></td>

							<?php } ?>
							<td></td>
							<td><?php 

							if($chk){ 
							$com = $commisonSection->findcustomrow(array('id'=>$estinfo['commision']));

							$comm = $com['commision'];
							}
							else{ $comm = 0;  }
							echo $mformate->moneyFormat($misccomm =$v['money']*$comm/100);?></td>
							<td><?php echo $mformate->moneyFormat($miscsub =$v['money']+$misccomm)?> </th>
							<td><?php echo $mformate->moneyFormat($miscsub*18/100 );?></td>
							<td><?php echo $mformate->moneyFormat($mistax = $miscsub + $miscsub*18/100 );?></td>
							<td></td>
							<td><?php echo num_to_fulldate($v['invoice_date']); ?></td>
							<td>30</td>
							<td><?php echo addDate($v['invoice_date']); ?></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>

							</tr>
							<?php  $z++;
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
        displayLength: 50,
        "bLengthChange": false
      });
      
      /*$('.datatable-header-basic thead th').on("click.DT", function (e) {
        if (!$(e.target).hasClass('sortMask')) {
          e.stopImmediatePropagation();
        }
      });*/
	  
	  var tblHead_fix = true;
	  var wdnsWdth = $(window).width();
	  
		if(wdnsWdth <= 1080 ){
			var tblHead_fix = false;
			$('.table-responsive').removeClass('tblRspnv_actionbtn');
		}else{
			var tblHead_fix = true;
			$('.table-responsive').addClass('tblRspnv_actionbtn');
		}
	  
	$(window).resize(function(){
	var wdnsWdth = $(window).width();	
		//alert(wdnsWdth);
		if(wdnsWdth <= 1080 ){
			var tblHead_fix = false;
			$('.table-responsive').removeClass('tblRspnv_actionbtn');
		}else{
			var tblHead_fix = true;
			$('.table-responsive').addClass('tblRspnv_actionbtn');
		}
		
	});

      // Basic initialization
      var table_basic = $('.datatable-header-basic').DataTable({
        fixedHeader: tblHead_fix,
        buttons: {
          dom: {
            button: {
              className: 'btn btn-secondary'
            }
          },
          buttons: [
           /* {
              extend: 'colvis',
              text: '<i class="icon-table2"></i> <span class="caret"></span>',
              className: 'btn btn-secondary',
              collectionLayout: 'fixed'
            },
            {extend: 'copy', className: 'copyButton' },
            {extend: 'csv', className: 'csvButton' },
            {extend: 'excel', className: 'excelButton' },
            {extend: 'print', className: 'printButton' }*/
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
<script>
$(document).ready(function(){
$( "#myDiv" ).val("Glenn Quagmire");
});
</script>

<script>
$('table').on('scroll', function () {
    $("table > *").width($("table").width() + $("table").scrollLeft());
});
$(document).ready(function () {
    $('tbody > tr').click(function () {
        if(this.style.background == "" || this.style.background =="white") {
            $(this).css('background', 'red');
			$(this).find('td').css('color', '#fff');
			$(this).find('td a').css('color', '#fff');
        }
        else {
            $(this).css('background', '');
			$(this).find('td').css('color', '');
			$(this).find('td a').css('color', '');
        }
    });
});
$(document).ready(function () {
    $('#unselect').click(function () {
		//alert('hello');
		$('table#mytable > tbody > tr').css('background', '');
		$('table#mytable > tbody > tr td').css('color', '#111');
		$('table#mytable > tbody > tr td a').css('color', '#565090');
    });
});


</script>
