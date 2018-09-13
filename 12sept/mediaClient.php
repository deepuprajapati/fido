<?php include('include/header-files.php'); ?>

<!-- write your custom css and js here -->
<style>
.fa{color: #909090;}

.icons-list>li:first-child {
    margin-left: 0;
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
	$projectC = new category_estimate();
	$mformate = new mediadata();
	$project  = new project();
	$media_report = new media_report();
	//$cond="status = 1"
	
if(isset($_GET['action'])){
    switch ($_GET['action']) {
    case "requisition_to_invoice":
            $allproject = $project->requisition_to_invoice();
        break;
    case "pending_requisition_to_invoice":
        $query =  " and process = 1 and po_approvel = 1 and  reconciliation = 0 ";
            $allproject = $project->selectallEstimateWithQuery('2',$query);
        break;
    case "pending_po_approval":
        $allproject = $project->pending_po_approval_estimate_list();
        break;
    case "no_po":
        $allproject = $project->no_po_estimate_list();
        break;
    case "unconfirmed_estimate_requisitions":
        $query =  " and p.status = 0 ";
        $allproject = $project->selectallEstimateWithQuery('2',$query);
        break;
    case "rejected_pos":
        $query =  " and p.po_approvel = 2 ";
        $allproject = $project->selectallEstimateWithQuery('2',$query);
        break;
    case "po_approved_but_no_media_uploaded":
        $allproject = $project->po_approved_but_no_media_uploaded();
        break;
    case "media_plan_but_no_report_uploaded":
        $allproject = $project->media_plan_but_no_report_uploaded();
        break;
    case "rejected_reports":
        $query =  " and p.process = 2 ";
        $allproject = $project->selectallEstimateWithQuery('2',$query);
        break;
    case "partially_invoiced_estimates":
        $allproject = $project->partially_invoiced_estimates();
        break;
    case "invoiced_estimates": 
        $allproject = $project->get_invoiced_estimates_by_service('2');
        break;
    case "po_received": 
        $query =  "and p.po_approvel = 1  ";
        $allproject = $project->selectallEstimateWithQuery("2",$query);
        break;
    case "pending_estimates_requisition": 
        $query =  " and p.status = 0  ";
        $allproject = $project->selectallEstimateWithQuery('2',$query);
        break;
}

}else{
    $allproject = $project->selectMedia();
}

$estimate=new category_estimate();
if(isset($_GET['stop']))
{
	$sid = $_GET['stop'];
	$project->id=$sid;
	$project->process=1;
	$project->save();

	redirectAdmin('mediaClient.php');
}
if(isset($_GET['formedia']))
{
	$sid = $_GET['formedia'];
	if(isEligibleForInvoice($sid)){
		$project->id=$sid;
		$project->reconciliation=1;
		$project->save();
	}
	redirectAdmin('mediaClient.php');
}


if(isset($_POST['uploadpo']))
{
	
	 if(!empty($_FILES['filepo']) && !empty($_POST['eid'])){

			 $filename=$_FILES["filepo"]["tmp_name"];
		 $filename  = basename($_FILES['filepo']['name']);
		 $extension = pathinfo($filename, PATHINFO_EXTENSION);
		 $new       = 'report'.date('m-d-Y_hia').'.'.$extension;
		 $target_path = $_SERVER["DOCUMENT_ROOT"]."/fido/upload/upload_report_media/".$new;
		 if(move_uploaded_file($_FILES['filepo']['tmp_name'], $target_path)){
		 $target_file = $target_path . basename($_FILES["filepo"]["name"]);
		 		//$arr = array('media_id' => $_POST['eid'] );
				//$check_report = $media_report->findCustom($arr);

				//if (empty($check_report)) {
					$media_report->media_id = $_POST['eid'];
					$media_report->report = $new;
					$media_report->active = 0;
					$media_report->create();
					/*
				}else{
					$sql = "UPDATE media_report set active = 0 where media_id = ".$_POST['eid'];
					$result = $media_report->customQuery($sql);
						$media_report = new media_report();
					$media_report->media_id = $_POST['eid'];
					$media_report->report = $new;
					$media_report->active = 1;
					$media_report->create();
				}
				*/
             $user = new User();
        $project  = new project();
         $projectDetails = $project->findCustom(array('id' => $_POST['eid'] ));
        $useremail = $user->getUserDetail($projectDetails[0]['userid']);
       
        /*    sending mail to the BS team */      
        $message='';
        $message.= "The Media Report has been uploaded against the Estimate <strong>".$projectDetails[0]['W_O']."</strong>.<br>";
        $message.="Please visit FIDO to approve/disapprove it and then the requisition for Invoice.";
        $urlforservice = ($config['API_BASE_URL']."sendmail");

        $data['email']=$useremail[0]['email'];
        $data['name']=$useremail[0]['name'];
        $data['msg']=$message;
        $data['subject'] ='Media Report Uploaded';
        $services = postCURL($urlforservice,$data);
       

/*    sending mail to the BS and Service/Media  team */ 
        
                 $cmcnt = "<strong>".$userinfo['name']."</strong> has been <strong>uploaded Media Report</strong> against the Estimate <strong>".$projectDetails[0]['W_O']."</strong>";
                 saveNotification($projectDetails[0]['userid'],$cmcnt,0,$projectDetails[0]['W_O'],1);
             redirectAdmin('mediaClient.php');
				//$_SESSION['msg'] = "Purchase order has been updated successfully";
				//redirectAdmin('mediaClient.php');
			}else {
				echo $target_path;
				echo $_FILES['filepo']['tmp_name'];
				die;
			}

		}

}

	?>

        <!-- Page container begins -->
       <section class="main-container">
		<div class="header headerCntnt_wrapr">
			<div class="heading_top">
				<div class="page-title">Media Management</div>
			</div>
			<div class="pageTgle" id="openLnks"><i class="icon-menu7 navIcon_size"></i></div>
			<div class="links" id="slideLinks"><a href="uploadexl.php" class="btn btn-secondary btn-labeled m-r-10"><b><i class="icon-upload"></i></b>    Upload Media Plan</a>
			<a href="releaseOrderPermission.php" class="btn btn-secondary btn-labeled m-r-10"><b><i class="icon-link"></i></b>   Permission RO from Media Plan</a></div>
		</div>
            <div class="container-fluid page-content">
                <!-- Fixed header -->
				<div class="min_hght_440">
                <div class="card card-inverse card-flat p-10">
                    <div class="table-responsive tblRspnv_actionbtn">
                        <table class="table datatable table-bordered dataTable_cstm datatable-header-basic fixTlb_hdr_minwidht">
						<thead>
                                <tr>
									<th style="width:70px;">S.No.
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
									
									
									<th class="no_Sort txt_cntr" >PO Approval</th>
									
									<th class="no_Sort txt_cntr">Report </th>
									
									<th class="no_Sort">Requistion of of Invoice Approval Status</th>
									</tr>
                            </thead>
							<tbody>
										<?php $i=1; 
                                            foreach($allproject as $k=>$projectData){
											//dd(isEligibleForInvoice($projectData['id']));
											?>

										<tr>
                                        <td class="txt_cntr"><?php echo $i; ?></td>
										<td><a class="tbl_txt_lnk" target="_blank" href="<?php echo $config['SITE_URL']."estimatePdf.php?id=".$projectData['id'];?>"><?php echo $projectData['W_O']; ?></a>
										</td>
										<td><?php echo $projectData['partner_name']; ?></td>
										<td><a class="tbl_txt_lnk" target="_blank" href="<?php echo $config['SITE_URL']."releaseOrder.php?campaign=".$projectData['id'];?>"><?php echo $projectData['project_name']; ?></a></td>
										<td><?php echo $mformate->numberToCurrency($projectData['price']); ?></td>
										<td><?php  echo $projectData['project_start'].'/'.$projectData['project_end']
											?></td>


			             <td style="text-align:center;width:60px;">
                            <?php
                            if($projectData['po_approvel']==2){ ?>
                              <i aria-hidden="true" class="fa fa-times icn_sz_19 text-danger" style="margin-right: 5px;"></i>
                          <?php  } 
                                if($projectData['po_approvel']==1) {  ?>
							  <i class="fa fa-check icn_sz_20 text-success" aria-hidden="true"></i>
                          <?php  }
                                if($projectData['po_approvel']==0) {  ?>
							  <i class="fa fa-clock-o fa-spin fa-2x fa-fw" aria-hidden="true"></i>
                          <?php  }
                          ?>
                          </td>

					<td class="text-center" style="text-align: center;width:60px;">
                    <?php   $sqlarray = array('media_id' => $projectData['id']);
                    $res = $media_report->findCustom($sqlarray);
                    if (empty($res)) {
                        if($projectData['po_approvel']==1){ ?>
                            <a href="javascript:;" data-toggle="modal" onclick="f1(this)" data-target="#myyModal"><i class="fa fa-upload icn_sz_19"> </i></a>
                        <input type="hidden" value="<?php echo $projectData['id']; ?>" class="hval" >
                        <?php } else{ ?>
                        <i class="fa fa-clock-o fa-spin fa-2x fa-fw" aria-hidden="true"></i>
                        <?php }
                        }else{
                $target_path = $config['SITE_URL']."/upload/upload_report_media/".$res[0]['report']; ?>
                        <!--<a target="_blank" href="<?php echo $target_path; ?>" ><i class="fa fa-external-link icn_sz_19 tbl_txt_lnk" aria-hidden="true"></i>
                        </a>-->
                        <ul class="icons-list">
                            <li class="dropdown">
                            	<button type="button" class="btn btn-secondary toggle_drpdown" style="text-align: center;border: 0;" data-toggle="dropdown" aria-expanded="true"><i style="margin-right:0" class="icon-three-bars position-left"></i></button>
                                <ul class="dropdown-menu dropdown-menu-right">
                                	<?php $x=1;
                                	foreach($res as $a=>$b){ ?>
                                	<a  target="_blank" href="<?php echo $config['SITE_URL']."/upload/upload_report_media/".$b['report']?>" class="dropdown-item"><i class="fa fa-external-link" style="vertical-align: sub;"></i>
                                	<?php if ($b['active']) {
                                		echo 'Report '.$x.' <i style="float: right;margin-top: 3px;" class="fa fa-check icn_sz_20 text-success" aria-hidden="true"></i>';
                                	} else {
                                		echo 'Report '.$x.' <i style="float: right;margin-top: 3px;" class="fa fa-times icn_sz_20 text-danger" aria-hidden="true"></i>';
                                	}
                                	 ?>
                                	 </a>
                                <?php $x++; } ?>
                                 <div class="dropdown-divider"></div>
                                    <a href="javascript:;" data-toggle="modal" onclick="f1(this)" data-target="#myyModal" class="dropdown-item"><i class="fa fa-upload" style="vertical-align: sub;"></i> Upload</a>
                                    <input type="hidden" value="<?php echo $projectData['id']; ?>" class="hval" >
                                </ul>
                            </li>
                        </ul>
                        <?php } 
                        ?>
                        </td>
                        <td style="text-align: center;">
							<?php if($projectData['reconciliation'] == 0){
								?>
								<button type="button" class="btn tooltip-left tooltip_cstm" data-tooltip="Not Done">
									<i class="fa fa-clock-o fa-spin icn_sz_22 marg_0 fa-fw"></i>
								</button>	
							<?php }else{ ?>
								<button type="button" class="btn tooltip-left tooltip_cstm" data-tooltip="Done">
									<i class="fa fa-thumbs-up icn_sz_20 text-success"></i>
								</button>
							<?php }?>	     
						</td>

                        <!--<td style="text-align: center;">
                        <?php if($projectData['reconciliation'] == 0){
                                    echo '<i data-toggle="tooltip" data-placement="top" title="Not Done" class="fa fa-clock-o fa-spin fa-2x" aria-hidden="true">';          
                                } else {
                                    echo '<i data-toggle="tooltip" data-placement="top" title="Done" class="fa fa-thumbs-up fa-2x" aria-hidden="true">';
                                    } ?>        
						</td>-->
			

										</tr>
										<?php
                                            $i++;
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
				displayLength: 50,
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
		function f1(h) {
				var a = $(h).closest('td').find('.hval').val();
				var b = $(h).closest('td').find('.poval').val();
				//var b = h.getAttribute('value');
				//var c = b + "&povalue=" + a;
				//$(h).closest('tr').find('.spo').attr("href", c);
				$('#op').val(a);
				$('#po').val(a);
				$('#opr').val(a);
				$('#eop').val(a);
				$('#pono').val(b);
				//alert(a);
		}

</script>

    <script>
		$(document).ready(function(){
			
			$('#openLnks').click(function(){
				$('#slideLinks').slideToggle();
			})
				
		});
    </script>

<div class="modal fade" id="myyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg_none p-10">
        <h5 class="modal-title" id="myModalLabel">Upload Media Report</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
	  <form method="post" action="mediaClient.php" enctype="multipart/form-data">
      <div class="modal-body">
		<div class="row marg_b_15">
		<div class="col-md-12 col-sm-12">
			<div class="form-group">
			<label>Upload Here: </label>
			<div class="input-group">
			<input type="file" id="exampleInputFile" class="form-control" name="filepo" required>
			</div>
			</div>
		</div>
		</div>
		<input type="hidden" name="eid" id="eop" value="">
      </div>
	  <div class="modal-footer bg_none">
		<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		<button type="submit" class="btn btn-primary" name="uploadpo">Submit</button>
	  </div>
		</form>
    </div>
  </div>
</div>