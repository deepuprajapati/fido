<?php include('include/header-files.php'); ?>
<style>
.addCnt_flds{
    display: flex;
    align-items: center;
}

.addCnt_flds button i{
    margin-top: 5px;
    display: block;
}

.addCnt_flds span{
    margin-left: 5px;
}

@media only screen and (max-width:767px){
.addmoreFldt{
    padding: 0 15px !important;
    margin-bottom: 10px;
}
}
</style>
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

$contract = new partner_cotract();
$partner_code = new Partner_code(); // Partner_code object
$col="numeric1";
$code2=$partner_code->max($col);
$code1=$code2+1;
$code = work_order_maker($code1);

$step = 1;
$partner = new Partner(); // partner object
if(isset($_GET['step']))
{
	$step = $_GET['step'];
}
if(isset($_GET['edit']))
{
	$partner_detail = $partner->findcustomrow(array('id'=>$_GET['edit']));
}

 //  $allLanguages = $language->getColumns();
   if(isset($_POST['company_name'])){

   		$result= $partner->findcustomrow(array('GST'=>$_POST['stax']));
		if(empty($result))
		{


		   $partner_code->numeric1=$code;
		   $partner_code->ref=$_POST['company_code'];
		   $partner_code->create();
		   $partner->partner_inhouse_name	 = trim($_POST['company_name_inhouse']);
		   $partner->partner_name	 = trim($_POST['company_name']);
		   $partner->official_address	= trim($_POST['company_address']);
		   //$partner->publisher_name	 = $_POST['publisher_name'];
		   $partner->website_address	= trim($_POST['website_address']);
		   $partner->pan	 = trim($_POST['pan']);
		   //$partner->service_tax	 = trim($_POST['stax']);
           $partner->GST	 = trim($_POST['stax']);
           $partner->state_code	 = trim($_POST['state_code']);

		   $partner->district	 = trim($_POST['company_district']);
		   $partner->state	= trim($_POST['company_state']);
		   $partner->country	 = trim($_POST['company_country']);
		   $partner->postal_code	 = trim($_POST['company_pincode']);
		   $partner->isIndian =(($_POST['company_country']=="India")?1:0);
		   $partner->company_code	 = trim($_POST['company_code']);
		   $partner->company_type	= trim($_POST['comptype']);
		   $partner->company_cat	= trim($_POST['company_category']);
		   $dat = date("Y-m-d H:i:s");
		   $partner->created_at =  $dat;
		   $partner->create();

			$last_insert_id = $partner->lastInsertId();

		   $client_address = new client_address();
		   $client_address->client_id = $last_insert_id;
   		   $client_address->address = trim($_POST['company_address']);
   		   $client_address->create();

		   
		    $info = new customer_contact_info();
		   foreach($_POST['name'] as $key=>$value){
			   if($_POST['name'][$key]!=''){
			   $info->client_id = $last_insert_id;
			   $info->name = $_POST['name'][$key];
			   $info->email = $_POST['email'][$key];
			   $info->designation = $_POST['degi'][$key];
			   $info->create();
			   }
		   }
		   if($_FILES['contract']['type'] =='application/pdf'){
			    //$filename=$_FILES["contract"]["tmp_name"];
				$filename  = $_FILES['contract']['name'];
				$extension = pathinfo($filename, PATHINFO_EXTENSION);
				$new       = $last_insert_id.'.'.$extension;
				$target_path = $_SERVER["DOCUMENT_ROOT"]."/mis/upload_contract/".$new;
				move_uploaded_file($_FILES['contract']['tmp_name'], $target_path);
				$target_file = $target_path . basename($_FILES["contract"]["name"]);
				$contract->partner_id=$last_insert_id;
				$contract->img_url=$new;
				$contract->start_date=$_POST['contractstart'];
				$contract->end_date=$_POST['contractend'];
				$contract->est_mood=$_POST['radio2'];
				$contract->create();
			}
			else{
				$contract->partner_id=$last_insert_id;
				$contract->start_date=$_POST['contractstart'];
				$contract->end_date=$_POST['contractend'];
				$contract->est_mood=$_POST['radio2'];
				$contract->create();
			}
		   //$_SESSION['msg'] = "General details are saved please fill services &amp; finance details";
		   redirectAdmin('addPartner.php?step=2&edit='.$last_insert_id);
	}

	redirectAdmin('addPartner.php?action=register&gst='.$_POST['stax']);

}
elseif(isset($_POST['second_step']))	// Saving second step
{
	$partner_cat_com = new PartnerCommisionSection();
	if(isset($_POST['category']))
	{

		foreach($_POST['category'] as $service_id=>$services):
			if(isset($_POST['commsion_issued'][$service_id]) || isset($_POST['commsion_money'][$service_id]))
			{
				$partner_cat_com->commision		=	$_POST['commsion_issued'][$service_id];
				$partner_cat_com->fee  =	str_replace(',','', $_POST['commsion_money'][$service_id]);
			}
			else{
				$partner_cat_com->commision		=	0.00;	// default value for commission
			}
                $partner_cat_com->totalFee      =   str_replace(',','', $_POST['Fee']);
				$partner_cat_com->service_id	=	$service_id;
				$partner_cat_com->partner_id	=	$_POST['partner_id'];
				$partner_cat_com->created_on	=	date('Y-m-d H:i:s');
				$partner_cat_com->modified_on	=	date('Y-m-d H:i:s');
				$partner_cat_com->create();
		endforeach;
	}
	//$_SESSION['msg'] = "Partner is added successfully.";
	header("Location: managePartner.php");
	exit();
}

	//_d($allLanguages);
	?>
    <!-- Page container begins -->
        <section class="main-container">
            <div class="header headerCntnt_wrapr">
                <div class="heading_top">
                    <div class="page-title">Partner Management <small>(General Details)</small></div>
                    
                </div>
                <!--<div class="links"><a href="" class="btn btn-secondary btn-labeled m-r-10"><b><i class="icon-plus22"></i></b> CREATE ESTIMATE REQUISITION</a><button type="button" class="btn btn-secondary btn-labeled"><b><i class="icon-plus22"></i></b> New Group</button></div>-->
            </div>
            <div class="container-fluid page-content">
                <!-- formatted inputs -->
                <div class="card card-inverse card-flat p-10 CrdTop_brdr p-t-20">
                    <div class="card-block p-b-50 p-0" >
						<?php
						if($step==1)
						{
							if (isset($_GET['action']) && $_GET['action'] == 'register') {
								?>
								<script>
									alert('Client with this GST No <?php echo $_GET["gst"]; ?> is already register')
								</script>
						<?php
							}
						?>

						<form class="parsley-form" role="form" action=" "  method='post'  id="bookForm" enctype="multipart/form-data">
                            <div class="row marg_b_20" id="comptype" >
                                <div class="col-lg-2 col-md-12">
                                    <label>Company Type:</label>
                                </div>
                                <div class="col-lg-2 col-md-4 col-sm-6">
									<div class="chkbox_cstm_wpr">
										<label class="marg_0">
											<div class="chbx_style">
												<input type="radio" name="comptype" class="shwInput"  value="1" required >
												<span class="radio_stl"></span>
											</div>
											Retainer
										</label>
									</div>
								</div>
                                <div class="col-lg-3 col-md-4 col-sm-6">
									<div class="chkbox_cstm_wpr">
										<label class="marg_0">
											<div class="chbx_style">
											<input type="radio" name="comptype" class="shwInput" value="2" required>
											<span class="radio_stl"></span>
										</div>Retainer + Commission
										</label>
									</div>
								</div>
                                <div class="col-lg-2 col-md-4 col-sm-6">
									<div class="chkbox_cstm_wpr">
										<label class="marg_0">
											<div class="chbx_style">
												<input type="radio" name="comptype" class="shwInput" value="3" required>
												<span class="radio_stl"></span>
											</div>Commission
										</label>
									</div>
								</div>
                                <div class="col-lg-2 col-md-4 col-sm-6">
									<div class="chkbox_cstm_wpr">
										<label class="marg_0">
											<div class="chbx_style">
												<input type="radio" name="comptype" class="shwInput" value="4" required>
												<span class="radio_stl"></span></div>Project
										</label>
									</div>
								</div>
							</div>
                            <div class="row marg_b_20" id="retaner" style="display:none;">
                                <div class="col-lg-2 col-md-12">
                                    <label>Estimate Rising Mood:</label>
                                </div>
                                <div class="col-lg-2 col-md-4 col-sm-4">
									<div class="chkbox_cstm_wpr">
										<label class="marg_0">
											<div class="chbx_rdo_style">
												<input type="radio" name="radio2" value="m">
												<div class="inner_radio">
													<div class="toggle_rdo_btn"></div>
												</div>
											</div>
											<span>Monthly</span>
										</label>
										
									</div>
								</div>
                                <div class="col-lg-2 col-md-4 col-sm-4">
									<div class="chkbox_cstm_wpr">
										<label class="marg_0">
											<div class="chbx_rdo_style">
												<input type="radio" name="radio2" >
												<div class="inner_radio">
													<div class="toggle_rdo_btn"></div>
												</div>
											</div>
											<span>Quarterly</span>
										</label>
										
									</div>
								</div>
                                <div class="col-lg-2 col-md-4 col-sm-4">
									<div class="chkbox_cstm_wpr">
										<label class="marg_0">
											<div class="chbx_rdo_style">
												<input type="checkbox">
												<input type="radio" name="radio2">
												<div class="inner_radio">
													<div class="toggle_rdo_btn"></div>
												</div>
											</div>
											<span>Yearly</span>
										</label>
										
									</div>
								</div>
							</div>
							
                            <div class="row">
                                <div class="col-lg-6 col-md-12 marg_b_20">
                                    <div class="form-group">
										<label>Company Name:</label>
										<input id="name" type="text" placeholder=" Name" onblur="edValueKeyPress()" name="company_name" class="form-control inptFld_sz" required>
									</div>
                                </div>
								
								<div class="col-lg-6 col-md-12 marg_b_20">
									<div class="form-group"><label>Company Name (Only for office use/To create estimate):</label>
										<input type="text" required placeholder="Company Name" name="company_name_inhouse" class="form-control inptFld_sz">
									</div>
								</div>
								
                                <div class="col-lg-6 col-md-12 marg_b_20">
                                    <div class="form-group">
										<label>Company Code</label>
										<input type="text" placeholder="Code" id="company_code"  name="company_code" class="form-control inptFld_sz" required>
									</div>
                                </div>
								

                                <div class="col-lg-6 col-md-12 marg_b_20">
                                    <div class="form-group">
										<label>Website address</label>
										<input type="text" required placeholder="Website address" name="website_address" class="form-control inptFld_sz">
									</div>
                                </div>

                                <div class="col-lg-6 col-md-12 marg_b_20">
                                    <div class="form-group">
										<label>Company Category</label>
										<select name='company_category' class='form-control inptFld_sz' required>
											<option value=''>Select Category</option>
											<option value='pvtltdcompany'>Pvt. LTD. Company</option>
											<option value='ltdcompany'>LTD. Company</option>
											<option value='partnership'>Partnership</option>
											<option value='proprietorship'>Proprietorship</option>
											<option value='individual'>Individual</option>
										</select>
									</div>
                                </div>
								
								
                                <div class="col-lg-6 col-md-12 marg_b_20">
                                    <div class="form-group">
										<label>Country</label>
										<select  placeholder=" Country" name="company_country" class="form-control inptFld_sz" id="country" required ></select>
									</div>
                                </div>
								

                                <div class="col-lg-6 col-md-12 marg_b_20">
                                    <div class="form-group">
										<label>PAN Number</label>
										<input type="text" placeholder="PAN Number"   name="pan" class="form-control inptFld_sz" onblur="pan_card(this.value)" id="pan">
									</div>
                                </div>

                                <div class="col-lg-6 col-md-12 marg_b_20">
                                    <div class="form-group">
										<label>state </label>
										<select placeholder=" State" name="company_state" class="form-control inptFld_sz" id="state" required></select>
									</div>
                                </div>
								
								


                                <div class="col-lg-6 col-md-12 marg_b_20">
                                    <div class="form-group">
										<label>State Code <small><a target="_blank" href="http://www.ddvat.gov.in/docs/List%20of%20State%20Code.pdf"> (Click for state code)</a></small></label>
										<select name='state_code' id='state_code' class='form-control inptFld_sz' required>
										<option value=''>Select Code</option>
                                       <?php for($i=1; $i<38; $i++){ ?>
										<option value='<?php echo $i;?>'><?php echo $i;?></option>
                                       <?php } ?>
										</select>
									</div>
                                </div>

                                <div class="col-lg-6 col-md-12 marg_b_20">
                                    <div class="form-group">
										<label>City </label>
										<input type="text" placeholder="City" name="company_district" class="form-control inptFld_sz" required>
									</div>
                                </div>

                                <div class="col-lg-6 col-md-12 marg_b_20">
                                    <div class="form-group">
										<label>GST No.</label>
										<input type="text" placeholder="GST No" name="stax" id ="stax" class="form-control inptFld_sz">
									</div>
                                </div>

                                <div class="col-lg-6 col-md-12 marg_b_20">
                                    <div class="form-group">
										<label>Company Address.</label>
										<input type="text" required placeholder="Address"    name="company_address" class="form-control inptFld_sz" >
									</div>
                                </div>

                                <div class="col-lg-6 col-md-12 marg_b_20">
                                    <div class="form-group">
										<label>Pin/Zip code</label>
										<input type="text" placeholder="Pin code " id="zip" name="company_pincode" class="form-control inptFld_sz" required  maxlength="6">
									</div>

									<div class="row">
										<div class="col-lg-12 marg_b_20">
											<div class="row">
												<div class="col-md-4">
													<p style="margin-top: 6px;">Upload Contract File</p>
												</div>
												<div class="col-md-8">
													<div class="form-group">
														<input id="image-file" type="file"  name="contract" class="form-control inptFld_sz"  style="padding-top: 5px !important;" accept="application/pdf">
													</div>
												</div>
											</div>
										</div>

										<div class="col-md-6 col-md-12 marg_b_20">
										<div class="form-group">
											<div class="input-group">
												<span class="input-group-addon"><i class="icon-calendar2"></i></span>
												<input id='startdate'  type="text" placeholder="Contract Start Date" name="contractstart" class="form-control datepicker-here inptFld_sz" data-language="en" required>
											</div>
										</div>
										</div>

										<div class="col-md-6 col-md-12 marg_b_20">
											<div class="form-group">
												<div class="input-group">
													<span class="input-group-addon"><i class="icon-calendar2"></i></span>
													<input  id='enddate' type="text" placeholder="Contract End Date" name="contractend" class="form-control datepicker-here inptFld_sz" required  data-language="en">
												</div>
											</div>
										</div>
									</div>
								</div>


                                <div class="col-lg-6 col-md-6 col-md-12 marg_b_20">
                                    <div class="form-group">
										<label>Contact Information</label>
										<input type="text" required class="form-control inptFld_sz" name="name[]" placeholder="Name" />
									</div>
									
									<div class="row">
										<div class="col-md-12 marg_b_20">
											<div class="form-group">
												<input type="text" required class="form-control inptFld_sz" name="email[]" placeholder="E-mail" />
											</div>
										</div>

										<div class="col-md-12 marg_b_20">
											<div class="form-group">
												<input type="text" required class="form-control inptFld_sz" name="degi[]" placeholder="Ex:- 9988776655"  pattern="[0-9]{10}" onkeypress="return event.charCode >= 48 && event.charCode <= 57" class="form-control" required maxlength="10"/>
											</div>
										</div>

									</div>
									<div class="addCnt_flds marg_b_20">
										<button type="button" class="btn btn-primary addButton"><i class="fa fa-plus"></i></button><span>Add More Fields</span>
									</div>
									
									<div class="fromAppend_grp row marg_b_20 hide" id="bookTemplate">
										
										<div class="col-md-4 p-r-5 addmoreFldt">
											<div class="form-group">
												<input type="text" class="form-control inptFld_sz" name="name[]" placeholder="Name" />
											</div>
										</div>

										<div class="col-md-4 p-r-5 p-l-5 addmoreFldt">
											<div class="form-group">
												<input type="text" class="form-control inptFld_sz" name="email[]" placeholder="E-mail" />
											</div>
										</div>

										<div class="col-md-3 p-r-5 p-l-5 addmoreFldt">
											<div class="form-group">
												<input type="text" class="form-control inptFld_sz" name="degi[]" placeholder="Ex:- 9988776655" onkeypress="return event.charCode >= 48 && event.charCode <= 57" class="form-control" maxlength="10" />
											</div>
										</div>

										<div class="col-md-1 p-r-0 p-l-0 addmoreFldt">
											<div class="addCnt_flds">
												<button type="button" style="height:35px;" class="btn btn-primary removeButton"><i class="fa fa-minus"></i></button>
											</div>
										</div>
									
									</div>


                                </div>


							</div>



						
							<button type="Submit" class="btn btn-primary ui-wizard-content float-right marg_t_30" id="add-step">Next</button>
						</form>
						<?php }?>
						
					<?php
					if($step==2)
					{
					?>
					<form class="parsley-form" role="form"  method='post'>	
					<div class="">
					<?php if($partner_detail['company_type'] !=3) { ?>
					<div class="row">
					<div class="col-md-6 col-sm-6 m-b-20">
						<div class="form-group">
							<label>Fee.</label>
							<input type="text" required placeholder="Fee" name="Fee" id="Fee" class="form-control auto inptFld_sz" data-d-group="2" >
						</div>
					</div>
					</div>
					<div class="row">
					<?php }
					if(isset($partner_detail))
					{
					$projectCatObj = new ProjectCategory();
					$project_category = $projectCatObj->findCustom(array());
					foreach($project_category as $key=>$p_cat):
					// 2 for Retainer + commision
					if($partner_detail['company_type']==2)
					{
					$inCat = array(2,3,4);
					?>
					<?php if($p_cat['id']=='2'){?>
						<div class="col-md-6 m-b-20">
							<div class="form-group">
								<div class="chkbox_cstm_wpr">
									<label class="marg_b_10">
										<div class="chbx_style">
											<!--<input type="checkbox" name="comptype" class="shwInput" value="1" required="">-->
											<input class="category-checks shwInput" type="checkbox" name="category[<?=$p_cat['id']?>]" value="<?=$p_cat['id']?>">
											<span></span>
										</div>
										<?=$p_cat['name']?> Only Commission in %
									</label>
								</div>
							</div>
						</div>
						<?php } else { ?>
						<div class="col-md-6 m-b-20">	
							<div class="form-group">
								<div class="chkbox_cstm_wpr">
									<label class="marg_b_10">
										<div class="chbx_style">
											<!--<input type="checkbox" name="comptype" class="shwInput" value="1" required="">-->
											<input class="category-checks shwInput" type="checkbox" name="category[<?=$p_cat['id']?>]" value="<?=$p_cat['id']?>" <?=(!in_array($p_cat['id'],$inCat)?'disabled=""':'')?>>
											<span></span>
										</div>
										<?=$p_cat['name']?>
									</label>
								</div>
								<div class="input-group bootstrap-touchspin ">
									<div class="input-group" >
									<input required="required" type="number" style="display: block;" disabled="disabled" onblur="getValue(this.value,this)" class="form-control" name="commsion_issued[<?=$p_cat['id']?>]" id="" placeholder="<?=$p_cat['name']?> Commission">
									<span class="input-group-addon bootstrap-touchspin-postfix">%</span>
								</div>
									<div class="input-group money" >
									<input min="0" max="100" required="required" type="text" style="display: block;" disabled="disabled"  class="form-control auto" name="commsion_money[<?=$p_cat['id']?>]" placeholder="<?=$p_cat['name']?> Commission" readonly data-d-group="2" >
									<span class="input-group-addon bootstrap-touchspin-postfix"><i class="icon icon-rupee"></i></span>
								</div>
								</div>
								
							</div>
						</div>
						<?php
							}
					   }
					   elseif($partner_detail['company_type']==1) //retainer
					   {
						   $inCat = array(11,9,8,7,6,5,1,2);
						?>
						<div class="col-md-6 m-b-20">
							<div class="form-group">
								<div class="chkbox_cstm_wpr">
									<label class="marg_b_10">
										<div class="chbx_style">
											<!--<input type="checkbox" name="comptype" class="shwInput" value="1" required="">-->
											<input class="category-checks shwInput" type="checkbox" name="category[<?=$p_cat['id']?>]" value="<?=$p_cat['id']?>" <?=(!in_array($p_cat['id'],$inCat)?'disabled=""':'')?>>
											<span></span>
										</div>
										<?=$p_cat['name']?>
									</label>
								</div>
								<div class="input-group bootstrap-touchspin ">
									<div class="input-group" >
									<input required="required" type="number" style="display: block;" disabled="disabled" onblur="getValue(this.value,this)" class="form-control" name="commsion_issued[<?=$p_cat['id']?>]" id="" placeholder="<?=$p_cat['name']?> Commission">
									<span class="input-group-addon bootstrap-touchspin-postfix">%</span>
								</div>
									<div class="input-group money" >
									<input min="0" max="100" required="required" type="text" style="display: block;" disabled="disabled"  class="form-control auto" name="commsion_money[<?=$p_cat['id']?>]" placeholder="<?=$p_cat['name']?> Commission" readonly data-d-group="2" >
									<span class="input-group-addon bootstrap-touchspin-postfix"><i class="icon icon-rupee"></i></span>
								</div>
								</div>
								
							</div>
						</div>
						<?php
					   }
					   else
						{	// commission
						   if(strtolower($p_cat['name'])=='media')
						   {
							?>
						<div class="col-md-6 m-b-20">
							<div class="form-group">
								<div class="chkbox_cstm_wpr">
									<label class="marg_b_10">
										<div class="chbx_style">
											<!--<input type="checkbox" name="comptype" class="shwInput" value="1" required="">-->
											<input  class="category-checks shwInput" type="checkbox" name="category[<?=$p_cat['id']?>]" value="<?=$p_cat['id']?>" required="required"  >
											<span></span>
										</div>
										<?=$p_cat['name']?> Commission in % (Please Click First)
									</label>
								</div>
								<div class="">
									<input required maxlength="2" type="text"  class="form-control" name="commsion_issued[<?=$p_cat['id']?>]" id="commision_m" placeholder="<?=$p_cat['name']?> Commission"  >
								</div>
							</div>
						</div>
						
							<?php
							break;
						   }
					   }
					   endforeach;
				   }
				   ?>
				   </div>
					<input type="hidden" value="<?=$partner_detail['id']?>" name="partner_id">
					<input type="hidden" value="1" name="second_step">
					<button type="submit" class="btn btn-primary ui-wizard-content float-right marg_t_30">Next</button>
					</div>
					</form>
					<?php
					}
					?>
					</div>
				</div>
            <!-- /formatted inputs -->
                       <!-- Footer -->
     <?php include('include/footer-new.php'); ?>  

<script src="asset/js/Countries_States.js"></script>
<script>
$(function() {
	$('.datepicker-here').datepicker({
		dateFormat: 'yyyy-mm-dd'
	});
});
</script>
<script>
	
$('.category-checks').change(function(){
	if($(this).is(':checked'))
	{
		$(this).closest('div .form-group').find('div.input-group>input').attr('disabled',false);
	}
	else{
		$(this).closest('div .form-group').find('div.input-group>input').attr('disabled','disabled').val('');
	}
})
</script>

<script>

function getValue(a,ref) {
    //alert(a);
	var feeValue = document.getElementById("Fee").value.replace(/\,/g, '');
	//alert(feeValue);
	var total = 0;
	var selected = [];
	$('.parsley-form input:checked').each(function() {
		selected.push($(this).closest('div .form-group').find('div.input-group>input').val());
		total = 0;
        for (var i = 0; i < selected.length; i++) {
        total += selected[i] << 0;
        }
     });
	 if(total<101){
		 var cVal = feeValue*a/100;
	$(ref).closest('div .form-group').find('div.input-group').find('div.money>input').val(cVal);
	 }
	 else{
		 var displayMsg = "Your "+total+"% is above then 100 %";
		 alert(displayMsg);
		 $(ref).val('');
	 }
}
</script>

  <script>
    function edValueKeyPress()
    {
        var edValue = document.getElementById("name");
		var v=edValue.value;
        var splitted=[];
splitted = v.split(" ");
var y=[];
var str;
for(var i=0; i<splitted.length; i++)
{
	y[i]=splitted[i].charAt(0);

}

var str1 =y.join("");
var str = str1.toUpperCase();

        var lblValue = document.getElementById("company_code");
		var code = "CL_"+"<?php echo $code; ?>"+"_"+str
        lblValue.value = code;

        //var s = $("#edValue").val();
        //$("#lblValue").text(s);
    }
</script>
<script>
function STN(a)
{
var pan = document.getElementById("pan").value;
//alert(pan);
//alert(a);
var res = a.substring(0, 10);
//alert(res);
if(a.length==15 && a!='')
{
		if( pan === res )
		{
		var val = a.replace(res,'').substring(0,2);
		//alert(val);
		//var b = val.substring(0,2);
				if(val=='ST' || val=='SD')
				{
					var endWord = a.substring(12,15);
					//alert(endWord);
					if(!isNaN(endWord)) alert("Vaild Service Tax Number No.");
				}
				else{
					alert('Invaild Service Tax Number No.');
				}

		}else{
		alert("Invaild Service Tax Number  No.");
		}
}
else{
	alert("Invaild Service Tax Number  No.");
}

}

</script>
<script>
/* This function validates for PAN Card No.*/
function pan_card(textObj)
{
//alert(textObj);
var regpan = /^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/;
/*C - Company
P - Person
H - HUF(Hindu Undivided Family)
F - Firm
A - Association of Persons (AOP)
T - AOP (Trust)
B - Body of Individuals (BOI)
L - Local Authority
J - Artificial Juridical Person
G - Govt.*/
var code= /([C,P,H,F,A,T,B,L,J,G])/;
var code_chk=textObj.substring(3,4);
if (textObj!=="")
{
if(regpan.test(textObj) == false)
{
alert("Invaild PAN Card No.")
return false;
}
if (code.test(code_chk)==false)
{
alert("Invaild PAN Card No.");
return false;
}
}
}
</script>
<script language="javascript">
      $('#pan').attr('required','required');
	  $('#stax').attr('required','required');
    $('#country').on('change', function() {
  if(this.value=='India' || this.value=='' ){
	  $('#pan').attr('required','required');
	  $('#stax').attr('required','required');
	  $('.contryChange').show();

  }
  else{
	   $('#pan').attr('required',false);
	  $('#stax').attr('required',false);
	   $('.contryChange').hide();

  }
})

</script>
<script language="javascript">
            populateCountries("country", "state");
            populateCountries("country2");
</script>

<script>
$(document).ready(function() {
    var titleValidators = {
            row: '.col-xs-4',   // The title is placed inside a <div class="col-xs-4"> element
            validators: {
                notEmpty: {
                    message: 'The title is required'
                }
            }
        },
        isbnValidators = {
            row: '.col-xs-4',
            validators: {
                notEmpty: {
                    message: 'The ISBN is required'
                },
                isbn: {
                    message: 'The ISBN is not valid'
                }
            }
        },
        priceValidators = {
            row: '.col-xs-2',
            validators: {
                notEmpty: {
                    message: 'The price is required'
                },
                numeric: {
                    message: 'The price must be a numeric number'
                }
            }
        },
        bookIndex = 0;

    $('#bookForm')

        // Add button click handler
        .on('click', '.addButton', function() {
            bookIndex++;
            var $template = $('#bookTemplate'),
                $clone    = $template
                                .clone()
                                .removeClass('hide')
                                .removeAttr('id')
                                .attr('data-book-index', bookIndex)
                                .insertBefore($template);

            // Update the name attributes
            $clone
                .find('[name="title"]').attr('name', 'name[' + bookIndex + ']').end()
                .find('[name="isbn"]').attr('name', 'email[' + bookIndex + ']').end()
				.find('[name="isbn"]').attr('name', 'degi[' + bookIndex + ']').end()


            // Add new fields
            // Note that we also pass the validator rules for new field as the third parameter
            $('#bookForm')

        })

        // Remove button click handler
        .on('click', '.removeButton', function() {
            var $row  = $(this).parents('.fromAppend_grp'),
                index = $row.attr('data-book-index');

            // Remove fields
            $('#bookForm')


            // Remove element containing the fields
            $row.remove();
        });
});

	$(document).on('change', '.btn-file :file', function() {
	  var input = $(this),
		  numFiles = input.get(0).files ? input.get(0).files.length : 1,
		  label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
	  input.trigger('fileselect', [numFiles, label]);
	});
	
	$(document).ready( function() {
		$('.btn-file :file').on('fileselect', function(event, numFiles, label) {

			var input = $(this).parents('.form-group').find(':text'),
				log = numFiles > 1 ? numFiles + ' files selected' : label;

			if( input.length ) {
				input.val(log);
			} else {
				if( log ) alert(log);
			}

		});
	});
	
	$(document).ready(function() {
		$('#comptype input').on('change', function() {
		   var x = $('input[name="comptype"]:checked', '#comptype').val();
		   if(x==1){
			   $('#retaner').css("display","flex");
		   }
		   else{
			   $('#retaner').css("display","none");
		   }
		});
	});
		</script>
<script type="text/javascript">
$('#image-file').bind('change', function() {
	if(this.files[0].size/1024/1024 >2){
		var control = $("#image-file");
	control.replaceWith( control = control.clone(true ));
	alert("This file size is More then 2MB. Please upload less then it.");
	}
});
</script>


