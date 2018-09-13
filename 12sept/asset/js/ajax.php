<?php

$fileBasePath = dirname(__FILE__).'/';
include_once('include/actionHeader.php');

if(!isset($_SESSION['admin_info'])){
	exit();
}
if(isset($_GET['remove']))
{
    unlink($config['DOC_ROOT'].'upload/'.$_GET['imageurl']);
    $gallery->id=$_GET['id'];
    $gallery->delete();
    echo '1';
}
if(isset($_POST['pvalue']))
{
	$id = $_POST['pvalue'];
	$minvoice = new media_invoice();
	$project = new Project();
	$getValue = $minvoice->findCustom(array('campaignId'=>$id));
	foreach($getValue as $key=>$value)
	{
		echo '<div class="form-group">
		<input type="hidden" value="'.$value["campaignId"].'" name="id" >
		<label class="radio-inline" style="margin-left: 37px; font-size: 14px;">
		<input type="radio" name="mInvoiceId" id="inlineRadio1" value="'.$value["id"].'" style="margin-left:-33px;">'.$value["Invoice_No"].'&nbsp;&nbsp;&nbsp; '.$value["Invoice_month"].'
		</label>
		</div>';
	}
	$getEstNo = $project->findcustomrow(array('id'=>$value["campaignId"]));
	echo '<div class="col-md-6">
        	<div class="form-group" style="margin-left: 1px; margin-right: 8px;" >
        	<label for="recipient-name" class="control-label">Estimate NO</label>
            <input type="text" class="form-control" id="" value="'.$getEstNo["W_O"].'" readonly value="">
          </div>
        </div>';
    
}

if(isset($_POST['invCreate']))
{
	$id = $_POST['invCreate'];
	$minvoice = new media_invoice();
	$project = new Project();
	$company=new Partner();
	$my_company = new my_company();
	$getValue = $minvoice->findCustom(array('campaignId'=>$id));
	if(!empty($getValue)){
	foreach($getValue as $key=>$value)
	{
		echo '<div class="form-group">
		<label class="radio-inline" style="margin-left: 37px; font-size: 14px;">
		<a href="'.$config["SITE_URL"].'invoicePDF.php?id='.$value["campaignId"].'&mInvoiceId='.$value["id"].'" id="inlineRadio1" style="margin-left:-33px;">'.$value["Invoice_No"].'&nbsp;&nbsp;&nbsp; '.$value["Invoice_month"].'</a>
		</label>
		</div>';
	}
}
	$getEstNo = $project->findcustomrow(array('id'=>$id));
	$clientinfo = $company->findcustomrow(array('id'=>$getEstNo["clientid"]));
	$bankinfo = $my_company->findcustomrow(array('id'=>$clientinfo["bank"]));
	$Bankdetails = $my_company->all();
	?><div class="col-md-6">
	<input type="hidden" value="<?php echo $id ?>" name="id" >
        	<div class="form-group" style="margin-left: 1px; margin-right: 8px;" >
        	<label for="recipient-name" class="control-label">Estimate NO</label>
            <input type="text" class="form-control" id="" value="<?php echo $getEstNo["W_O"] ?>" readonly value="">
          </div>
        </div>
        <div class="col-md-12">
        <div class="col-md-6">
        	<div class="form-group" style="margin-right: 5px;">
        	<label for="recipient-name"  class="control-label">Invoice Date</label>
            <input type="text" class="form-control" name="Idate" id="" placeholder="YYYY-MM-DD" required pattern="(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))" oninvalid="setCustomValidity('Formate YYYY-MM-DD')" onchange="try{setCustomValidity('')}catch(e){}">
          </div>
        </div>
        <div class="col-md-6">
        	<div class="form-group">
        	<label for="recipient-name" class="control-label">Invoice Money</label>
            <input type="text" class="form-control" id="" name="Imoney" required>
          </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="col-md-6">
        	<div class="form-group" style="margin-right: 5px;">
        	<label for="recipient-name"  class="control-label">Invoice Start Date</label>
            <input type="text" class="form-control" name="ISdate" id="startdate">
          </div>
        </div>
        <div class="col-md-6">
        	<div class="form-group" style="margin-right: 5px;">
        	<label for="recipient-name"  class="control-label">Invoice End Date</label>
            <input type="text" class="form-control" name="IEdate" id="" placeholder="YYYY-MM-DD" required pattern="(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))" oninvalid="setCustomValidity('Formate YYYY-MM-DD')" onchange="try{setCustomValidity('')}catch(e){}">
          </div>
        </div>
    </div>
    <div class="col-md-12">
    <div class="col-md-6">
        	<div class="form-group" style="margin-right: 5px;">
        	<label for="recipient-name" class="control-label">Client Address</label>
            <textarea name="address" class="form-control" rows="3" required=""><?php echo $clientinfo['official_address']." ".$clientinfo['state']." ".$clientinfo['country']." ".$clientinfo['postal_code']?></textarea>
          </div>
        </div>
        <div class="col-md-6">
        	<div class="form-group" style="margin-right: 5px;">
        	<label for="recipient-name" class="control-label">Engagement Description</label>
            <textarea name="pdis" class="form-control" rows="3" required=""></textarea>
          </div>
        </div>
    </div>
    <div class="col-md-12">
    	<div class="col-md-6">
        	<div class="form-group" style="margin-right: 5px;">
        	<label for="recipient-name" class="control-label">Project Name</label>
            <input type="text" name="pname" class="form-control" id="" required="">
          </div>
        </div>
        <div class="col-md-6">
        	<div class="form-group" style="margin-right: 5px;">
        	<label for="recipient-name" class="control-label">Bank</label>
           <select class="form-control" name="bank" required="">
           <option value="">Select Bank</option>
           <?php 
           foreach ($Bankdetails as $key => $value) { ?>
           	<option value="<?php echo $value['id'] ?>" <?php if($value['id'] == $bankinfo['id']) echo"selected"; ?>><?php echo $value['bank_name'] ?></option>
        <?php   }
           ?>
			</select>
          </div>
          <style>
#startdate{z-index:1151 !important;}
</style>
<script src=""<?php echo $URL_SITE?>/js/custom.js""></script>
        </div>
    </div>
    <?php 
    
}

if(isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
	$projectC = new category_estimate();
	$category = new Category();
	$cat_id = $category->findcustomrow(array('name'=>$action));
	
	
    $sql1 = "SELECT project_estimate_detail.`id` , project_estimate_detail.`project_id` , project_estimate_detail.`project_cat_id` , SUM( project_estimate_detail.`price` ) , project.clientid, MONTH( project.created_at ) as m , YEAR( project.created_at ) as y , COUNT( MONTH( project.created_at ) ) 
FROM  `project_estimate_detail` , project
WHERE project_estimate_detail.`project_id` = project.id
AND project_estimate_detail.`project_cat_id` =".$cat_id['id']."
GROUP BY YEAR( project.created_at ) , MONTH( project.created_at ) 
ORDER BY YEAR( project.created_at ) , MONTH( project.created_at )";
$result = $projectC->customQuery($sql1);
	static $i = 0;
	$array_bar_x = array();
	$array_bar_y = array(); 
	foreach($result as $k=>$v)
	{ 
	$dateObj   = DateTime::createFromFormat('!m', $v['m']);
	$monthName = $dateObj->format('F');
	 $array_bar_y[] = $v['SUM( project_estimate_detail.`price` )'];
	 $array_bar_x[] = $monthName.'-'.$v['y']; 
	}
	$return["y"] = json_encode($array_bar_y);
	 $return["x"] = json_encode($array_bar_x); 
	 echo json_encode($return); 
}
if(isset($_POST['cataction']) && !empty($_POST['cataction'])) {
    $action = $_POST['cataction'];
	$projectC = new category_estimate();
	$category = new Category();
	$cat_id = $category->findcustomrow(array('name'=>$action));
	
	
    $sql1 = "SELECT partner.id,project.project_name,partner.partner_name,project_estimate_detail.project_cat_id,SUM(project_estimate_detail.price) as m  FROM project,partner,project_estimate_detail WHERE project.clientid = partner.id and project.id = project_estimate_detail.project_id and  project_estimate_detail.project_cat_id=".$cat_id['id']." group by partner.partner_name
ORDER BY `m`  DESC limit 5";
$result = $projectC->customQuery($sql1);
	 echo json_encode($result); 
}
if(isset($_POST['revenueaction']) && !empty($_POST['revenueaction']) && $_POST['revenueaction']=="Revenue") {
    $action = $_POST['revenueaction'];
	$category = new Category();
	$partner = new Partner();
	$cond3 = "SELECT a.* ,b.project_name,c.partner_name,c.company_type,c.id FROM project_estimate_detail as a,project as b, partner as c where a.project_id = b.id and b.clientid = c.id";
$clint_revenue = $category->customQuery($cond3);
$new_array = array();
$cat=array();

foreach($clint_revenue as $k=>$v)
{
	if(!(in_array($v['id'],$cat)))
	{
		$new_array[$v['id']]['sum']=0;
		$cat[]=$v['id'];
	}
	if($v['project_cat_id'] ==2 && $v['company_type']!=1)
	{
		$cond4 = "SELECT * FROM `partner_section_commisions` WHERE partner_id=".$v['id']." and service_id = 2";
		 $clint_comm = $category->customQuery($cond4);
		 $m = $v['price']*($clint_comm[0]['commision']/100);
	}
	else
	{
		$m=$v['price'];
	}
	$new_array[$v['id']][] = $v;
	$new_array[$v['id']]['sum']+=$m;

}
$final_array = array();
foreach($new_array as $k=>$v)
{
	$currentclint=$partner->findcustomrow(array('id'=>$k));
	$final_array[$currentclint['partner_name']] = $v['sum'];
} 
arsort($final_array); 
	 echo json_encode(array_slice($final_array, 0,5, true)); 
}
if(isset($_POST['revenueaction']) && !empty($_POST['revenueaction']) && $_POST['revenueaction']=="Estimate") {
					 $project  = new project();
$cond1 = "SELECT partner.partner_name  ,count(project.clientid) as c FROM project, partner where project.clientid = partner.id group by `clientid` order by count(project.clientid) desc LIMIT 5";
$topEst = $project->customQuery($cond1);
$final_array = array();
foreach($topEst as $k=>$v)
{
	$final_array[$v['partner_name']] = $v['c'];
}
 echo json_encode($final_array);
}
if(isset($_POST['targetcat']) && !empty($_POST['targetcat'])) {
    $action = $_POST['targetcat'];
	$projectC = new category_estimate();
	$category = new Category();
	$cat_id = $category->findcustomrow(array('name'=>$action));
	
	
    $sql1 = "SELECT SUM(a.totalprice) as money , MONTH(a.created_at ) as m , YEAR(a.created_at ) as y, a.clientid,b.* FROM project as a INNER JOIN project_estimate_detail as b ON a.id = b.project_id where b.project_cat_id = ".$cat_id['id']." and  status = 1 GROUP BY YEAR( a.created_at ) , MONTH(a.created_at ) ORDER BY YEAR( a.created_at ) , MONTH( a.created_at )";
$result = $projectC->customQuery($sql1);
	 static $i = 0;
	$array_bar_x = array();
	$array_bar_y = array(); 
	foreach($result as $k=>$v)
	{ 
	$dateObj   = DateTime::createFromFormat('!m', $v['m']);
	$monthName = $dateObj->format('F');
	 $array_bar_y[] = $v['money'];
	 $array_bar_x[] = substr($monthName, 0, 3).'-'.$v['y'];
	}
	$return["y"] = json_encode($array_bar_y);
	 $return["x"] = json_encode($array_bar_x); 
	 echo json_encode($return); 
}
	
if(isset($_POST['user']) && !empty($_POST['user'])) {
	$users = new User();
    $user = $_POST['user'];
	$client = $_POST['client'];
	foreach($client as $k=>$v)
	{
		$sql="UPDATE partner SET account_sub_lead = '".$user."' WHERE id = '".$v."'";
		$alluser = $users->customQuery($sql);

	}
	echo "1";
	
}	

if(isset($_POST['clientId']) && !empty($_POST['clientId'])) {
	$mformate = new mediadata();
	$users = new User();
    $user = $_POST['clientId'];
	 $sql1="SELECT * FROM   project WHERE STATUS =1 AND P_O='' and po_Images_url='' and clientid =".$user." ORDER BY W_O";
 $user_client = $users->customQuery($sql1);
 $final_array = array();
 ?>
 <style>
 #optionRight{
	 float:right;
 }
 </style>
 <li class="list-group-item no-b">
                          <b>
                             <a href="javascript:;">Estimate No</a><a target="_blank" style="margin-left:100px;"href="javascript:;"> Project Name</a><a style="margin-right:50px; float: right;"href="javascript:;">Project Cost</a><a style="margin-right:150px; float: right;"href="javascript:;">Created At</a>
                        </b></li>
 <?
 foreach($user_client as $key=>$v){
					?>
					<li class="list-group-item no-b">
                            <span class="badge bg-120px"><i class="fa fa-inr"></i> <?= $mformate->moneyFormat($v['totalprice']); ?></span>
                             <a href="<?=$config['SITE_URL']."clientService.php?id=".$v['clientid']?>"><?= $v['W_O']?></a><a target="_blank" style="margin-left:50px;"href="<?=$config['SITE_URL']."estimatePdf.php?id=".$v['id']?>"><?= $v['project_name']?></a><a style="margin-right:100px; float: right;"href="javascript:;"><?= $v['created_at']?></a>
                        </li>
					
					<?
 }
  

}
if(isset($_POST['chkinvoice']))
{
	$id = $_POST['chkinvoice'];
	$minvoice = new media_invoice();
	$sql1='SELECT Invoice_No FROM  media_invoice WHERE Invoice_No ="'.trim($_POST['chkinvoice']).'"
	UNION ALL
	SELECT invoice_no FROM mise_invoice WHERE invoice_no ="'.trim($_POST['chkinvoice']).'"';
	//echo $sql1;
		$search = $minvoice->customQuery($sql1);
		if(empty($search)){
			echo "";
		}else{
			echo "Duplicate Invoice No";
		}
    
}

if(isset($_POST['checkuser']))
{
	$id = $_POST['checkuser'];
    $partner = new Partner();
    $selectedClient = $partner->findcustom(array('account_sub_lead'=>$id));
	foreach($selectedClient as $key=>$value)
	{
		?>
		<li><?php echo $value['partner_inhouse_name'] ?></li>
		<?php 
	}


}




if(isset($_POST['estimateNo']) && !empty($_POST['estimateNo'])) {
	$media_invoice = new media_invoice();
	$mformate = new mediadata();
	$project = new Project();
	$Publisher = new Publisher();
	$company=new Partner();
	$my_company = new my_company();
    $est = $_POST['estimateNo'];
	$isInvoiceBefore=$media_invoice->findcustom(array('campaignId'=>$est));
	 $sql1="SELECT * FROM media where campaignId =".$est."  and permission=1 and R_O!=''";
 $pub_value = $mformate->customQuery($sql1);
 $sql2="SELECT * FROM project where id =".$est;
 $project_value = $mformate->customQuery($sql2);
 $x = $project->getMonths($project_value[0]['project_start'],$project_value[0]['project_end']);
 $doneInvoiceMonth = array();
 $sql3="SELECT *, SUM(a.money) as m  FROM invoice_details as a, media_invoice as b where a.refId = b. id and b.campaignId = ".$est." group by a.pubid";
 $pubandmoneypaid = $mformate->customQuery($sql3);
 $pubmoney = array();
 foreach($pubandmoneypaid as $key=>$value)
 {
	$pubmoney[$value['pubId']] = $value['m'];
 }

	$clientinfo = $company->findcustomrow(array('id'=>$project_value[0]['clientid']));
	$bankinfo = $my_company->findcustomrow(array('id'=>$clientinfo["bank"]));
	$Bankdetails = $my_company->all();

 ?>
<div class="col-md-3">									 
    <div class="form-group">
            <label>Client Address</label>
        <div>
            <textarea name="address" class="form-control" rows="2" required=""><?php echo $clientinfo['official_address']." ".$clientinfo['state']." ".$clientinfo['country']." ".$clientinfo['postal_code']?></textarea>
        </div> 
    </div>
</div>
<div class="col-md-3">									 
    <div class="form-group">
            <label>Project Name</label>
        <div>
            <input type="text" placeholder="Project Name" name="pname" class="form-control" required>
        </div> 
    </div>
</div>
<div class="col-md-3">									 
    <div class="form-group">
            <label>Project Discription</label>
        <div>
            <textarea name="pdis" class="form-control" rows="2" required=""></textarea>
        </div> 
    </div>
</div>
<div class="col-md-3">									 
    <div class="form-group">
         <label for="recipient-name" class="control-label">Bank</label>
           <select class="form-control" name="bank" required="">
           <option value="">Select Bank</option>
           <?php 
           foreach ($Bankdetails as $key => $value) { ?>
           	<option value="<?php echo $value['id'] ?>" <?php if($value['id'] == $bankinfo['id']) echo"selected"; ?>><?php echo $value['bank_name'] ?></option>
        <?php   }
           ?>
			</select> 
    </div>
</div>
 <figure class="highlight" style="background-color: #F1F4F9;margin-bottom: 2em;">
 <table class="table table-bordered table-striped no-m">
	<thead>
		<tr>
			<th>Client Name</th>
				<th>Project Name</th>
			<th>Project Start</th>
			<th>Project End</th>
			<th>Project Cost</th>
			
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><?php  echo $clientinfo['partner_name']?></td>
			<td><?=$project_value[0]['project_name'] ?></td>
			<td><?=$project_value[0]['project_start'] ?></td>
			<td><?=$project_value[0]['project_end'] ?></td>
			<td><?=$mformate->moneyFormat($project_value[0]['totalprice']) ?></td>
		</tr>
	</tbody>
</table>
</figure> 
 <table class="table table-bordered table-striped no-m">
		<thead>
			<tr>
				<th>Publisher Name</th>
				<th>R.O. Amount</th>
				<th>Billed Amount</th>
				<th>Balance</th>
				<th>Current Amount</th> 
				<th>Balance</th>
			</tr>
		</thead>
		<tbody>
		<? if(!empty($isInvoiceBefore)) { ?>
		<figure class="highlight" style="background-color: #F1F4F9;margin-bottom: 2em;">
		<div class="row">
		<? foreach($isInvoiceBefore as $k=>$v)
		{ 
		$doneInvoiceMonth[] = $v['Invoice_month'];
		?>
			<a href="<?php echo $config['SITE_URL']."invoicePDF.php?action=media&month=".$v['Invoice_month']."&id=".$est."&mid=".$v['id'];?>" target="_blank" class="btn btn-default btn-sm" style="background-color: #FFF;margin-left: 1.2em;" data-toggle="tooltip" data-placement="top" title="<? echo $v['Invoice_No']?>" ><? echo $v['projectName']?></a>
		<? }
			?>
		</div>
		</figure> 
		<? } ?>
		<figure class="highlight" style="background-color: #F1F4F9;margin-bottom: 2em;">
		<div class="row">
		<div class="col-md-4"></div><div class="col-md-4">
		<select name='month' class='form-control' required style="width:100%">
														<option value=''>Select Month</option>
														<?
														foreach ($x as $dt) {
														?>
															<option value='<?php echo $dt->format("F-Y"); ?>' ><?php  if (in_array($dt->format("F-Y"), $doneInvoiceMonth))
    { echo $dt->format("F-Y")."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp; Done";} 
 else{ echo $dt->format("F-Y"); }?></option>
															   <?
															  
															}															
														?>
														
		</select>
		</div>
		</div>
		</figure> 
 <?
 foreach($pub_value as $key=>$v){
	 $pubname=$Publisher->findcustomrow(array('id'=>$v['publisher']));
	 ?>

		<tr>
			<td><?= $pubname['publisher_name']?></td>
			<input type="hidden" name="pub[]" value="<?=$pubname['id'] ?>" >
			<td><?=$mformate->moneyFormat($v['cost']);?></td>
			<td><?php if(isset($pubmoney[$pubname['id']])){
				echo $mformate->moneyFormat($pubmoney[$pubname['id']]);
			} ?></td>
			<td class="maxamount"><?php 
				echo $mformate->moneyFormat($v['cost']-@$pubmoney[$pubname['id']]);
			 ?></td>
			<td><input type="text" class="form-control auto" name="money[<?=$pubname['id'] ?>]" onblur="checkbalance(this)" onkeypress='return event.charCode >= 48 && event.charCode <= 57' data-d-group="2"></td>
			<td class="bal"></td>
		</tr>
                                            
                                       
 
 <?
 }
?>
</tbody>
 </table>
 
 <script>

 $('input').bind('cut copy paste', function (e) {
    e.preventDefault(); //disable cut,copy,paste
});
 </script>
 <script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
</script>

 <?
 }