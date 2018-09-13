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

if(isset($_GET['id'])){
	$id=$_GET['id'];

}
 $project  = new project();
 $category = new Category();
 $company=new Partner();
 $estimate=new category_estimate();

 $allCategories = $category->all();
$currencies = new currencies();
$allCurrencies = $currencies->all();

 $clientlist=$company->all();
 //findcustom(array('company_type'=>0));

$currentproject=$project->findcustomrow(array('id'=>$id));
$project_description = new project_description();
$currentproject_description = $project_description->findcustomrow(array('project_id'=>$id)); 
$partner_cat_com = new PartnerCommisionSection();
$sqlarray = array('service_id' => 2,'partner_id' =>$currentproject['clientid'] );
$commisions = $partner_cat_com->findcustom($sqlarray);
if(isset($_POST['projectname'])){

$result= $project->findcustomrow(array('project_name'=>$_POST['projectname']));
if(empty($result) || $currentproject['project_name']==$_POST['projectname'])
{
	$estimate->deleteall($id);
	 $project  = new project();
	$project->id=$id;
	$project->project_name = trim($_POST['projectname']);
	$project->project_start	 = trim($_POST['projectstart']);
	$project->project_end	 = trim($_POST['projectend']);
	$project->currency_id	 = $_POST['currency'];
       if($_GET['media'] == 'true'){
        $project->commision	 = $_POST['commision'];
       }
    $project->clientid	 = $_POST['client'];
	$project->userid=$userinfo['id'];
	$project->update_at=date('Y-m-d H:i:s');
	$_SESSION['msg'] = "Project has been Updated successfully";
    
    if(isset($_POST['description']) && !empty($_POST['description']))
	{
		$project_description = new project_description();
		$project_description->project_id = $id;
		$project_description->description =  trim($_POST['description']);
		$project_description->create();


	}

	$estimate->project_id=$id;
	$total=0;
	$mny;
	foreach($_POST['cat'] as $key=> $value)
	{
		$estimate->project_cat_id=$value;
		$mny=$estimate->price=trim($_POST['price'][$key]);
		$total = ($total+$mny);
		$estimate->approve=0;
		$estimate->create();
	}
	$project->totalprice=$total;
	$project->save();

	redirectAdmin('index.php');

}
else
{
$_SESSION['msg'] = "Project has been already Exists";
	//redirectAdmin('userManagement.php');
}
}

$estimatecategory=$estimate->findcustom(array('project_id'=>$id));
$myarray=array();
foreach($estimatecategory as $key=>$value){
	$myarray[]=$value['project_cat_id'];
	$list[$value['project_cat_id']]=$value['price'];
}
	//_d($allLanguages);
	?>
	
    <!-- Page container begins -->
        <section class="main-container">
            <div class="header headerCntnt_wrapr">
                <div class="heading_top">
                    <div class="page-title">Update project management</div>
                    
                </div>
                <!--<div class="links"><a href="" class="btn btn-secondary btn-labeled m-r-10"><b><i class="icon-plus22"></i></b> CREATE ESTIMATE REQUISITION</a><button type="button" class="btn btn-secondary btn-labeled"><b><i class="icon-plus22"></i></b> New Group</button></div>-->
            </div>
            <div class="container-fluid page-content">
                <!-- formatted inputs -->
                <div class="card card-inverse card-flat p-10 p-t-20 CrdTop_brdr">
                    <div class="card-block p-b-50 p-0">
                        <form class="form-add-steps" action=" " role="form"  method='post'>
                            <div class="row marg_b_20">
                                <div class="col-lg-6 col-md-12 col-sm-12 marg_b_20">
                                    <div class="form-group select_srch"><label>Select Client:</label>
										<select name='client' class="selectpicker form-group form-control select"  required >
											<option value=''>Select Client</option>
												<?php foreach($clientlist as $key=>$value){ ?>
													<option value='<?php echo $value['id'] ?>' <?php if($value['id']==$currentproject['clientid']) echo 'selected'?> ><?php echo $value['partner_name'] ;?></option>
												<?php } ?>
										</select>
									</div>
                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12 marg_b_20 resCode_campaignName">
                                    <div class="form-group"><label>Project Name:</label>
									<input  type="text" placeholder="Project Name" name="projectname" class="inptFld_sz form-control" value='<?php echo $currentproject['project_name'] ?>' >
									</div>
								</div>

                                <div class="col-lg-3 col-md-6 col-sm-12 marg_b_20">
                                    <div class="form-group"><label>Project End Date:</label>
										<div class="input-group">
											<span class="input-group-addon"><i class="icon-calendar2"></i></span>
											<input autocomplete="off" id='enddate' type="text" placeholder="Project Start Date" name="projectend" class='inptFld_sz form-control datepicker-here' data-language='en' value='<?php echo $currentproject['project_end'] ?>'>
										</div>
									</div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-12 marg_b_20">
                                    <div class="form-group"><label>Campaign Start Date:</label>
										<div class="input-group">
											<span class="input-group-addon"><i class="icon-calendar2"></i></span>
											<input autocomplete="off" id='startdate'  type="text" placeholder="Campaign Start Date" name="projectstart" class='inptFld_sz form-control datepicker-here'  value='<?php echo $currentproject['project_start'] ?>' data-language='en'>
										</div>
									</div>
                                </div>
                                <div class="col-lg-3 col-md-12 col-sm-12 marg_b_20">
                                    <div class="form-group">
									<label>Campaign Discription (optional):</label>
										<input  type="text" placeholder="Description" name="description" value="<?php echo $currentproject_description['description']?>" class="form-control ui-wizard-content inptFld_sz" >
									</div>
								</div>

                                <div class="col-lg-3 col-md-12 col-sm-12 marg_b_20">
                                    <div class="form-group"><label>Select Currencies:</label>
										<select name="currency" class="form-control inptFld_sz" required>
										<option value="">Select Currencies</option>
										<?php foreach($allCurrencies as $keys=>$values){ ?>
										<option <?php if($values['id'] == $currentproject['currency_id']) echo 'selected'; ?> value='<?php echo $values['id'] ?>' ><?php echo $values['currency'] ;?></option>
													<?php } ?>
										</select>
									</div>
                                </div>
								
                            </div>

                            <div class="row marg_b_20">
								<div class="col-md-12">
									<div class="smll_heading_1">Services</label></div>
								</div>
								<?php
								$count=0;
								foreach($allCategories as $k=>$value){
								$count++;
									
								?>

                                <div class="col-md-4 col-sm-6">
									<div class="slctFrom_chkbox resCode_slctFrom_chkbox">
										<div class="form-group row height_36 resCode_chsServ">
											<div class="col-lg-5 col-md-5 col-sm-5 col-xs-5  marg_0 flx_hrzl">
												<div class="chkbox_cstm_wpr">
													<label class="marg_0">
														<div class="chbx_style">
															<input name='cat[<?php echo $value['id']?>]' type="checkbox" value='<?php echo $value['id']?>' onclick="showhide('<?php echo $value['id']?>')" id='check_<?php echo $value['id']?>'  <?php if(in_array($value['id'],$myarray)) { echo 'checked';} ?> class="inptFld_sz shwInput">
															<span></span></div> <p><?php echo $value['name']?></p>
													</label>
												</div>
												
											</div>
											<div class="col-lg-7 col-sm-7 col-xs-7" >
												<div class="input-group priceInpt_js resCode_priceInp" <?php if(isset($value['id']) && !(in_array($value['id'],$myarray))) { ?> style='display:none' <?php } ?> id="price_<?php echo $value['id']?>"  >
													<div class="input-group-addon">
														<i class="icon-rupee"></i>
													</div>
													<input  type="text" class="inptFld_sz form-control formFld"  placeholder="Enter Price" name='price[<?php echo $value['id']?>]' <?php if(isset($list[$value['id']])) { ?>value='<?php echo $list[$value['id']] ?>' <?php } ?> >
												</div>
											</div>
										</div>
									</div>
								</div>
								<?php
											}
								
								?>
							</div>
						
							<button type="submit" class="btn btn-primary ui-wizard-content float-right marg_t_30" id="add-step"><i class="icon-paperplane"></i> Update</button>
							</form>
						
					</div>
				</div>
            <!-- /formatted inputs -->
                       <!-- Footer -->
     <?php include('include/footer-new.php'); ?>  
	 