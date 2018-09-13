<?php
/**
*	THIS FILE IS FOR ADMIN LOGIN LOGOUT	5/4/2014
**/
$fileBasePath = dirname(__FILE__).'/';
include_once('include/header.php');
include_once('include/sidebar.php');
/*
*	Redirect Admin To Home Page
*	If Already Logged In
*/
$client_approvel = new client_approvel();
$projectC = new category_estimate();
 $mformate = new mediadata();
   $project  = new project();
   $media_report = new media_report();

$Publisher  = new blogger();
	$allPublishers = $Publisher->all();
//dd($permissioninfo);
   //$cond="status = 1"
   //
if(isset($_POST['addmediaplan'])){
	$mediaObj=new pr_media();
	$mediaObj->blog = trim($_POST['blog']);
	$mediaObj->cross_sharing_posts = trim($_POST['crosssharingpost']);
	$mediaObj->social_stories = trim($_POST['socailstories']);
	$mediaObj->social_posts = trim($_POST['socalpost']);
	$mediaObj->engagement = trim($_POST['engagement']);
	$mediaObj->impression = trim($_POST['impression']);
	$mediaObj->rate = $_POST['rate'];
	$mediaObj->cost = $_POST['cost'];
	$mediaObj->publisher = $_POST['publisher'];
    $mediaObj->clientId = $_POST['clientId'];
	$mediaObj->campaignId = $_POST['campaignId'];
	$mediaObj->userId = $_POST['userId'];
	$mediaObj->permission = '1';
	$mediaObj->create();
	$_SESSION['msg'] = "Media Plan has been create successfully!";
	header('Location: ' . $_SERVER['HTTP_REFERER']);
	
}
$x = false;
    $z = false;
if(isset($_GET['action'])){
    
    switch ($_GET['action']) {
    case "requisition_to_invoice":
        $query =  " and reconciliation = 1 ";
            $allproject = $project->selectallEstimateWithQuery($query);
        break;
    case "pending_requisition_to_invoice":
        $query =  " and po_approvel = 1 and  reconciliation = 0 ";
            $allproject = $project->selectallEstimateWithQuery('6',$query);
        break;
    case "pending_po_approval":
        $allproject = $project->pending_po_approval_estimate_list();
        break;
    case "no_po":
        $allproject = $project->no_po_estimate_list();
        break;
    case "unconfirmed_estimate_requisitions":
        $query =  " and p.status = 0 ";
        $allproject = $project->selectallEstimateWithQuery('6',$query);
        break;
    case "rejected_pos":
        $query =  " and po_approvel = 2 ";
        $allproject = $project->selectallEstimateWithQuery('6',$query);
        break;
    case "partially_invoiced_estimates":
        $allproject = $project->partially_invoiced_estimates();
        break;
    case "invoiced": 
        $query =  " and p.process = 1 and  p.reconciliation = 1 ";
        $allproject = $project->selectallEstimateWithQuery('6',$query);
        break;
    case "active_project": 
        $allproject = $project->active_projects(6);
        break;
    default:
            $allproject = $project->selectPR();
}

}else{
        $allproject = $project->selectPR();
    }
if(isset($_GET['action'])){
    switch ($_GET['action']) {
    case "upcoming_project":
          $x = true;
        break;
    case "requisition_for_invoice":
         $z = true;
        break;
}

}

$estimate=new category_estimate();
$category = new Category();
 $company=new Partner();
 $commisonSection=new PartnerCommisionSection();

 $allCategories = $category->all();
 ////// Doc Approval function calling //////////////////////
 if(isset($_GET['po_approval'])){
   if(hasPermission('Approve_PO',$permissioninfo)){
        docApproval($_GET['id']);
        redirectAdmin('digitalPR.php');
      }
      else{
        redirectAdmin('digitalPR.php');
      }
}
///////// stop servise /////////////
if(isset($_GET['stop']))
{
	$sid = $_GET['stop'];
	$project->id=$sid;
	$project->process=1;
	$project->save();
	redirectAdmin('digitalPR.php');
}
////// Estimate creation function calling //////////////////////

if(isset($_GET['approval'])){
      if(hasPermission('create_estimate',$permissioninfo)){
      createEstimate($_GET['id'],$userinfo['email']);
      redirectAdmin('digitalPR.php');
    } else{
      redirectAdmin('digitalPR.php');
    }
}


////// Estimate deletion function calling //////////////////////

if(isset($_GET['delete'])){
      if(hasPermission('delete_estimate',$permissioninfo)){
      deleteEstimate($_GET['id']);
      redirectAdmin('digitalPR.php');
    } else{
      redirectAdmin('digitalPR.php');
    }
}

//////////// request for invoice /////////////////
if(hasPermission('Requision_Invoice',$permissioninfo)){
if(isset($_GET['formedia']))
{
	$sid = $_GET['formedia'];
	if(isEligibleForInvoice($sid)){
		$project->id=$sid;
		$project->reconciliation=1;
		$project->save();
	}
	redirectAdmin('digitalPR.php');
}
if(isset($_GET['fornonmedia']))
{
	$sid = $_GET['fornonmedia'];
	if(isEligibleForInvoiceForNonmedia($sid)){
		$project->id=$sid;
		$project->reconciliation=1;
		$project->save();
	}
	redirectAdmin('digitalPR.php');
}
}

//////////////// approvel report //////////////////////

if(hasPermission('approve_report',$permissioninfo)){
     if(isset($_GET['apporve_report']))
    {
        $id = $_GET['id'];
        $project->id=$id;
		$project->process=1;
		$project->save();
        redirectAdmin('digitalPR.php');
    }
    
}

//////////////// disapprovel PO with msg //////////////////////

if(hasPermission('Disapporve_Po',$permissioninfo)){
    if(isset($_POST['msg_send_reject_po']))
    {
        $id = $_POST['id_reject_po'];
        $msg = $_POST['msg_reject_po'];
       
        $project->id=$id;
		$project->po_approvel=2;
		$project->save();
        
        $issue_msg = new reconciliation_issue_msg();
        $arr = array('project_id' => $id );
     				$check_msg = $issue_msg->findCustom($arr);

     			if (empty($check_msg)) {
     			$issue_msg->project_id = $id;
                $issue_msg->msg = $msg;
                $issue_msg->active = 1; 
                $issue_msg->created_at = date('Y-m-d H:i:s');
                $issue_msg->column_name = 'Disapporve_PO';
                $issue_msg->create();
     			}else{
                $issue_msg = new reconciliation_issue_msg();
                $sql = "UPDATE reconciliation_issue_msg set active = 0 where project_id = ".$id;
                $result = $issue_msg->customQuery($sql);
              $issue_msg->project_id = $id;
              $issue_msg->msg = $msg;
              $issue_msg->active = 1;
              $issue_msg->created_at = date('Y-m-d H:i:s');
              $issue_msg->column_name = 'Disapporve_PO';
              $issue_msg->create();
     				}
    }
}



////////////// -------------------------------------------//////////////

//////////////// disapprovel report with msg //////////////////////

if(hasPermission('Disapporve_Report',$permissioninfo)){
    if(isset($_POST['msg_send']))
    {
        $id = $_POST['id'];
        $msg = $_POST['msg'];
        $project->id=$id;
		$project->process=2;
		$project->save();
        
        $issue_msg = new reconciliation_issue_msg();
        $arr = array('project_id' => $id );
     				$check_msg = $issue_msg->findCustom($arr);

     			if (empty($check_msg)) {
     			$issue_msg->project_id = $id;
                $issue_msg->msg = $msg;
                $issue_msg->active = 1; 
                $issue_msg->created_at = date('Y-m-d H:i:s');
                $issue_msg->column_name = 'Disapporve_Report';
                $issue_msg->create();
     			}else{
                $issue_msg = new reconciliation_issue_msg();
                $sql = "UPDATE reconciliation_issue_msg set active = 0 where project_id = ".$id;
                $result = $issue_msg->customQuery($sql);
              $issue_msg->project_id = $id;
              $issue_msg->msg = $msg;
              $issue_msg->active = 1;
              $issue_msg->created_at = date('Y-m-d H:i:s');
              $issue_msg->column_name = 'Disapporve_Report';
              $issue_msg->create();
     				}
    }
}



////////////// -------------------------------------------//////////////

if(isset($_POST['po']) || isset($_POST['pr'])){

     	 if(!empty($_FILES['filepo']) && !empty($_POST['id']) && !empty($_POST['porder']) && !empty($_POST['amount'])){
         $client_approvel = new client_approvel();
     			 $filename=$_FILES["filepo"]["tmp_name"];
     		 $filename  = basename($_FILES['filepo']['name']);
     		 $extension = pathinfo($filename, PATHINFO_EXTENSION);
     		 $new       = 'approvel'.date('m-d-Y_hia').'.'.$extension;
     		 $target_path = $_SERVER["DOCUMENT_ROOT"]."/fido/upload/uploadfile/".$new;
     		 if(move_uploaded_file($_FILES['filepo']['tmp_name'], $target_path)){
     		 $target_file = $target_path . basename($_FILES["filepo"]["name"]);
     		 		$arr = array('project_id' => $_POST['id'] );
     				$check_client_approvel = $client_approvel->findCustom($arr);

     				if (empty($check_client_approvel)) {
     					$client_approvel->project_id = $_POST['id'];
              $client_approvel->code = $_POST['porder'];
              $client_approvel->amt = $_POST['amount'];
                $client_approvel->img_path = $new;
                $client_approvel->active = 1;
                $client_approvel->create();
     				}else{
              $client_approvel = new client_approvel();
                $sql = "UPDATE project_client_approvel set active = 0 where project_id = ".$_POST['id'];
                $result = $client_approvel->customQuery($sql);
              $client_approvel->project_id = $_POST['id'];
              $client_approvel->code = $_POST['porder'];
              $client_approvel->amt = $_POST['amount'];
              $client_approvel->img_path = $new;
              $client_approvel->active = 1;
              $client_approvel->create();
     				}
     				//$_SESSION['msg'] = "Purchase order has been updated successfully";
     				//redirectAdmin('mediaClient.php');
     			}else {
     				
     			}

     		}


   }
   if(isset($_POST['uploadpo']))
   {
	    if(!empty($_FILES['filepo']) && !empty($_POST['pono'])){

			    $filename=$_FILES["filepo"]["tmp_name"];
				$filename  = basename($_FILES['filepo']['name']);
				$extension = pathinfo($filename, PATHINFO_EXTENSION);
				$new       = $_POST['id'].'.'.$extension;
				$target_path = $_SERVER["DOCUMENT_ROOT"]."/fido/upload/uploadfile/".$new;
				move_uploaded_file($_FILES['filepo']['tmp_name'], $target_path);
				$target_file = $target_path . basename($_FILES["filepo"]["name"]);
				$project->id = $_POST['id'];
	            $project->po_Images_url = $new;
	            $project->save();
				   $_SESSION['msg'] = "Purchase order has been updated successfully";
				   redirectAdmin('digitalPR.php');

		   }
		   $_SESSION['msg'] = "Upload PO order first";
				   redirectAdmin('digitalPR.php');
   }

   if(isset($_POST['upload'])){
       $client_approvel = new client_approvel();
	   $filename=$_FILES["filea"]["tmp_name"];
		$filename  = basename($_FILES['filea']['name']);
		$extension = pathinfo($filename, PATHINFO_EXTENSION);
		$new       = 'approvel'.date('m-d-Y_hia').'.'.$extension;
		$target_path = $_SERVER["DOCUMENT_ROOT"]."/fido/upload/uploadfile/".$new;
		//echo $target_path;
		move_uploaded_file($_FILES['filea']['tmp_name'], $target_path);
		$target_file = $target_path . basename($_FILES["filea"]["name"]);
		$arr = array('project_id' => $_POST['eid'] );
     				$check_client_approvel = $client_approvel->findCustom($arr);

     				if (empty($check_client_approvel)) {
     					$client_approvel->project_id = $_POST['eid'];
                $client_approvel->code = $_POST['porder'];
                $client_approvel->amt = $_POST['amount'];
                $client_approvel->img_path = $new;
                $client_approvel->active = 1;
                $client_approvel->create();
     				}else{
              $client_approvel = new client_approvel();
                $sql = "UPDATE project_client_approvel set active = 0 where project_id = ".$_POST['eid'];
                $result = $client_approvel->customQuery($sql);
              $client_approvel->project_id = $_POST['eid'];
              $client_approvel->code = $_POST['porder'];
              $client_approvel->amt = $_POST['amount'];
              $client_approvel->img_path = $new;
              $client_approvel->active = 1;
              $client_approvel->create();
     				}
		//redirectAdmin('digitalPR.php');
   }


// Instantiate the user class

	//_d($allSettings);
	?>
<style>
    .fa-times{
        color: #d53817;
    }
    .fa-check{
        color: #20d415;
    }
    .modal-header {
min-height: 41.43px;
}

.main-content .content-wrap .wrapper{position:static !important;}


.table-bordered > thead > tr > th, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > tbody > tr > td, .table-bordered > tfoot > tr > td{
	    border: 1px solid #e3e6f3;
}


.dataTables_wrapper .dataTables_paginate .paginate_button{
    padding: 0;
    margin-left: 0;
}

.dataTables_wrapper .dataTables_paginate .paginate_button:hover{
    border: 1px solid #fff;
	    background: none;
}


#usertable thead th, table.dataTable thead>tr>th.sorting_asc, table.dataTable thead>tr>th.sorting_desc, table.dataTable thead>tr>th.sorting, table.dataTable thead>tr>td.sorting_asc, table.dataTable thead>tr>td.sorting_desc, table.dataTable thead>tr>td.sorting{
	padding: 5px 5px 5px 5px !important;}
	
	
.fixedHeader-floating thead th:nth-child(1) , #usertable thead tr th:nth-child(1){
	    width:80px !important;
		min-width:80px !important;
}

.fixedHeader-floating thead th:nth-child(9) , #usertable thead tr th:nth-child(9){
	    width:90px !important;
		min-width:90px !important;
}	

 .fixedHeader-floating thead tr th .src_inpt input,  #usertable thead tr th .src_inpt input{
    width: 80% !important;
    min-width: 80% !important;
    padding: 5px 3px 4px 2px;
    font-size: 9px;
	margin-top:5px;
 }
 
.sortMask {
    width: 20px;
    height: 100%;
    float: right;
    display: inline-block;
    z-index: 9;
    /* margin-right: -19px; */
    /* background: red; */
    position: absolute;
    right: 0;
    top: 0;
}

table.dataTable thead .sorting:after, table.dataTable thead .sorting_asc:after, table.dataTable thead .sorting_desc:after, table.dataTable thead .sorting_asc_disabled:after, table.dataTable thead .sorting_desc_disabled:after{
    right: 3px !important;
}

</style>
    <section style="font-size: 11px; color:black;" class="main-content">
        <!-- content wrapper -->
        <div class="content-wrap">
            <!-- inner content wrapper -->
            <div class="wrapper">
                <section class="content-header" style="margin-bottom: 10px;">
                    <h1>
						Digital PR
					</h1>
                    
                    <div class="row">
                        <a style="float: right;margin-right: 16px;" class="btn btn-success btn-sm" href="addProject.php"><i class="fa fa-plus-square" aria-hidden="true"></i> CREATE ESTIMATE REQUSITION</a>
                  </div>
                </section>
                
                <section class="panel panel-default">
                    
                    <div class="alert alert-info" role="alert">
                      <a class="toggle-vis btn btn-primary btn-xs" onclick="myFunctionForClass(this)" data-column="0"><span class="glyphicon-plus glyphicon" aria-hidden="true"></span> S.No</a> -
                      <a class="toggle-vis btn btn-primary btn-xs" onclick="myFunctionForClass(this)" data-column="1"><span class="glyphicon-plus glyphicon" aria-hidden="true"></span> Estimate No</a> -
                      <a onclick="myFunctionForClass(this)" class="toggle-vis btn btn-primary btn-xs" data-column="2"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Client</a> -
                      <a onclick="myFunctionForClass(this)" class="toggle-vis btn btn-primary btn-xs" data-column="3"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Project Name</a> -
                      <a onclick="myFunctionForClass(this)" class="toggle-vis btn btn-primary btn-xs" data-column="4"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Service</a> -
                      <a onclick="myFunctionForClass(this)" class="toggle-vis btn btn-primary btn-xs" data-column="5"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>Estimate Value</a> -
                      <a onclick="myFunctionForClass(this)" class="toggle-vis btn btn-primary btn-xs" data-column="6"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Document</a> -
                     <a onclick="myFunctionForClass(this)" class="toggle-vis btn btn-primary btn-xs" data-column="7"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>PO/PR/Signed Estimate Approval</a>
                    <a onclick="myFunctionForClass(this)" class="toggle-vis btn btn-primary btn-xs" data-column="8"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>Report</a>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive no-border" style="overflow-x: auto;">
                            
                            <table id='usertable' class="display table table-bordered table-striped mg-t datatable editable-datatable">
                            <thead> 
                                <tr><th>S.No.<div class="src_inpt"></div><div class="sortMask"></div> </th>
                                    <th>Estimate No <div class="src_inpt"></div><div class="sortMask"></div></th>
                                    <th>Client <div class="src_inpt"></div><div class="sortMask"></div></th>
                                    <th>Project Name <div class="src_inpt"></div><div class="sortMask"></div></th>
                                    <th>Service <div class="src_inpt"></div><div class="sortMask"></div></th>
                                    <th>Estimate Value <div class="src_inpt"></div><div class="sortMask"></div></th>
                                    <th style="text-align:Center;vertical-align:middle">Document <div class="sortMask"></div></th>
                                    <th style="text-align:Center;vertical-align:middle">PO/PR/Signed Estimate Approval<div class="sortMask"></div></th>
                                    <th style="text-align:Center;vertical-align:middle">Report<div class="sortMask"></div></th>
                                    <th class="widthSort">Action</th>
                                </tr>
                            </thead>
                <tbody>
                    <?php $chk_po = false; $i=1;
                    foreach($allproject as $k=>$projectData){
                        
                        if($x && $projectData['po_approvel'] ==1)continue;
                        if($z && ($projectData['process'] !=1 || $projectData['reconciliation'] == 1))continue;
                        
                        $com;
                        $dat = explode(" ", $projectData['created_at']);
                        ?>
                        <tr><td><?php echo $i; ?></td>
                            <td> <a class="show_estimate_link" target="_blank" href="<?php echo $config['SITE_URL']."estimatePdf.php?id=".$projectData['id'];?>"><b><?php echo $projectData['W_O']; ?></b></a> </td>
                            <td>
                                <?php echo $projectData['partner_name']; ?>
                            </td>
                            <td>
                                <?php echo $projectData['project_name']; ?>
                            </td>
                            <td>
                                <?php
                                $cat_chk=0;
                                $val=$projectC->findCustom(array('project_id'=>$projectData['id']));

                            foreach($val as $j=>$catId){
                            $catv=$projectC->catValue($catId['project_cat_id']);
                      if ($catId['project_cat_id'] == 2) {
                        $cat_chk=1;
                      }
                    echo $catv[0]['name']."<br>";
                    }
                    ?>
                    </td>
                    <td>
                        <?php echo $mformate->numberToCurrency($projectData['totalprice']); ?>
                    </td>
                    <td style="text-align: center;">
            <?php 
            $cond = "project_id = ".$projectData['id']." and active = 1";
            $res = $client_approvel->findWhere($cond);
            if (!empty($res)) {
                  $chk_po = true;

	echo'<input  class="imgval" type="hidden" value="'.$res[0]['img_path'].'">';
	echo '<a class="imgshow" onclick="f2(this)" data-toggle="modal" data-target="#slipimg" href="javascript:;"><i class="fa fa-file-pdf-o fa-2x"></i></a>';
    if(hasPermission('upload_po',$permissioninfo) && $projectData['po_approvel']==2){
		            echo '<div class="btn-group" style="margin-left: 11px;margin-top: -8px;">
					<input type="hidden" value="'.$projectData['id'].'" class="hval" >
					<input type="hidden" value="'.$projectData['P_O'].'" class="poval" >
                                        <button type="button" class="btn btn-success btn-xs dropdown-toggle" data-toggle="dropdown" style="width: 96%;">Upload
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu pull-right" role="menu">
                                            <li>
                                                <a href="javascript:;" data-toggle="modal" data-target="#myModal" onclick="f1(this)" class="pero" ><i class="fa fa-upload"> P.O. Number</i></a>
                                            </li>
                                            <li>
                                                <a href="javascript:;" data-toggle="modal" onclick="f1(this)" data-target="#myyModal"><i class="fa fa-upload"> Sign Estimate</i>/PO</a>
                                            </li>
                                            <li>
                                                <a href="javascript:;" data-toggle="modal" data-target="#myyyModal" onclick="f1(this)" ><i class="fa fa-upload"> P.R.</i></a>
                                            </li>
                                        </ul>
                        </div>';
					}
} else { $chk_po = false; 
					if(hasPermission('upload_po',$permissioninfo)){
		            echo '<div class="btn-group" style="width: 105%;">
					<input type="hidden" value="'.$projectData['id'].'" class="hval" >
					<input type="hidden" value="'.$projectData['P_O'].'" class="poval" >
                                        <button type="button" class="btn btn-success btn-xs dropdown-toggle" data-toggle="dropdown" style="width: 96%;">Action to Upload
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu pull-right" role="menu">
                                            <li>
                                                <a href="javascript:;" data-toggle="modal" data-target="#myModal" onclick="f1(this)" class="pero" ><i class="fa fa-upload"> P.O. Number</i></a>
                                            </li>
                                            <li>
                                                <a href="javascript:;" data-toggle="modal" onclick="f1(this)" data-target="#myyModal"><i class="fa fa-upload"> Sign Estimate</i>/PO</a>
                                            </li>
                                            <li>
                                                <a href="javascript:;" data-toggle="modal" data-target="#myyyModal" onclick="f1(this)" ><i class="fa fa-upload"> P.R.</i></a>
                                            </li>
                                        </ul>
                        </div>';
					}
        } 
?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                if($chk_po){
                                                if($projectData['po_approvel']==2){ ?>
                                                  <i aria-hidden="true" class="fa fa-times fa-2x"></i>
                                              <?php  } 
                                                    if($projectData['po_approvel']==1) {  ?>
                                                  <i class="fa fa-check fa-2x" aria-hidden="true"></i>
                                              <?php  }
                                                    if($projectData['po_approvel']==0) {  ?>
                                                  <i class="fa fa-clock-o fa-spin fa-2x fa-fw" aria-hidden="true"></i>
                                              <?php  }
                                            } else {
                                              echo '<i class="fa fa-clock-o fa-spin fa-2x fa-fw" aria-hidden="true"></i>';
                                            }
                                              ?>
                                              </td>
                                              <td style="text-align: center;"><?php  if ($cat_chk) {
                                                   $sqlarray = array('media_id' => $projectData['id'],'active' =>1  );
                                                $res = $media_report->findCustom($sqlarray);
                                                if (empty($res)) {
                                                  	echo '<i class="fa fa-clock-o fa-spin fa-2x fa-fw" aria-hidden="true"></i>';
                                              	} else {
                                     $target_path =$config['SITE_URL']."/upload/upload_report_media/".$res[0]['report'];
                                                
                                                  switch ($projectData['process']) {
                                                    case 1:
                                                        echo '<i class="fa fa-check-square fa-lg" aria-hidden="true"></i>';
                                                        break;
                                                    case 0:
                                                        echo '<i class="fa fa-thumbs-down fa-lg fa-fw" aria-hidden="true"></i>';
                                                        break;
                                                    case 2:
                                                        echo '<i class="fa fa-clock-o fa-spin fa-lg fa-fw" aria-hidden="true"></i>';
                                                        break;
                                                }
                                                    ?>
                                             <a target="_blank" href="<?php echo $target_path; ?>" ><i class="fa fa-external-link fa-lg" aria-hidden="true"></i></a>
                                      <?php    }
                                    } else {
                                                  switch ($projectData['process']) {
                                                    case 1:
                                                        echo '<i class="fa fa-check-square fa-2x" aria-hidden="true"></i>';
                                                        break;
                                                    case 0:
                                                        echo '<i class="fa fa-thumbs-down fa-2x fa-fw" aria-hidden="true"></i>';
                                                        break;
                                                    case 2:
                                                        echo '<i class="fa fa-clock-o fa-spin fa-2x fa-fw" aria-hidden="true"></i>';
                                                        break;
                                                }

                                    }
                                    ?> </td>
                                              <td>
                                <?php if($projectData['reconciliation'] == 0){ ?>

                            <div class="dropdown drpDwn_cstm">
                              <button class="btn btn-default dropdown-toggle btn-xs" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                Action
                                <span class="caret"></span>
                              </button>
                              <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                  <li>
                    <input type="hidden" value="<?php echo $projectData['id'] ?>" class="pid" >
					<input type="hidden" value="<?php echo $projectData['companyid'] ?>" class="pcid" >
                                      <a  class="addmedia" onclick="f4(this)" href="javascript:;" >Add Media Plan</a></li>
                                <?php if(hasPermission('delete_estimate',$permissioninfo)){ ?>
                                <li><a onclick="return confirm('Are you sure?');" href="<?php echo $config['SITE_URL']."digitalPR.php?delete=1&id=".$projectData['id'];?>">Cancel</a></li>
                                <?php }
                                if(hasPermission('edit_estimate',$permissioninfo) && $chk_po == false){ ?>
                                <li>	<a  href="<?php echo $config['SITE_URL']."editProject.php?id=".$projectData['id'];?>">Edit</a></li>
                                <?php }
                                if(hasPermission('create_estimate',$permissioninfo) && $projectData['W_O'] ==''){ ?>
                                <li><a href="<?php echo $config['SITE_URL']."digitalPR.php?approval=1&id=".$projectData['id'];?>">Approve Estimate</a></li>
                                <?php } ?>
                                  <?php if($projectData['W_O'] ==''){?>
                                  <li role="separator" class="divider"></li>
                                <li><a target="_blank"  href="<?php echo $config['SITE_URL']."actionpdf.php?id=".$projectData['id'];?>">Requisition Slip</a></li>
                                <?php
                                    }
                                if($chk_po){
                                if($projectData['po_approvel']==0){
                                if(hasPermission('Approve_PO',$permissioninfo)){ ?>
                                <li><a href="<?php echo $config['SITE_URL']."digitalPR.php?po_approval&id=".$projectData['id'];?>">Approve PO</a></li>
                                  <input type="hidden" value="<?php echo $projectData['id']; ?>" class="hval" >
                                  <li>
                                    <a href="javascript:;" data-toggle="modal" data-target="#formsg_reject_po" onclick="f1(this)" >Disapporve PO</a>
                                </li>
                                  <?php }
                                }
                              }
                              if(hasPermission('Requision_Invoice',$permissioninfo)){
                               if ($cat_chk) {
                                 if(isEligibleForInvoice($projectData['id'])){ ?>
                                   <li><a data-toggle="tooltip" data-placement="top" title="Do ensure that all the reports have been checked." href="<?php echo $config['SITE_URL']."digitalPR.php?&formedia=".$projectData['id'];?>">Send Requisition for Invoice</a></li>
                               		<?php } else { ?>
                               			<li class="disabled" ><a href="javascript:;">Send Requisition for Invoice</a></li>
                                <?php  }
                               }
                               else {
                                 if(isEligibleForInvoiceForNonmedia($projectData['id'])){ ?>
                                   <li><a data-toggle="tooltip" data-placement="top" title="Do ensure that all the reports have been checked." href="<?php echo $config['SITE_URL']."digitalPR.php?&fornonmedia=".$projectData['id'];?>">Send Requisition for Invoice</a></li>
                               		<?php } else { ?>
                               			<li class="disabled" ><a href="javascript:;">Send Requisition for Invoice</a></li>
                                 <?php }
                               }
                             }
                            if($cat_chk) {
                            if(hasPermission('Disapporve_Report',$permissioninfo)){ 
                                ?>
                                  <input type="hidden" value="<?php echo $projectData['id']; ?>" class="hval" >
                                <li>
                                    <a href="javascript:;" data-toggle="modal" data-target="#formsg" onclick="f1(this)" >Disapporve Report</a>
                                </li>
                           <?php }
                        if(hasPermission('approve_report',$permissioninfo)){ 
                                ?>
                                <li>
                                    <a href="<?php echo $config['SITE_URL']."digitalPR.php?apporve_report=1&id=".$projectData['id'];?>">Approve Report</a>
                                </li>
                                  
                           <?php } 
                            }
                            if($userinfo['type'] == 14 && $projectData['request_date'] == 1){
                               ?>
                                  <input type="hidden" value="<?php echo $projectData['id']; ?>" class="hval" >
                                  <input type="hidden" value="<?php echo $projectData['project_start']; ?>" class="sdate_est" >
                                  <input type="hidden" value="<?php echo $projectData['project_end']; ?>" class="edate_est" >
                                  <input type="hidden" value="<?php echo $projectData['W_O']; ?>" class="est_no" >
                                 <li>
                                     <a href="javascript:;" data-toggle="modal" data-target="#change_date_request" onclick="f1(this)" >Change Date</a>
                                </li> 
                            <?php } ?>
                                   <?php if($projectData['po_approvel']==1 && $projectData['reconciliation']==0) { ?>
                                  <li>
                                      <a onclick="return confirm('Are you sure?');" href="<?php echo $config['SITE_URL']."digitalPR.php?stop=".$projectData['id'];?>">Done</a>
                                  </li>
                                      <?php } else { ?>
                                  <li class="disabled">
                                        <a data-toggle="tooltip" data-placement="top" title="PO not approved"  href="javascript:;">Done</a>
                                  </li>
                                   <?php } ?>
                              </ul>
                            </div>
                               <?php }else{ ?> 
                                              
                                    <i data-toggle="tooltip" data-placement="top" title="Process Complete" class="fa fa-archive fa-2x" aria-hidden="true"></i> 
                                                
                                <?php  } ?>
                          </td>
                                        </tr>
                                        <?php
                                        $i++;
	                                   }
										?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
            <!-- /inner content wrapper -->
        </div>
        <!-- /content wrapper -->
        <a class="exit-offscreen"></a>
    </section>
    <script type="text/javascript">
        function f4(h){
            var a = $(h).closest('li').find('.pid').val();
            var b = $(h).closest('li').find('.pcid').val();
            $('#pid').val(a);
            $('#pcid').val(b);
        }
        function f1(h) {

            var a = $(h).closest('td').find('.hval').val();
            var b = $(h).closest('td').find('.poval').val();
            var sdate_est = $(h).closest('td').find('.sdate_est').val();
            var edate_est = $(h).closest('td').find('.edate_est').val();
            var est_no = $(h).closest('td').find('.est_no').val();
            //var b = h.getAttribute('value');
            //var c = b + "&povalue=" + a;
            //$(h).closest('tr').find('.spo').attr("href", c);
            $('#op').val(a);
            $('#po').val(a);
            $('#opr').val(a);
            $('#eop').val(a);
            $('#formsg_id').val(a);
            $('#formsg_po').val(a);
            $('#formsg_change_date_request').val(a);
            $('#pono').val(b);
            $('#sd').val(sdate_est);
            $('#ed').val(edate_est);
            $("#change_date_request").find('#myModalLabel').html(est_no);
            $("#change_date_request").find('.datepicker-text').datepicker({
        autoclose:true,
        format: 'yyyy-mm-dd'
        });
            //alert(a);
        }

        function f2(h) {
            var a = $(h).closest('td').find('.imgval').val();
            var c = "https://armworldwide.com/fido/upload/uploadfile/" + a;
            var res = a.split(".");
            if (res[1] == "pdf") {
                $('#slipimg').find(".modal-body").html("<object type='application/pdf' width='580' height='800' data='" + c + "'></object>");
            }
            else {
                $('#slipimg').find('.modal-body').html('<img src="' + c + '">');
                //$('#slipimgs').attr("src",c);
                //$(h).closest('tr').find('.spo').attr("href", c);
            }
            //var b = h.getAttribute('value');
            //alert(a);
        }
        $('.modal').on('hidden.bs.modal', function (e) {
          console.log("yes");
            $(this).find('.modal-body').html("");
        })
        $('.modal').on('hidden.bs.modal', function (e) {
          console.log("yes");
            $(this).find('.modal-body').html("");
        })
        $('.modal').on('hidden.bs.modal', function (e) {
          console.log("yes");
            $(this).find('.modal-body').html("");
        })
        $('.modal').on('hidden.bs.modal', function (e) {
          console.log("yes");
            $(this).find('.modal-body').html("");
        })
    </script>
    <script type="text/javascript">
        function checkdata(a, b) {
            var ok = true;
            if (a == '') {
                ok = false;
            }
            if (ok) $(b).closest('tr').find('.spo').removeAttr("disabled");
            else $(b).closest('tr').find('.spo').attr("disabled", "disabled");
        }
        $(document).ready(function () {
            $(".spo").attr("disabled", "disabled");
            $("#usertable :input").blur(function () {
                var c = $(this).val();
                //alert(c);
                checkdata(c, this);
            });
        });
    </script>
    <script>
    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    })
    $(document).on('click','.addmedia',function(){
		$('#addMediaModal').modal('show');
	});
    </script>

<script src="asset/js/bootstrap-datatables.js"></script>
    <?php
include_once('include/footer.php');
if($userinfo['type'] == 211111){ ?>
<script>
    $(".content-wrap").find(".remove_ele_for_user").remove();
    
</script>
<?php } ?>
        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Purchase Order</h4> </div>
                    <div class="modal-body">
                        <form method="post" action="digitalPR.php" enctype="multipart/form-data">
                            <div class="form-group">
                              <label for="exampleInputFile">Enter Code</label>
                                <input type="text" class="form-control" name="porder" id="exampleInputEmail1" placeholder="Purchase Order" required>
                            </div>
                            <div class="form-group">
                              <label for="exampleInputFile">Enter Amount</label>
                                <input type="text" class="form-control" name="amount" id="exampleInputEmail1" placeholder="Amount" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">Upload PO</label>
                                <input type="file" id="exampleInputFile" name="filepo" required accept="application/pdf">
                                <p class="help-block">Upload PO Here.</p>
                            </div>
                            <input type="hidden" name="id" id="op" value="">
                          </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-default" name="po">Submit</button>
                        </form>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="myyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Sign Estimate</h4> </div>
                    <div class="modal-body">
                        <form method="post" action="digitalPR.php" enctype="multipart/form-data">
                            <div class="form-group">
                              <label for="exampleInputFile">Enter Code</label>
                                <input type="text" class="form-control" name="porder" id="exampleInputEmail1" placeholder="Purchase Order" required>
                            </div>
                            <div class="form-group">
                              <label for="exampleInputFile">Enter Amount</label>
                                <input type="text" class="form-control" name="amount" id="exampleInputEmail1" placeholder="Amount" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">upload</label>
                                <input type="file" id="exampleInputFile" name="filea" required accept="application/pdf">
                                <p class="help-block">Upload Sign Estimate Here.</p>
                            </div>
                            <input type="hidden" name="eid" id="eop" value=""> </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-default" name="upload">Submit</button>
                        </form>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <!-- Modal -->
        <div class="modal fade" id="myyModalpo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Sign PO</h4> </div>
                    <div class="modal-body">
                        <form method="post" action="digitalPR.php" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="exampleInputFile">upload</label>
                                <input type="file" id="exampleInputFile" name="filepo" required accept="application/pdf">
                                <p class="help-block">Upload Sign PO Here.</p>
                            </div>
                            <input type="hidden" name="id" id="po" value="">
                            <input type="hidden" name="pono" id="pono" value=""> </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-default" name="uploadpo">Submit</button>
                        </form>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="myyyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Purchase Reference</h4> </div>
                    <div class="modal-body">
                        <form method="post" action="digitalPR.php" enctype="multipart/form-data">
                          <div class="form-group">
                            <label for="exampleInputFile">Enter Purchase Reference Code</label>
                              <input type="text" class="form-control" name="porder" id="exampleInputEmail1" placeholder="Purchase Reference" required>
                          </div>
                          <div class="form-group">
                            <label for="exampleInputFile">Enter Amount</label>
                              <input type="text" class="form-control" name="amount" id="exampleInputEmail1" placeholder="Amount" required>
                          </div>
                          <div class="form-group">
                              <label for="exampleInputFile">Upload PR</label>
                              <input type="file" id="exampleInputFile" name="filepo" required accept="application/pdf">
                              <p class="help-block">Upload PR Here.</p>
                          </div>
                            <input type="hidden" name="id" id="opr" value=""> </div>
                    <div class="modal-footer">
                        <button type="submit" name="pr" class="btn btn-default">Submit</button>
                        </form>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal for img show  -->
        <div class="modal fade" id="slipimg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel"></h4> </div>
                    <div class="modal-body">
                        <!-- Data will come here VIA JS -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

<div class="modal fade" id="formsg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel"></h4> </div>
                    <div class="modal-body">
                        <form method="post" action="digitalPR.php" >
                          
                          <div class="form-group">
                            <label for="exampleInputFile">Enter Text</label>
                              <textarea name="msg" class="form-control" rows="3"></textarea>
                          </div>
                          
                            <input type="hidden" name="id" id="formsg_id" value=""> </div>
                    <div class="modal-footer">
                        <button type="submit" name="msg_send" class="btn btn-default">Submit</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
</div>
<div class="modal fade" id="formsg_reject_po" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel"></h4> 
            </div>
        <div class="modal-body">
            <form method="post" action="digitalPR.php" >

                <div class="form-group">
                <label for="exampleInputFile">Enter Message For Team </label>
                <textarea name="msg_reject_po" class="form-control" rows="3"></textarea>
                </div>

            <input type="hidden" name="id_reject_po" id="formsg_po" value=""> 
            </div>
            <div class="modal-footer">
            <button type="submit" name="msg_send_reject_po" class="btn btn-default">Submit</button>
            </form>
        </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="change_date_request" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel"></h4> 
            </div>
        <div class="modal-body">
            <form action=" " id="date_change_form">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleInputFile">Start Date</label>
                            <input type="text" name="sdate" id="sd" class="form-control datepicker-text">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleInputFile">End Date</label>
                            <input type="text" name="edate" id="ed" class="form-control datepicker-text">
                        </div>
                    </div>
                </div>
            <input type="hidden" name="change_date_request_id" id="formsg_change_date_request" value="">
                </form>
            </div>
            <div class="modal-footer">
            <div style="float: left;font-size: 13px;font-weight: bold;" id="result_show"></div>
            <a href="javascript:;" id="send_change_date_request" class="btn btn-default">Submit</a>
        </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
    <script>
    $('#send_change_date_request').click(function(){
        var form_value = $("#date_change_form").serialize();
        console.log(form_value);
            $.ajax
            ({
                url: 'ajax.php?action=change_est_date',
                data: form_value,
                type: "POST",
                dataType: "json",
                cache: false, 
                success: function(result)
                {
                  if(result.success == 'true'){ 
                      $("#result_show").html(result.msg);
                  }
                else{

                    }
                }
            });
});
    </script>
</div>
<div id="addMediaModal" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
	<form method="post" action="" id="mediaPlanForm">
	<div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Media Plan</h4>
      </div>
      <div class="modal-body">
	  
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group">
					<label><strong>Blog/Article</strong></label><br/>
					<input name="blog" type="text" class="form-control" required>
				</div>
				<div class="form-group">
					<label><strong>Cross sharing posts</strong></label><br/>
					<input name="crosssharingpost" type="text" class="form-control" required>
				</div>
				<div class="form-group">
					<label><strong>Social stories</strong></label><br/>
					<input name="socailstories" type="text" class="form-control" required>
				</div>
                <div class="form-group">
					<label><strong>Social posts</strong></label><br/>
					<input name="socalpost" type="text" class="form-control" required>
				</div>
                <div class="form-group">
					<label><strong>Cost</strong></label><br/>
					<input name="cost" type="text" class="form-control" required>
				</div>
				
			</div>
			<div class="col-sm-6">	
            	<div class="form-group">
					<label><strong>Engagement</strong></label><br/>
					<input name="engagement" type="text" class="form-control" required>
				</div>
				<div class="form-group">
					<label><strong>Impression</strong></label><br/>
					<input name="impression" type="text" class="form-control" required>
				</div>
				<div class="form-group">
					<label><strong>Rate</strong></label><br/>
					<input name="rate" type="number" onkeypress="return isNumberKey(event)" class="form-control" required>
                    <input type="hidden" name="clientId" id="pcid" value="">
                    <input type="hidden" name="campaignId" id="pid" value="">
                    <input type="hidden" name="userId" value="<?php echo $userinfo['id']; ?>">
				</div>
				<div class="form-group">
					<label><strong>Publisher</strong></label><br/>
					<select name="publisher" class="form-control" required>
					<option value="">Select Blogger</option>
					<?php foreach($allPublishers as $keys=>$values){ ?>
					<option value='<?php echo $values['id'] ?>' ><?php echo $values['publisher_name'] ;?></option>
					<?php } ?>
					</select>
					
				</div>
			</div>
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		
        <button type="submit" name="addmediaplan"  id="addmediaplan" class="btn btn-primary btn-success">Add Media Plan</button>
      </div>
    </div>
	</form>
  </div>
  </div>

