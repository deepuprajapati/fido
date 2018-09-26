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

.drpDwn_rprt{
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0px 10px;
}


.ttlWth_icn{
width: 100%;
}

.ttlWth_icn i.icnDrp_lft{
    top: 0 !important;
    position: static;
    font-size: 14px;
    vertical-align: middle;
    margin-right: 4px;
}


.ttlWth_icn a.rprt_ttl{
    font-size: 13px;
}

.rightApp_btn{
    width: 55px;
    text-align: center;
    display: flex;
}

.rightApp_btn a{

}

.rightApp_btn a i{
    font-size: 15px;
    border: 1px solid gainsboro;
    width: 22px;
    height: 19px;
    margin-right: 5px;
    line-height: 20px;
    top: 0 !important;
}


.dataTable_cstm thead th {
    font-size: 9.5px !important;
    padding: 7px 9px 6px 9px !important;
    line-height: 13px !important;
    vertical-align: bottom !important;
}


.mdlBox_tbl_stl th {
	font-size: 11px !important;
	line-height: 17px !important;
	background: #e9ecef70 !important;
	padding-top: 12px !important;
	padding-bottom: 12px !important;
}

.mdlBox_tbl_stl td {
    font-size: 11px !important;
    line-height: 16px !important;
}


.mdlBox_tbl_stl td input , .mdlBox_tbl_stl td select{
    border: 1px solid gainsboro;
    padding: 3px 4px 3px 4px;
}
</style>


<!-- write your custom css and js here -->

<!-- Header begins -->
<?php include('include/header-new.php'); ?>

<?php

//var_dump(exec('getmac'));

  
/*
* Getting MAC Address using PHP
* Md. Nazmul Basher
*/
ob_start(); // Turn on output buffering


error_reporting(E_ALL);

ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

date_default_timezone_set('Asia/Calcutta');
include 'asset/phpexl/Classes/PHPExcel/IOFactory.php';

$projection = new projection();
$partner=new Partner;
if(isset($_POST['assign']) && !empty($_POST['assign'])){
	
	if(isset($_POST['clientid'])){
		foreach($_POST['clientid'] as $clientid=>$partner_id){
			

			$id=$partner->setClient($clientid,$partner_id);
		}
	}
}

if(isset($_POST['matchtotal']) && !empty($_POST['matchtotal'])){
	
	if(isset($_POST['updated'])){
		foreach($_POST['updated'] as $key=>$value){
			
            
			$id=$projection->updateProjection($key,$value);
		}
	}
}
if(isset($_POST['active_version_id']) && !empty($_POST['active_version_id'])){
	 $aopobj= new Aopversion();
	 $year=$_POST['active_version_year'];
	 $aopobj->updateVersion($_POST['active_version_id'],$year);
}
if(isset($_POST['upload'])){
/** PHPExcel_IOFactory */
$filename=$_FILES["file"]["tmp_name"];


/**
if(validate($filename)){

}
else{
	$_SESSION['msg'] = "File is not in formate";
	redirectAdmin('uploadexl.php');
	exit();
}
*/
//print_r( $_FILES);
$target_path = $_SERVER["DOCUMENT_ROOT"]."/fido/upload/". $_FILES['file']['name'];
//echo $target_path;
move_uploaded_file($_FILES['file']['tmp_name'], $target_path);
$target_file = $target_path . basename($_FILES["file"]["name"]);
//$data=file_get_contents($target_path);
//print_r($data);

$objPHPExcel = PHPExcel_IOFactory::load($target_path);
foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
	
    $worksheetTitle     = $worksheet->getTitle();
    $highestRow         = $worksheet->getHighestRow(); // e.g. 10
    $highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
    $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
	//echo $highestColumnIndex;
    $allcolumn = $projection->getColumns();
    $nrColumns = ord($highestColumn) - 64;
    $aopobj= new Aopversion();
    $aopobj->version=$_POST['version'];
    $aopobj->year=$_POST['period'];
    $aopobj->created_at=date("Y-m-d h:i:s");
	$aopobj->active=1;
    $aopobj->create();
	
    $aopid=$aopobj->lastInsertId();
	//$aopobj->updateActiveVersion($aopid,$_POST['period']);
    for ($row = 0; $row <= $highestRow; ++ $row) {
		
     $val=array();

        for ($col = 0; $col < $highestColumnIndex; ++ $col) {
            $cell = $worksheet->getCellByColumnAndRow($col, $row);
            $val[] = $cell->getCalculatedValue();


        }
		
       
		//$val = array_filter($val);
		static $i=0;
		$projection = new projection();
		
		
		     
           
		$projection->client_name=trim($val[0]);
        $project=new Project();
        $clientid=$project->selectbyname(trim($val[0]));
            $projection->client_id=0;
        if(!empty($clientid))
        {
            $projection->client_id=$clientid[0]['id'];
        }
        
      
    
       //echo "<pre>";print_r($allcolumn);echo "</pre>";
       //die;
	   if(isset($val[9])){
			$projection->client_name=htmlspecialchars($val[0]);
			$projection->social_orm_content= (empty(trim($val[1]))) ? 0 : trim($val[1]);
			$projection->creative=(empty(trim($val[2]))) ? 0 : trim($val[2]);
			$projection->media_mobile_sem=(empty(trim($val[3]))) ? 0 : trim($val[3]);
			$projection->sco=(empty(trim($val[4]))) ? 0 : trim($val[4]);
			$projection->pr=(empty(trim($val[5]))) ? 0 : trim($val[5]);
			$projection->content_marketing=(empty(trim($val[6]))) ? 0 : trim($val[6]);
			$projection->inbound_marketing=(empty(trim($val[7]))) ? 0 : trim($val[7]);
            $projection->tech=(empty(trim($val[8]))) ? 0 : trim($val[8]);
			$projection->total=round($val[9],2)*100000;
			$projection->added_on=date('Y-m-d H:i:s');
			$projection->aopid=$aopid;
			$projection->quarter1=round($val[10],2)*100000;
			$projection->quarter2=round($val[11],2)*100000;
			$projection->quarter3=round($val[12],2)*100000;
			$projection->quarter4=round($val[13],2)*100000;
			$projection->create();
            
	   }

}

}
	
}
$project  = new project();
$allproject = $project->selectMedia();
$year=date('Y');
$date=date("Y-03-31");
$currentdate=date("Y-2-d");
$projection = new projection();
$aopobj= new Aopversion();
if(isset($_GET['yearly'])){
    $year= $_GET['yearly'];
    $allprojectiondata = $projection->selectalllbyversion('',$year);
    $aoplist=$aopobj->selectversion('',$year);
}
else
{
        if(strtotime($date) > strtotime($currentdate))
        {
            $year= date("Y").'-'.(date("Y")+1);
        }else
        {
            $year= (date("Y")-1).'-'.(date("Y"));
        }
        $allprojectiondata = $projection->selectalllbyversion('',$year);
        $aoplist=$aopobj->selectversion();
}
$unasignedclient=$projection->getunasignedclient();
$totalnotmatch=$projection->totalnotmatch();
$partner=new Partner;
$partners=$partner->getPartners();
$allversions=$aopobj->all();
$versions=array();
if(isset($allversions) && !empty($allversions)){
  foreach($allversions as $version){
	$versions[$version['year']][]=$version;		
  }
}


?>
        <!-- Page container begins -->
       <section class="main-container">
	   <input id='partners' type='hidden' value='<?php echo json_encode($partners);?>'>
    <div class="header headerCntnt_wrapr">
      <div class="heading_top">
        <div class="page-title">Projection Summary</div>
      </div>
      <div class="links"><a href="javascript:;" id="version_active" class="btn btn-info">Set Version Active</a></div>
    </div>
            <div class="container-fluid page-content">
                <!-- Fixed header -->
                <div class="min_hght_440">
				
								<div class="card card-inverse card-flat p-b-25 p-t-25 p-l-10 p-r-10">
                                    <form action=" " enctype="multipart/form-data" method="post" class="">
									<div class="row marg_b_20">
									
										
											<div class="col-sm-4">
												<input style="padding-top: 5px !important;" type="file" id="upload" class="form-control inptFld_sz" name="file" required="">
											</div>
											<div class="col-sm-4">
											   <input type="number" class="form-control inptFld_sz" name="version" placeholder="Version" required="">
											</div>
											<div class="col-sm-3">
												<select id="" class="form-control inptFld_sz" name="period">
													<option>2018-2019</option>
													<option>2017-2018</option>
													 
												</select>
											</div>
											<!--<div class="col-sm-1">
												 <button style="width: 100%;" id="check" name="upload" class="btn btn-default">Submit </button>

											</div>-->
											
										<div class="col-md-1 p-l-0">

										<button style="width: 100%;height:35px;" name="upload" type="button" id="check" class="btn btn-primary"> Submit</button>


										</div>
										
									
									</div>
                                    </form>
                              
                                <div class="row">


                                    <div class="col-md-4">
                                        <form>
                                            <select id="yearly" name="yearly" class="form-control inptFld_sz" onchange="this.form.submit()">
												 <option <?php if($year==(((date('Y'))). '-' .  date('Y')+1)) echo 'selected'; ?>><?php echo ((date('Y'))).'-' .  (date('Y')+1); ?></option>
                                                 <option <?php if($year==(((date('Y')-1)). '-' .  date('Y'))) echo 'selected'; ?> ><?php echo ((date('Y')-1)). '-' .  date('Y'); ?></option>
                                                    
                                            </select>
                                        </form>
                                    
                                    
                                    </div>
                                    <div class="col-md-4">
                                    
                                    <?php $i=0;foreach($aoplist as $key=>$value){ 
                                        $class='';
                                        if($i=0){ $class='active'; }
                                        ?>    
										<button data-toggle="tab" style="width: 100%;"onclick="showtable('<?php echo $value['id']; ?>')"  class="btn btn-default">Version <?php echo $value['id']; ?></button>  
										
                                    <?php } ?>
                                    
                                    
 
                                    </div>
                                    <div class="col-md-2">

                                        <button style="width: 100%;" onclick='showpopup(<?php echo json_encode($unasignedclient) ?>)'  class="btn btn-default">Un Named Client (<?php echo  count($unasignedclient); ?>)</button>    
                                        
                                    
                                    </div>

                                    <div class="col-md-2">
  

									<button style="width: 100%;" onclick='showmatched(<?php echo json_encode($totalnotmatch) ; ?>)'  class="btn btn-default">Un Matched Total (<?php echo  count($totalnotmatch); ?>)</button>    
                                    
                                    </div>

								</div>
							</div>
				
                <div class="card card-inverse card-flat p-10">
                    <div class="table-responsive tblRspnv_actionbtn">
                        <table class="table datatable table-hover table-bordered dataTable_cstm datatable-header-basic">
            <thead>
                                            <tr>
												<th>Id
												<div class="src_inpt"><input type="text" class="form-control" placeholder="Search"></div>
												<div class="sortMask"></div>
												</th>
                                                <th>Client Name
												<div class="src_inpt"><input type="text" class="form-control" placeholder="Search"></div>
												<div class="sortMask"></div>
												</th>
                                                <th>Social ORM Content
												<div class="src_inpt"><input type="text" class="form-control" placeholder="Search"></div>
												<div class="sortMask"></div>
												</th>
                                                <th>Creative
												<div class="src_inpt"><input type="text" class="form-control" placeholder="Search"></div>
												<div class="sortMask"></div>
												</th>
                                                <th>Media Mobile SEM
												<div class="src_inpt"><input type="text" class="form-control" placeholder="Search"></div>
												<div class="sortMask"></div>
												</th>
											    <th>SEO
												<div class="src_inpt"><input type="text" class="form-control" placeholder="Search"></div>
												<div class="sortMask"></div>
												</th>
                                                <th>PR
												<div class="src_inpt"><input type="text" class="form-control" placeholder="Search"></div>
												<div class="sortMask"></div>
												</th>
                                                <th>Content Marketing
												<div class="src_inpt"><input type="text" class="form-control" placeholder="Search"></div>
												<div class="sortMask"></div>
												</th>
                                                <th>Tech
												<div class="src_inpt"><input type="text" class="form-control" placeholder="Search"></div>
												<div class="sortMask"></div>
												</th>
                                                <th>Total
												<div class="src_inpt"><input type="text" class="form-control" placeholder="Search"></div>
												<div class="sortMask"></div>
												</th>
                                                <th>Quarter 1
												<div class="src_inpt"><input type="text" class="form-control" placeholder="Search"></div>
												<div class="sortMask"></div>
												</th>
                                                <th>Quarter 2
												<div class="src_inpt"><input type="text" class="form-control" placeholder="Search"></div>
												<div class="sortMask"></div>
												</th>
                                                <th>Quarter 3
												<div class="src_inpt"><input type="text" class="form-control" placeholder="Search"></div>
												<div class="sortMask"></div>
												</th>
                                                <th>Quarter 4
												<div class="src_inpt"><input type="text" class="form-control" placeholder="Search"></div>
												<div class="sortMask"></div>
												</th>
                                                <th>Date & Time
												<div class="src_inpt"><input type="text" class="form-control" placeholder="Search"></div>
												<div class="sortMask"></div>
												</th>
                                            </tr>
                            </thead>
							<tbody id="allProjectlot">
							<?php 
							foreach($allprojectiondata as $k=>$projectData){ 
							   
								
								?>
								<tr>
									<td class="txt_cntr"><?php echo $projectData['id']; ?></td>
									<td><?php echo $projectData['client_name']; ?></td>
									<td><?php echo $projectData['social_orm_content']; ?></td>
									<td><?php echo $projectData['creative']; ?></td>
									<td><?php echo $projectData['media_mobile_sem']; ?></td>
									<td><?php echo $projectData['sco']; ?></td>
									<td><?php echo $projectData['pr']; ?></td>
									<td><?php echo $projectData['content_marketing']; ?></td>
									<td><?php echo $projectData['tech']; ?></td>
									<td><?php echo $projectData['total']; ?></td>
									<td><?php echo $projectData['quarter1']; ?></td>
									<td><?php echo $projectData['quarter2']; ?></td>
									<td><?php echo $projectData['quarter3']; ?></td>
									<td><?php echo $projectData['quarter4']; ?></td>
									<td><?php echo $projectData['added_on']; ?></td>
								</tr>
							<?php   } ?>
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
  
<!--<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Assign Clients</h4>
        </div>
        <div class="modal-body">
		<form name="assignclient" method="post" action="" >
			<div class="row">
				<input style="float:right;margin-right:20px;margin-bottom:20px;" class="btn btn-primary btn-success" type="submit" name="assign" id="assign" value="Assign Clients">
			</div>
			<div class="row"></div>
			<div class="row" style="max-height:450px;overflow-y:auto;">
			  <table  class="bootstraptablebody display table table-bordered table-striped mg-t datatable editable-datatable" >
				  
				  
			  </table>
			</div>
		 </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>-->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width:90%;max-width:1120px;">
    <div class="modal-content">
      <div class="modal-header bg_none p-10">
        <h5 class="modal-title">Assign Clients</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
	  <form name="assignclient" method="post" action="" > 
     <div class="modal-body">
		
			<div class="row">
			<div class="table-responsive" style="height:420px;">
			<table class="bootstraptablebody table table-hover datatable table-bordered mdlBox_tbl_stl" ></table>
			</table>
			</div>	
			</div>	
		
     </div>
    <div class="modal-footer bg_none">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	<button class="btn btn-primary" type="submit" name="assign" id="assign" value="Assign Clients">Assign Clients</button>
    </div>
    </form>
    </div>
  </div>
</div><!-- Done End 1-->  
  
  
  
  
  
<!--<div class="modal fade" id="version_modal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Version List</h4>
        </div>
        <div class="modal-body">
		
			<div class="row">
				<div class="col-sm-4">
					<?php
					  
					  if(isset($versions) && !empty($versions)){
						  echo "<select name='version_dropdown' id='version_dropdown' class='form-control'>";
						  foreach($versions as $year=>$version){
							  echo "<option value='".$year."'>".$year."</option>";
							  
						  }
						  echo "</select>";
					  }
					?>
				</div>
				<div class="col-sm-4">
				</div>
				<div class="col-sm-4">
					<form method="post" action="">
						<input type='hidden' name='active_version_id' id="active_version_id" value="">
						<input type='hidden' name='active_version_year' id="active_version_year" value="">
						<input type="button" id="save_active_version" value="Save" class="btn btn-primary">
						<input id="submit_active_version" type="submit" value="Save" class="btn btn-primary" style="display:none;">
					</form>
				</div>
			</div>
			<div class="row"><hr/></div>
			  <?php
			  if(isset($versions) && !empty($versions)){
				  foreach($versions as $year=>$version){
					  ?>
					  <div class="row versions" style="max-height:450px;overflow-y:auto;" id="year-<?php echo $year;?>">
					  <?php if(isset($version) && !empty($version)){
						  foreach($version as $value){ 
						  
						  
						  ?>
						  <div class="form-group">
							<div class="col-sm-6">
								<?php echo 'Version '.$value['id']; ?>
							</div>
							<div class="col-sm-6">
								<input type="checkbox" year="<?php echo $year;?>" name="active" value="<?php echo $value['id']; ?>" class="vcheckbox" <?=isset($value['active']) && $value['active']==1?'checked':''?>>
							</div>
						  </div>
						  <?php }
					  }
					  ?>
					  </div>
					<?php					
				  }
			  }
			  ?>
			</div>
		
        </div>
        
      </div>
    </div>-->
<div class="modal fade" id="version_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg_none p-10">
        <h5 class="modal-title">Version List</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<div class="row">
			<div class="col-sm-10">
				<?php
				  
				  if(isset($versions) && !empty($versions)){
					  echo "<select name='version_dropdown' id='version_dropdown' class='form-control inptFld_sz' style='width:100%'>";
					  foreach($versions as $year=>$version){
						  echo "<option value='".$year."'>".$year."</option>";
						  
					  }
					  echo "</select>";
				  }
				?>
			</div>

				<div class="col-sm-2">
					<form method="post" action="">
						<input type='hidden' name='active_version_id' id="active_version_id" value="">
						<input type='hidden' name='active_version_year' id="active_version_year" value="">
						<!--<input type="button" id="save_active_version" value="Save" class="btn btn-primary">-->
						<button type="button" id="save_active_version" class="btn btn-primary" style="width: 100%;height:35px">Save</button>
						<input id="submit_active_version" type="submit" value="Save" class="btn btn-primary" style="display:none;">
					</form>
				</div>
		</div>
		<div class="dropdown-divider marg_t_20 marg_b_15"></div>
		  <?php
		  if(isset($versions) && !empty($versions)){
			  foreach($versions as $year=>$version){
				  ?>
				  <div class="row versions" style="max-height:450px;overflow-y:auto;" id="year-<?php echo $year;?>">
				  <?php if(isset($version) && !empty($version)){
					  foreach($version as $value){ 
					  
					  
					  ?>
					 
						
						<div class="col-sm-6 marg_b_10">
							<?php echo 'Version '.$value['id']; ?>
						</div>
						<div class="col-sm-6 marg_b_10">
							<!--<input type="checkbox" year="<?php echo $year;?>" name="active" value="<?php echo $value['id']; ?>" class="vcheckbox" <?=isset($value['active']) && $value['active']==1?'checked':''?>>-->
							
							<div class="chkbox_cstm_wpr">
								<label class="marg_0">
								<div class="chbx_style"><input type="checkbox" year="<?php echo $year;?>" name="active" value="<?php echo $value['id']; ?>" class="shwInput vcheckbox" <?=isset($value['active']) && $value['active']==1?'checked':''?>><span></span></div>
								</label>
							</div>

						</div>
						
						
					 
					  <?php }
				  }
				  ?>
				  </div>
				<?php					
			  }
		  }
		  ?>
     </div>
    <div class="modal-footer bg_none">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    </div>
    </div>
  </div>
</div><!-- Done End 1-->
	
	
	
	

<!--<div class="modal fade" id="myModalnew" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Match Total</h4>
        </div>
        <div class="modal-body">
		<form name="assignclient" method="post" action="" >
			<div class="row">
				<input style="float:right;margin-right:20px;margin-bottom:20px;" class="btn btn-primary btn-success" type="submit" name="matchtotal" id="match" value="Save">
			</div>
			<div class="row"></div>
			<div class="row" style="max-height:450px;overflow-y:auto;">
			  <table  class="bootstraptablebodytotalmatch display table table-bordered table-striped mg-t datatable editable-datatable" >
				  
				  
			  </table>
			</div>
		 </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>-->
  
  
 <div class="modal fade" id="myModalnew" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width:90%;max-width:1120px;">
    <div class="modal-content">
      <div class="modal-header bg_none p-10">
        <h5 class="modal-title">Match Total</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
     <form name="assignclient" method="post" action="" >
      <div class="modal-body">
		
			<div class="row">
			<div class="table-responsive" style="height:420px;">
			<table class="bootstraptablebodytotalmatch table table-hover datatable table-bordered mdlBox_tbl_stl">
			</table>
			</div>	
			</div>	
		
     </div>
    <div class="modal-footer bg_none">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	<button type="submit" name="matchtotal" id="match" class="btn btn-primary">Save</button>
    </div>
    </form>
    </div>
  </div>
</div><!-- Done End 1--> 


<script>
$(document).on('click','#version_active',function(){
	$('#version_modal').modal('show');
});
$('#version_dropdown').trigger('change');
$(document).on('change','#version_dropdown',function(){
	var cur=$(this).val();
	$('.versions').hide();
	$('#year-'+cur).show();
});
$(document).on('click','.vcheckbox',function(){
	$('.vcheckbox').addClass('checkbox-active');
	if($(this).is(':checked')){
		$(this).removeClass('checkbox-active');
		$('.checkbox-active').removeAttr('checked');
		var year=$(this).attr('year');
		$('#active_version_id').val($(this).val());
		$('#active_version_year').val(year);
	}else{
		$('.checkbox-active').removeAttr('checked');
		$('#active_version_id').val('');
		$('#active_version_year').val('');
		
	}
});
$(document).on('click','#save_active_version',function(){
	if($('#active_version_id').val()==''){
		alert('Please select at least one version to be active.');
	}else{
		$('#submit_active_version').click();
	}
	
});
$('INPUT[type="file"]').change(function () {
    var ext = this.value.match(/\.(.+)$/)[1];
    switch (ext) {
        case 'xlsx':
        case 'xls':
		case 'XLSX':
		case 'XLS':

		$('#check').removeAttr('disabled');;
            break;
        default:
		$('#check').attr('disabled', true);
            alert('This is not an allowed file type.');
           $('#check').attr('disabled','disabled');
    }
});
    

function showtable(id)
    {
     
         
       year=$('#yearly').val();
       var url =   'ajax.php?action=aop&id='+id+'&year='+year; 
       runajax(url, '', 'get', '', 'json', function(res) {
           console.log(res.status);
		
			
			 data=res.result;
           
			  tablehtml(data);
			  
			
			
			
		
	   });
    }
function tablehtml(data)
    {
        console.log(data)
       $html='';
       for(i=0; i<data.length; i++)
            {
               
				  $html+='<tr>';
				  $html+='<td>'+data[i].id+'</td>';
				  $html+='<td>'+data[i].client_name+'</td>';
				  $html+='<td>'+data[i].social_orm_content+'</td>';
				  $html+='<td>'+data[i].creative+'</td>';
				  $html+='<td>'+data[i].media_mobile_sem+'</td>';
				  $html+='<td>'+data[i].sco+'</td>';
				  $html+='<td>'+data[i].pr+'</td>';
				  $html+='<td>'+data[i].content_marketing+'</td>';
				  $html+='<td>'+data[i].tech+'</td>';
				  $html+='<td>'+data[i].total+'</td>';
				  $html+='<td>'+data[i].quarter1+'</td>';
				  $html+='<td>'+data[i].quarter2+'</td>';
				  $html+='<td>'+data[i].quarter3+'</td>';
				  $html+='<td>'+data[i].quarter4+'</td>';
                  $html+='<td>'+data[i].added_on+'</td>';
               
               $html+='</tr>';
            }
        jQuery('#allProjectlot').html($html);
        
    }
function runajax(url, mydata, type, responseid, returntype, fn) {
	
   
    jQuery.ajax({
        timeout: 10000,
        type: type,
        url: url,
        data: mydata,
        dataType: 'json',
        success: function(res) {
            if (typeof fn === 'function') {
                fn(res);
            }

        },
        error:function (res){

        }
    });
}
 function conditional(data) {
  return (data ? data : "--");
}   
function showpopup(data)
    {
		
		
        jQuery('#myModal').modal('show');
        $html='<thead> <th>Id</th><th>Client Name</th><th>Total</th><th>Q1</th> <th>Q2</th> <th>Q3</th> <th>Q4</th><th>Client</th> <th>Date & Time</th> </thead><tbody>';
	
		option='<option value="0">Select Client</option>';
		var partners=JSON.parse($('#partners').val());
		
		console.log(partners);
		for(var j=0;j<partners.length; j++){
			console.log(partners[j]);
			option+="<option value='"+partners[j].id+"'>"+partners[j].partner_name+"</option>";
			
		}
        
        for(i=0;i<data.length; i++){
				$html+='<tr>';
				$html+='<td>'+data[i].id+'</td>';
				$html+='<td>'+data[i].client_name+'</td>';
				$html+='<td>'+data[i].total+'</td>';
				$html+='<td>'+conditional(data[i].quarter1)+'</td>';
				$html+='<td>'+conditional(data[i].quarter2)+'</td>';
				$html+='<td>'+conditional(data[i].quarter3)+'</td>';
				$html+='<td>'+conditional(data[i].quarter4)+'</td>';
				$html+='<td ><select name="clientid['+data[i].id+']" class="assignclient" >'+option+'</select>';
				$html+='<td>'+data[i].added_on+'</td>';
				$html+='</tr>';
                
        }
        $html+='</tbody>';
		jQuery('.bootstraptablebody').html($html);
        
    }
	$(document).on('change','.assignclient',function(){
		var projectionId=$(this).attr('projection-id');
		var cur=$(this).val();
		if(cur!=''){
			
		}
	});
function showmatched(data)
    {
       
         jQuery('#myModalnew').modal('show');
        $html='<thead> <th>Id</th><th>Client Name</th><th>Social ORM Content</th> <th>Creative</th><th>Media Mobile SEM</th><th>SEO</th><th>PR</th><th>Content Marketing</th>  <th>Tech</th>  <th>Total</th>  </thead><tbody>';
        
        for(i=0;i<data.length; i++)
            {
                
                  $html+='<tr>';
                $html+='<td>'+data[i].id+'</td>';
                  $html+='<td>'+data[i].client_name+'</td>';
                  $html+='<td><input value="'+data[i].social_orm_content+'" name="updated['+data[i].id+'][social_orm_content]"></td>';
                  $html+='<td><input value="'+data[i].creative+'" name="updated['+data[i].id+'][creative]"></td>';
                  $html+='<td><input value="'+data[i].media_mobile_sem+'" name="updated['+data[i].id+'][media_mobile_sem]"></td>';
                   $html+='<td><input value="'+data[i].sco+'" name="updated['+data[i].id+'][sco]"></td>';
                  $html+='<td><input value="'+data[i].pr+'" name="updated['+data[i].id+'][pr]"></td>';
                  $html+='<td><input value="'+data[i].content_marketing+'" name="updated['+data[i].id+'][content_marketing]"></td>';
                 $html+='<td><input value="'+data[i].tech+'" name="updated['+data[i].id+'][tech]"></td>';
                 $html+='<td><input value="'+data[i].total+'" name="updated['+data[i].id+'][total]"></td>';
                 
               
               $html+='</tr>';
                
            } 
          $html+='</tbody>';
      
         $('.bootstraptablebodytotalmatch').html($html);
    }

</script>