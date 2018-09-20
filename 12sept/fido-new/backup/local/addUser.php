<?php include('include/header-files.php'); ?>


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
$userarray=array(1,6);
if(!in_array($_SESSION['admin_info']['type'], $userarray)){
	header('Location: logout.php');
}
$partner = new Partner();
$Publisher = new Publisher();
$Publisherlist=$Publisher->all();
$user  = new Admin();
$usermeta=new usermeta();
$userpermission=new userPermission();
$partnerlist=$partner->all();

 //  $allLanguages = $language->getColumns();
if(isset($_POST['email'])){

$result= $user->findcustomrow(array('email'=>$_POST['email']));
if(empty($result))
{

	$user->name = trim($_POST['name']);

	$user->email	 = trim($_POST['email']);
	$user->address	 = trim($_POST['address']);
	$user->phone	 = trim($_POST['phone']);
	$user->password=md5(trim($_POST['password']));
	if(!empty($_POST['type']))
	{
		$user->type=$_POST['type'];
	}
	if(!empty($_POST['client']))
	{
		$user->type=$_POST['client'];
	}
	if(!empty($_POST['publisher']))
	{
		$user->type=$_POST['publisher'];
	}
	if($_POST['partner']!=0)
	{
		$user->partnerid=$_POST['partner'];
	}
	if($_POST['publisherpartner']!=0)
	{
		$user->partnerid=$_POST['publisherpartner'];
	}




	$user->created_at=date('Y-m-d H:i:s');
	$user->updated_at=date('Y-m-d H:i:s');

	$user->create();
	$userid=$user->lastInsertId();

	if($_POST['client']==7 || $_POST['client']==8 || $_POST['publisher']==9 || $_POST['publisher']==10)
	{
		$usermeta->userid= $userid;
		if($_POST['publisher']==10){
			foreach($_POST['finance'] as $key=>$value){

				$usermeta->optionkey= trim($key);
				$usermeta->optionvalue= trim($value);
				$usermeta->create();
			}
		}
		foreach($_POST['both'] as $key=>$value){
				$usermeta->optionkey= trim($key);
				$usermeta->optionvalue= trim($value);
				$usermeta->create();
			}

	}


	$_SESSION['msg'] = "User has been added successfully";
	$url = "group.php?id=".$userid."&type=".$_POST['type'];
   redirectAdmin($url);

}
else
{
$_SESSION['msg'] = "This Email id already EXists";
	redirectAdmin('addUser.php');
}
}

	//_d($allLanguages);
	?>
	
    <!-- Page container begins -->
        <section class="main-container">
            <div class="header headerCntnt_wrapr">
                <div class="heading_top">
                    <div class="page-title">Users Management</div>
                    
                </div>
                <!--<div class="links"><a href="" class="btn btn-secondary btn-labeled m-r-10"><b><i class="icon-plus22"></i></b> CREATE ESTIMATE REQUISITION</a><button type="button" class="btn btn-secondary btn-labeled"><b><i class="icon-plus22"></i></b> New Group</button></div>-->
            </div>
            <div class="container-fluid page-content">
                <!-- formatted inputs -->
                <div class="card card-inverse card-flat p-10 CrdTop_brdr p-t-20">
                    <div class="card-block p-b-50 p-0">
                       <form role="form"  method='post' >
                            <div class="row">
                                <div class="col-md-6 col-sm-6 marg_b_20">
                                    <div class="form-group">
										<label>Select [ Internal / External ] user </label>
										<select  id="isInternal" name='isInternal' class="form-control inptFld_sz" required>
											<option value=''>Select</option>
											<option value='1'>Internal</option>
											<option value='2'>External </option>
										</select>
									</div>
								</div><!-- done 1-->
								<!--<p style='color:red;'><?php if(isset($_SESSION['msg'] )) {echo $_SESSION['msg'] ; unset($_SESSION['msg'] ); } ?> </p>-->
								<?php if(isset($_SESSION['msg'] )) { ?>
								<p style='color:red;'>
								<?php echo $_SESSION['msg'] ; unset($_SESSION['msg'] ); ?>
								</P>
								<?php }?>
                                <div class="whichpartner col-md-6 col-sm-6 marg_b_20" style='display:none'>
                                    <div class="form-group">
										<label>Select [ Client / Publisher ] user </label>
										<select id="whichpartner" name='whichpartner' class="form-control inptFld_sz" >
										<option value=''>Select</option>
										<option value='1'>Client</option>
										<option value='2'>Publisher </option>
										</select>
									</div>
                                </div><!-- done 2-->


                                <div class="client col-md-6 col-sm-6 marg_b_20" style='display:none'>
                                    <div class="form-group">
										<label>Select [ Media / finance ] user </label>
										<select id="client_drop" name='client' class="form-control inptFld_sz">
										<option value=''>Select</option>
										<option value='7'>Client Media</option>
										<option value='8'>Client finance</option>
										</select>
									</div>
                                </div><!-- done 3-->


                                <div class="pub col-md-6 col-sm-6 marg_b_20" style='display:none' id="publisher_drop_id">
                                    <div class="form-group">
										<label>Select [ Media / finance ] user </label>
										<select id="publisher_drop" name='publisher' class="form-control inptFld_sz" >
											<option value=''>Select</option>
											<option value='9'>Publisher Media</option>
											<option value='10'>Publisher finance</option>
										</select>
									</div>
                                </div><!-- done 4-->


                                <div class="col-md-6 col-sm-6 marg_b_20" >
                                    <div class="form-group">
										<label>User Type</label>
											<select  id="type" name='type' class="form-control inptFld_sz" required>
												<option value=''>Select Internal User</option>
												<option value='17'>Inbound Team</option>
												<option value='15'>Business Head</option>
												<option value='16'>Business Development</option>
												<option value='14'>Head BS Team</option>
												<option value='2'>Brand Solution Team</option>
												<option value='11'>Seo Team </option>
												<option value='12'>Content Team </option>
												<option value='13'>Social Team </option>
												<option value='3'>Tech Team </option>
												<option value='4'>Digital PR</option>
												<option value='5'>Media Team </option>
												<option value='6'>Finance Team</option>
												<option value='1'>Admin</option>
											</select>
									</div>
                                </div><!-- done 5-->


                                <div class="col-md-6 col-sm-6 marg_b_20" style='display:none' id='partner'>
                                    <div class="form-group">
										<label>Partner list</label>
											<select  name='partner' class='form-group form-control' class="form-control inptFld_sz">
												<option value='' >Select Parner</option>
												<?php foreach($partnerlist as $keys=>$values){ ?>
												<option value='<?php echo $values['id'] ?>'><?php echo $values['partner_name'] ?></option>
												<?php } ?>
											</select>
									</div>
                                </div><!-- done 6-->


                                <div class="col-md-6 col-sm-6 marg_b_20" style='display:none' id='partner'>
                                    <div class="form-group">
										<label>Publisher list</label>
										<select  id="publisherpartner" name='publisherpartner' class="form-control inptFld_sz" >
											<option value='0' >Select Publisher</option>
											<?php foreach($Publisherlist as $key=>$value){ ?>
											<option value='<?php echo $value['id'] ?>'><?php echo $value['publisher_name'] ?></option>
											<?php } ?>
										</select>
									</div>
                                </div><!-- done 7-->


                                <div class="col-md-6 col-sm-6 marg_b_20">
                                    <div class="form-group">
										<label>Name</label>
										<input type="text" placeholder="Name" name="name" class="form-control inptFld_sz" required>
									</div>
                                </div><!-- done 8-->


                                <div class="col-md-6 col-sm-6 marg_b_20">
                                    <div class="form-group">
										 <label>Email</label>
										<input type="email" placeholder="Email"  name="email" class="form-control inptFld_sz" required>
									</div>
                                </div><!-- done 9-->

                                <div class="col-md-6 col-sm-6 both marg_b_20" style='display:none'>
                                    <div class="form-group">
										 <label>Landline no</label>
										<input type="text" placeholder="Landline No"  name="both[landline]" class="form-control inptFld_sz" >
									</div>
                                </div><!-- done 10-->


                                <div class="col-md-6 col-sm-6 marg_b_20" >
                                    <div class="form-group">
										<label>Phone</label>
										 <input type="text" placeholder="Phone no"   name="phone" class="form-control inptFld_sz" required>
									</div>
                                </div><!-- done 11-->


                                <div class="col-md-6 col-sm-6 marg_b_20" >
                                    <div class="form-group">
										<label>Employee code</label>
										 <input type="text" placeholder="Employee code" required name="address" class="form-control inptFld_sz" id="ecode">
									</div>
                                </div><!-- done 12-->


                                <div class="col-md-6 col-sm-6 marg_b_20" >
                                    <div class="form-group">
										<label>Password</label>
										<input type="password" placeholder="Password"  name="password" class="form-control inptFld_sz" required>
									</div>
                                </div><!-- done 13-->

                                <div class="col-md-6 col-sm-6 both marg_b_20" id='designation' style='display:none'>
                                    <div class="form-group">
										<label>Designation</label>
										<input type="text" placeholder="Designation"  name="both[designation]" class="form-control inptFld_sz">
									</div>
                                </div><!-- done 14-->


                                <div class="finance col-md-6 col-sm-6 marg_b_20" style='display:none'>
                                    <div class="form-group">
										<label>Bank Name</label>
										<input type="text"  placeholder="Bank Name"  name="finance[bankname]" class="form-control inptFld_sz" >
									</div>
                                </div><!-- done 15-->


                                <div class="finance col-md-6 col-sm-6 marg_b_20" style='display:none'>
                                    <div class="form-group">
										<label>Account Type</label>
										<input type="text"  placeholder="Account Type" name="finance[accounttype]" class="form-control inptFld_sz" >
									</div>
                                </div><!-- done 16-->


                                <div class="finance col-md-6 col-sm-6 marg_b_20" style='display:none'>
                                    <div class="form-group">
										<label>Branch & Address</label>
										<input type="text"  placeholder="Branch & Address"  name="finance[Branch]" class="form-control inptFld_sz" >
									</div>
                                </div><!-- done 17-->


                                <div class="finance col-md-6 col-sm-6 marg_b_20" style='display:none'>
                                    <div class="form-group">
										<label>IFSC Code</label>
										<input type="text"  placeholder="IFSC Code" name="finance[ifsc]" class="form-control inptFld_sz">
									</div>
                                </div><!-- done 18-->

                                <div class="finance col-md-6 col-sm-6 marg_b_20" style='display:none'>
                                    <div class="form-group">
										<label>Bank MICR Code</label>
										<input type="text"  placeholder="Bank MICR Code"  name="finance[micr]" class="form-control inptFld_sz" >
									</div>
                                </div><!-- done 19-->


                                <div class="finance col-md-6 col-sm-6 marg_b_20" style='display:none'>
                                    <div class="form-group">
										<label>Account Number</label>
										<input type="text"  placeholder="Account Number"  name="finance[Account Number]" class="form-control inptFld_sz" >
									</div>
                                </div><!-- done 20-->
								

                            </div>


						
							<button type="submit" class="btn btn-primary ui-wizard-content float-right m-t-20" >Next Permission</button>
							</form>
						
					</div>
				</div>
            <!-- /formatted inputs -->
                       <!-- Footer -->
     <?php include('include/footer-new.php'); ?>  
	 

<script>
$('#isInternal').change(function(){

		var internal=$("#isInternal option:selected").val();
		if(internal=='1')
		{
			$('.types').show();
			 $('.whichpartner').hide();
			 $('.finance').hide();
			$('.finance input').each(function(){
				$(this).attr('required',false);
			});
			$('#publisher_drop_id').hide();
			$('.both').hide();
			$('#partner').attr('required', false);
			$('#publisher_drop').attr('required', false);
			$('#client_drop').attr('required', false);
			$('#whichpartner').attr('required', false);
			$('#publisherpartner').attr('required', false)
		}
		else if(internal=='2'){
			$('.types').hide();
			$('.types').attr('required', false);
			$('#whichpartner').attr('required', 'required')
			    $('.whichpartner').show();
				$('.whichpartner input').each(function(){
				$(this).attr('required','required');
		        })
	       }
	else{
		$('.pub').hide();
		$('.client').hide();
		$('.whichpartner').hide();
	}
	})
	$('#whichpartner').change(function(){
		var part=$("#whichpartner option:selected").val();
		//alert(part);
		if(part=='1')
		{

			 $('.client').show();
			 $('.pub').hide();
			 $('#publisher_drop').attr('required', false);
			 $('#ecode').attr('required', false);
			 $('#type').attr('required', false);
			 $('#client_drop').attr('required', 'required');
		}
		if(part=='2')
		{
			$('.pub').show();
			$('.client').hide();
			 //$('#pub').show();
			 $('#ecode').attr('required', false);
			    $('#client_drop').attr('required', false);
				$('#type').attr('required', false);
				$('#publisher_drop').attr('required', 'required');

	}
	})
	$('#client_drop').change(function(){
		var client_drop_value=$("#client_drop option:selected").val();
		//alert(part);
		 $('#ecode').attr('required', false);
		 $('.types').hide();
		 $('.types').attr('required', false);
		 $('#publisherpartner').attr('required', false);
		if(client_drop_value=='7')
		{

			    $('.finance').hide();
				$('.finance input').each(function(){
				$(this).attr('required',false);
			})
			$('.both').show();
			$('#partner').attr('required','required');

		}
		if(client_drop_value=='8')
		{
			 $('.finance').show();
				$('.finance input').each(function(){
				$(this).attr('required','required');
			});
			$('.both').show();
			$('#partner').attr('required','required');


	}
	})

	$('#publisher_drop').change(function(){
		var publisher_drop_value=$("#publisher_drop option:selected").val();
		//alert(part);
		 $('#ecode').attr('required', false);
		if(publisher_drop_value=='9')
		{

			    $('.finance').hide();
				$('.finance input').each(function(){
				$(this).attr('required',false);
			})
			$('.both').show();
			$('#partner').attr('required','required');

		}
		if(publisher_drop_value=='10')
		{
				$('.finance').show();
				$('.finance input').each(function(){
				$(this).attr('required','required');
			});
			$('.both').show();
			$('#partner').attr('required','required');


	}
	})


</script>