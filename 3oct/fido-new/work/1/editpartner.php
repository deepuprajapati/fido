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
</style>
<!-- write your custom css and js here -->

  
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

$partner = new Partner();
if (isset($_GET['id'])) {

	$id=$_GET['id'];

} else {

	$_SESSION['msg'] = "Partner does not Exists";
	redirectAdmin('addPartner.php');
}
// check contract details here

if (isset($_POST['upload'])) {

    if (!empty($_FILES['filea'])) {

		$contract = new partner_cotract();
		$eid = $_POST['eid'];
		//$filename=$_FILES["contract"]["tmp_name"];
		$filename  = $_FILES['filea']['name'];
		$extension = pathinfo($filename, PATHINFO_EXTENSION);
		$new       = $eid.'.'.$extension;
		$target_path = $_SERVER["DOCUMENT_ROOT"]."/mis/upload_contract/".$new;

		move_uploaded_file($_FILES['filea']['tmp_name'], $target_path);

		$target_file = $target_path . basename($_FILES["filea"]["name"]);
		$result_client= $contract->findcustomrow(array('partner_id'=>$eid));

		if (empty($result_client)) {

			$contract->partner_id=$eid;
			$contract->img_url=$new;
			$contract->create();

		} else {

			$contract->id=$result_client['id'];
			$contract->img_url=$new;
			$contract->save();

		}

	}
		$_SESSION['msg'] = "Uploaded Contract";
		redirectAdmin('editpartner.php?id='.$eid);
}

$contract = new partner_cotract();
$contract_info = $contract->findcustomrow(array('partner_id'=>$id));
if(!empty($contract_info))
{
@$errors = array_filter($contract_info);
}
else {
    $errors = '';
}

if (!empty($errors)) {
	@$sdate=$errors['start_date'];
	@$edate=$errors['end_date'];
	@$img_url=$errors['img_url'];
	@$est_mood=$errors['est_mood'];
}
else
{
	$sdate="";
	$edate="";
	$img_url="";
	$est_mood="";
}

$partner_cat_com = new PartnerCommisionSection();
$cond = "service_id = 2 and partner_id =".$id;
$mValue = $partner_cat_com->findWhere($cond);

$comValue = $partner_cat_com->findCustom(array('partner_id'=>$id));

foreach($comValue as $key=>$totalCom) {

	$tfee = $totalCom['totalFee'];
	$comcat[$totalCom['service_id']] =  array($totalCom['commision'],$totalCom['fee']);
	 //$x[$totalCom['service_id']] = $totalCom['fee'];

   //$comcat[$totalCom['service_id']] =  $totalCom['commision'].','.$totalCom['fee'];

}

$value=$partner->findcustomrow(array('id'=>$id));

if(isset($_POST['company_name'])){

	$result= $partner->findcustom(array('partner_name'=>$_POST['company_name']));

	if (empty($result) or $value['partner_name']==$_POST['company_name']) {

		$partner = new Partner();
		$partner->id= $id;

		$partner->partner_name= trim($_POST['company_name']);
		// $partner->official_address= trim($_POST['company_address']);    

		//$partner->publisher_name= trim($_POST['publisher_name']);
		$partner->website_address= trim($_POST['website_address']);
		$partner->pan= trim($_POST['pan']);
		//$partner->service_tax= trim($_POST['stax']);
		$partner->GST	 = trim($_POST['stax']);
		$fullcode = (strlen($_POST['state_code']) == 1) ? '0'.$_POST['state_code'] : $_POST['state_code'];
		$partner->state_code	 = $fullcode;
		$partner->district= trim($_POST['company_district']);
		$partner->state= $_POST['company_state'];
		$partner->country= $_POST['company_country'];
		$partner->postal_code= $_POST['company_pincode'];
		$partner->company_code= $_POST['company_code'];
		$partner->company_type= $_POST['company_type'];
		$partner->company_cat= $_POST['company_category'];
		$partner->save();
		$result_client= $contract->findcustomrow(array('partner_id'=>$id));

		if (empty($result_client)) {

			$contract->partner_id=$id;
			$contract->start_date=$_POST['contractstart'];
			$contract->end_date=$_POST['contractend'];
			$contract->est_mood=$_POST['est_mood'];
			$contract->create();

		} else {

		    $contract->id=$result_client['id'];
		    $contract->start_date=$_POST['contractstart'];
		    $contract->end_date=$_POST['contractend'];
		    $contract->est_mood=$_POST['est_mood'];
			$contract->save();

		}

		$partner_cat_com = new PartnerCommisionSection();

		$servername = "localhost";
		$username = "newuser";
		$password = "password";
		$dbname = "fido";

		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
			// Check connection
			if ($conn->connect_error) {

				die("Connection failed: " . $conn->connect_error);

			}

			foreach($_POST['category'] as $service_id=>$services):

			if (isset($_POST['commsion_issued'][$service_id]) || isset($_POST['commsion_money'][$service_id])) {

			    $udcommision		=	$_POST['commsion_issued'][$service_id];
			    $udfee  =	str_replace(',','', $_POST['commsion_money'][$service_id]);

			} else {

			    $udcommision		=	0.00;	// default value for commission

			}

			$uptotalFee     =   str_replace(',','', $_POST['Fee']);
			$upservice_id	=	$service_id; 
			$uppartner_id	=	$id;
			$upmodified_on	=	date('Y-m-d H:i:s');

			if ($upservice_id != 2) {

			    $chk_sql = "select id from partner_section_commisions WHERE partner_id = $uppartner_id AND service_id = $upservice_id";
			    $resultsss = $conn->query($chk_sql);
			    //echo $resultsss->num_rows;
				if ($resultsss->num_rows > 0) {

				    $sql = "UPDATE partner_section_commisions SET commision = $udcommision,totalFee = $uptotalFee,modified_on = '$upmodified_on' WHERE partner_id = $uppartner_id AND service_id = $upservice_id";
				    //echo $sql;
				    $conn->query($sql);

				} else {

				    $sql = "INSERT INTO partner_section_commisions (commision, service_id, totalFee, fee, created_on, partner_id )
				    VALUES ('$udcommision', '$upservice_id', '$uptotalFee', '$udfee', '$upmodified_on', '$uppartner_id' )";
				    //echo $sql;
				    $conn->query($sql);
				}

			}

			endforeach;
			//die;
			$_SESSION['msg'] = "Partner has been Edited successfully";
			redirectAdmin('managePartner.php');
			}

			}

	//_d($allLanguages);
	?>
	
    <!-- Page container begins -->
        <section class="main-container">
            <div class="header headerCntnt_wrapr">
                <div class="heading_top">
                    <div class="page-title">Partner Management</div>
                    
                </div>
                <!--<div class="links"><a href="" class="btn btn-secondary btn-labeled m-r-10"><b><i class="icon-plus22"></i></b> CREATE ESTIMATE REQUISITION</a><button type="button" class="btn btn-secondary btn-labeled"><b><i class="icon-plus22"></i></b> New Group</button></div>-->
            </div>
            <div class="container-fluid page-content">
                <!-- formatted inputs -->
                <div class="card card-inverse card-flat p-10">
                    <div class="card-block p-b-50 p-0" >
                        <h3 class="form-wizard-title text-uppercase p-b-10"><small class="display-block">Details about yourself</small></h3>

						<form role="form"  method='post'>  						
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 marg_b_20">
                                    <div class="form-group">
										<label>Company Name</label>
										   <input type="text" placeholder="Name" value= '<?php echo $value['partner_name'] ?>' name="company_name" class="form-control inptFld_sz" required>
									</div>
                                </div>
								
								<div class="col-lg-6 col-md-6 col-sm-12 marg_b_20">
									<div class="form-group"><label>Company Type</label>
									   <select name='company_type' class='form-control inptFld_sz' required>
											<option value=''>Select Type</option>
											<option value='1'  <?php if($value['company_type'] =='1') echo 'selected' ; ?>>Retailer</option>
											<option value='2'  <?php if($value['company_type'] =='2') echo 'selected' ; ?>>Retailer + Commission</option>
											<option value='3'  <?php if($value['company_type'] =='3') echo 'selected' ; ?>>Commission</option>
									   </select>
									</div>
								</div>
								
                                <div class="col-lg-6 col-md-6 col-sm-12 marg_b_20">
                                    <div class="form-group">
										<label>Company Code</label>
										 <input type="text" placeholder="Code" name="company_code" class="form-control inptFld_sz"  value= '<?php echo $value['company_code'] ?>' required>
									</div>
                                </div>
								

                                <div class="col-lg-6 col-md-6 col-sm-12 marg_b_20">
                                    <div class="form-group">
										<label>Website address</label>
										<input type="text" required placeholder="Website address" name="website_address" class="form-control inptFld_sz" value= '<?php echo $value['website_address'] ?>'>
									</div>
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-12 marg_b_20">
                                    <div class="form-group">
										<label>Company Category</label>
									   <select name='company_category' class='form-control inptFld_sz'>
											<option value=''>Select Category</option>
											<option value='Co' <?php if($value['company_cat'] =='Co') echo 'selected' ; ?>>Co.</option>
											<option value='None_Co' <?php if($value['company_cat'] =='None_Co') echo 'selected' ; ?>>None_Co.</option>
											<option value='pvtltdcompany' <?php if($value['company_cat'] =='pvtltdcompany') echo 'selected' ; ?>>Pvt. LTD. Company</option>
											<option value='ltdcompany' <?php if($value['company_cat'] =='ltdcompany') echo 'selected' ; ?>>LTD. Company</option>
											<option value='partnership' <?php if($value['company_cat'] =='partnership') echo 'selected' ; ?>>Partnership</option>
											<option value='proprietorship' <?php if($value['company_cat'] =='proprietorship') echo 'selected' ; ?>>Proprietorship</option>
											<option value='individual' <?php if($value['company_cat'] =='individual') echo 'selected' ; ?>>Individual</option>
									   </select>
									</div>
                                </div>
								
								

                                <div class="col-lg-6 col-md-6 col-sm-12 marg_b_20">
                                    <div class="form-group">
										<label>PAN Number</label>
										<input type="text" required placeholder="PAN Number"   name="pan" class="form-control inptFld_sz" value= '<?php echo $value['pan'] ?>' >
									</div>
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-12 marg_b_20">
                                    <div class="form-group">
										<label>Country</label>
										<input type="text" placeholder="Country"  name="company_country" class="form-control inptFld_sz"  value= '<?php echo $value['country'] ?>' required>
									</div>
                                </div>


                                <div class="col-lg-6 col-md-6 col-sm-12 marg_b_20">
                                    <div class="form-group">
										<label>GST No.</label>
										 <input type="text" required placeholder="GST No." name="stax" class="form-control inptFld_sz" value= '<?php echo $value['GST'] ?>'>
									</div>
                                </div>
								
								


                                <div class="col-lg-6 col-md-6 col-sm-12 marg_b_20">
                                    <div class="form-group">
										<label>State</label>
										 <input type="text" placeholder="State"    value= '<?php echo $value['state'] ?>'  name="company_state" class="form-control inptFld_sz" required>
									</div>
                                </div>
								
								
                                <div class="col-lg-6 col-md-6 col-sm-12 marg_b_20">
                                    <div class="form-group">
										<label>City </label>
										<input type="text" placeholder="District" name="company_district" class="form-control inptFld_sz" value= '<?php echo $value['district'] ?>'>
									</div>
                                </div>


                                <div class="col-lg-6 col-md-6 col-sm-12 marg_b_20">
                                    <div class="form-group">
										<label>State Code <small><a target="_blank" href="http://www.ddvat.gov.in/docs/List%20of%20State%20Code.pdf">(Click for state code)</a></small></label>
										<select name='state_code' id='state_code' class='form-control' required>
											<option value=''>Select Code</option>
										   <?php for($i=1; $i<38; $i++){ ?>
											<option <?php if($value['state_code'] == $i) echo 'selected' ; ?> value='<?php echo $i;?>'><?php echo $i;?></option>
										   <?php } ?>
										</select>
									</div>
                                </div>
							<!--
                                <div class="col-md-6 col-sm-6 marg_b_20">
                                    <div class="form-group">
										<label>Company Address.</label>
										<input type="text" required placeholder="Address"    name="company_address" class="form-control inptFld_sz" value= '<?php echo $value['official_address'] ?>' >
									</div>
                                </div>
                            -->
								
                                <div class="col-lg-6 col-md-6 col-sm-12 marg_b_20">
                                    <div class="form-group">
										<label>Pin code</label>
										<input type="text" placeholder="Pin code "     name="company_pincode" class="form-control inptFld_sz"  value= '<?php echo $value['postal_code'] ?>' >
									</div>

								</div>

                                <div class="col-lg-3 col-md-6 col-sm-6 marg_b_20">
                                    <div class="form-group">
										<label>Company Contract File</label>
										<ul class="icons-list marg_0">
										<li class="dropdown marg_0">
										<button style="padding-right: 9px;height: 35px;" type="button" class="btn btn-secondary btn-md" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Choose Option Here <i class="icon-arrow-down12 position-right"></i></button>

										<ul class="dropdown-menu dropdown-menu-left" style="width: 170px;dis">
										<?php if($img_url !='') { ?>
										<a target="_blank" class="dropdown-item" href="<?php echo $config['SITE_URL']."upload_contract/".$img_url;?>">View Contract</a>
										<?php } ?>			
										<a href="javascript:;" class="dropdown-item" data-toggle="modal" data-target="#myyModal"  >Upload Contract</a>
										</ul>
										</li>
										</ul>
									</div>
								</div>

                                <div class="col-lg-3 col-md-6 col-sm-6 marg_b_20">
                                    <div class="form-group">
										<label>Estimate Mood(Retailer Ship client)</label>
									   <select name='est_mood' class='form-control inptFld_sz'>
											<option value=''>Select Category</option>
											<option value='m' <?php if($est_mood =='m') echo 'selected' ; ?>>Monthly</option>
											<option value='q' <?php if($est_mood =='q') echo 'selected' ; ?>>Quarterly.</option>
											<option value='y' <?php if($est_mood =='y') echo 'selected' ; ?>>Yearly</option>
									   </select>
									</div>
								</div>

                                <div class="col-lg-3 col-md-6 col-sm-6 marg_b_20">
									<div class="form-group">
										<label>Contract Start Date</label>
										<div class="input-group">
											<span class="input-group-addon"><i class="icon-calendar2"></i></span>
											<input id='startdate' type="text" placeholder="Contract Start Date" name="contractstart" value="<?php echo  $sdate ?>"  class='form-control datepicker-here inptFld_sz' data-language='en' data-position='bottom right'>
										</div>
									</div>
								</div>

                                <div class="col-lg-3 col-md-6 col-sm-6 marg_b_20">
									<div class="form-group">
										<label>Contract End Date</label>
										<div class="input-group">
											<span class="input-group-addon"><i class="icon-calendar2"></i></span>
											<input  id='enddate' type="text" placeholder="Contract End Date" name="contractend" class="form-control datepicker-here inptFld_sz" value="<?php echo  $edate?>" data-language='en' data-position='bottom right'>
										</div>
									</div>
								</div>


                                <div class="col-lg-6 col-md-6 col-sm-12 marg_b_20">
									<div class="form-group">
										<label>Fee</label>
										<input type="text" required placeholder="Fee" name="Fee" id="Fee" class="form-control auto inptFld_sz" data-d-group="2" value="<?php echo @$tfee; ?>">
									</div>
								</div>


						<?php

					   $projectCatObj = new ProjectCategory();
					   $project_category = $projectCatObj->findCustom(array());
					   foreach($project_category as $key=>$p_cat):
					   if($value['company_type']==1)
					   {
						    $inCat = array(2,3,4,11,9,8,7,6,5,1,10,12,13,14,15,21,22,23);
						?>
                         <div class="col-md-6">
							<div class="form-group">
								<div class="chkbox_cstm_wpr checkbox">
									<label class="marg_b_10">
										<?php  $cond = "partner_id ='".$id."' and  service_id = '".$p_cat['id']."'";
										$commValue = $partner_cat_com->findWhere($cond);
										$errors = array_filter($commValue);
										?>
										<div class="chbx_style">
											<!--<input type="checkbox" name="comptype" class="shwInput" value="1" required="">-->
											<input class="category-checks shwInput" type="checkbox" <?php echo (empty($errors)?'':'checked')?> name="category[<?php echo $p_cat['id']?>]" value="<?php echo $p_cat['id']?>" <?php echo (!in_array($p_cat['id'],$inCat)?'disabled=""':'')?>>
											<span></span>
										</div>
										<?php echo $p_cat['name']?>
									</label>
								</div>
							
							
								<div class="input-group bootstrap-touchspin marg_b_20">
								  <input min="0" max="100" required="required" value="<?php
								  foreach($comcat as $key=>$value1){
									echo ($p_cat['id']==$key ? $value1[0] :'');
								  } ?>" type="number" style="display: block;" <?php echo (empty($errors)?'disabled="disabled"':'')?>  onblur="getValue(this.value,this)" class="form-control" name="commsion_issued[<?php echo $p_cat['id']?>]" id="" placeholder="<?php echo $p_cat['name']?> Commission">
								  <span class="input-group-addon bootstrap-touchspin-postfix">%</span>

								  
								  <input required="required" value="<?php
								  foreach($comcat as $key=>$value1){
									echo ($p_cat['id']==$key ? $value1[1] :'');
								  } ?>" type="text" <?php echo (empty($errors)?'disabled="disabled"':'')?> style="display: block;"  class="form-control auto" name="commsion_money[<?php echo $p_cat['id']?>]" placeholder="<?php echo $p_cat['name']?> Commission" readonly data-d-group="2">
								  <span class="input-group-addon bootstrap-touchspin-postfix"><i class="icon icon-rupee"></i></span>
								  
								</div>

							
							
							
						</div>
                         </div>
						   <?php
					   }
					   else
					   {
                            $inCat = array(3,4,11,9,8,7,6,5,1,10,12,13,14,15,21,22,23);

						?>
                <div class="col-md-6" <?php echo ($p_cat['id'] =='2'?'style="display:none"':'')?>>
				<div class="form-group">

				
				<div class="chkbox_cstm_wpr checkbox">
					<label class="marg_b_10">
						<?php  $cond = "partner_id ='".$id."' and  service_id = '".$p_cat['id']."'";
						$commValue = $partner_cat_com->findWhere($cond);
						$errors = array_filter($commValue);
						?>
						<div class="chbx_style">
							<!--<input type="checkbox" name="comptype" class="shwInput" value="1" required="">-->
							<input class="category-checks shwInput" type="checkbox" <?php echo (empty($errors)?'':'checked')?>  name="category[<?php echo $p_cat['id']?>]" value="<?php echo $p_cat['id']?>" <?php echo (!in_array($p_cat['id'],$inCat)?'disabled=""':'')?>>
							<span></span>
						</div>
						<?php echo $p_cat['name']?>
					</label>
				</div>
				
				
				<div class="input-group bootstrap-touchspin marg_b_20">
				    <input min="0" max="100" required="required" value="<?php
				    foreach($comcat as $key=>$value1){
				    echo ($p_cat['id']==$key ? $value1[0] :'');
				} ?>" type="number" style="display: block;" <?php echo (empty($errors)?'disabled="disabled"':'')?> onblur="getValue(this.value,this)" class="form-control" name="commsion_issued[<?php echo $p_cat['id']?>]" id="" placeholder="<?php echo $p_cat['name']?> Commission">
				<span class="input-group-addon bootstrap-touchspin-postfix">%</span>
				
				<input style="display: block;" value="<?php foreach($comcat as $key=>$value1){ echo ($p_cat['id']==$key ? $value1[1] :''); } ?>" required="required" type="text" <?php echo (empty($errors)?'disabled="disabled"':'')?>  class="form-control auto" name="commsion_money[<?php echo $p_cat['id']?>]" placeholder="<?php echo $p_cat['name']?> Commission" readonly data-d-group="2">
				 <span class="input-group-addon bootstrap-touchspin-postfix"><i class="icon icon-rupee"></i></span>
				
				</div>

				
				</div>
                         </div>
						   <?php
					   }
					   endforeach;
				   ?>
	

							</div>



						
							<button type="Submit" class="btn btn-primary ui-wizard-content float-right marg_t_30">Next</button>
						</form>
					
						
					
					</div>
				</div>
            <!-- /formatted inputs -->
                       <!-- Footer -->
     <?php include('include/footer-new.php'); ?>  
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

<script src="asset/js/Countries_States.js"></script>
<script>
$(function() {
	$('.datepicker-here').datepicker({
		dateFormat: 'yyyy-mm-dd',
	});
});
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
            var $row  = $(this).parents('.form-group'),
                index = $row.attr('data-book-index');

            // Remove fields
            $('#bookForm')


            // Remove element containing the fields
            $row.remove();
        });
});

			</script>

<!--<div class="modal fade" id="myyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="myModalLabel">Client Contract</h4>
	  </div>
	  <div class="modal-body">
<form method="post" action="editpartner.php?id=".$id enctype="multipart/form-data">

		  <div class="form-group">
			<label for="exampleInputFile">upload</label>
<input type="file" id="exampleInputFile" name="filea" required accept="application/pdf">
			<p class="help-block">Upload Client Contract Here.</p>
		  </div>
		 <input type="hidden" name="eid" id="eop" value="<?php echo $id?>" >
	  </div>
	  <div class="modal-footer">
		<button type="submit" class="btn btn-default" name="upload" >Submit</button>
		</form>
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	  </div>
	</div>
  </div>
</div>-->

<div class="modal fade" id="myyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg_none p-10">
        <h5 class="modal-title">Client Contract</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
     <form method="post" action="editpartner.php?id=".$id enctype="multipart/form-data">
      <div class="modal-body">
    <div class="row marg_b_15">
    <div class="col-md-12 col-sm-12">
      <div class="form-group">
      <label>Upload </label>
      <div class="input-group">
	   <input type="file" id="exampleInputFile" class="form-control " name="filea" required accept="application/pdf">
      </div>
	   <p class="help-block">Upload Client Contract Here.</p>
      </div>
    </div>
    </div>
    <input type="hidden" name="eid" id="eop" value="<?php echo $id?>" >
    </div>
      <div class="modal-footer bg_none">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	 <button type="submit" class="btn btn-primary" name="upload" >Submit</button>
      </div>
    </form>
     </div>
    </div>
  </div>
