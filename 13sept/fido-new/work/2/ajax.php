<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
{
    
$fileBasePath = dirname(__FILE__).'/';
include_once('include/actionHeader.php');

if(!isset($_COOKIE['user_info'])){
	exit();
}
else
{
    $userinfo = json_decode($_COOKIE['user_info'],true);
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
	$invoice_type = $_POST['invoice_type'];
	$id = $_POST['invCreate'];
    $mdata = new mediadata();
	$minvoice = new media_invoice();
	$project = new Project();
	$company=new Partner();
	$my_company = new my_company();
	$getValue = $minvoice->findCustom(array('campaignId'=>$id));
    $estimate=new category_estimate();
    $cat_sql="SELECT a.*,b.name FROM project_estimate_detail a INNER JOIN project_category b ON a.project_cat_id = b.id where project_id = ".$id." and a.reconciliation = 1";
    //echo $cat_sql;
    $cat_est = $estimate->customQuery($cat_sql);
	if(!empty($getValue)){
		echo '<div class="row marg_b_10">';
	foreach($getValue as $key=>$value)
	{
		echo '<div class="col-md-6 col-sm-12"><div><a target="_blank" href="'.$config["SITE_URL"].'invoicePDF.php?id='.$value["campaignId"].'&mInvoiceId='.$value["id"].'" id="inlineRadio1" style="
    color: #6d85c6;font-size: 15px;">'.$value["Invoice_No"].'&nbsp;&nbsp;&nbsp; '.$value["Invoice_month"].'</a></div></div>';
	}
	echo '</div>';
}
	$getEstNo = $project->findcustomrow(array('id'=>$id));
	$clientinfo = $company->findcustomrow(array('id'=>$getEstNo["clientid"]));
	$bankinfo = $my_company->findcustomrow(array('id'=>$clientinfo["bank"]));
	$Bankdetails = $my_company->all();
	?>
		<div class="row marg_b_15">
		<div class="col-md-6 col-sm-12">
			<div class="form-group">
			<label>Estimate NO: </label>
			<div class="input-group">
			<span class="input-group-addon"><i class="icon-qr-code"></i></span>
			<input type="hidden" name="inv_type" = value="<?php echo $invoice_type; ?>">
			 <input type="text" class="form-control" id="" value="<?php echo $getEstNo["W_O"] ?>" readonly value="">
			</div>
			<input type="hidden" value="<?php echo $id ?>" name="id" >
			</div>
		</div>
		<?php if($invoice_type != "performa") { ?>
		<div class="col-md-6 col-sm-12">
			<div class="form-group">
			<label>Invoice NO: </label>
			<div class="input-group">
			<span class="input-group-addon"><i class="icon-qr-code"></i></span>
			<input type="text" class="form-control" id="invoiceno" name="Invoiceno" required onblur="checkInvoice(this.value)">
			</div>
			</div>
			<div style="color: red;" id="invoiceresult" style=""></div>
		</div>
		<?php } ?>
		</div>
		
		<div class="row marg_b_15" style="margin-top: -20px;">
		<div class="col-md-6 col-sm-12">
			<div class="form-group">
			<label>Invoice Date: </label>
			<div class="input-group">
			<span class="input-group-addon"><i class="icon-calendar"></i></span>
			 <input type="text" class="form-control datepicker-text" name="Idate" id="" placeholder="YYYY-MM-DD" required data-language='en'>
			</div>
			</div>
		</div>
		<div class="col-md-6 col-sm-12">
			<div class="form-group">
			<label>Invoice Money: </label>
			<div class="input-group">
			<span class="input-group-addon"><i class="icon-rupee"></i></span>
			<input type="text" class="form-control" id="" name="Imoney" required>
			</div>
			</div>
		</div>
		</div>
	
		<div class="row marg_b_15">
		<div class="col-md-6 col-sm-12">
			<div class="form-group">
			<label>Invoice Start Date: </label>
			<div class="input-group">
			<span class="input-group-addon"><i class="icon-calendar"></i></span>
			<input type="text" class="form-control datepicker-text" name="ISdate" id="" placeholder="YYYY-MM-DD" required >
			</div>
			</div>
		</div>
		<div class="col-md-6 col-sm-12">
			<div class="form-group">
			<label>Invoice End Date: </label>
			<div class="input-group">
			<span class="input-group-addon"><i class="icon-calendar"></i></span>
			<input type="text" class="form-control datepicker-text" name="IEdate" id="" placeholder="YYYY-MM-DD" required >
			</div>
			</div>
		</div>
		</div>
		
		
		<div class="row marg_b_15">
		<div class="col-md-6 col-sm-12">
			<div class="form-group">
			<label>Client Address: </label>
			<div class="input-group">
			<textarea name="address" class="form-control" rows="3" required=""><?php echo $clientinfo['official_address']." ".$clientinfo['state']." ".$clientinfo['country']." ".$clientinfo['postal_code']?></textarea>
			</div>
			</div>
		</div>
		<div class="col-md-6 col-sm-12">
			<div class="form-group">
			<label>Engagement Description: </label>
			<div class="input-group">
			<textarea name="pdis" class="form-control" rows="3" required=""></textarea>
			</div>
			</div>
		</div>
		</div>
		
		<div class="row marg_b_15">
		<div class="col-md-6 col-sm-12">
			<div class="form-group">
			<label>Project Name: </label>
			<div class="input-group">
			 <input type="text" name="pname" class="form-control" id="" required="">
			</div>
			</div>
		</div>
		<div class="col-md-6 col-sm-12">
			<div class="form-group">
			<label>Bank: </label>
			<div class="input-group">
			<select class="form-control" name="bank" required="">
			<option value="">Select Bank</option>
			<?php
			foreach ($Bankdetails as $key => $value) { ?>
			<option value="<?php echo $value['id'] ?>" <?php if($value['id'] == $bankinfo['id']) echo"selected"; ?> > <?php echo $value['bank_name'] ?></option>
			<?php   }
			?>
			</select>
			</div>
			</div>
		</div>
			<script type="text/javascript">
			function checkInvoice(x)
			{
				if(x!=''){
					var value1 = $.ajax({
					type: "POST",
					url: "ajax.php",
					data: "chkinvoice="+x,
					async: false
					}).responseText;
					if (value1!='') {
					alert(value1);
					}

				}
			}

			</script>
		</div>
	
	
		<div class="row marg_b_15">
		<div class="col-md-6 col-sm-12">
		<div class="form-group">
		<label>Invoice PO: </label>
		<div class="input-group">
		<span class="input-group-addon"><i class="icon-newspaper"></i></span>
		<input type="text" class="form-control" id="" name="invoicepo" required>
		</div>
		</div>
		</div>
		</div>

	<?php if($invoice_type != "performa") { ?>
		<div class="row marg_b_15">
		<div class="col-md-12">
			<div class="chkbox_cstm_wpr marg_b_10" style="font-style: italic;font-size: 10px;">
				<label class="marg_0 col-md-6" style="padding:0">
				<div class="chbx_style"><input id="forNoBreakUp" type="checkbox" class="shwInput"><span></span></div> Skip breakup of services
				</label>
			</div>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>S.No.</th><th>Service</th><th>Estimate Amount</th><th>Invoce Amount</th>
					</tr>
				</thead>
				<tbody>
					<!--<tr><label><input id="forNoBreakUp" style="margin-right: 7px;" type="checkbox"> <em> Skip breakup of services</em></label></tr>-->
					<?php $i=1; foreach($cat_est as $key=>$value){ ?>

				<tr>
					<td><?php echo $i; ?></td>
					<td><?php echo $value['name'] ?></td>
					<td><?php echo $mdata->numberToCurrency($value['price']); ?></td>
					<td><input type="text" class="form-control brackup" id="" name="service[<?php echo $value['project_cat_id'] ?>]" value="" required></td>
				</tr>
					<?php $i++;  } ?>
				</tbody>
			</table>
		</div>
		</div>
	<?php } ?>
	<script>
	$('#forNoBreakUp').change(function() {
	if(this.checked){
	   $('.brackup').removeAttr('required').prop("readonly", true);
	}
	else{
		$('.brackup').attr('required', 'required').prop("readonly", false);
	}
	//'unchecked' event code
	});
	</script>

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

if(isset($_POST['userforclients']) && !empty($_POST['userforclients']) && !empty($_POST['client'])) {
	
	$users = new User();
    $user = $_POST['userforclients'];
	$client = $_POST['client'];
    
    $user_client = new user_client();

    $cond = "user_id = ".$user;

    $output = $user_client->findWhere($cond);

    if(!empty($output)){

    	$user_client->deleteCustom("user_id",$user);

    }

	foreach($client as $k=>$v)
	{
        $user_client->entity_relation = "user client";
        $user_client->user_id = $user;
        $user_client->client_id = $v;
        $user_client->create();
		

	}
	echo "yes";

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
 <?php 
 foreach($user_client as $key=>$v){
					?>
					<li class="list-group-item no-b">
                            <span class="badge bg-120px"><i class="fa fa-inr"></i> <?php echo  $mformate->moneyFormat($v['totalprice']); ?></span>
                             <a href="<?php echo $config['SITE_URL']."clientService.php?id=".$v['clientid']?>"><?php echo  $v['W_O']?></a><a target="_blank" style="margin-left:50px;"href="<?php echo $config['SITE_URL']."estimatePdf.php?id=".$v['id']?>"><?php echo  $v['project_name']?></a><a style="margin-right:100px; float: right;"href="javascript:;"><?php echo  $v['created_at']?></a>
                        </li>

					<?php
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
			echo "Duplicate Invoice No \n\n";

			$sql2='SELECT Invoice_No FROM  media_invoice UNION ALL SELECT invoice_no FROM mise_invoice ORDER BY Invoice_No  desc limit 1';
			$Invoicelast = $minvoice->customQuery($sql2);
			echo "Last Invoice No is ".$Invoicelast[0]['Invoice_No'];
		}

}

if(isset($_POST['checkuser']))
{
	$id = $_POST['checkuser'];
    $clientType = $_POST['clientType'];
    $partner = new Partner();
    $user_client = new user_client();

    $cond = "user_id = ".$id;

    $output = $user_client->findWhere($cond);

    if (!empty($output)) {

    	$all_clients = $partner->getPartners();

    	$client_array='';

    	foreach ($all_clients as $k => $v) {
    		$client_array[$v['id']] = $v;
    	}
    	//print_r($client_array);
    	foreach ($output as $key => $value) {
    		
			echo '<option value="'.$client_array[$value['client_id']]['id'].'">'.$client_array[$value['client_id']]['partner_inhouse_name'].'</option>';

    	}

    } else {
    	
    }
   
}




if(isset($_POST['estimateNo']) && !empty($_POST['estimateNo'])) {
	$media_invoice = new media_invoice();
	$mformate = new mediadata();
	$project = new Project();
	$Publisher = new Publisher();
	$company=new Partner();
	$my_company = new my_company();
    $other_values = new other_values();
    $others = $other_values->all();
    $est = $_POST['estimateNo'];
	//$isInvoiceBefore=$media_invoice->findcustom(array('campaignId'=>$est));
	$sql9="select * from media_invoice where campaignId = ".$est." and isMedia = 1";
	$isInvoiceBefore = $media_invoice->customQuery($sql9);
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
	$pubmoney[$value['refmediaId']] = $value['m'];
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
<div class="col-md-2">
    <div class="form-group">
            <label>Project Discription</label>
        <div>
            <textarea name="pdis" class="form-control" rows="2" required=""></textarea>
        </div>
    </div>
</div>
<div class="col-md-2">
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
<div class="col-md-2">
<div class="form-group">
            <label>PO No</label>
        <div>
            <input name="invoicepo" class="form-control"  required="">
        </div>
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
			<td><?php echo $project_value[0]['project_name'] ?></td>
			<td><?php echo $project_value[0]['project_start'] ?></td>
			<td><?php echo $project_value[0]['project_end'] ?></td>
			<td><?php echo $mformate->moneyFormat($project_value[0]['totalprice']) ?></td>
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
		<?php if(!empty($isInvoiceBefore)) { ?>
		<figure class="highlight" style="background-color: #F1F4F9;margin-bottom: 2em;">
		<div class="row">
		<?php foreach($isInvoiceBefore as $k=>$v)
		{
		$doneInvoiceMonth[] = $v['Invoice_month'];
		?>
			<a href="<?php echo $config['SITE_URL']."invoicePDF.php?action=media&month=".$v['Invoice_month']."&id=".$est."&mid=".$v['id'];?>" target="_blank" class="btn btn-default btn-sm" style="background-color: #FFF;margin-left: 1.2em;" data-toggle="tooltip" data-placement="top" title="<?php echo $v['Invoice_No']?>" ><?php echo $v['projectName']?></a>
		<?php }
			?>
		</div>
		</figure>
		<?php } ?>
		<figure class="highlight" style="background-color: #F1F4F9;margin-bottom: 2em;">
		<div class="row">
		<div class="col-md-4"></div><div class="col-md-4">
		<select name='month' class='form-control' required style="width:100%">
            <option value=''>Select Month</option>
            <?php
            foreach ($x as $dt) {
            ?>
                <option value='<?php echo $dt->format("F-Y"); ?>' ><?php  if (in_array($dt->format("F-Y"), $doneInvoiceMonth))
                { echo $dt->format("F-Y")."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp; Done";}
                else{ echo $dt->format("F-Y"); }?></option>
                   <?php

                }
            ?>

		</select>
		</div>
		</div>
		</figure>
             
<div class="row" style="margin-bottom: 20px;">
    <div class="col-md-3"></div>
  <div class="col-md-3">
    <div class="input-group">
      <span class="input-group-addon">
        <input type="checkbox" id="iscommision" aria-label="..." name="iscommision" value="yes">
      </span>
      <input type="text" class="form-control" name="iscommision_val" aria-label="..." value="" placeholder="Others">
    </div>
  </div>
    <div class="col-md-3"> 
        <div class="input-group">
            <select class="form-control" name="iscommision_val_drop">
                <option value="">Select Other</option>
                <?php 
                foreach($others as $k=>$v){ ?>
                    <option value="<?php echo $v['id']?>"><?php echo $v['value']?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="col-md-3">
        <div class="input-group">
            <input type="text" class="form-control" name="iscommision_money" value="" placeholder="Money">
        </div>
    </div>
</div>
 <?php
 foreach($pub_value as $key=>$v){
	 $pubname=$Publisher->findcustomrow(array('id'=>$v['publisher']));
	 ?>

		<tr class="hide_on_commision">
			<td><?php echo $pubname['publisher_name']?></td>
			<input type="hidden" name="pub[<?php echo $v['id'] ?>]" value="<?php echo $pubname['id'] ?>" >
			<td><?php echo $mformate->moneyFormat($v['cost']);?></td>
			<td><?php if(isset($pubmoney[$v['id']])){
				echo $mformate->moneyFormat($pubmoney[$v['id']]);
			} ?></td>
			<td class="maxamount"><?php
				echo $mformate->moneyFormat($v['cost']-@$pubmoney[$v['id']]);
			 ?></td>
			<td><input type="text" class="form-control auto" name="money[<?php echo $v['id'] ?>]" onblur="checkbalance(this)" onkeypress='return event.charCode >= 48 && event.charCode <= 57' data-d-group="2"></td>
			<td class="bal"></td>
		</tr>



 <?php
 }
?>
</tbody>
 </table>

 <script>
$(document).ready(function(){
    $('#iscommision').change(function() {
        if(this.checked) {
            $(".hide_on_commision").hide();
        }
        else{
            $(".hide_on_commision").show();
        }       
    });
    $('[data-toggle="tooltip"]').tooltip();
});
    
</script>

 <?php
 }

 if(isset($_GET['action']) && $_GET['action']=='up_down_cell')
 {
	 $mformate = new mediadata();
	 $_POST = (array)json_decode(file_get_contents("php://input"));
     foreach ($_POST as $key => $value) {
			 $mformate->id = $value->id;
			 $mformate->cost = $value->optionValue;
     	 $mformate->save();
     }
		 echo 1;
 }

if(isset($_GET['action']) && $_GET['action']=='up_down_cell')
 {
	 $mformate = new mediadata();
	 $_POST = (array)json_decode(file_get_contents("php://input"));
     foreach ($_POST as $key => $value) {
			 $mformate->id = $value->id;
			 $mformate->cost = $value->optionValue;
     	 $mformate->save();
     }
		 echo 1;
 }

if(isset($_GET['action']) && $_GET['action']=='user_hierarchy')
 {
	 $_POST = json_decode(file_get_contents("php://input"),true);
   
     $UserSave = new UserSave();
     $UserSave->id = 1;
     $UserSave->jsontext = file_get_contents("php://input");
     $UserSave->save();
        function array_values_recursive($array,$parent=0) {
            
            $users=new user();
            foreach($array as $key=>$value)
            {
                $sql="update users set parent_id=".$parent." where id=".$value['id'];
                $users->customQuery($sql);
                if(isset($value['children']))
                {
                    array_values_recursive($value['children'],$value['id']);
                }
            }
           
        }
     array_values_recursive($_POST,$parent=0);
}

if(isset($_GET['action']) && $_GET['action']=='change_ro_date')
 {
     function check_in_range($start_date, $end_date, $date_from_user)
        {
          $start_ts = strtotime($start_date);
          $end_ts = strtotime($end_date);
          $user_ts = strtotime($date_from_user);
          return (($user_ts >= $start_ts) && ($user_ts <= $end_ts));
        }
     $project = new Project();
     $camp_info = $project->find($_POST['camid']);
     check_in_range($camp_info['project_start'], $camp_info['project_end'], $_POST['sdate']);
     if(check_in_range($camp_info['project_start'], $camp_info['project_end'], $_POST['sdate']) && check_in_range($camp_info['project_start'], $camp_info['project_end'], $_POST['edate'])){
         $mformate = new mediadata();
         $mformate ->id = $_POST['rid'];
         $mformate ->start_date = $_POST['sdate'];
         $mformate ->end_date = $_POST['edate'];
         $mformate->save();
        echo json_encode(array("success"=>"true","msg"=>"Date is changed."));
     }
     else{
         echo json_encode(array("success"=>"false","msg"=>"These dates are out of date of estimate. please change estimate date first"));
     }
     die;
	 
 }

if(isset($_GET['action']) && $_GET['action']=='request_est_date')
 {  
        
        $project = new Project();
        $project->id = $_POST['camid'];
        $project->request_date = 1;
        $project->save();
       echo json_encode(array("success"=>"true","msg"=>"Conatact to BS head for change."));
     die;
	 
 }
if(isset($_GET['action']) && $_GET['action']=='change_est_date')
 {  
        
        $project = new Project();
        $project->id = $_POST['change_date_request_id'];
        $project->project_start = $_POST['sdate'];
        $project->project_end = $_POST['edate'];
        $project->save();
       echo json_encode(array("success"=>"true","msg"=>"date have been updated."));
     die;
	 
 }

if(isset($_GET['action']) && $_GET['action']=='aop')
 { 
    $projection = new projection();
    $aopobj= new Aopversion();
   
    $year= $_GET['year'];
    if(!empty($_GET['id']))
    {
        $allprojectiondata = $projection->selectalllbyversion($_GET['id']);
       // $aoplist=$aopobj->selectversion($_GET['id']);
    }else{
        $allprojectiondata = $projection->selectalllbyversion('',$year);
        //$aoplist=$aopobj->selectversion('',$year);
       
 }
     echo json_encode(array("status"=>"true","result"=>$allprojectiondata));
}
if(isset($_GET['action']) && $_GET['action']=='change_est_contact_person')
{ 
    $info = new customer_contact_info();
    if(isset($_POST['id'])){
    $name      = trim($_POST["name"]);
    $id   = $_POST["id"];
    $phone    = trim($_POST["phone"]);
    $email       = trim($_POST["email"]);
        $info->id=$id;
        $info->name=$name;
        $info->email=$email;
		$info->designation=$phone;
        $info->save();
    } 
    else{
    $name      = trim($_POST["name"]);
    $clientId   = $_POST["clientidContact"];
    $phone    = trim($_POST["phone"]);
    $email       = trim($_POST["email"]);
        $info->client_id=$clientId;
        $info->name=$name;
        $info->email=$email;
		$info->designation=$phone;
        $info->create();
    }
    echo "yes";
		
}

if(isset($_GET['action']) && $_GET['action']=='change_client_commision')
{ 
    print_r($_POST);
    $info = new PartnerCommisionSection();
    if(isset($_POST['id'])){
    $newComm      = trim($_POST["newComm"]);
        $id  = $_POST["id"];
        $info->id=$id;
        $info->commision=$newComm;
        $info->save();
    }
    if(!isset($_POST['id'])){
    $clientId   = $_POST["clientidContact"];
    $newComm      = trim($_POST["newComm"]);
        $info->commision=$newComm;
        $info->service_id=2;
        $info->fee=0;
		$info->totalFee=1;
        $info->partner_id=$clientId;
        $info->created_on=date("Y-m-d H:i:s");
        $info->modified_on=date("Y-m-d H:i:s");
        $info->create();
    }
		
}

if(isset($_REQUEST['action']) && $_REQUEST['action']=='dashboardpie')
{
    
    $projection = new projection();
    $project  = new project();
    $clientid=$_REQUEST['clientid'];
    $aopid=$_REQUEST['aopid'];
    
    $type=$_REQUEST['type'];
    if(isset($_REQUEST['year']) && empty($_REQUEST['year'])){
        $year=date('Y');
        $date=date("Y-03-31");
        $currentdate=date("Y-2-d");
        if(strtotime($date) > strtotime($currentdate))
        {
        $year= date("Y").'-'.(date('Y')+1);
        }else
        {
        $year= (date("Y")-1).'-'.(date('Y'));
        }
    }else
    {
        $year=$_REQUEST['year'];
    }
    if(!empty($aopid)){
        $sql="select * from projection  where client_id='".$clientid."' and aopid='".$aopid."'";
    }else
    {
         $sql="select * from projection  where client_id='".$clientid."' and aopid='(select id from aopversion where active=1 and year='".$year."";
    }
    
    $aopresult = $projection->customQuery($sql);
    if(!empty($aopresult))
    {
        $result['client_name']=$aopresult[0]['client_name'];
        $result['total']=$aopresult[0]['total'];
        $result['quarter1']=$aopresult[0]['quarter1'];
		$result['quarter2']=$aopresult[0]['quarter2'];
        $result['quarter3']=$aopresult[0]['quarter3'];
        $result['quarter4']=$aopresult[0]['quarter4'];
        
        if(date('m')<4){
            $result['monthly']= $result['quarter4']/3;
            $result['quarter']=$aopresult[0]['quarter4'];
        }else if(date('m')>=4 && date('m')< 7){
            $result['monthly']= $result['quarter1']/3;
             $result['quarter']=$aopresult[0]['quarter1'];
        }
        else if(date('m')>=7 && date('m')< 10){
            $result['monthly']= $result['quarter2']/3;
             $result['quarter']=$aopresult[0]['quarter2'];
        }
        else if(date('m')>=10 && date('m')<= 12){
            $result['monthly']= $result['quarter3']/3;
             $result['quarter']=$aopresult[0]['quarter3'];
        }
        switch($type){
            case 'quaterly':
                    $result['total']= $result['quarter'];
                break;
            case 'monthly':
                    $result['total']= $result['quarter']/3;
                break;
            case 'yearly':
                    $result['total']=$result['total'];
                break;
                
        }
        
    }
    else
    {
        $result['client_name']=0;
        $result['total']=0;
        $result['quarter']=0;
        $result['monthly']=0;
      
    }
    
    $revenue = $project->clientViseRevenue($clientid,$type);
    if(!empty($revenue))
    {   $totalrevenue=0;
    
        foreach($revenue as $key=>$value)
        {
           #  echo '<pre>'; print_R($value); echo '<pre>';
            $totalrevenue+=$value['revenue'];
        }
           // $result['revenue']= $revenue[0]['revenue'];
              //  $totalrevenue=$totalrevenue;
            $result['revenue']=$totalrevenue;
         /*   $result['revenue']= $revenue[0]['revenue'];
            $result['revenue']= $revenue[0]['revenue'];
            $result['revenue']= $revenue[0]['revenue'];
            $result['revenue']= $revenue[0]['revenue'];*/
    }else
    {
           $result['revenue']=0;
        
    }
    echo json_encode($result);
    
    
    
    
}

if(isset($_REQUEST['changepwd']))
{
  
   # echo '<pre>'; print_r($userinfo);echo '</pre>';
    if($_POST['password']==$_POST['confirm'])
    {
         $user=new user();
        $result= $user->findcustomrow(array('id'=>$userinfo['id']));
      
        if(md5($_POST['oldpassword'])==$result['password'])
        {
            $sql="update users set password='".md5($_POST['password'])."' where id='".$userinfo['id']."'";
            
            $result = $user->customQuery($sql);
             echo json_encode(array('status'=>true,'result'=>0));
           
        }else
        {
             echo json_encode(array('status'=>false,'result'=>1));
        }
    }
    else
    {
        echo json_encode(array('status'=>false,'result'=>2));
    }
}
if(isset($_GET['action']) && $_GET['action']=='outstanding')
 {  
        
     $cname = $_POST['clientname'];
     $outstanding_payment = new old_outstanding_payment();
     $res = $outstanding_payment->findCustom(array('client_name'=>$cname));
     echo json_encode($res);
     die;
	 
 }
if(isset($_GET['action']) && $_GET['action']=='load_notification_red')
 {  
     if($userinfo['type'] == 6){
         $userid = 6;
     }elseif($userinfo['type'] == 5){
         $userid = 5;
     }else{
         $userid = $userinfo['id'];
     }
     
    if($_POST["view"] != '')
    {   
        
        $notification = new notification();
        $update_query = "update notification set active = 0 where user_id = ".$userid." AND danger = 1 and active = 1";
        $red_noti = $notification->customQuery($update_query);
        
    }
        $notification = new notification();
        $sql_noti = "SELECT * FROM notification WHERE user_id = ".$userid." AND danger = 1 ORDER BY id DESC LIMIT 5";
        $red_noti = $notification->customQuery($sql_noti);
        $output='';
        if(count($red_noti) > 0){
            foreach($red_noti as $k1=>$v1){
                $cdate = explode(" ",$v1['cdate']);
                $output .= '
                <li class="media notification-message">
                    <a href="estimate.php?search='.$v1["url"].'">
                    <div class="media-body">
                      <p class="noti-details">'.htmlspecialchars_decode($v1["comment"]).'</p>
                      <span class="notification_time"><i class="icon-calendar6"></i> '.date("M d", strtotime($cdate[0])).' at '.date("h:i A", strtotime($cdate[1])).'</span>
                    </div>
                    </a>
                </li>';
                }
        }else {
            $output .= '<li style="position:  absolute;top: 50%;width: 100%;text-align: center;transform: translate(0,-50%); "><a style="font-weight: 400;color: gray;font-size: 15px;cursor: default; " href="javascript:;" >No Notification Found</a></li>';
        }
     $sql_noti_red = "SELECT * FROM notification WHERE user_id = ".$userid." AND danger = 1 and active = 1";
    $red_noti_count = $notification->customQuery($sql_noti_red);
    $c = count($red_noti_count);
       $data = array(
          'notification'   => $output,
          'unseen_notification' => $c
        );
	 echo json_encode($data);
 }

if(isset($_GET['action']) && $_GET['action']=='load_notification_green')
 {
    
     if($userinfo['type'] == 6){
         $userid = 6;
     }elseif($userinfo['type'] == 5){
         $userid = 5;
     }else{
         $userid = $userinfo['id'];
     }
     
    if($_POST["view"] != '')
    {   
        
        $notification = new notification();
        $update_query = "update notification set active = 0 where user_id = ".$userid." AND danger = 0 and active = 1";
        $green_noti = $notification->customQuery($update_query);
        
    }
        $notification = new notification();
        $sql_noti = "SELECT * FROM notification WHERE user_id = ".$userid." AND danger = 0 ORDER BY id DESC LIMIT 5";
        $green_noti = $notification->customQuery($sql_noti);
        $output='';
        if(count($green_noti) > 0){
            foreach($green_noti as $k1=>$v1){
                $str_explpde = explode(" ",$v1["comment"]);
                $last_str = str_replace($str_explpde[0],"<strong>$str_explpde[0]</strong>",$v1["comment"]);
                $cdate = explode(" ",$v1['cdate']);
                $output .= '
                <li class="media notification-message">
                    <a href="estimate.php?search='.$v1["url"].'">
                    <div class="media-body">
                      <p class="noti-details">'.htmlspecialchars_decode($v1['comment']).'</p>
                      <span class="notification_time"><i class="icon-calendar6"></i> '.date("M d", strtotime($cdate[0])).' at '.date("h:i A", strtotime($cdate[1])).'</span>
                    </div>
                    </a>
                </li>';
                }
        }else {
            $output .= '<li style="position:  absolute;top: 50%;width: 100%;text-align: center;transform: translate(0,-50%); "><a style="font-weight: 400;color: gray;font-size: 15px;cursor: default; " href="javascript:;" >No Notification Found</a></li>';
        }
     $sql_noti_green = "SELECT * FROM notification WHERE user_id = ".$userid." AND danger = 0 and active = 1";
    $green_noti_count = $notification->customQuery($sql_noti_green);
    $c = count($green_noti_count);
       $data = array(
          'notification'   => $output,
          'unseen_notification' => $c
        );
	 echo json_encode($data);
 }

 if (isset($_GET['client_payment_info']) && !empty($_GET['client_payment_info'])) {
    $x = $_GET['client_payment_info'];
    $mformate = new mediadata();

    $payment_info = (new payment())->getRestPaymentInfoByClient($x);
    $counter = 2;
    foreach ($payment_info as $key => $value) { 

    	$all_money = 0;

    	if ($value['commision']) {
    		$all_money = $value['moneywithtex'] + ($value['moneywithtex']*$value['com']/100);
    	} else {
    		$all_money = $value['moneywithtex'];
    	}


    ?>
         
    <tr class="<?php if ($counter % 2 == 0){ echo "odd_tr_clr"; } else { echo "even_tr_clr"; } ?>">
     
                <td>
					
					<div class="chkbox_cstm_wpr">
						<label class="marg_0">
							<div class="chbx_style"><input type="checkbox" class="chk" name="clientid[<?= $value['id'];?>]" value="<?=  $value['id'];?>" class="shwInput" /><span></span></div>
						</label>
					</div>
                </td>
                <td>
                    <?=  $value['Invoice_No'];?> 
                </td>
                <td>
                     <?=  $mformate->currencyFormatCountry($all_money,$value['isIndian']);?>
                </td>
                <td>
                     <?=  $mformate->currencyFormatCountry(($all_money-$value['moneywithtds']),$value['isIndian']);?>
                </td>
                <td>
                    <input type="hidden"  type="number" name="bal[<?=  $value['id'];?>][pay_money]" class="bal_<?=  $value['id'];?>" value="<?=  $all_money-$value['moneywithtds'];?>">
                    <input type="number" step=".01" class="money_<?=  $value['id'];?>" name="money[<?=  $value['id'];?>][pay_money]" class="form-control" placeholder="" min="0" disabled> 
                </td>
                <td>
                    <input type="number" step=".01" class="tds_<?=  $value['id'];?>"  name="money[<?=  $value['id'];?>][tds]" class="form-control" placeholder="" min="0" disabled>
                </td>
                <td style="width: 300px;">
                    <input style="float: left;" type="number" step=".01" class="shot_and_excess_<?=  $value['id'];?>"  name="money[<?=  $value['id'];?>][shot]" class="form-control" placeholder="" min="0" disabled> 
                    <button style="display: none; float: right;" onclick="shor_update('<?=  $value['id'];?>')" type="button" name="submit_shot" class="btn btn-primary ui-wizard-content btn-sm submit_shot_<?=  $value['id'];?>">Update</button>
                </td>

            </tr>
            <tr class="<?php if ($counter % 2 == 0){ echo "odd_tr_clr"; } else { echo "even_tr_clr"; } ?>">
                <td class="error_show error_row_<?=  $value['id'];?>" colspan="3"></td>
                <td class="bal_sh bal_row_<?=  $value['id'];?>" colspan="3"></td>
            </tr>
            
            
     <?php 
        $counter++;
    } 
    ?>
    <script type="text/javascript">
                $('.chk').click(function(){
                    var cur=$(this).val();
                    if($(this).is(':checked')){ 
                    $('.money_'+cur).attr("disabled", false);
                    $('.tds_'+cur).attr("disabled", false);
                    $('.shot_and_excess_'+cur).attr("disabled", false);
                    $('.tds_'+cur ).on('input', function() {
                        var x = parseFloat($('.money_'+cur).val());
                        var y = parseFloat($('.tds_'+cur).val());
                        var z = parseFloat($('.bal_'+cur).val());

                        z = z.toFixed(2);

                        if(isNaN(y)){
                            var y = 0;
                        }

                        if(isNaN(x)){
                            var x = 0;
                        }
                 
                        var run_bal = z-(x+y);

                        if(x+y == 0){
                        	$('.bal_row_'+cur).text('');
                        }else{
                        	$('.bal_row_'+cur).text(run_bal.toLocaleString('en-IN', {
								    maximumFractionDigits: 2,
								    style: 'currency',
								    currency: 'INR'
								})
                        	); 
                        }
                        console.log(typeof z);
                        console.log(z);
                        if (z < (x+y)) {
                                $('.error_row_'+cur).text('Value greater then Balance') 
                             } else {
                                $('.error_row_'+cur).text(' ') 
                          }
                    });

                    $('.money_'+cur ).on('input', function() {
                        var x = parseFloat($('.money_'+cur).val());
                        var y = parseFloat($('.tds_'+cur).val());
                        var z = parseFloat($('.bal_'+cur).val());

                        z = z.toFixed(2);

                        if(isNaN(y)){
                            var y = 0;
                        }

                        if(isNaN(x)){
                            var x = 0;
                        }
                        
                        var run_bal = z-(x+y);

                        if(x+y == 0){
                        	$('.bal_row_'+cur).text('');
                        }else{
                        	$('.bal_row_'+cur).text(run_bal.toLocaleString('en-IN', {
								    maximumFractionDigits: 2,
								    style: 'currency',
								    currency: 'INR'
								})
                        	);
                        }

                        if (z < (x+y)) {
                                $('.error_row_'+cur).text('Value greater then Balance') 
                             } else {
                                $('.error_row_'+cur).text(' ') 
                          }
                    });
                        $(".shot_and_excess_"+cur).keyup(function () {
                       if ($(this).val()) {
                        //console.log("yes");
                          $(".submit_shot_"+cur).css('display','block');
                       }
                       else {
                        //console.log("no");
                          $(".submit_shot_"+cur).css('display','none');
                       }
                    });

                    }
                else{
                    $('.money_'+cur).prop("disabled", true);
                    $('.tds_'+cur).prop("disabled", true);
                    ('.shot_and_excess_'+cur).attr("disabled", true);
                }
                });


            </script>
            <?php
 }

 

 
 if (isset($_GET['client_balance_payment_info']) && !empty($_GET['client_balance_payment_info'])) {
    $x = $_GET['client_balance_payment_info'];
    $payment_info = new payment_info_update();
    $balPyamnet = $payment_info->findCustom(array('client_id' => $x )); 
	
	echo "";
	$i = 1;
    foreach ($balPyamnet as $key => $value) { 
        if(!empty($value['balance']) && $value['balance'] != 0){
        if($i == 1){
        ?>
    <div class='row marg_t_15'>
        <div class='col-md-12 col-sm-12 marg_b_10'>
            <label  style='color: #747474;font-size: 16px;'>Unallocated Money:</label>
        </div>
		<?php } ?>

	<div class="col-md-4">
		<div class="chkbox_cstm_wpr">
			<label class="marg_0" for="exampleRadios<?= $value['id']?>">
				<div class="chbx_style">
					<input class="shwInput unalocated shwInput" type="radio" name="bal_client" id="exampleRadios<?= $value['id']?>" value="<?= $value['balance'].'|'.$value['id']?>">
					<span class="radio_stl"></span></div>
					<?= $value['payment_mode']." No. : ".$value['mode_info']." and Balance : <strong>".$value['balance']."</strong>"; ?>
			</label>
		</div>
	</div>

		
       <!-- <div class="form-check text-center">
        <input class="form-check-input unalocated" type="radio" name="bal_client" id="exampleRadios<?= $value['id']?>" value="<?= $value['balance'].'|'.$value['id']?>">
        <label class="form-check-label" for="exampleRadios<?= $value['id']?>">
        <?= $value['payment_mode']." No. : ".$value['mode_info']." and Balance : ".$value['balance']; ?>
        </label>
        </div>-->

    <?php $i++; } ?>
    <script type="text/javascript">
        $("input[name='bal_client']").change(function(){
            console.log("yes");
            $("#bank").removeAttr('required');
            $("#mode").removeAttr('required');
            $("#mode_type").removeAttr('required');
            $("#full_payment").removeAttr('required');
        });

    </script>
    <?php }
	echo "</div>";
 }

 if (isset($_GET['short_payment']) && isset($_GET['shrt'])) {
        $payment = new payment();   
        $payment->money = trim($_GET['shrt']);
        $payment->tds = 0;
        $payment->refId = $_GET['short_payment'];
        $payment->payment_id = 0;
        $payment->createdAt = date("Y-m-d H:i:s");
        $payment->invoice_type = 'short_payment';
        $payment->create();
 }

 if (isset($_GET['client_payment_show']) && !empty($_GET['client_payment_show'])) {
    $a = $_GET['client_payment_show'];
    $connection = mysqli_connect("localhost", "newuser", "password", "fido");
    $payment_info_update = new payment_info_update();
    $mformate = new mediadata();
    $payment = new payment(); 

    if($a == 'all'){
        $counter = 1;
        $payment_info_client = $payment_info_update->paymentInfoForAllClients();
        foreach ($payment_info_client as $key => $value) {
           
        ?>
           <tr class="<?php if($counter%2) { echo 'odd_tr_stl'; } else { echo 'evn_tr_stl'; } ?>">
            <td><?= $counter; ?></td>
            <td>
                <div class="infoTbl_tlt">
                    <span class="title"><?= @$value['partner_name'];?></span><i class="fa fa-plus" id="trloop_<?= $counter;?>"></i>
                </div>
				<input class="srchFld trloop_<?= $counter;?>" id="2" type="text" placeholder="Search..">
            </td>
            <td><p><?= @$mformate->currencyFormatCountry($value['billed'],$value['isIndian']);?></p><input class="srchFld trloop_<?= $counter;?>" id="3" type="text" placeholder="Search.."></td>
            <td><p><?= @$mformate->currencyFormatCountry($value['billed'] - $value['total'],$value['isIndian']);?></p><input class="srchFld trloop_<?= $counter;?>" id="4" type="text" placeholder="Search.."></td>
            <td><p><?= @$mformate->currencyFormatCountry($value['m'],$value['isIndian']);?></p><input class="srchFld trloop_<?= $counter;?>" id="5" type="text" placeholder="Search.."></td>
            <td><p><?= @$mformate->currencyFormatCountry($value['t'],$value['isIndian']);?></p><input class="srchFld trloop_<?= $counter;?>" id="6" type="text" placeholder="Search.."></td>
            <td><p><?= @$mformate->currencyFormatCountry($value['total'],$value['isIndian']);?></p><input class="srchFld trloop_<?= $counter;?>" id="7" type="text" placeholder="Search.."></td>
        </tr>
        <?php 
             $z = $value['cid'];
            $rows = $payment->allPaymentInfoForclients($z);
            foreach($rows as $keys => $row){  
            	$all_money = 0;

	    	if ($row['isMedia']) {
	    		$all_money = $row['moneywithtex'] + ($row['moneywithtex']*$row['com']/100);
	    	} else {
	    		$all_money = $row['moneywithtex'];
	    	} 
        ?>
        <tr class="tr_stl_loop trloop_<?= $counter;?>" >
            <td></td>
            <td><?= $row['Invoice_No']; ?></td>
            <td><?= $mformate->currencyFormatCountry($all_money,$row['isIndian']); ?></td>
            <td><?= $mformate->currencyFormatCountry($all_money - $row['moneywithtds'],$row['isIndian']); ?></td>
            <td><?= $mformate->currencyFormatCountry($row['money'],$row['isIndian']); ?></td>
            <td><?= $mformate->currencyFormatCountry($row['tds'],$row['isIndian']); ?></td>
            <td><?= $mformate->currencyFormatCountry($row['moneywithtds'],$row['isIndian']); ?></td>
        </tr>
		<?php 
        }
        $counter++;
    }

}
    else{
    $result = mysqli_query($connection, "CALL paymentInfo($a)");
    $payment_info_client = $payment_info_update->paymentInfoByClient($a);
    
    ?>
    <tr class="odd_tr_stl">
            <td>1</td>
            <td>
                <div class="infoTbl_tlt">
                    <span class="title"><?= @$payment_info_client[0]['partner_name']?></span><i class="fa fa-plus" id="trloop_1"></i>
                </div>
				<input class="srchFld trloop_1" id="2" type="text" placeholder="Search..">
            </td>
            <td><?= @$mformate->currencyFormatCountry($payment_info_client[0]['billed'],$payment_info_client[0]['isIndian']);?><input class="srchFld trloop_1" id="3" type="text" placeholder="Search.."></td>
            <td><?= @$mformate->currencyFormatCountry($payment_info_client[0]['billed'] - $payment_info_client[0]['total'],$payment_info_client[0]['isIndian']);?><input class="srchFld trloop_1" id="4" type="text" placeholder="Search.."></td>
            <td><?= @$mformate->currencyFormatCountry($payment_info_client[0]['m'],$payment_info_client[0]['isIndian']);?><input class="srchFld trloop_1" id="5" type="text" placeholder="Search.."></td>
            <td><?= @$mformate->currencyFormatCountry($payment_info_client[0]['t'],$payment_info_client[0]['isIndian']);?><input class="srchFld trloop_1" id="6" type="text" placeholder="Search.."></td>
            <td><?= @$mformate->currencyFormatCountry($payment_info_client[0]['total'],$payment_info_client[0]['isIndian']);?><input class="srchFld trloop_1" id="7" type="text" placeholder="Search.."></td>
        </tr>
        <?php 
            while ($row = mysqli_fetch_array($result)){   

            	$all_money = 0;

	    	if ($row['isMedia']) {
	    		$all_money = $row['moneywithtex'] + ($row['moneywithtex']*$row['com']/100);
	    	} else {
	    		$all_money = $row['moneywithtex'];
	    	} 
            
        ?>
        <tr class="tr_stl_loop trloop_1" >
            <td></td>
            <td><?= $row['Invoice_No']; ?></td>
            <td><?= $mformate->currencyFormatCountry($all_money,$row['isIndian']); ?></td>
            <td><?= $mformate->currencyFormatCountry($all_money - $row['moneywithtds'],$row['isIndian']); ?></td>
            <td><?= $mformate->currencyFormatCountry($row['money'],$row['isIndian']); ?></td>
            <td><?= $mformate->currencyFormatCountry($row['tds'],$row['isIndian']); ?></td>
            <td><?= $mformate->currencyFormatCountry($row['moneywithtds'],$row['isIndian']); ?></td>
        </tr>
<?php 
}
    }
    ?>
<script type="text/javascript">
    $(document).ready(function(){
            
            $('.infoTbl_tlt i').click(function(){
                var idVal = $(this).attr('id');
                $(this).toggleClass('fa-minus');
                $(this).parents('.odd_tr_stl').toggleClass('actv_td');
                $(this).parents('.evn_tr_stl').toggleClass('actv_td');
                $('.'+idVal).toggle();
            })
            

        });

</script>
<?php  
}

if (isset($_POST['estimate_id']) && $_POST['type'] == 'invoice') {

	$x = $_POST['estimate_id'];

	$media_invoice = new media_invoice();

	$invoice_info = $media_invoice->showInvoiceInfoByEstimateNo($x);

	echo json_encode($invoice_info);


}

if (isset($_POST['invoice_id_for_creditnote']) && !empty($_POST['invoice_id_for_creditnote'])) {

	$id =  $_POST['invoice_id_for_creditnote'];

	$payment_info_update = new payment_info_update();

	$mformate = new mediadata();

	$info = $payment_info_update->getInvoiceInfo($id);

	$invoice_breakup;

	foreach ($info as $key => $value) {

		$invoice_breakup['money'] = $value['money'];

		if ($value['isMedia']) {

			$comm = $value['money']*$value['client_comm']/100;

			
		} else {

			 $comm = 0;
			
		}
		
		$invoice_breakup['comm'] = $comm;

		$invoice_breakup['money_comm'] = $value['money'] + $comm;

		if ($value['isIndian']) {

			$gst = ($value['money'] + $comm)*.18;
			
		} else {
			$gst = 0;
		}

		$invoice_breakup['gst'] = $gst;

		$invoice_breakup['amt'] = $gst + $value['money'] + $comm;

		$invoice_breakup['invoice_comm'] = $value['client_comm'];

		$invoice_breakup['invoice_isMedia'] = $value['isMedia'];

		$invoice_breakup['invoice_isIndian'] = $value['isIndian'];

		

	}

		echo json_encode($invoice_breakup);
}

if (isset($_GET['action']) && $_GET['action']=='client_contact_person_delete') {
	
    if(isset($_POST['id']) && !empty($_POST['id'])){
    	$info = new customer_contact_info();
    	$id = $_POST['id'];
    	$info->delete($id);
    	echo "yes";
    }else{
    	echo "no";
    }
}

    
}else{
    die('Direct access not permitted');
}
?>

