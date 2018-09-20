<?php include('include/header-files.php'); ?>


<!-- write your custom css and js here -->
<style>
.fa, .toggle_drpdown i{color: #909090;}

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

.rightApp_btn a i{
    font-size: 15px;
    border: 1px solid gainsboro;
    width: 22px;
    height: 19px;
    margin-right: 5px;
    line-height: 20px;
    top: 0 !important;
}

</style>


<!-- write your custom css and js here -->

<!-- Header begins -->
<?php include('include/header-new.php'); ?>

<?php
$fileBasePath = dirname(__FILE__).'/';


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); 

$client_approvel = new client_approvel();
$projectC = new category_estimate();
 $mformate = new mediadata();
   $project  = new project();
   $media_report = new media_report();
   //$cond="status = 1"
   //




if(isset($_GET['action'])){
    switch ($_GET['action']) {
    case "requisition_to_invoice":
            $allproject = $project->requisition_to_invoice();
        break;
    case "pending_requisition_to_invoice":
        $query =  " and process = 1 and po_approvel = 1 and  reconciliation = 0 ";
            $allproject = $project->selectallEstimateWithQuery('',$query);
        break;
    case "pending_po_approval":
        $allproject = $project->pending_po_approval_estimate_list();
        break;
    case "no_po":
        $allproject = $project->no_po_estimate_list();
        break;
    case "unconfirmed_estimate_requisitions":
        $query =  " and p.status = 0 ";
        $allproject = $project->selectallEstimateWithQuery('',$query);
        break;
    case "rejected_pos":
        $query =  " and p.po_approvel = 2 ";
        $allproject = $project->selectallEstimateWithQuery('',$query);
        break;
    case "po_approved_but_no_media_uploaded":
        $allproject = $project->po_approved_but_no_media_uploaded();
        break;
    case "media_plan_but_no_report_uploaded":
        $allproject = $project->media_plan_but_no_report_uploaded();
        break;
    case "rejected_reports":
        $query =  " and p.process = 2 ";
        $allproject = $project->selectallEstimateWithQuery('',$query);
        break;
    case "partially_invoiced_estimates":
        $allproject = $project->partially_invoiced_estimates();
        break;
    case "invoiced_estimates": 
        $allproject = $project->invoiced_estimates();
        break;
    case "pending_estimates_requisition": 
        $query =  " and p.status = 0  ";
        $allproject = $project->selectallEstimateWithQuery('',$query);
        break;
    case "approved_estimates": 
        $query =  " and p.status = 1  ";
        $allproject = $project->selectallEstimateWithQuery('',$query);
        break;
    case "pending_invoice": 
        $allproject = $project->selectallEstimateWithPendinginvoice();
        break;
}

}else{
    if($userinfo['type'] == 2){
        $allproject = $project->selectallforBSteam($userinfo['id']);
    }
    else{
        $allproject = $project->selectallEstimateWithQuery();
    }
}



$estimate=new category_estimate();
$category = new Category();
 $company=new Partner();
 $commisonSection=new PartnerCommisionSection();

////// Split invoice //////////////////////

if(isset($_POST['split_service'])){
    foreach($_POST['service'] as $k=>$v)
    {
        $projectC->id = $v;
        $projectC->reconciliation = 1;
        $projectC->approve = 1;
        $projectC->save();
    }
    $sqlarray = array('project_id' => $_POST['pro_row'],'reconciliation' => 0  );
    $val=$projectC->findCustom($sqlarray);
    if(count($val) == 0)
    {
        $project->id = $_POST['pro_row'];
        $project->reconciliation = 1;
        $project->process = 1;
        $project->save();
        
    }
    redirectAdmin('estimate.php');
    
}


 $allCategories = $category->all();
 ////// Doc Approval function calling //////////////////////
 if(isset($_GET['po_approval'])){
   if(hasPermission('Approve_PO',$permissioninfo)){
        docApproval($_GET['id']);
         $project  = new project();
         $user = new User();
        $projectDetails = $project->findCustom(array('id' => $_GET['id'] ));
         $clientDetails = $company->findCustom(array('id' => $projectDetails[0]['clientid'] ));
        $useremail = $user->getUserDetail($projectDetails[0]['userid']);

/*    sending mail to the BS and Service/Media team */      
       $message='';
        $message.= "The PO uploaded against the Estimate <strong>".$projectDetails[0]['W_O']."</strong> has been Approved.<br>";
        $urlforservice = ($config['API_BASE_URL']."sendmail");

        $data['email']=$useremail[0]['email'];
        $data['name']=$useremail[0]['name'];
        $data['msg']=$message;
        $data['subject'] ='New PO Approved';
        $services = postCURL($urlforservice,$data);
       

/*    sending mail to the BS and Service/Media  team */ 
       
       
                 $cmcnt = "<strong>".$userinfo['name']."</strong> has <strong>approved</strong> the document for project name <strong>".$projectDetails[0]['project_name']."</strong> and estimate no <strong>".$projectDetails[0]['W_O']."</strong>";
                 saveNotification($projectDetails[0]['userid'],$cmcnt,0,$projectDetails[0]['W_O'],1);
        redirectAdmin('estimate.php');
      }
      else{
        redirectAdmin('estimate.php');
      }
}
////// Estimate creation function calling //////////////////////

if(isset($_GET['approval'])){
      if(hasPermission('create_estimate',$permissioninfo)){
      createEstimate($_GET['id'],$userinfo['name']);
      redirectAdmin('estimate.php');
    } else{
      redirectAdmin('estimate.php');
    }
}


////// Estimate deletion function calling //////////////////////

if(isset($_GET['delete'])){
      if(hasPermission('delete_estimate',$permissioninfo)){
      deleteEstimate($_GET['id']);
      redirectAdmin('estimate.php');
    } else{
      redirectAdmin('estimate.php');
    }
}

//////////// request for invoice /////////////////
if(hasPermission('Requision_Invoice',$permissioninfo)){
if(isset($_GET['formedia']))
{
  $sid = $_GET['formedia'];
  if(isEligibleForInvoice($sid)){
        $projectC = new category_estimate();
        $sql = "UPDATE project_estimate_detail SET reconciliation = 1 WHERE project_id = ".$sid;
        $projectC->customQuery($sql);
        
    $project->id=$sid;
    $project->reconciliation=1;
    $project->save();
        
        $project  = new project();
         $user = new User();
        $projectDetails = $project->findCustom(array('id' => $sid ));
         $clientDetails = $company->findCustom(array('id' => $projectDetails[0]['clientid'] ));
        $useremail = $user->getUserDetail($projectDetails[0]['userid']);

/*    sending mail to the BS and Service/Media team */      
       $message='';
        $message.= "There is a new Requisition  for Invoice against the Estimate <strong>".$projectDetails[0]['W_O']."</strong>.<br>";
        $message.='Please visit FIDO to create a Invoice against it.';
        $urlforservice = ($config['API_BASE_URL']."sendmail");

        $data['email']="tapan.kharbanda@armworldwide.com";
        $data['name']="Tapan";
        $data['msg']=$message;
        $data['subject'] ='New Invoice Requisition';
        $services = postCURL($urlforservice,$data);
       

/*    sending mail to the BS and Service/Media  team */ 
        
         $projectDetails = $project->findCustom(array('id' => $sid ));
         $cmcnt = "<strong>".$userinfo['name']."</strong> has placed a <strong>requisition for an invoice</strong> against the estimate no <strong>".$projectDetails[0]['W_O']."</strong>";
         saveNotification(6,$cmcnt,0,$projectDetails[0]['W_O'],1);
  }
  redirectAdmin('estimate.php');
}
if(isset($_GET['fornonmedia']))
{
  $sid = $_GET['fornonmedia'];
  if(isEligibleForInvoiceForNonmedia($sid)){
        $projectC = new category_estimate();
        $sql = "UPDATE project_estimate_detail SET reconciliation = 1 WHERE project_id = ".$sid;
        $projectC->customQuery($sql);
        
    $project->id=$sid;
    $project->reconciliation=1;
    $project->save();
        
        $project  = new project();
         $user = new User();
        $projectDetails = $project->findCustom(array('id' => $sid ));
         $clientDetails = $company->findCustom(array('id' => $projectDetails[0]['clientid'] ));
        $useremail = $user->getUserDetail($projectDetails[0]['userid']);

/*    sending mail to the BS and Service/Media team */      
       $message='';
        $message.= "There is a new Requisition  for Invoice against the Estimate <strong>".$projectDetails[0]['W_O']."</strong>.<br>";
        $message.='Please visit FIDO to create and Invoice against it.';
        $urlforservice = ($config['API_BASE_URL']."sendmail");

        $data['email']="tapan.kharbanda@armworldwide.com";
        $data['name']="Tapan";
        $data['msg']=$message;
        $data['subject'] ='New Invoice Requisition';
        $services = postCURL($urlforservice,$data);
       

/*    sending mail to the BS and Service/Media  team */ 
        
        
         $projectDetails = $project->findCustom(array('id' => $sid ));
         $cmcnt = "<strong>".$userinfo['name']."</strong> has placed a <strong>requisition for an invoice</strong> against the estimate no <strong>".$projectDetails[0]['W_O']."</strong>";
         saveNotification(6,$cmcnt,0,$projectDetails[0]['W_O'],1);
  }
  redirectAdmin('estimate.php');
}
}

//////////////// approvel report //////////////////////

if(hasPermission('approve_report',$permissioninfo)){
     if(isset($_GET['apporve_report']))
    {

        $projectC = new category_estimate();
        $sqlarray = array('project_id' => $_GET['id'],'project_cat_id' => 2  );
        $val=$projectC->findCustom($sqlarray);
        
        $projectC = new category_estimate();
        $projectC->id=$val[0]['id'];
        $projectC->approve=1;
        $projectC->save();
        
        $id = $_GET['id'];
        $media_report_id = $_GET['media_report_id'];
        $project->id=$id;
        $project->process=1;
        $project->save();

        $media_report->id = $media_report_id;
        $media_report->active = 1;
        $media_report->save(); 
        
        $project  = new project();
        $user = new User();
        $mformate = new mediadata();
        $mediadetails = $mformate->findCustom(array('campaignId' => $_GET['id'] ));
        $projectDetails = $project->findCustom(array('id' => $_GET['id'] ));
        $clientDetails = $company->findCustom(array('id' => $projectDetails[0]['clientid'] ));
        $useremail = $user->getUserDetail($projectDetails[0]['userid']);
        $mediaemail = $user->getUserDetail($mediadetails[0]['userId']);

/*    sending mail to the BS and Service/Media team */      
       $message='';
        $message.= "The Report uploaded against the Estimate <strong>".$projectDetails[0]['W_O']."</strong> has been Approved by ".$userinfo['name'];
        $message.="Client Name:- ".$clientDetails[0]['partner_name'];
        $urlforservice = ($config['API_BASE_URL']."sendmail");

        $data['email']=$mediaemail[0]['email'];
        $data['name']=$mediaemail[0]['name'];
        $data['msg']=$message;
        $data['subject'] ='New Report Approved';
        $services = postCURL($urlforservice,$data);
       

/*    sending mail to the BS and Service/Media  team */ 
        
        $projectDetails = $project->findCustom(array('id' => $id ));
         $cmcnt = "<strong>".$userinfo['name']."</strong> has <strong>approved</strong> the report for project name <strong>".$projectDetails[0]['project_name']."</strong> and estimate no <strong>".$projectDetails[0]['W_O']."</strong>";
         saveNotification($mediaemail[0]['id'],$cmcnt,0,$projectDetails[0]['W_O'],1);
        
        redirectAdmin('estimate.php');
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
        $user = new User();
        $project  = new project();
         $projectDetails = $project->findCustom(array('id' => $id ));
        $useremail = $user->getUserDetail($projectDetails[0]['userid']);
       
        /*    sending mail to the BS and Service/Media team */      
        $message='';
        $message.= "The PO uploaded against the Estimate <strong>".$projectDetails[0]['W_O']."</strong> has been <strong>Disapproved</strong>.<br>";
        $message.="Due to ".$msg."<br>";
        $message.="Please visit FIDO to reUpload the new One.";
        $urlforservice = ($config['API_BASE_URL']."sendmail");

        $data['email']=$useremail[0]['email'];
        $data['name']=$useremail[0]['name'];
        $data['msg']=$message;
        $data['subject'] ='PO Disapproved';
        $services = postCURL($urlforservice,$data);
       

/*    sending mail to the BS and Service/Media  team */ 
        
                 $cmcnt = "<strong>".$userinfo['name']."</strong> has <strong>disapporve</strong> the document for project name <strong>".$projectDetails[0]['project_name']."</strong> and estimate no <strong>".$projectDetails[0]['W_O']."</strong> due to <strong>".$msg."</strong>";
                 saveNotification($projectDetails[0]['userid'],$cmcnt,1,$projectDetails[0]['W_O'],1);
        redirectAdmin('estimate.php');
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

      $media_report_id = $_POST['m_id'];

      $media_report->id = $media_report_id;
      $media_report->active = 0;
      $media_report->save(); 

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
        
/*    sending mail to the BS and Service/Media team */  
        
        $user = new User();
        $project  = new project();
        $projectDetails = $project->findCustom(array('id' => $id ));
        $useremail = $user->getUserDetail($projectDetails[0]['userid']);
       
        /*    sending mail to the BS and Service/Media team */      
        $message='';
        $message.= "The Media Report uploaded against the Estimate <strong>".$projectDetails[0]['W_O']."</strong> has been <strong>Disapproved</strong>.<br>";
        $message.="Due to ".$msg."<br>";
        $message.="Please visit FIDO to reUpload the new One.";
        $urlforservice = ($config['API_BASE_URL']."sendmail");

        $data['email']=$useremail[0]['email'];
        $data['name']=$useremail[0]['name'];
        $data['msg']=$message;
        $data['subject'] ='Media Report Disapproved';
        $services = postCURL($urlforservice,$data);
        
/*    sending mail to the BS and Service/Media team */  
        
        $projectDetails = $project->findCustom(array('id' => $id ));
         $cmcnt = "<strong>".$userinfo['name']."</strong> has <strong>disapporve</strong> the report for project name <strong>".$projectDetails[0]['project_name']."</strong> and estimate no <strong>".$projectDetails[0]['W_O']."</strong> due to <strong>".$msg."</strong>";
         saveNotification(5,$cmcnt,1,$projectDetails[0]['W_O'],1);
        
        redirectAdmin('estimate.php');
    }
}



////////////// -------------------------------------------//////////////

if(isset($_POST['po']) || isset($_POST['pr'])){

       if(!empty($_FILES['filepo']) && !empty($_POST['id']) && !empty($_POST['porder']) && !empty($_POST['amount'])){
         $client_approvel = new client_approvel();
           $filename=$_FILES["filepo"]["tmp_name"];
         $filename  = basename($_FILES['filepo']['name']);
         $extension = pathinfo($filename, PATHINFO_EXTENSION);
         $extension = strtolower($extension);
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
                 
                $project  = new project();
                $projectDetails = $project->findCustom(array('id' => $_POST['id'] ));
                 $clientDetails = $company->findCustom(array('id' => $projectDetails[0]['clientid'] ));
                 
/*    sending mail to the finance team */      
                 
                $message.= "A New PO has been uploaded against the Estimate <strong>".$projectDetails[0]['W_O']."</strong> of client <strong>".$clientDetails[0]['partner_name']."</strong>.<br>";
                $message.= "Please visit FIDO to Approve/Disapprove it.";
                $urlforservice = ($config['API_BASE_URL']."sendmail");
    
                $data['email']="tapan.kharbanda@armworldwide.com";
                $data['name']="Tapan";
                $data['msg']=$message;
                $data['subject'] ='New PO Uploaded';
                $services = postCURL($urlforservice,$data);
                 
/*    sending mail to the finance team */   
                 
                 
                 $cmcnt = "<strong>".$userinfo['name']."</strong> has <strong>uploaded the document</strong> for project name <strong>".$projectDetails[0]['project_name']."</strong> and estimate no <strong>".$projectDetails[0]['W_O']."</strong>";
                 saveNotification(6,$cmcnt,0,$projectDetails[0]['W_O'],1);
          }else {
            
          }
                redirectAdmin('estimate.php');
        }


   }
   if(isset($_POST['uploadpo']))
   {
      if(!empty($_FILES['filepo']) && !empty($_POST['pono'])){

          $filename=$_FILES["filepo"]["tmp_name"];
        $filename  = basename($_FILES['filepo']['name']);
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $extension = strtolower($extension);
        $new       = $_POST['id'].'.'.$extension;
        $target_path = $_SERVER["DOCUMENT_ROOT"]."/fido/upload/uploadfile/".$new;
        move_uploaded_file($_FILES['filepo']['tmp_name'], $target_path);
        $target_file = $target_path . basename($_FILES["filepo"]["name"]);
              $project->id = $_POST['id'];
              $project->po_Images_url = $new;
              $project->save();
            
                 $project  = new project();
                $projectDetails = $project->findCustom(array('id' => $_POST['id'] ));
                 $clientDetails = $company->findCustom(array('id' => $projectDetails[0]['clientid'] ));
                 
/*    sending mail to the finance team */      
                 
                $message.= "A New PO has been uploaded against the Estimate <strong>".$projectDetails[0]['W_O']."</strong> of client <strong>".$clientDetails[0]['partner_name']."</strong>.<br>";
                $message.= "Please visit FIDO to Approve/Disapprove it.";
                $urlforservice = ($config['API_BASE_URL']."sendmail");
    
                $data['email']="tapan.kharbanda@armworldwide.com";
                $data['name']="Tapan";
                $data['msg']=$message;
                $data['subject'] ='New PO Uploaded';
                $services = postCURL($urlforservice,$data);
                 
/*    sending mail to the finance team */  
            
                 $cmcnt = "<strong>".$userinfo['name']."</strong> has <strong>uploaded the document</strong> for project name <strong>".$projectDetails[0]['project_name']."</strong> and estimate no <strong>".$projectDetails[0]['W_O']."</strong>";
                 saveNotification(6,$cmcnt,0,$projectDetails[0]['W_O'],1);
            
            
           $_SESSION['msg'] = "Purchase order has been updated successfully";
           redirectAdmin('estimate.php');

       }
       $_SESSION['msg'] = "Upload PO order first";
           redirectAdmin('estimate.php');
   }

   if(isset($_POST['upload'])){
       $client_approvel = new client_approvel();
     $filename=$_FILES["filea"]["tmp_name"];
    $filename  = basename($_FILES['filea']['name']);
    $extension = pathinfo($filename, PATHINFO_EXTENSION);
    $extension = strtolower($extension);
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
         $project  = new project();
                $projectDetails = $project->findCustom(array('id' => $_POST['id'] ));
                 $clientDetails = $company->findCustom(array('id' => $projectDetails[0]['clientid'] ));
                 
/*    sending mail to the finance team */      
                 
                $message.= "A New PO has been uploaded against the Estimate <strong>".$projectDetails[0]['W_O']."</strong> of client <strong>".$clientDetails[0]['partner_name']."</strong>.<br>";
                $message.= "Please visit FIDO to Approve/Disapprove it.";
                $urlforservice = ($config['API_BASE_URL']."sendmail");
    
                $data['email']="tapan.kharbanda@armworldwide.com";
                $data['name']="Tapan";
                $data['msg']=$message;
                $data['subject'] ='New PO Uploaded';
                $services = postCURL($urlforservice,$data);
                 
/*    sending mail to the finance team */  
       
                 $cmcnt = "<strong>".$userinfo['name']."</strong> has <strong>uploaded the document</strong> for project name <strong>".$projectDetails[0]['project_name']."</strong> and estimate no <strong>".$projectDetails[0]['W_O']."</strong>";
                 saveNotification(6,$cmcnt,0,$projectDetails[0]['W_O'],1);
       
    redirectAdmin('estimate.php');
   }


// Instantiate the user class

  //_d($allSettings);
  ?>

        <!-- Page container begins -->
       <section class="main-container">
    <div class="header headerCntnt_wrapr">
      <div class="heading_top">
        <div class="page-title">Estimate Summary</div>
      </div>
	  <div class="pageTgle" id="openLnks"><i class="icon-menu7 navIcon_size"></i></div>
      <div id="slideLinks" class="links"><a href="addProject.php" class="btn btn-secondary btn-labeled m-r-10"><b><i class="icon-link"></i></b>  CREATE ESTIMATE REQUISITION</a></div>
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
                  <th>Service
                                        <div class="src_inpt"><input type="text" class="form-control" placeholder="Search"></div>
                                        <div class="sortMask"></div>
                                    </th>
                  <th>Service Value
                                        <div class="src_inpt"><input type="text" class="form-control" placeholder="Search"></div>
                                        <div class="sortMask"></div>
                                    </th>
                  
                  <th class="no_Sort txt_cntr">Document </th>
                  
                  <th class="no_Sort txt_cntr" >PO/PR/Signed Estimate</th>
                  
                  <th class="no_Sort txt_cntr">Report </th>
                  
                  <th class="no_Sort">Action</th>
                  </tr>
                            </thead>
                    <?php $chk_po = false; $i=1;
                    foreach($allproject as $k=>$projectData){
                        $com;
                        $dat = explode(" ", $projectData['created_at'])
                        ?>
                        <tr><td style="text-align:Center"><?php echo $i; ?></td>
                            <td> <a class="tbl_txt_lnk" target="_blank" href="<?php echo $config['SITE_URL']."estimatePdf.php?id=".$projectData['id'];?>"><?php echo $projectData['W_O']; ?></a> </td>
                            <td>
                                <?php echo $projectData['partner_name']; ?>
                            </td>
                            <td>
                                <?php echo $projectData['project_name']; ?>
                            </td>
                            <td>
                                <?php
                                $cat_chk=0;
                                $cat_report=0;
                                $chk_work_done = false;
                                $chk_requisition_for_invoice = '';
                                $val=$projectC->findCustom(array('project_id'=>$projectData['id']));

                    foreach($val as $j=>$catId)
                    {
                      if($catId['approve'] == 1){
                          $chk_requisition_for_invoice[] = $catId;
                          $chk_work_done = true;
                      }
                        $catv=$projectC->catValue($catId['project_cat_id']);
                      if ($catId['project_cat_id'] == 2) {
                        $cat_chk=1;
                      }
                    echo $catv[0]['name']."<br>";
                    }
                    //print_r($chk_requisition_for_invoice);
                    //print_r($chk_work_done);
                    ?>
                    </td> 
                    <td>
        <?php echo $mformate->currencyFormatCountry($projectData['totalprice'],$projectData['currency_id']); ?>
                    </td>
                    <td class="txt_cntr">
            <?php 
            $cond = "project_id = ".$projectData['id']." and active = 1";
            $res = $client_approvel->findWhere($cond);
            if (!empty($res)) {
                  $chk_po = true;

  echo'<input  class="imgval" type="hidden" value="'.$res[0]['img_path'].'">';
    echo'<input  class="codeval" type="hidden" value="'.$res[0]['code'].'">';
    echo'<input  class="amtval" type="hidden" value="'.$mformate->currencyFormatCountry($res[0]['amt'],$projectData['indian']).'">';
  echo '<a class="imgshow" onclick="f2(this)" data-toggle="modal" data-target="#slipimg" href="javascript:;"><i class="fa fa-file-pdf-o icn_sz_20 tbl_txt_lnk"></i></a>';
    if(hasPermission('upload_po',$permissioninfo) && $projectData['po_approvel']==2){
                echo '<input type="hidden" value="'.$projectData['id'].'" class="hval" >
                    <ul class="icons-list">
                    <li class="dropdown">
                    <button  style="padding-top: 0;" type="button" class="btn btn-secondary btn-xs" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Upload <i class="icon-three-bars position-right"></i></button>
                    
                                        <ul class="dropdown-menu dropdown-menu-sm  dropdown-menu-right" style="width: 170px;" >
                                          
                                                <a class="dropdown-item" href="javascript:;" data-toggle="modal" data-target="#myModal" onclick="f1(this)" >P.O. Number</i></a>
                                           
                                          
                                                <a class="dropdown-item" href="javascript:;" data-toggle="modal" onclick="f1(this)" data-target="#myyModal">Sign Estimate</a>
                                           
                                           
                                                <a class="dropdown-item" href="javascript:;" data-toggle="modal" data-target="#myyyModal" onclick="f1(this)" >P.R.</a>
                                           
                                        </ul>
                    </li>
                    </ul>';
          }
} else { $chk_po = false; 
          if(hasPermission('upload_po',$permissioninfo)){
                echo '<input type="hidden" value="'.$projectData['id'].'" class="hval" >
                                        <ul class="icons-list">
                    <li class="dropdown">
                    <button  style="padding-top: 0;" type="button" class="btn btn-secondary btn-xs" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Upload <i class="icon-three-bars position-right"></i></button>
                    
                                        <ul class="dropdown-menu dropdown-menu-sm  dropdown-menu-right" style="width: 170px;">
                                           
                                                <a href="javascript:;" data-toggle="modal" data-target="#myModal" onclick="f1(this)"  class="dropdown-item" >P.O. Number</a>
                                           
                                                <a href="javascript:;" data-toggle="modal" onclick="f1(this)" data-target="#myyModal" class="dropdown-item">Sign Estimate</a>
                                          
                                                <a href="javascript:;" data-toggle="modal" data-target="#myyyModal" onclick="f1(this)" class="dropdown-item">P.R.</a>
                                            
                                       </ul>
                    </li>
                    </ul>
                        ';
          }
        } 
?>
                                            </td>
                                            <td class="txt_cntr">
                                                <?php
                                                if($chk_po){
                                                if($projectData['po_approvel']==2){ ?>
                                                  <i aria-hidden="true" class="fa fa-times icn_sz_19 text-danger"></i><!--3-->
                                              <?php  } 
                                                    if($projectData['po_approvel']==1) {  ?>
                                                  <i class="fa fa-check icn_sz_20 text-success" aria-hidden="true"></i>
                                              <?php  }
                                                    if($projectData['po_approvel']==0) {  ?>
                                                  <i class="fa fa-clock-o fa-spin fa-2x fa-fw" aria-hidden="true"></i>
                                              <?php  }
                                            } else {
                                              echo '<i class="fa fa-clock-o fa-spin fa-2x fa-fw" aria-hidden="true"></i>';
                                            }
                                              ?>
                                              </td>
                     <td style="width:60px;" class="txt_cntr">
                      <?php  if ($cat_chk) {
                        $sqlarray = array('media_id' => $projectData['id']);
                        $res = $media_report->findCustom($sqlarray);
                        if (empty($res)) {
                        $cat_report = 0;
                          echo '<i class="fa fa-clock-o fa-spin fa-2x fa-fw" aria-hidden="true"></i>';
                        } else {
                          $cat_report = 1; ?>
                      <ul class="icons-list">
                        <li class="dropdown">
                          <button type="button" class="btn btn-secondary toggle_drpdown" style="text-align: center;border: 0;" data-toggle="dropdown" aria-expanded="true"><i style="margin-right:0" class="icon-three-bars position-left"></i>
                          </button>
                          <ul class="dropdown-menu dropdown-menu-right" style="width:200px;">
                            <?php $x=1;
                            foreach($res as $a=>$b){ ?>
            							<div class="drpDwn_rprt">
            								<div class="ttlWth_icn">
                              <a target="_blank" href="<?php echo $config['SITE_URL']."upload/upload_report_media/".$b['report']?>" class="rprt_ttl">
                              <i class="fa fa-external-link icnDrp_lft"></i>
                               Report <?= $x;?></a>
                            </div>
                            <div class="rightApp_btn">
                              <?php  if(hasPermission('approve_report',$permissioninfo)){ ?>
                              <a href="<?php echo $config['SITE_URL']."estimate.php?apporve_report=1&id=".$projectData['id']."&media_report_id=".$b['id'];?>" class="rprt_app">
                                <?php if ($b['active']) {
                                echo '<i class="fa fa-check text-success"></i>';
                                  } else {
                                    echo '<i class="fa fa-check"></i>';
                                    } ?>
                              </a>
                            <?php } 
                            if(hasPermission('Disapporve_Report',$permissioninfo) ){ 
                            ?>
                              <input type="hidden" value="<?php echo $projectData['id']; ?>" class="hval" >
                              <input type="hidden" value="<?php echo $b['id']; ?>" class="media_id" >
                              <a href="javascript:;" class="rprt_app" data-toggle="modal" data-target="#formsg" onclick="f1(this)" >
                                <?php if (!$b['active']) {
                                echo '<i class="fa fa-times text-danger"></i>';
                                  } else {
                                    echo '<i class="fa fa-times" style="margin-right:0px;"></i>';
                                    } ?>
                              </a>
                            <?php } ?>
                            </div>
            							</div>
                              <?php $x++; } ?>
                          </ul>
                        </li>
                      </ul>

                          <?php  
                          }
                        }else{
                                switch ($projectData['process']) {
                                  case 1:
                                      echo '<i class="fa fa-check-square icn_sz_19 text-success" style="margin-right: 3px;" aria-hidden="true"></i>';
                                      break;
                                  case 0:
                                      echo '<i class="fa fa-clock-o fa-spin fa-2x fa-fw" aria-hidden="true"></i>';
                                      break;
                                  case 2:
                                      echo '<i class="fa fa-times icn_sz_19 text-danger" aria-hidden="true"></i><!--2-->';
                                      break;
                              }

                                    }
                                    ?> 
                                  </td>
                            <td class="txt_cntr" >
                                    <?php if($cat_chk) { 
                                        $add_url = "&media=true";     
                                    }
                                    else{
                                        $add_url = "&media=false";
                                    }
                        if($projectData['reconciliation'] ==0) {
                                        ?>
                           <ul class="icons-list" style="text-align: center;">
                <li class="dropdown">
              <button type="button" class="btn btn-secondary toggle_drpdown" style="text-align: center;border: 0;" data-toggle="dropdown" aria-expanded="false"><i style="margin-right:0" class="icon-three-bars position-left"></i></button>
                              <ul  class="dropdown-menu dropdown-menu-sm  dropdown-menu-right" style="width: 170px;">
                               <?php if(hasPermission('delete_estimate',$permissioninfo) && $chk_po == false){ ?>
                               <a onclick="return confirm('Are you sure?');" href="<?php echo $config['SITE_URL']."estimate.php?delete=1&id=".$projectData['id'];?>" class="dropdown-item">Cancel</a>
                <?php }
                                if(hasPermission('edit_estimate',$permissioninfo) && $chk_po == false){ ?>
                                  <a href="<?php echo $config['SITE_URL']."editProject.php?id=".$projectData['id'].$add_url;?>" class="dropdown-item">Edit</a>
                <?php }
                                if(hasPermission('create_estimate',$permissioninfo) && $projectData['W_O'] =='' && $userinfo['id'] != $projectData['userid'] && (in_array($userinfo['id'], checkParent($projectData['userid'])) || $userinfo['type'] == 1)){ ?>
                                 <a href="<?php echo $config['SITE_URL']."estimate.php?approval=1&id=".$projectData['id'];?>" class="dropdown-item">Approve Estimate</a>
                                 <?php } ?>
                                 <?php if($projectData['W_O'] ==''){?>
                  <a target="_blank"  href="<?php echo $config['SITE_URL']."actionpdf.php?id=".$projectData['id'];?>" class="dropdown-item">Requisition Slip</a>
                                <?php
                                    }
                                if($chk_po){
                                //if($projectData['po_approvel']==0 || $projectData['po_approvel'] ==2){
                                if(hasPermission('Approve_PO',$permissioninfo)){ ?>
                                <a href="<?php echo $config['SITE_URL']."estimate.php?po_approval&id=".$projectData['id'];?>" class="dropdown-item">Approve PO</a>
                                  <input type="hidden" value="<?php echo $projectData['id']; ?>" class="hval" >
                                <a class="dropdown-item" href="javascript:;" data-toggle="modal" data-target="#formsg_reject_po" onclick="f1(this)" >Disapporve PO</a>
                                  <?php }
                                //}
                              }
                              if(hasPermission('Requision_Invoice',$permissioninfo)){
                               if ($cat_chk) {
                                 if(isEligibleForInvoice($projectData['id'])){ ?>
                                  <a class="dropdown-item" data-toggle="tooltip" data-placement="top" title="Do ensure that all the reports have been checked." href="<?php echo $config['SITE_URL']."estimate.php?&formedia=".$projectData['id'];?>">Send Requisition for Invoice</a>
                                  <?php } else { ?>
                                  <a class="dropdown-item disabled" href="javascript:;" >Send Requisition for Invoice</a>
                                <?php  }
                               }
                               else {
                                 if(isEligibleForInvoiceForNonmedia($projectData['id'])){ ?>
                                   <a class="dropdown-item" data-toggle="tooltip" data-placement="top" title="Do ensure that all the reports have been checked." href="<?php echo $config['SITE_URL']."estimate.php?&fornonmedia=".$projectData['id'];?>">Send Requisition for Invoice</a>
                                  <?php } else { ?>
                                  <a class="dropdown-item disabled" href="javascript:;" >Send Requisition for Invoice</a>
                                 <?php }
                               }
                             }
                            if($userinfo['type'] == 14 && $projectData['request_date'] == 1){
                               ?>
                                  <input type="hidden" value="<?php echo $projectData['id']; ?>" class="hval" >
                                  <input type="hidden" value="<?php echo $projectData['project_start']; ?>" class="sdate_est" >
                                  <input type="hidden" value="<?php echo $projectData['project_end']; ?>" class="edate_est" >
                                  <input type="hidden" value="<?php echo $projectData['W_O']; ?>" class="est_no" >
                                  <a class="dropdown-item" href="javascript:;" data-toggle="modal" data-target="#change_date_request" onclick="f1(this)" >Change Date</a>
                              <?php } ?>
                              </ul>
                 </li>
                            </ul>
                            <?php }elseif($projectData['reconciliation'] ==2){ ?>
              <ul class="icons-list" style="text-align: center;">
                <li class="dropdown">
                  <button type="button" class="btn btn-secondary toggle_drpdown" style="text-align: center;border: 0;" data-toggle="dropdown" aria-expanded="false"><i style="margin-right:0" class="icon-three-bars position-left"></i></button>
                  <ul  class="dropdown-menu dropdown-menu-sm  dropdown-menu-right" style="width: 170px;">
                    <a class="dropdown-item" href="javascript:;" data-toggle="modal" data-target="#service_invoice" onclick='show_services(<?php echo json_encode($chk_requisition_for_invoice);?>)' >Partially Invoice</a>
                    <?php   if($cat_chk && $cat_report) {
                    if(hasPermission('Disapporve_Report',$permissioninfo) && $projectData['process']!= 1){ 
                    ?>
                    <input type="hidden" value="<?php echo $projectData['id']; ?>" class="hval" >
                    <a href="javascript:;" data-toggle="modal" data-target="#formsg" onclick="f1(this)" >Disapporve Report</a>
                    <?php }
                    if(hasPermission('approve_report',$permissioninfo) && $projectData['process']!= 1 ){ 
                    ?>
                    <a href="<?php echo $config['SITE_URL']."estimate.php?apporve_report=1&id=".$projectData['id'];?>">Approve Report</a>
                    <?php } 
                    } ?>
                  </ul>
                </li>
              </ul>
                                
                       <?php }else{ ?>
                                
                <button type="button" class="btn tooltip-left tooltip_cstm" data-tooltip="Process complete">
                  <i class="fa fa-archive icn_sz_18 text-success"></i>
                </button>                 
                            <?php } ?>
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
        
        var allCat = <?php echo json_encode($allCategories);?>;
        //console.log(allCat);
        function show_services(data){
            $html='<thead> <th></th><th>Service</th><th>Money</th></thead><tbody>';
            $.each(data, function(index) {
                $html+='<tr>';
                function isService(ser) { 
                    return ser.id == data[index].project_cat_id;
                }
                cat_val = allCat.find(isService);
                if(data[index].approve == 0 || data[index].reconciliation == 1){
                    var chk_ver = "disabled";
                }else{
                    var chk_ver = "";
                }
                $html+='<td><input type="hidden" name="pro_row" value="'+data[index].project_id+'" ><div class="checkbox"><label><input '+chk_ver+' type="checkbox" name="service[]" value="'+data[index].id+'"></label></div></td>';
                $html+='<td>'+cat_val.name+'</td>';
                $html+='<td>'+data[index].price+'</td>';
        });
            $html+='</tr>';
            $html+='</tbody>';
            $('.service_invoice').html($html);
        }
        function f1(h) {

            var a = $(h).closest('td').find('.hval').val();
            var b = $(h).closest('td').find('.media_id').val();
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
            $('#m_id').val(b);
            $('#formsg_po').val(a);
            $('#formsg_change_date_request').val(a);
            //$('#pono').val(b);
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
            var code = $(h).closest('td').find('.codeval').val();
            var amt = $(h).closest('td').find('.amtval').val();
            var c = "<?php echo $config['SITE_URL']?>/upload/uploadfile/" + a;
            var res = a.split(".");
            $('#slipimg').find('.code').text('Code:- '+code);
            $('#slipimg').find('.amt').text('Amount:- '+amt);
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
  
  
  
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg_none p-10">
        <h5 class="modal-title" id="myModalLabel">Purchase Order</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
     <form method="post" action="estimate.php" enctype="multipart/form-data">
      <div class="modal-body">
    <div class="row marg_b_15">
    <div class="col-md-12 col-sm-12">
      <div class="form-group">
      <label>Enter Code: </label>
      <div class="input-group">
      <span class="input-group-addon"><i class="icon-qr-code"></i></span>
      <input type="text" class="form-control" name="porder" id="exampleInputEmail1" placeholder="Purchase Order" required>
      </div>
      </div>
    </div>
    </div>
    <div class="row marg_b_15">
    <div class="col-md-12 col-sm-12">
      <div class="form-group">
      <label>Enter Amount: </label>
      <div class="input-group">
      <span class="input-group-addon"><i class="icon-rupee"></i></span>
      <input type="number" class="form-control" name="amount" id="exampleInputEmail1" step="any" placeholder="Amount" required>
      </div>
      </div>
    </div>
    </div>
    <div class="row marg_b_15">
    <div class="col-md-12 col-sm-12">
      <div class="form-group">
      <label>Upload PO Here: </label>
      <div class="input-group">
      <input type="file" id="exampleInputFile" class="form-control "name="filepo" required accept="application/pdf,image/gif, image/jpeg">
      </div>
      </div>
    </div>
    </div>
    <input type="hidden" name="id" id="op" value="">
      </div>
    <div class="modal-footer bg_none">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary" name="po">Submit</button>
    </div>
    </form>
    </div>
  </div>
</div><!-- Done End 1-->




<div class="modal fade" id="myyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg_none p-10">
        <h5 class="modal-title" id="myModalLabel">Sign Estimate</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
     <form method="post" action="estimate.php" enctype="multipart/form-data">
      <div class="modal-body">
    <div class="row marg_b_15">
    <div class="col-md-12 col-sm-12">
      <div class="form-group">
      <label>Enter Code: </label>
      <div class="input-group">
      <span class="input-group-addon"><i class="icon-qr-code"></i></span>
      <input type="text" class="form-control" name="porder" id="exampleInputEmail1" placeholder="Sign Estimate" required>
      </div>
      </div>
    </div>
    </div>
    <div class="row marg_b_15">
    <div class="col-md-12 col-sm-12">
      <div class="form-group">
      <label>Enter Amount: </label>
      <div class="input-group">
      <span class="input-group-addon"><i class="icon-rupee"></i></span>
      <input type="number" class="form-control" name="amount" id="exampleInputEmail1" step="any" placeholder="Amount" required>
      </div>
      </div>
    </div>
    </div>
    <div class="row marg_b_15">
    <div class="col-md-12 col-sm-12">
      <div class="form-group">
      <label>Upload Sign Estimate Here: </label>
      <div class="input-group">
      <input type="file" id="exampleInputFile" class="form-control" name="filea" required accept="application/pdf,image/gif, image/jpeg">
      </div>
      </div>
    </div>
    </div>
    <input type="hidden" name="eid" id="eop" value="">
     </div>
      <div class="modal-footer bg_none">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary" name="upload">Submit</button>
      </div>
    </form>
      </div>
    </div>
  </div>
<!-- Done End 2-->



<div class="modal fade" id="myyModalpo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg_none p-10">
        <h5 class="modal-title" id="myModalLabel">Sign PO</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
     <form method="post" action="estimate.php" enctype="multipart/form-data">
      <div class="modal-body">
    <div class="row marg_b_15">
    <div class="col-md-12 col-sm-12">
      <div class="form-group">
      <label>Upload Sign PO Here: </label>
      <div class="input-group">
       <input type="file" id="exampleInputFile" class="form-control" name="filepo" required accept="application/pdf,image/gif, image/jpeg">
      </div>
      </div>
    </div>
    </div>
    <input type="hidden" name="id" id="po" value="">
    <input type="hidden" name="pono" id="pono" value=""> 
    </div>
      <div class="modal-footer bg_none">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
     <button type="submit" class="btn btn-primary" name="uploadpo">Submit</button>
      </div>
    </form>
     </div>
    </div>
  </div>
<!-- Done End 3-->




<div class="modal fade" id="myyyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg_none p-10">
        <h5 class="modal-title" id="myModalLabel">Purchase Reference</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
     <form method="post" action="estimate.php" enctype="multipart/form-data">
      <div class="modal-body">
    <div class="row marg_b_15">
    <div class="col-md-12 col-sm-12">
      <div class="form-group">
      <label>Enter Purchase Reference Code: </label>
      <div class="input-group">
      <span class="input-group-addon"><i class="icon-rupee"></i></span>
      <input type="text" class="form-control" name="porder" id="exampleInputEmail1" placeholder="Purchase Reference" required>
      </div>
      </div>
    </div>
    </div>
    <div class="row marg_b_15">
    <div class="col-md-12 col-sm-12">
      <div class="form-group">
      <label>Enter Amount: </label>
      <div class="input-group">
      <span class="input-group-addon"><i class="icon-rupee"></i></span>
      <input type="number" class="form-control" name="amount" id="exampleInputEmail1" placeholder="Amount" required>
      </div>
      </div>
    </div>
    </div>
    <div class="row marg_b_15">
    <div class="col-md-12 col-sm-12">
      <div class="form-group">
      <label>Upload PR Here: </label>
      <div class="input-group">
       <input type="file" id="exampleInputFile" class="form-control" name="filepo" required accept="application/pdf,image/gif, image/jpeg">
      </div>
      </div>
    </div>
    </div>
     <input type="hidden" name="id" id="opr" value=""> 
      </div>
      <div class="modal-footer bg_none">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
     <button type="submit" name="pr" class="btn btn-primary">Submit</button>
      </div>
    </form>
    </div>
    </div>
  </div>
<!-- Done End 4 -->


 <!-- Modal for img show  -->
<div class="modal fade" id="slipimg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg_none p-10">
        <h5 class="modal-title code">Purchase Reference</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
     
     <p class="amt" style="padding: 6px 0 0 11px;font-size: 13px;"></p>
     
      <div class="modal-body popImg_mdl_style p-0">

    </div>
      <div class="modal-footer bg_none">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    
    </div>
    </div>
  </div>
    <!-- Done End 5 -->

<div class="modal fade" id="formsg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg_none p-10">
        <h5 class="modal-title" id="myModalLabel">Disapporve Report</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
     <form method="post" action="estimate.php" >
      <div class="modal-body">
    <div class="row marg_b_15">
    <div class="col-md-12 col-sm-12">
      <div class="form-group">
      <label>Reason for Disapporve: </label>
      <div class="input-group">
      <textarea name="msg" class="form-control" rows="3"></textarea>
      <input type="hidden" name="id" id="formsg_id" value="">
      <input type="hidden" name="m_id" id="m_id" value="">
      </div>
      </div>
    </div>
    </div> 
      </div>
      <div class="modal-footer bg_none">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
     <button type="submit" name="msg_send" class="btn btn-primary">Submit</button>
      </div>
    </form>
    </div>
    </div>
  </div>

<!-- Done End 6 -->


<div class="modal fade" id="formsg_reject_po" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel"></h4> 
            </div>
        <div class="modal-body">
            <form method="post" action="estimate.php" >

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

<!-- Done End 7 -->



<div class="modal fade" id="service_invoice" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel"></h4> 
            </div>
            <form method="post" action="estimate.php">
        <div class="modal-body">
            

                        <table id='show_outstanding' class="service_invoice display table table-bordered datatable" width="100%">
                            
                        </table>
                
            </div>
            <div class="modal-footer">
            <button type="submit" name="split_service" class="btn btn-default">Submit</button>
        </div>
                </form>
            <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Done End 8 -->


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
  </div>
  
  
  <!-- Done End 9 -->
  
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


    <script>
		$(document).ready(function(){
			
			$('#openLnks').click(function(){
				$('#slideLinks').slideToggle();
			})
				
		});
    </script>


