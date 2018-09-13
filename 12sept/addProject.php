<?php include('include/header-files.php'); ?>

<!-- write your custom css and js here -->

<!-- write your custom css and js here -->

<!-- Header begins -->
<?php include('include/header-new.php'); ?>


<?php


$fileBasePath = dirname(__FILE__).'/';

    /*
    *	Redirect Admin To Home Page
    *	If Already Logged In
    */

	$info = new customer_contact_info();
	$serviceTex = new service_tex_details();
    $serviceTexs = $serviceTex->all();
    $project  = new project();
    $category = new Category();
    $company=new Partner();
    $estimate=new category_estimate();
    $currencies = new currencies();
    $allCurrencies = $currencies->all();
    $allCategories = $category->all();
    if($userinfo['type'] == 2){
      
        $clientlist = $company->getClientInfoByUserAssign($userinfo['id']);
        
    }
    else{
        $clientlist=$company->all();
    }
    $partner_cat_com = new PartnerCommisionSection();


 //  $allLanguages = $language->getColumns();
	if(isset($_POST['projectname'])){

	$result= $project->findcustomrow(array('project_name'=>$_POST['projectname']));
	if(empty($result))
	{


	$workOrder = new WorkOrder2017();
	$wo1 = $workOrder->max('wo');
	$Fyear=$project->getFinancialYear();
	$wo2 = work_order_maker($wo1);
	$wo = "REQUISITION/".$Fyear."/".$wo2;
	$workOrder->wo = ($wo1+1);
	$workOrder->create();
    $commForPro = ($_POST['commForPro'] == '' ? 0 : $_POST['commForPro'] );
	$project->project_name = trim($_POST['projectname']);
	$project->project_start	 = trim($_POST['projectstart']);
	$project->project_end	 = trim($_POST['projectend']);
	$project->clientid	 = $_POST['client'];
	$project->address_id	 = $_POST['address'];
	$project->Requisition_No	 = $wo;
	$project->userid=$userinfo['id'];
	$project->status=0;
	$project->client_account_lead=$_POST['account_lead'];
	$project->currency_id=trim($_POST['currency']);
	$project->created_at=date('Y-m-d H:i:s');
    $project->update_at=date('Y-m-d H:i:s');
	$project->est_type=$_POST['typeest'];
    $project->f_year=$Fyear;
    $project->commision=$commForPro;
	$_SESSION['msg'] = "Project has been added successfully";
	$project->create();
	$projectid=$project->lastInsertId();
	$estimate->project_id=$projectid;
	$total=0;
	if(isset($_POST['description']) && !empty($_POST['description']))
	{
		$project_description = new project_description();
		$project_description->project_id = $projectid;
		$project_description->description =  trim($_POST['description']);
		$project_description->create();


	}
	foreach($_POST['cat'] as $key=> $value)
	{
		$estimate->project_cat_id=$value;
		$estimate->price=str_replace(',','', $_POST['price'][$key]);
		$estimate->approve=0;
		$estimate->create();
		$total=$total+str_replace(',','', $_POST['price'][$key]);

	}
	@$errors = array_filter($_POST['comm']);
	if(!empty($errors))
	{
		$partner_cat_com = new PartnerCommisionSection();
		foreach($_POST['cat'] as $key=> $value)
		{
		$partner_cat_com->commision=$_POST['comm'][$key];  str_replace(',','', $_POST['Fee']);
		$partner_cat_com->service_id=$key;
		$partner_cat_com->fee=str_replace(',','', $_POST['price'][$key]);
		$partner_cat_com->totalFee=str_replace(',','', $_POST['price'][$key]);
		$partner_cat_com->partner_id=$_POST['client'];;
		$partner_cat_com->created_on=date('Y-m-d H:i:s');
	    $partner_cat_com->modified_on=date('Y-m-d H:i:s');
	    $partner_cat_com->create();

		}

	}
	$comp = $company->findcustomrow(array('id'=>$_POST['client']));
	$user = new User();
		//echo $total;
	$project->id=$projectid;
	$project->totalprice=$total;
	$project->save();
	if($userinfo['type'] == 1)
	{
    	$useremail = $userinfo['email'];
    	$username = $userinfo['name'];
    	$userid = $userinfo['id'];
	}else{
		$usermails = $user->getParantInfo($userinfo['id']);
		$useremail = $usermails[0]['email'];
		$username = $usermails[0]['name'];
		$userid = $usermails[0]['id'];
	}

        
$message.= "A New Estimate Requisition has been created by ".$userinfo['name'].".<br><br>";
$message.= "PFB further details: <br><br>";
$message.= "<strong>Project Name :- ".trim($_POST['projectname']).".<br><br>  Client:- ".$comp['partner_name']."</strong>";
                $urlforservice = ($config['API_BASE_URL']."sendmail");
				
					$data['email']=$useremail;
				
					$data['name']=$username;
				
					$data['id']=$userid;
				
                $data['msg']=$message;
                $data['subject'] ='New Estimate Created';
                $services = postCURL($urlforservice,$data);
        
                $cmnt = "A New Estimate Requisition has been created of the client <strong>".$comp['partner_name']."</strong> and project name is <strong>".trim($_POST['projectname'])."</strong> by <strong>".$userinfo['name']."</strong>";
                saveNotification($data['id'],$cmnt,0,'',1);

        $people = array(3,11,13,18);
        if($userinfo['type'] == 12)
        {
            redirectAdmin('content.php');
        }
        else if($userinfo['type'] == 4)
        {
            redirectAdmin('digitalPR.php');
        }
        else if(in_array($userinfo['type'], $people))
        {
        	redirectAdmin('globelServices.php');
        }
        else
        {
            redirectAdmin('estimate.php');
        }
	//redirectAdmin('estimate.php');

}
else
{
$_SESSION['msg'] = "This Campaign Name is already EXists";
	//redirectAdmin('userManagement.php');
}
}
$userdata=json_decode($_COOKIE['user_info']);
if(isset($userdata) && !empty($userdata)){
	$user_type=$userdata->type;
}else{
	$user_type='';
}


	//_d($allLanguages);
	?>
	
	
    <!-- Page container begins -->
        <section class="main-container">
            <div class="header headerCntnt_wrapr">
                <div class="heading_top">
                    <div class="page-title">Create New Estimate Requistion</div>
                    
                </div>
                <!--<div class="links"><a href="" class="btn btn-secondary btn-labeled m-r-10"><b><i class="icon-plus22"></i></b> CREATE ESTIMATE REQUISITION</a><button type="button" class="btn btn-secondary btn-labeled"><b><i class="icon-plus22"></i></b> New Group</button></div>-->
            </div>
            <div class="container-fluid page-content">
                <!-- formatted inputs -->
                <div class="card card-inverse card-flat p-10 p-t-20 CrdTop_brdr">
                    <div class="card-block p-b-50 p-0">
                       <form role="form"  method='post'>
                            <div class="row">
                                <div class="col-lg-6 col-md-12 col-sm-12 marg_b_20">
                                    <div class="form-group select_srch"><label>Client:</label>
										<select name='client' class="form-control ui-wizard-content select inptFld_sz" required="">
											<option value=''>Select Client</option>
											<?php foreach($clientlist as $key=>$value){ ?>
												<option value='<?php echo $value['id'] ?>' ><?php echo $value['partner_inhouse_name'] ;?></option>
											<?php } ?>
										</select>
									</div>
                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12 marg_b_20 resCode_campaignName">
                                    <div class="form-group"><label>Campaign Name: <small class="font-italic">( Should be unique. For ex: we can include month & year to make it more exclusive)</small></label>
                                    	<input  type="text" placeholder="" name="projectname" class="inptFld_sz form-control ui-wizard-content" required>
                                    	<?php
										if(isset($_SESSION['msg'])){                                    
										?>
										<small class="text-danger font-italic"><?= $_SESSION['msg']; ?></small>
										<?php
										unset($_SESSION['msg']);                     
										}
										?>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-6 col-sm-12 marg_b_20">
                                    <div class="form-group"><label>Campaign Start Date:</label>
										<div class="input-group">
											<span class="input-group-addon"><i class="icon-calendar2"></i></span>
											<input autocomplete="off" id='startdate'  type="text" placeholder="" name="projectstart"  class='inptFld_sz form-control datepicker-here' data-language='en' required/>
										</div>
									</div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-12 marg_b_20">
                                    <div class="form-group"><label>Campaign End Date:</label>
										<div class="input-group">
											<span class="input-group-addon"><i class="icon-calendar2"></i></span>
											<input autocomplete="off" tabindex="4" id='enddate' type="text" placeholder="" name="projectend" class='inptFld_sz form-control datepicker-here' data-language='en' required/>
										</div>
									</div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-12 marg_b_20">
                                    <div class="form-group"><label>Select Account Lead From Client:</label>
										<select tabindex="5" name="account_lead" id="account_lead"  class="form-control ui-wizard-content inptFld_sz" required>
										<option value="">Select Account Lead From Client</option>
										</select>
									</div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-12 marg_b_20">
                                    <div class="form-group">
									<label>Select Currencies:</label>
										<select tabindex="6" name="currency" class="form-control ui-wizard-content inptFld_sz" required>
										<option value="">Select Currencies</option>
										<?php foreach($allCurrencies as $keys=>$values){ ?>
										<option value='<?php echo $values['id'] ?>' ><?php echo $values['currency'] ;?></option>
													<?php } ?>
										</select>
									</div>
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-12 marg_b_20"">
                                    <div class="form-group"><label>Campaign Discription (optional):</label><input  tabindex="7" type="text" placeholder="" name="description" class="inptFld_sz form-control ui-wizard-content" ></div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 marg_b_20"">
                                    <div class="form-group">
										<label>Type Of Estimate:</label>
										<select tabindex="8" name="typeest" class="form-control ui-wizard-content inptFld_sz" required>
										<option value="">Select Estimate Type</option>
										<option value="1">Retainer Ship</option>
										<option value="2">Project</option>
										<option value="3">Commission</option>
										</select>
									</div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 marg_b_20">
                                    <div class="form-group">
										<?php if($user_type!='4'){ ?>
									<label>Choose Commision( Only For Media):</label>
										<select tabindex="9" name="commForPro" id="commForPro" class="form-control ui-wizard-content" >

										</select>
									<?php }else{ ?>	
									<label>Outsourcing Limit (in %)</label>
									 <input  tabindex="9" id="commForPro" type="number" step="1" value="" min="0" max="100" placeholder="" name="commForPro" class="inptFld_sz form-control ui-wizard-content" required>
									<?php } ?>
									</div>
                                </div>
                               
							   <div class="col-lg-6 col-md-6 col-sm-12 marg_b_20">
                                	<div class="form-group" id="address">


									</div>
                                </div>

                            </div>
                            <div class="row marg_b_20">
								<div class="col-md-12">
									<div class="smll_heading_1">Choose Services</label></div>
								</div>
								<?php
								$count=0;
								foreach($allCategories as $k=>$value){
								$count++;
									
										if($user_type=='4' && $value['id']!=6 && $value['id']!=25)
											continue;
                                        if($user_type=='12' && $value['id']!=9 && $value['id']!=29 && $value['id']!=30 && $value['id']!=25 )
											continue;
										if($user_type=='11' && $value['id']!=5 && $value['id']!=25)
											continue;
										if($user_type=='13' && $value['id']!=1 && $value['id']!=25)
											continue;
										if($user_type=='3' && $value['id']!=8 && $value['id']!=25)
											continue;
										
								?>
                                <div class="col-lg-4 col-md-6 col-sm-12">
									<div class="slctFrom_chkbox resCode_slctFrom_chkbox">
										<div class="form-group row height_36 resCode_chsServ"> 
											<div class="col-lg-5 col-md-5 col-sm-5 col-xs-5  marg_0 flx_hrzl">
												<div class="chkbox_cstm_wpr">
													<label class="marg_0">
														<div class="chbx_style"><input name='cat[<?php echo $value['id']?>]' type="checkbox" value='<?php echo $value['id']?>' onclick="showhide('<?php echo $value['id']?>')" id='check_<?php echo $value['id']?>' class="inptFld_sz shwInput" /><span></span></div> <p><?php echo $value['name']?></p>
													</label>
												</div>
												
											</div>
											<div class="col-lg-7 col-md-7 col-sm-7 col-xs-7" >
												<div class="input-group priceInpt_js resCode_priceInp" id="price_<?php echo $value['id']?>" style="display:none;" >
													<div class="input-group-addon">
														<i class="icon-rupee"></i>
													</div>
													<input type="text" placeholder="Enter Price" class="inptFld_sz form-control formFld" name='price[<?php echo $value['id']?>]' value='' aria-required="true">
												</div>
											</div>
										</div>
									</div>
								</div>
								<?php
											
								}
								?>
							</div>
						
							<button type="submit" class="btn btn-primary ui-wizard-content float-right marg_t_30" id="add-step"><i class="icon-paperplane"></i> Submit Requisition</button>
							</form>
						
					</div>
				</div>
            <!-- /formatted inputs -->
                       <!-- Footer -->
     <?php include('include/footer-new.php'); ?>  
	 
	 
  <script>
  $(document).ready(function() {
	  
	
	
	$(function() {
		  $('.datepicker-here').datepicker({
				dateFormat: 'yyyy-mm-dd'
		  });
	});
	  
    $("select[name='client']").change(function() {
		$('input:checkbox').removeAttr('checked');
		 $('input.formFld[type=text]').val("");
		 $("[id^='price_']").hide();
		id_numbers = new Array();
        // Get the value selected (convert spaces to underscores for class selection)
        var value = $(this).val();
		//alert(value);
		 {
			$.ajax({
				type: "POST",
				data: {client : value},
				cache: false,
				url: "new-test-ajaxaddproject.php",
				dataType:"json",
				beforeSend: function(){
				//emailInfo.html("Checking Please wait....."); //show checking or loading image
				},
				success: function(data)
				{
				var result = $.map(data.first, function(value, key) {
					return key;
				});
				var result1 = $.map(data.first, function(value, key) {
					return value;
				});

				for (var i = 0; i < result.length; i++) {
					$(":checkbox").filter("#"+"check_"+result[i]).prop("checked",true);
					$('#price_'+result[i]).val(result1[i]).show();
					//alert(result1[i]);
				}
					var result2 = $.map(data.second, function(value, key) {
						return key;
					});
					var result3 = $.map(data.second, function(value, key) {
						return value;
					});
					var result4 = $.map(data.third, function(value, key) {
						return key;
					});
					var result5 = $.map(data.third, function(value, key) {
						return value;
					});
				$("#account_lead").find('option').remove().end();
				 $("#account_lead").append($("<option></option>").val('').html('Please Select Person'));
					for (var i = 0; i <  result2.length; i++) {
					$("#account_lead").append($("<option></option>").val(result2[i]).html(result3[i]));
				}
				
				var html = "<label>Select Address:</label>";
				$("#address").empty();
				for (var i = 0; i <  result5.length; i++) {
					/*html = html + '<div class="card card-inverse card-flat"><div class="card-block"><div class="row"><div class="col-md-12 col-sm-6"><div class="radio"><label><input style="margin-right: 10px;" type="radio" value="'+result4[i]+'" name="address" class="control-primary" checked="checked">'+result5[i]+'</label></div></div></div></div></div>';*/
					
					html = html + '<div class="chkbox_cstm_wpr" style="background:#fafbfc;padding:10px 9px;margin-bottom: 5px;border: 1px solid gainsboro"><label class="marg_0"><div class="chbx_style"><input type="radio" name="comptype" class="shwInput" value="'+result4[i]+'" required="" checked="checked"><span class="radio_stl"></span></div>'+result5[i]+'</label></div>';
						}
				$("#address").html(html);

				}
			});
		}

		 // Clear checks, then check boxes that have class "value"

    });
      
     $("select[name='client']").change(function() {
        // Get the value selected (convert spaces to underscores for class selection)
        var value = $(this).val();
		//alert(value);
		 {
    $.ajax({
    type: "POST",
    data: {clientForComm : value},
    cache: false,
    url: "new-test-ajaxaddproject.php",
	dataType:"json",
    beforeSend: function(){
    //emailInfo.html("Checking Please wait....."); //show checking or loading image
    },
    success: function(data)
    {
        $("#commForPro").find('option').remove().end();
        $("#commForPro").append($("<option></option>").val('').html('Please Select Commision'));
        $.each(data, function(key, value){
            $("#commForPro").append($("<option></option>").val(key).html(value));
        });
        
    }
});
  }

         // Clear checks, then check boxes that have class "value"

    });
});


</script>