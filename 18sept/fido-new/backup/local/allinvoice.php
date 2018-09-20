<?php include('include/header-files.php'); ?>

<!-- write your custom css and js here -->
<style>
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
*
**/
$fileBasePath = dirname(__FILE__).'/';
/*
*	Redirect Admin To Home Page
*	If Already Logged In
*/

	$projectC = new category_estimate();
 	$mformate = new mediadata();
 	$project  = new project();
    $minvoice  = new mise_invoice();
    $company=new Partner();
    $sql1="SELECT id,Invoice_month,Invoice_No, isMedia, campaignId, projectName, money, invoiceStartDate, invoiceEndDate
FROM media_invoice";
  //echo $sql1;
    $allproject= $project->customQuery($sql1);

    function clientname($id){
    	$project  = new project();
 	$sql2 = "SELECT a.* FROM partner as a, project as b where b.clientid = a.id and b.id = ".$id;
 	//echo $sql2;
 	$cname= $project->customQuery($sql2);
 	//print_r($cname);
 	return $cname[0]['partner_name'];
   }

   function getusername($id){
   	$project  = new project();
   	$sql3 = "SELECT b.* FROM project as a, users as b where a.userid = b.id and a.id = ".$id;
   	$uname= $project->customQuery($sql3);
 	return @$uname[0]['name'];
   }
   function getusernamebycampaign($id){
   	$project  = new project();
   	$sql4 = "SELECT b.* FROM project as a, users as b where a.userid = b.id and a.W_O = '".$id."'";
   	$uname= $project->customQuery($sql4);
   	if(empty($uname)){
   		return;
   	}else{
   		return @$uname[0]['name'];
   	}

   }

	?>


        <!-- Page container begins -->
       <section class="main-container">
		<div class="header headerCntnt_wrapr">
			<div class="heading_top">
				<div class="page-title">All Invoice List</div>
			</div>
			<!--<div class="links"><a href="addProject.php" class="btn btn-secondary btn-labeled m-r-10"><b><i class="icon-link"></i></b>  CREATE ESTIMATE REQUISITION</a></div>-->
		</div>
            <div class="container-fluid page-content">
                <!-- Fixed header -->
				<div class="min_hght_440">
                <div class="card card-inverse card-flat p-10">
                    <div class="table-responsive tblRspnv_actionbtn">
                        <table class="table datatable table-bordered dataTable_cstm datatable-header-basic">
						<thead>
                                <tr>
									<th style="width:70px;">Invoice No
                                        <div class="src_inpt"><input type="text" class="form-control" placeholder="Search"></div>
                                        <div class="sortMask"></div>
                                    </th>
									<th>Estimate No
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
									<th>Duration
                                        <div class="src_inpt"><input type="text" class="form-control" placeholder="Search"></div>
                                        <div class="sortMask"></div>
                                    </th>
									<th class="no_Sort">Handle By</th>
									<th class="no_Sort">Action</th>
									</tr>
                            </thead>
						<?php foreach($allproject as $k=>$projectData){ ?>
                        <tr>
							<td style="text-align:Center" style="background-color: rgb(241, 243, 51);"><?php echo $projectData['Invoice_No']; ?></td>
                            <td>
							<?php
								switch ($projectData['isMedia']) {
								case "1":
								$a = $project->findCustomRow(array('id'=>$projectData['campaignId']));
								echo $a['W_O'];
								break;
								case "0":
								$a = $project->findCustomRow(array('id'=>$projectData['campaignId']));
								echo $a['W_O'];
								break;
								default:
								echo $projectData['isMedia'];
								} ?>
							</td>
							<td>
							<?php
								switch ($projectData['isMedia']) {
								case "1":
								echo clientname($projectData['campaignId']);
								break;
								case "0":
								echo clientname($projectData['campaignId']);
								break;
								default:
								$a = $company->findCustomRow(array('id'=>$projectData['campaignId']));
								echo $a['partner_name']; } ?>
							</td>
							<td>
								<?php echo $projectData['projectName']; ?>
							</td>
							<td>
								<?php echo $mformate->numberToCurrency($projectData['money']); ?>
							</td>
							<td>
							<?php
								switch ($projectData['isMedia']) {
								case "1":
								$a = $project->findCustomRow(array('id'=>$projectData['campaignId']));
								echo $a['project_start'].'/'.$a['project_end'];
								break;
								case "0":
								$a = $project->findCustomRow(array('id'=>$projectData['campaignId']));
								echo $a['project_start'].'/'.$a['project_end'];
								break;
								default:
								echo $projectData['invoiceStartDate'].'/'.$projectData['invoiceEndDate'];
								} ?>
							</td>
							<td class="widthSort">
								<?php
								switch ($projectData['isMedia']) {
								case "1":
								echo getusername($projectData['campaignId']);
								break;
								case "0":
								echo getusername($projectData['campaignId']);
								break;
								default:
								echo getusernamebycampaign($projectData['isMedia']);
								} ?>
							</td>

                                            <td class="widthSort">
<ul class="icons-list" style="text-align: center;">
<li class="dropdown">
  <button type="button" class="btn btn-secondary toggle_drpdown" style="text-align: center;border: 0;" data-toggle="dropdown" aria-expanded="false"><i style="margin-right:0" class="icon-three-bars position-left"></i></button>
      <ul  class="dropdown-menu dropdown-menu-sm  dropdown-menu-right" style="width: 170px;">
<?php
switch ($projectData['isMedia']) {
    case "1":
        $a = $project->findCustomRow(array('id'=>$projectData['campaignId']));
        echo "<a class='dropdown-item' target='_blank' href='".$config['SITE_URL']."invoicePDF.php?action=media&month=".$projectData['Invoice_month']."&id=".$projectData['campaignId']."&mid=".$projectData['id']."' >Invoice</a>";
                                                ?>
        <a class="dropdown-item" target="_blank" href="<?php echo $config['SITE_URL']." editmediaInvoice.php?id=".$projectData['id']?>"> Edit</a>
<?php
break;
        case "0":
        $a = $project->findCustomRow(array('id'=>$projectData['campaignId']));
        echo "<a class='dropdown-item' target='_blank' href='".$config['SITE_URL']."invoicePDF.php?id=".$projectData['campaignId']."&mInvoiceId=".$projectData['id']."'>Invoice</a>";

?>
            <a class="dropdown-item" target="_blank" href="<?php echo $config['SITE_URL']."editInvoice.php?id=".$projectData['id']?>"> Edit</a>
<?php 
break;
            default:
            echo "<a class='dropdown-item' target='_blank'  href='".$config['SITE_URL']."miseInvoicePDF.php?id=".$projectData['id']."'>Invoice</a>";
?>
           <a class="dropdown-item" target="_blank" href="<?php echo $config['SITE_URL']."miscEdit.php?id=".$projectData['id']?>"> Edit</a>
<?php
} ?>
      </ul>
	  </li>
      </ul>
</div>
                                            </td>
                            
                                        </tr>
                                        <?php

										}
										?>
                                </tbody>
                        </table>
                    </div>
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
	
